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
use Zend\Code\Annotation\Parser\DoctrineAnnotationParser;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class DoctrineAnnotationParserFactory implements FactoryInterface
{

    /**
     * 
     * @param ServiceLocatorInterface $serviceLocator
     * @return DoctrineAnnotationParser
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return $this($serviceLocator, DoctrineAnnotationParser::class);
    }
    
    /**
     * 
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param array $options
     * @return DoctrineAnnotationParser
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $config = $container->get('Config');
        return self::factory($config['zf_annotation']['annotations']);        
    }

    /**
     * 
     * @param array $annotations
     * @return DoctrineAnnotationParser
     */
    public static function factory(array $annotations = array())
    {
        $parser = new DoctrineAnnotationParser;
        $parser->registerAnnotations($annotations);
        return $parser;
    }

}
