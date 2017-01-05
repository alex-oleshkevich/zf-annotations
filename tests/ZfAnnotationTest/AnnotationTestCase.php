<?php

namespace ZfAnnotationTest;

use PHPUnit_Framework_TestCase;
use Zend\EventManager\AbstractListenerAggregate;
use Zend\EventManager\EventManager;
use ZfAnnotation\Event\ParseEvent;
use ZfAnnotation\Factory\AnnotationReaderFactory;
use ZfAnnotation\Parser\ClassAnnotationHolder;
use ZfAnnotation\Parser\ClassParser;

class AnnotationTestCase extends PHPUnit_Framework_TestCase
{
    /**
     *
     * @var AbstractListenerAggregate
     */
    protected $listener;
    
    /**
     * 
     * @param string $class
     * @param array $config
     * @return ClassParser
     */
    public function createParser(array $config = array())
    {
        $annotationReader = AnnotationReaderFactory::factory([
            'annotations' => [],
            'cache' => null,
            'cache_debug' => false,
            'ignored_annotations' => [
                'events'
            ],
            'namespaces' => [
                'ZfAnnotation\Annotation' => __DIR__ . '/../../src'
            ]
        ]);

        $eventManager = new EventManager;
        return new ClassParser($config, $annotationReader, $eventManager);        
    }
    
    
    /**
     * 
     * @param string $class
     * @param array $config
     * @return ClassAnnotationHolder
     */
    public function parse($class, array $config = array())
    {
        $parser = $this->createParser($config);
        return $this->handleClassAnnotations($parser->parseClass($class), $config);
    }

    /**
     * 
     * @param ClassAnnotationHolder $annotations
     * @return array
     */
    protected function handleClassAnnotations(ClassAnnotationHolder $annotations, array $config = array())
    {
        $events = new EventManager;
        $this->listener->attach($events);
        
        $event = new ParseEvent(ParseEvent::EVENT_CLASS_PARSED, $annotations, ['config' => $config, 'scannedConfig' => array()]);
        $events->triggerEvent($event);
        
        $finalizeEvent = new ParseEvent(ParseEvent::EVENT_FINALIZE, $event->getResult(), ['config' => $config]);
        $events->triggerEvent($finalizeEvent);
        return $finalizeEvent->getTarget();
    }

}
