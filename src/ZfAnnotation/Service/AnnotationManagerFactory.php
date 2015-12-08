<?php

/**
 * Annotation module for Zend Framework 2
 *
 * @link      https://github.com/alex-oleshkevich/zf-annotations the canonical source repository
 * @copyright Copyright (c) 2014 Alex Oleshkevich <alex.oleshkevich@gmail.com>
 * @license   http://en.wikipedia.org/wiki/MIT_License MIT
 */

namespace ZfAnnotation\Service;

use Zend\Code\Annotation\AnnotationManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Annotation manager factory.
 */
class AnnotationManagerFactory implements FactoryInterface
{

    /**
     * @param ServiceLocatorInterface $serviceLocator
     * @return AnnotationManager
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $manager = new AnnotationManager;
        $manager->attach($serviceLocator->get('ZfAnnotation\DoctrineAnnotationParser'));
        return $manager;
    }
    
    /**
     * 
     * @param array $annotations
     * @return AnnotationManager
     */
    public static function factory(array $annotations)
    {
        $manager = new AnnotationManager;
        $manager->attach(DoctrineAnnotationParserFactory::factory($annotations));
        return $manager;
    }

}
