<?php

use ZfAnnotation\EventListener\RouteListener;
use ZfAnnotation\EventListener\ServiceListener;
use ZfAnnotation\Factory\AnnotationReaderFactory;
use ZfAnnotation\Factory\ClassParserFactory;

/**
 * Annotated Router module for Zend Framework 2
 *
 * @link      https://github.com/alex-oleshkevich/zf2-annotated-routerfor the canonical source repository.
 * @copyright Copyright (c) 2014-2016 Alex Oleshkevich <alex.oleshkevich@gmail.com>
 * @license   http://en.wikipedia.org/wiki/MIT_License MIT
 */
return [
    'zf_annotation' => [
        'ignored_annotations' => [
            'events'
        ],
        'scan_modules' => [],
        'namespaces' => [
            'ZfAnnotation\Annotation'
        ],
        'annotations' => [],
        'event_listeners' => [
            RouteListener::class,
            ServiceListener::class
        ],
        'cache' => null,
        'cache_debug' => true
    ],
    'service_manager' => [
        'factories' => [
            'ZfAnnotation\AnnotationReader' => AnnotationReaderFactory::class,
            'ZfAnnotation\Parser' => ClassParserFactory::class,
        ]
    ],
];
