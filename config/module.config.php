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
        'compile_on_request' => false,
        // use cached routes instead of controllers parsing
        'use_cache' => false,
        // a file to dump router config
        'cache_file' => 'data/cache/annotated-config.cache.php',
        'annotations' => array(
            'ZfAnnotation\Annotation\Route',
            'ZfAnnotation\Annotation\Service',
            'ZfAnnotation\Annotation\AbstractFactory',
            'ZfAnnotation\Annotation\Initializer',
            'ZfAnnotation\Annotation\Delegator',
            'ZfAnnotation\Annotation\Controller',
            'ZfAnnotation\Annotation\Controller\AbstractFactory',
            'ZfAnnotation\Annotation\Controller\Initializer',
            'ZfAnnotation\Annotation\Controller\Delegator',
            'ZfAnnotation\Annotation\ControllerPlugin',
            'ZfAnnotation\Annotation\ControllerPlugin\AbstractFactory',
            'ZfAnnotation\Annotation\ControllerPlugin\Initializer',
            'ZfAnnotation\Annotation\ControllerPlugin\Delegator',
            'ZfAnnotation\Annotation\Filter',
            'ZfAnnotation\Annotation\Filter\AbstractFactory',
            'ZfAnnotation\Annotation\Filter\Initializer',
            'ZfAnnotation\Annotation\Filter\Delegator',
            'ZfAnnotation\Annotation\FormElement',
            'ZfAnnotation\Annotation\FormElement\AbstractFactory',
            'ZfAnnotation\Annotation\FormElement\Initializer',
            'ZfAnnotation\Annotation\FormElement\Delegator',
            'ZfAnnotation\Annotation\Hydrator',
            'ZfAnnotation\Annotation\Hydrator\AbstractFactory',
            'ZfAnnotation\Annotation\Hydrator\Initializer',
            'ZfAnnotation\Annotation\Hydrator\Delegator',
            'ZfAnnotation\Annotation\InputFilter',
            'ZfAnnotation\Annotation\InputFilter\AbstractFactory',
            'ZfAnnotation\Annotation\InputFilter\Initializer',
            'ZfAnnotation\Annotation\InputFilter\Delegator',
            'ZfAnnotation\Annotation\LogProcessor',
            'ZfAnnotation\Annotation\LogProcessor\AbstractFactory',
            'ZfAnnotation\Annotation\LogProcessor\Initializer',
            'ZfAnnotation\Annotation\LogProcessor\Delegator',
            'ZfAnnotation\Annotation\LogWriter',
            'ZfAnnotation\Annotation\LogWriter\AbstractFactory',
            'ZfAnnotation\Annotation\LogWriter\Initializer',
            'ZfAnnotation\Annotation\LogWriter\Delegator',
            'ZfAnnotation\Annotation\RoutePlugin',
            'ZfAnnotation\Annotation\RoutePlugin\AbstractFactory',
            'ZfAnnotation\Annotation\RoutePlugin\Initializer',
            'ZfAnnotation\Annotation\RoutePlugin\Delegator',
            'ZfAnnotation\Annotation\Serializer',
            'ZfAnnotation\Annotation\Serializer\AbstractFactory',
            'ZfAnnotation\Annotation\Serializer\Initializer',
            'ZfAnnotation\Annotation\Serializer\Delegator',
            'ZfAnnotation\Annotation\Validator',
            'ZfAnnotation\Annotation\Validator\AbstractFactory',
            'ZfAnnotation\Annotation\Validator\Initializer',
            'ZfAnnotation\Annotation\Validator\Delegator',
            'ZfAnnotation\Annotation\ViewHelper',
            'ZfAnnotation\Annotation\ViewHelper\AbstractFactory',
            'ZfAnnotation\Annotation\ViewHelper\Initializer',
            'ZfAnnotation\Annotation\ViewHelper\Delegator',
        ),
        'event_listeners' => array(
            'ZfAnnotation\EventListener\RouteListener',
            'ZfAnnotation\EventListener\ServiceListener',
            'ZfAnnotation\EventListener\AbstractFactoryListener',
            'ZfAnnotation\EventListener\InitializerListener',
            'ZfAnnotation\EventListener\DelegatorListener',
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
                        'route' => 'config dump',
                        'defaults' => array(
                            'controller' => 'ZfAnnotation\Controller\Console',
                            'action' => 'dump'
                        )
                    )
                ),
            )
        )
    )
);
