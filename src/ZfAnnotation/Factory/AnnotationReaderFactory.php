<?php

/**
 * Annotation module for Zend Framework 2.
 *
 * @link      https://github.com/alex-oleshkevich/zf-annotations the canonical source repository.
 * @copyright Copyright (c) 2014-2016 Alex Oleshkevich <alex.oleshkevich@gmail.com>
 * @license   http://en.wikipedia.org/wiki/MIT_License MIT
 */

namespace ZfAnnotation\Factory;

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\AnnotationRegistry;
use Doctrine\Common\Annotations\CachedReader;
use Doctrine\Common\Cache\FilesystemCache;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class AnnotationReaderFactory implements FactoryInterface
{

    /**
     * 
     * @param ServiceLocatorInterface $serviceLocator
     * @return AnnotationReader
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return $this($serviceLocator, 'ZfAnnotation\AnnotationReader');
    }

    /**
     * 
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param array $options
     * @return AnnotationReader
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $config = $container->get('Config');
        return self::factory($config['zf_annotation']);
    }

    /**
     * 
     * @param array $config
     * @return AnnotationReader
     */
    public static function factory(array $config)
    {
        AnnotationRegistry::registerAutoloadNamespaces($config['namespaces']);

        $reader = new AnnotationReader;
        foreach ($config['ignored_annotations'] as $ignore) {
            $reader->addGlobalIgnoredName($ignore);
        }
        
        if (is_string($config['cache'])) {
            $reader = new CachedReader($reader, new FilesystemCache($config['cache'], 'cache'), $config['cache_debug']);
        }

        return $reader;
    }

}
