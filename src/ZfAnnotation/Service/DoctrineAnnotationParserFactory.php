<?php

/**
 * Annotation module for Zend Framework 2.
 *
 * @link      https://github.com/alex-oleshkevich/zf-annotations the canonical source repository.
 * @copyright Copyright (c) 2014-2016 Alex Oleshkevich <alex.oleshkevich@gmail.com>
 * @license   http://en.wikipedia.org/wiki/MIT_License MIT
 */

namespace ZfAnnotation\Service;

use Zend\Code\Annotation\Parser\DoctrineAnnotationParser;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class DoctrineAnnotationParserFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('Config');
        $parser = new DoctrineAnnotationParser;
        $parser->registerAnnotations($config['zf_annotation']['annotations']);
        return $parser;
    }

    /**
     * 
     * @param array $annotations
     * @return DoctrineAnnotationParser
     */
    public static function factory(array $annotations)
    {
        $parser = new DoctrineAnnotationParser;
        $parser->registerAnnotations($annotations);
        return $parser;
    }

}
