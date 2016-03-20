<?php

/**
 * Annotation module for Zend Framework 2.
 *
 * @link      https://github.com/alex-oleshkevich/zf-annotations the canonical source repository.
 * @copyright Copyright (c) 2014-2016 Alex Oleshkevich <alex.oleshkevich@gmail.com>
 * @license   http://en.wikipedia.org/wiki/MIT_License MIT
 */

namespace ZfAnnotation\Service;

use Interop\Container\ContainerInterface;
use Zend\Code\Annotation\AnnotationManager;
use Zend\Code\Annotation\Parser\DoctrineAnnotationParser;
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
        return $this($serviceLocator, AnnotationManager::class);
    }

    /**
     * 
     * @param DoctrineAnnotationParser $parser
     * @return AnnotationManager
     */
    public static function factory(DoctrineAnnotationParser $parser)
    {
        $manager = new AnnotationManager;
        $manager->attach($parser);
        return $manager;
    }

    /**
     * 
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param array $options
     * @return AnnotationManager
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return self::factory($container->get('ZfAnnotation\DoctrineAnnotationParser'));
    }

}
