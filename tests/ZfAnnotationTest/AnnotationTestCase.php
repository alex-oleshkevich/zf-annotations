<?php

namespace ZfAnnotationTest;

use PHPUnit_Framework_TestCase;
use Zend\Code\Annotation\AnnotationManager;
use Zend\Code\Annotation\Parser\DoctrineAnnotationParser;
use Zend\Code\Scanner\DirectoryScanner;
use Zend\EventManager\AbstractListenerAggregate;
use Zend\EventManager\EventManager;
use ZfAnnotation\Annotation\Controller;
use ZfAnnotation\Annotation\ControllerPlugin;
use ZfAnnotation\Annotation\Filter;
use ZfAnnotation\Annotation\FormElement;
use ZfAnnotation\Annotation\Hydrator;
use ZfAnnotation\Annotation\InputFilter;
use ZfAnnotation\Annotation\LogProcessor;
use ZfAnnotation\Annotation\LogWriter;
use ZfAnnotation\Annotation\Route;
use ZfAnnotation\Annotation\RoutePlugin;
use ZfAnnotation\Annotation\Serializer;
use ZfAnnotation\Annotation\Service;
use ZfAnnotation\Annotation\Validator;
use ZfAnnotation\Annotation\ViewHelper;
use ZfAnnotation\Event\ParseEvent;
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
     * @return ClassAnnotationHolder
     */
    public function parse($class, array $config = array())
    {
        $annotationManager = new AnnotationManager;
        $parser = new DoctrineAnnotationParser;
        $parser->registerAnnotation(Route::class);
        $parser->registerAnnotation(Service::class);
        $parser->registerAnnotation(Controller::class);
        $parser->registerAnnotation(ControllerPlugin::class);
        $parser->registerAnnotation(Filter::class);
        $parser->registerAnnotation(FormElement::class);
        $parser->registerAnnotation(Hydrator::class);
        $parser->registerAnnotation(InputFilter::class);
        $parser->registerAnnotation(LogProcessor::class);
        $parser->registerAnnotation(LogWriter::class);
        $parser->registerAnnotation(Route::class);
        $parser->registerAnnotation(RoutePlugin::class);
        $parser->registerAnnotation(Serializer::class);
        $parser->registerAnnotation(Validator::class);
        $parser->registerAnnotation(ViewHelper::class);
        $annotationManager->attach($parser);

        $scanner = new DirectoryScanner('.');
        $class = $scanner->getClass($class);

        $eventManager = new EventManager;

        $parser = new ClassParser($config, $annotationManager, $eventManager);
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
