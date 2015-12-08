<?php

/**
 * Annotated Router module for Zend Framework 2
 *
 * @link      https://github.com/alex-oleshkevich/zf2-annotated-routerfor the canonical source repository
 * @copyright Copyright (c) 2014 Alex Oleshkevich <alex.oleshkevich@gmail.com>
 * @license   http://en.wikipedia.org/wiki/MIT_License MIT
 */
return array(
    'zf_annotation' => array(
        'scan_modules' => [],
        'annotations' => array(
            'ZfAnnotation\Annotation\Route',
            'ZfAnnotation\Annotation\Service',
        ),
        'event_listeners' => array(
            'ZfAnnotation\EventListener\RouteListener',
            'ZfAnnotation\EventListener\ServiceListener',
        )
    ),
    'service_manager' => array(
        'factories' => array(
            'ZfAnnotation\DoctrineAnnotationParser' => 'ZfAnnotation\Service\DoctrineAnnotationParserFactory',
            'ZfAnnotation\AnnotationManager' => 'ZfAnnotation\Service\AnnotationManagerFactory',
            'ZfAnnotation\Parser' => 'ZfAnnotation\Service\ClassParserFactory',
        )
    ),
);
