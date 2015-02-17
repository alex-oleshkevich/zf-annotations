<?php

namespace ZfAnnotation\EventListener;

use Exception;
use Zend\Code\Annotation\AnnotationCollection;
use Zend\Code\Annotation\AnnotationInterface;
use Zend\Code\Scanner\ClassScanner;
use Zend\Code\Scanner\MethodScanner;
use Zend\Filter\FilterChain;
use Zend\Stdlib\ArrayUtils;
use ZfAnnotation\Annotation\Route;
use ZfAnnotation\Config\Collection;
use ZfAnnotation\EventListener\ListenerInterface;
use ZfAnnotation\Event\ParseEvent;
use ZfAnnotation\Exception\InvalidArgumentException;

class RouteListener implements ListenerInterface
{
    const PRIORITY = 2;

    /**
     * @var array
     */
    protected $config = array();

    /**
     * @var array
     */
    protected $controllerCache = array();

    public function onParseBegin(ParseEvent $event)
    {
        /* @var $configCollection Collection */
        $configCollection = $event->getTarget();
        $controllers = $configCollection->getFromBase('controllers', array());

        $controllers['invokables'] = isset($controllers['invokables']) ? $controllers['invokables'] : array();
        $controllers['factories'] = isset($controllers['factories']) ? $controllers['factories'] : array();

        $controllers = ArrayUtils::merge($controllers['invokables'], $controllers['factories']);
        $this->controllerCache = array_flip($controllers);
    }

    /**
     * @param ParseEvent $event
     */
    public function onClassAnnotationParsed(ParseEvent $event)
    {
        $annotation = $event->getTarget();
        $class = $event->getParam('class');
        if ($annotation instanceof Route) {
            if (!$this->isValidForRootNode($annotation)) {
                throw new InvalidArgumentException('"route" and "name" properties are required for class-level Route annotation.');
            }

            $config = $this->annotationToRouteConfig($annotation, $class);
            $this->config = ArrayUtils::merge($this->config, $config);
        }
    }

    /**
     * @param ParseEvent $event
     */
    public function onMethodAnnotationParsed(ParseEvent $event)
    {
        /* @var $annotation Route */
        $annotation = $event->getTarget();

        /* @var $class ClassScanner */
        $class = $event->getParam('class');

        /* @var $method MethodScanner */
        $method = $event->getParam('method');

        /* @var $classAnnotations AnnotationCollection */
        $classAnnotations = $event->getParam('class_annotations');

        if ($annotation instanceof Route) {
            if (!$this->isValidForChildNode($annotation)) {
                throw new InvalidArgumentException(
                'Method-level route annotation cannot extend another one (not implemented). '
                . 'Seen in route "' . $annotation->name . '", '
                . 'route: "' . $annotation->route . '", '
                . 'tried to extend: "' . $annotation->extends . '"'
                );
            }

            $routeConfig = $this->annotationToRouteConfig($annotation, $class, $method);
            if ($classAnnotations->hasAnnotation('ZfAnnotation\Annotation\Route')) {
                foreach ($classAnnotations as $classAnnotation) {
                    if ($classAnnotation instanceof Route) {
                        $path = trim($classAnnotation->getExtends() . '/' . $classAnnotation->getName(), '/');
                        $reference = &$this->getReferenceForPath(explode('/', $path), $this->config);
                        $reference = array_replace_recursive($reference, $routeConfig);
                    }
                }
            } else {
                $this->config = array_replace_recursive($this->config, $routeConfig);
            }
        }
    }

    /**
     * @param ParseEvent $event
     */
    public function onParseFinish(ParseEvent $event)
    {
        $event->getTarget()->set('router', array(
            'routes' => $this->config
        ));
    }

    public function getPriority()
    {
        return self::PRIORITY;
    }

