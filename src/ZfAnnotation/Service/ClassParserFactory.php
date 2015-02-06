<?php
/**
 * Annotation module for Zend Framework 2
 *
 * @link      https://github.com/alex-oleshkevich/zf2-annotated-router for the canonical source repository
 * @copyright Copyright (c) 2014 Alex Oleshkevich <alex.oleshkevich@gmail.com>
 * @license   http://en.wikipedia.org/wiki/MIT_License MIT
 */

namespace ZfAnnotation\Service;

use Exception;
use Zend\Code\Annotation\AnnotationManager;
use Zend\Code\Annotation\Parser\DoctrineAnnotationParser;
use Zend\Code\Scanner\DirectoryScanner;
use Zend\EventManager\EventManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\ServiceManager;
use ZfAnnotation\Config\Collection;
use ZfAnnotation\Event\ParseEvent;
use ZfAnnotation\Parser\ClassParser;
use ZfAnnotation\Parser\ControllerParser;

/**
 * Creates a class parser.
 */
class ClassParserFactory implements FactoryInterface
{
    /**
     * @param ServiceLocatorInterface $serviceLocator
     * @return ControllerParser
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return self::factory($serviceLocator->get('Config'), $serviceLocator);
    }
    
    /**
     * @param array $config
     * @param ServiceManager $serviceManager
     * @return ClassParser
     */
    public static function factory(array $config, ServiceManager $serviceManager)
    {
        $annotationManager = new AnnotationManager;
        $parser = new DoctrineAnnotationParser;
        $parser->registerAnnotations($config['zf_annotation']['annotations']);
        $annotationManager->attach($parser);
        
        /* @var $eventManager EventManager */
        $eventManager = $serviceManager->get('EventManager');
        foreach ($config['zf_annotation']['event_listeners'] as $listener) {
            $listenerInstance = new $listener; 
            $eventManager->attach(ParseEvent::EVENT_BEGIN, array($listenerInstance, 'onParseBegin'), $listenerInstance->getPriority());
            $eventManager->attach(ParseEvent::EVENT_CLASS_ANNOTATION, array($listenerInstance, 'onClassAnnotationParsed'), $listenerInstance->getPriority());
            $eventManager->attach(ParseEvent::EVENT_METHOD_ANNOTATION, array($listenerInstance, 'onMethodAnnotationParsed'), $listenerInstance->getPriority());
            $eventManager->attach(ParseEvent::EVENT_FINISH, array($listenerInstance, 'onParseFinish'));
        }
        
        if (empty($config['zf_annotation']['directories'])) {
            throw new Exception('No scan directories configured. See zf_annotation.directories[] config property or refer the documentation.');
        }
        $directoryScanner = new DirectoryScanner($config['zf_annotation']['directories']);
        return new ClassParser($directoryScanner->getClasses(), $annotationManager, $eventManager, new Collection($config));
    }
}