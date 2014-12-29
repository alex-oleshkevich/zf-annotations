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
        'directories' => array(),
        // parse controllers on every request. disable for prod
        'compile_on_request' => true,

        // a file to dump router config
        'cache_file' => 'data/cache/annotated-config.cache.php',

        // use cached routes instead of controllers parsing
        'use_cache' => false,
        
        'annotations' => array(
            'ZfAnnotation\Annotation\Route',
            'ZfAnnotation\Annotation\Service',
            'ZfAnnotation\Annotation\Controller',
        ),
        'event_listeners' => array(
            'ZfAnnotation\Event\RouteListener',
            'ZfAnnotation\Event\ServiceListener',
            'ZfAnnotation\Event\ControllerListener',
        )
    ),
    'service_manager' => array(
        'delegators' => array(
            'EventManager' => array(
            )
        ),
        'factories' => array(
            'ZfAnnotation\AnnotationManager' => 'ZfAnnotation\Service\AnnotationManagerFactory',
            'ZfAnnotation\Service\ClassParser' => 'ZfAnnotation\Service\ClassParserFactory',
            'ZfAnnotation\Config\Collection' => 'ZfAnnotation\Service\ConfigCollectionFactory',
        )
    ),
    'controllers' => array(
        'invokables' => array(
            'ZfAnnotation\Controller\Console' => 'ZfAnnotation\Controller\ConsoleController'
        )
    ),
    'console' => array(
        'router' => array(
            'routes' => array(
                'config-dump' => array(
                    'options' => array(
                        'route'    => 'config dump',
                        'defaults' => array(
                            'controller' => 'ZfAnnotation\Controller\Console',
                            'action'     => 'dump'
                        )
                    )
                ),
            )
        )
    )
);