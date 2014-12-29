<?php
/**
 * Annotated Router module for Zend Framework 2
 *
 * @link      https://github.com/alex-oleshkevich/zf2-annotated-routerfor the canonical source repository
 * @copyright Copyright (c) 2014 Alex Oleshkevich <alex.oleshkevich@gmail.com>
 * @license   http://en.wikipedia.org/wiki/MIT_License MIT
 */

namespace ZfAnnotation\Service;

use Zend\Code\Annotation\AnnotationManager;
use Zend\Code\Annotation\Parser\DoctrineAnnotationParser;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Annotatin manager factory.
 * Registers required annotations.
 */
class AnnotationManagerFactory implements FactoryInterface
{

    /**
     * @param ServiceLocatorInterface $serviceLocator
     * @return AnnotationManager
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $annotationManager = new AnnotationManager;
        $parser = new DoctrineAnnotationParser;
        $parser->registerAnnotation('ZfAnnotation\Annotation\Route');
        $annotationManager->attach($parser);
        return $annotationManager;
    }

}
