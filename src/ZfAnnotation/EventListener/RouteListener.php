<?php

/**
 * Annotation module for Zend Framework 2.
 *
 * @link      https://github.com/alex-oleshkevich/zf-annotations the canonical source repository.
 * @copyright Copyright (c) 2014-2016 Alex Oleshkevich <alex.oleshkevich@gmail.com>
 * @license   http://en.wikipedia.org/wiki/MIT_License MIT
 */

namespace ZfAnnotation\EventListener;

use Exception;
use Zend\Code\Annotation\AnnotationCollection;
use Zend\Code\Annotation\AnnotationInterface;
use Zend\Code\Scanner\ClassScanner;
use Zend\Code\Scanner\MethodScanner;
use Zend\EventManager\AbstractListenerAggregate;
use Zend\EventManager\EventManagerInterface;
use Zend\Filter\FilterChain;
use Zend\Stdlib\ArrayUtils;
use ZfAnnotation\Annotation\Route;
use ZfAnnotation\Event\ParseEvent;
use ZfAnnotation\Exception\InvalidArgumentException;

/**
 * Collects route annotations.
 */
class RouteListener extends AbstractListenerAggregate
{

    /**
     * @var array
     */
    protected $config = [];
    
    /**
     *
     * @var array
     */
    protected $scannedConfig = [];

    /**
     * @var array
     */
    protected $controllerCache = [];

    /**
     * @param EventManagerInterface $events
     */
    public function attach(EventManagerInterface $events, $priority = 1)
    {
        $this->listeners[] = $events->attach(ParseEvent::EVENT_CLASS_PARSED, [$this, 'onClassParsed']);
        $this->listeners[] = $events->attach(ParseEvent::EVENT_FINALIZE, [$this, 'onFinalize']);
    }

    /**
     * @param ParseEvent $event
     */
    public function onClassParsed(ParseEvent $event)
    {
        $this->cacheControllers($event->getParam('config'), $event->getParam('scannedConfig'));
        $this->scannedConfig = $event->getParam('scannedConfig');

        // handle class annotations
        $classHolder = $event->getTarget();
        $classAnnotationsCollection = $classHolder->getAnnotations();
        $classAnnotations = new AnnotationCollection;
        foreach ($classAnnotationsCollection as $annotation) {
            if (!$annotation instanceof Route) {
                continue;
            }

            $classAnnotations->append($annotation);
            $this->handleClassAnnotation($annotation, $classHolder->getClass());
        }

        // handle annotations per method
        foreach ($classHolder->getMethods() as $methodHolder) {
            foreach ($methodHolder->getAnnotations() as $methodAnnotation) {
                if (!$methodAnnotation instanceof Route) {
                    continue;
                }

                $this->handleMethodAnnotation($methodAnnotation, $classAnnotations, $classHolder->getClass(), $methodHolder->getMethod());
            }
        }

        $event->mergeResult([
            'router' => [
                'routes' => $this->config
            ]
        ]);
    }

    /**
     * 
     * @param ParseEvent $event
     */
    public function onFinalize(ParseEvent $event)
    {
        $config = $event->getTarget();
        array_walk_recursive($config, function (&$value, $key) use ($config) {
            if (is_object($value)) {
                $value = $value($config);
            }
        });
        $event->setTarget($config);
    }

    /**
     * 
     * @param array $config
     * @return void
     */
    public function cacheControllers(array $config, array $scannedConfig)
    {
        $controllers = ArrayUtils::merge($this->extractControllers($config), $this->extractControllers($scannedConfig));
        $this->controllerCache = array_flip($controllers);
    }
    
    /**
     * 
     * @param array $config
     * @return array
     */
    private function extractControllers(array $config)
    {
        $controllers = isset($config['controllers']) ? $config['controllers'] : [];
        $controllers['invokables'] = isset($controllers['invokables']) ? $controllers['invokables'] : [];
        $controllers['factories'] = isset($controllers['factories']) ? $controllers['factories'] : [];
        return ArrayUtils::merge($controllers['invokables'], $controllers['factories']);
    }

    /**
     * 
     * @param Route $annotation
     * @param ClassScanner $class
     * @throws InvalidArgumentException
     */
    public function handleClassAnnotation(Route $annotation, ClassScanner $class)
    {
        if (!$this->isValidForRootNode($annotation)) {
            throw new InvalidArgumentException('"route" and "name" properties are required for class-level @Route annotation.');
        }

        $config = $this->annotationToRouteConfig($annotation, $class);
        $this->config = ArrayUtils::merge($this->config, $config);
    }

    /**
     * 
     * @param Route $annotation
     * @param ClassScanner $class
     * @param MethodScanner $method
     * @throws InvalidArgumentException
     */
    public function handleMethodAnnotation(Route $annotation, AnnotationCollection $classAnnotations, ClassScanner $class, MethodScanner $method)
    {
        foreach ($classAnnotations as $classAnnotation) {
            if ($annotation->getExtends()) {
                throw new InvalidArgumentException(
                    'Not possible to define method-level "extends" property when at least one class-level @Route is defined.'
                );
            }
        }

        $routeConfig = $this->annotationToRouteConfig($annotation, $class, $method);
        if (count($classAnnotations) > 0) {
            foreach ($classAnnotations as $classAnnotation) {
                $path = trim($classAnnotation->getExtends() . '/' . $classAnnotation->getName(), '/');
                $reference = &$this->getReferenceForPath(explode('/', $path), $this->config);
                $reference = ArrayUtils::merge($reference, $routeConfig);

                if (trim($classAnnotation->getRoute()) == '/') {
                    foreach ($reference as &$reference) {
                        $reference['options']['route'] = ltrim($reference['options']['route'], '/');
                    }
                }
            }
        } else {
            $this->config = ArrayUtils::merge($this->config, $routeConfig);
        }
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
            $tmp = [];
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
            if (preg_match('/:[\w\d]+/', $annotation->getRoute())) {
                $annotation->setType('segment');
            } else {
                $annotation->setType('literal');
            }
        }

        if (!$annotation->hasDefaultController()) {
            $controllerClass = $this->getReferencedController($controllerClass);
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

    /**
     * 
     * @param string $class
     * @return string
     */
    protected function &getReferencedController($class)
    {
        if (!isset($this->controllerCache[$class])) {
            $this->controllerCache[$class] = function ($scannedConfig) use ($class) {
                $controllers = array_flip($this->extractControllers($scannedConfig));
                if (isset($controllers[$class])) {
                    return $controllers[$class];
                } else {
                    return $class;
                }
            };
        }
        return $this->controllerCache[$class];
    }
    
    public function getConfig()
    {
        return $this->scannedConfig;
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
        return [
            $annotation->getName() => [
                'type' => $annotation->getType(),
                'options' => [
                    'route' => $annotation->getRoute(),
                    'defaults' => $annotation->getDefaults(),
                    'constraints' => $annotation->getConstraints()
                ],
                'priority' => (int) $annotation->getPriority(),
                'may_terminate' => (bool) $annotation->getMayTerminate(),
                'child_routes' => []
            ]
        ];
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
                $ref[$key] = [
                    'child_routes' => []
                ];
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
        return ((bool) $annotation->extends) === false;
    }

}
