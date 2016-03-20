<?php

/**
 * Annotation module for Zend Framework 2.
 *
 * @link      https://github.com/alex-oleshkevich/zf-annotations the canonical source repository.
 * @copyright Copyright (c) 2014-2016 Alex Oleshkevich <alex.oleshkevich@gmail.com>
 * @license   http://en.wikipedia.org/wiki/MIT_License MIT
 */

namespace ZfAnnotation\Parser;

use Zend\Code\Annotation\AnnotationCollection;
use Zend\Code\Annotation\AnnotationManager;
use Zend\Code\Scanner\ClassScanner;
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
    protected $config = array();

    /**
     * @var AnnotationManager
     */
    protected $annotationManager;

    /**
     * @var EventManager
     */
    protected $eventManager;

    /**
     * @param array $config
     * @param AnnotationManager $annotationManager
     * @param EventManager $eventManager
     */
    public function __construct(array $config, AnnotationManager $annotationManager, EventManager $eventManager)
    {
        $this->config = $config;
        $this->annotationManager = $annotationManager;
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
     * @param ClassScanner[] $classes
     */
    public function parse($classes)
    {
        $config = array();
        foreach ($classes as $class) {
            $classAnnotationHolder = $this->parseClass($class);
            $event = new ParseEvent(ParseEvent::EVENT_CLASS_PARSED, $classAnnotationHolder, array(
                'config' => $this->config,
                'scannedConfig' => $config
            ));
            $this->eventManager->triggerEvent($event);
            $config = ArrayUtils::merge($config, $event->getResult());
        }
        
        $finalizeEvent = new ParseEvent(ParseEvent::EVENT_FINALIZE, $config, array(
            'config' => $this->config
        ));
        $this->eventManager->triggerEvent($finalizeEvent);
        $config = $finalizeEvent->getTarget();
        
        return $config;
    }

    /**
     * 
     * @param ClassScanner $class
     * @return ClassAnnotationHolder
     */
    public function parseClass(ClassScanner $class)
    {
        $classAnnotationHolder = new ClassAnnotationHolder($class);

        $classAnnotations = $class->getAnnotations($this->annotationManager);
        if ($classAnnotations instanceof AnnotationCollection) {
            foreach ($classAnnotations as $annotation) {
                $classAnnotationHolder->addAnnotation($annotation);
            }
        } else {
            $classAnnotations = new AnnotationCollection(array());
        }

        foreach ($class->getMethods() as $method) {
            // zf can't process abstract methods for now, wrap with "try" block
            $methodAnnotationHolder = new MethodAnnotationHolder($method);
            $methodAnnotations = $method->getAnnotations($this->annotationManager);
            if ($methodAnnotations instanceof AnnotationCollection) {
                foreach ($methodAnnotations as $annotation) {
                    $methodAnnotationHolder->addAnnotation($annotation);
                }
            }
            $classAnnotationHolder->addMethod($methodAnnotationHolder);
        }

        return $classAnnotationHolder;
    }

}
