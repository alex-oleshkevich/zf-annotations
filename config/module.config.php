<?php

use ZfAnnotation\Annotation\Controller;
use ZfAnnotation\Annotation\ControllerPlugin;
use ZfAnnotation\Annotation\Filter;
use ZfAnnotation\Annotation\FormElement;
use ZfAnnotation\Annotation\Hydrator;
use ZfAnnotation\Annotation\InputFilter;
use ZfAnnotation\Annotation\LogProcessor;
use ZfAnnotation\Annotation\LogWriter;
use ZfAnnotation\Annotation\Route;
use ZfAnnotation\Annotation\RoutePlugin;
use ZfAnnotation\Annotation\Serializer;
use ZfAnnotation\Annotation\Validator;
use ZfAnnotation\Annotation\ViewHelper;
use ZfAnnotation\EventListener\RouteListener;
use ZfAnnotation\EventListener\ServiceListener;
use ZfAnnotation\Service\AnnotationManagerFactory;
use ZfAnnotation\Service\ClassParserFactory;
use ZfAnnotation\Service\DoctrineAnnotationParserFactory;
use ZfExtra\Controller\Plugin\Service;

/**
 * Annotated Router module for Zend Framework 2
 *
 * @link      https://github.com/alex-oleshkevich/zf2-annotated-routerfor the canonical source repository.
 * @copyright Copyright (c) 2014-2016 Alex Oleshkevich <alex.oleshkevich@gmail.com>
 * @license   http://en.wikipedia.org/wiki/MIT_License MIT
 */
return array(
    'zf_annotation' => array(
        'scan_modules' => [],
        'annotations' => array(
            Controller::class,
            ControllerPlugin::class,
            Filter::class,
            FormElement::class,
            Hydrator::class,
            InputFilter::class,
            LogProcessor::class,
            LogWriter::class,
            Route::class,
            RoutePlugin::class,
            Serializer::class,
            Service::class,
            Validator::class,
            ViewHelper::class
        ),
        'event_listeners' => array(
            RouteListener::class,
            ServiceListener::class
        )
    ),
    'service_manager' => array(
        'factories' => array(
            'ZfAnnotation\DoctrineAnnotationParser' => DoctrineAnnotationParserFactory::class,
            'ZfAnnotation\AnnotationManager' => AnnotationManagerFactory::class,
            'ZfAnnotation\Parser' => ClassParserFactory::class,
        )
    ),
);
