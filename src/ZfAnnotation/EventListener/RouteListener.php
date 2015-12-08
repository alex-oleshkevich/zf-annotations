<?php

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

class RouteListener extends AbstractListenerAggregate
{
    /**
     * @var array
     */
    protected $config = array();

    /**
     * @var array
     */
    protected $controllerCache = array();

    /**
     * @param EventManagerInterface $events
     */
    public function attach(EventManagerInterface $events)
    {
        $this->listeners[] = $events->attach(ParseEvent::EVENT_CLASS_PARSED, [$this, 'onClassParsed']);
    }

    /**
     * @param ParseEvent $event
     */
    public function onClassParsed(ParseEvent $event)
    {
        $this->cacheControllers($event->getParam('config'));
        
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
        
        $event->mergeResult(array(
            'router' => array(
                'routes' => $this->config
            )
        ));
    }
    
    /**
     * 
     * @param array $config
     * @return void
     */
    public function cacheControllers(array $config)
    {
        if (!empty($this->controllerCache)) {
            return;
        }
        
        $controllers = isset($config['controllers']) ? $config['controllers'] : array();
        $controllers['invokables'] = isset($controllers['invokables']) ? $controllers['invokables'] : array();
        $controllers['factories'] = isset($controllers['factories']) ? $controllers['factories'] : array();

        $controllers = ArrayUtils::merge($controllers['invokables'], $controllers['factories']);
        $this->controllerCache = array_flip($controllers);
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
        if (!$this->isValidForChildNode($annotation)) {
            throw new InvalidArgumentException(
            'Method-level route annotation cannot extend another one (not implemented). '
            . 'Seen in route "' . $annotation->name . '", '
            . 'route: "' . $annotation->route . '", '
            . 'tried to extend: "' . $annotation->extends . '"'
            );
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
            if (preg_match('/:[\w\d]+/', $annotation->getRoute())) {
                $annotation->setType('segment');
            } else {
                $annotation->setType('literal');
            }
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

    /**
     * 
     * @param string $class
     * @return string
     */
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

}
