<?php

/**
 * Annotation module for Zend Framework 2.
 *
 * @link      https://github.com/alex-oleshkevich/zf-annotations the canonical source repository.
 * @copyright Copyright (c) 2014-2016 Alex Oleshkevich <alex.oleshkevich@gmail.com>
 * @license   http://en.wikipedia.org/wiki/MIT_License MIT
 */

namespace ZfAnnotation\Service;

use Zend\Code\Annotation\AnnotationManager;
use Zend\EventManager\EventManager;
use Zend\EventManager\EventManagerInterface;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use ZfAnnotation\Parser\ClassParser;

/**
 * Creates a class parser.
 */
class ClassParserFactory implements FactoryInterface
{

    /**
     * @param ServiceLocatorInterface $serviceLocator
     * @return ClassParser
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /* @var $eventManager EventManager */
        $eventManager = $serviceLocator->get('EventManager');
        $annotationManager = $serviceLocator->get('ZfAnnotation\AnnotationManager');
        $config = $serviceLocator->get('Config');

        return self::factory($config, $eventManager, $annotationManager);
    }

    /**
     * 
     * @param array $config
     * @param EventManagerInterface $eventManager
     * @return ClassParser
     */
    public static function factory(array $config, EventManagerInterface $eventManager, AnnotationManager $annotationManager = null)
    {
        if (null === $annotationManager) {
            $annotationManager = AnnotationManagerFactory::factory($config['zf_annotation']['annotations']);
        }
        $parser = new ClassParser($config, $annotationManager, $eventManager);
        foreach ($config['zf_annotation']['event_listeners'] as $listener) {
            $parser->attach(new $listener);
        }
        return $parser;
    }

}