    /**
     * @param AnnotationInterface $annotation
     * @param ClassScanner $class
     * @throws InvalidArgumentException
     */
    public function annotationToRouteConfig(AnnotationInterface $annotation, ClassScanner $class, MethodScanner $method = null)
    {
        $method = $method ? : 'index';
        $annotation = $this->guessMissingFields($annotation, $method, $class->getName());
        $routeConfig = $this->getRouteConfig($annotation);

        if ($annotation->getExtends()) {
            $tmp = array();
            $ref = &$this->getReferenceForPath(explode('/', $annotation->getExtends()), $tmp);
            $ref = $routeConfig;
            return $tmp;
        } else {
            return $routeConfig;
        }
    }

    protected function guessMissingFields(Route $annotation, $method, $controllerClass)
    {
        if ($method instanceof MethodScanner) {
            $methodName = $method->getName();
        } else if (is_string($method)) {
            $methodName = $method;
        } else {
            throw new Exception('Method must be a string or instance of MethodReflection');
        }

        if (!$annotation->hasName()) {
            $annotation->setName($this->filterActionMethodName($methodName));
        }

        if (!$annotation->hasType()) {
            $annotation->setType('literal');
        }

        if (!$annotation->hasDefaultController()) {
            if (isset($this->controllerCache[$controllerClass])) {
                $controllerClass = $this->controllerCache[$controllerClass];
            }
            $annotation->setDefaultController($controllerClass);
        }

        if (!$annotation->hasDefaultAction()) {
            $annotation->setDefaultAction($this->filterActionMethodName($methodName));
        }

        if (!$annotation->hasRoute()) {
            $annotation->setRoute('/' . $this->filterActionMethodName($methodName));
        }
        return $annotation;
    }

    protected function &getReferencedController($class)
    {
        $this->controllerCache[] = $class;
        $index = count($this->controllerCache) - 1;
        $ref = &$this->controllerCache[$index];
        return $ref;
    }

    /**
     * Sanitizes action name to use in route.
     *
     * @param string $name
     * @return string
     */
    protected function filterActionMethodName($name)
    {
        $filter = new FilterChain;
        $filter->attachByName('Zend\Filter\Word\CamelCaseToDash');
        $filter->attachByName('StringToLower');
        return rtrim(preg_replace('/action$/', '', $filter->filter($name)), '-');
    }

    /**
     * Converts annotation into ZF2 route config item.
     *
     * @param AnnotationInterface $annotation
     * @return array
     */
    protected function getRouteConfig(AnnotationInterface $annotation)
    {
        return array(
            $annotation->getName() => array(
                'type' => $annotation->getType(),
                'options' => array(
                    'route' => $annotation->getRoute(),
                    'defaults' => $annotation->getDefaults(),
                    'constraints' => $annotation->getConstraints()
                ),
                'priority' => (int) $annotation->getPriority(),
                'may_terminate' => (bool) $annotation->getMayTerminate(),
                'child_routes' => array()
            )
        );
    }

    /**
     * Extend parent route with children.
     *
     * @param array $path
     * @param array $config
     * @return array
     */
    protected function &getReferenceForPath(array $path, array &$config)
    {
        $path = array_filter($path, function ($value) {
            return (bool) $value;
        });

        $ref = &$config;

        if (empty($path)) {
            return $ref;
        }

        foreach ($path as $key) {
            if (!isset($ref[$key])) {
                $ref[$key] = array(
                    'child_routes' => array()
                );
            }
            $ref = &$ref[$key]['child_routes'];
        }

        return $ref;
    }

    /**
     * Checks if current route can be a class-level route.
     *
     * @return bool
     */
    public function isValidForRootNode(Route $annotation)
    {
        if (!$annotation->name) {
            return false;
        }

        if (!$annotation->route) {
            return false;
        }

        return true;
    }

    /**
     * Checks if current route can be a action-level route.
     *
     * @throws InvalidArgumentException
     */
    public function isValidForChildNode(Route $annotation)
    {
        return (bool) $annotation->extends == false;
    }

    /**
     * @return array
     */
    public function getConfig()
    {
        return array(
            'routes' => $this->config
        );
    }

}
