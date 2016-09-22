<?php

/**
 * Annotation module for Zend Framework 2.
 *
 * @link      https://github.com/alex-oleshkevich/zf-annotations the canonical source repository.
 * @copyright Copyright (c) 2014-2016 Alex Oleshkevich <alex.oleshkevich@gmail.com>
 * @license   http://en.wikipedia.org/wiki/MIT_License MIT
 */

namespace ZfAnnotation\Parser;

use Doctrine\Common\Annotations\AnnotationReader;
use ReflectionClass;
use Zend\EventManager\EventManager;
use Zend\EventManager\ListenerAggregateInterface;
use Zend\Stdlib\ArrayUtils;
use ZfAnnotation\Event\ParseEvent;

/**
 * The main process.
 */
class ClassParser
{

    /**
     *
     * @var array
     */
    protected $config = [];

    /**
     * @var AnnotationReader
     */
    protected $annotationReader;

    /**
     * @var EventManager
     */
    protected $eventManager;

    /**
     * @param array $config
     * @param AnnotationReader $annotationReader
     * @param EventManager $eventManager
     */
    public function __construct(array $config, AnnotationReader $annotationReader, EventManager $eventManager)
    {
        $this->config = $config;
        $this->annotationReader = $annotationReader;
        $this->eventManager = $eventManager;
    }

    /**
     * 
     * @param ListenerAggregateInterface $listener
     */
    public function attach(ListenerAggregateInterface $listener)
    {
        $listener->attach($this->eventManager);
    }

    /**
     * 
     * @param string[] $classes
     */
    public function parse($classes)
    {
        $config = [];
        foreach ($classes as $class) {
            $classAnnotationHolder = $this->parseClass($class);
            $event = new ParseEvent(ParseEvent::EVENT_CLASS_PARSED, $classAnnotationHolder, [
                'config' => $this->config,
                'scannedConfig' => $config
            ]);
            $this->eventManager->triggerEvent($event);
            $config = ArrayUtils::merge($config, $event->getResult());
        }

        $finalizeEvent = new ParseEvent(ParseEvent::EVENT_FINALIZE, $config, [
            'config' => $this->config
        ]);
        $this->eventManager->triggerEvent($finalizeEvent);
        $config = $finalizeEvent->getTarget();

        return $config;
    }

    /**
     * 
     * @param string $class
     * @return ClassAnnotationHolder
     */
    public function parseClass($class)
    {
        $ref = new ReflectionClass($class);
        $classAnnotationHolder = new ClassAnnotationHolder($ref);
        $classAnnotations = $this->annotationReader->getClassAnnotations($ref);

        foreach ($classAnnotations as $annotation) {
            $classAnnotationHolder->addAnnotation($annotation);
        }

        foreach ($ref->getMethods() as $method) {
            // zf can't process abstract methods for now, wrap with "try" block
            $methodAnnotationHolder = new MethodAnnotationHolder($method);
            $methodAnnotations = $this->annotationReader->getMethodAnnotations($method);
            foreach ($methodAnnotations as $annotation) {
                $methodAnnotationHolder->addAnnotation($annotation);
            }
            $classAnnotationHolder->addMethod($methodAnnotationHolder);
        }

        return $classAnnotationHolder;
    }

}
