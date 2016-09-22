<?php

namespace ZfAnnotationTest\Route;

use ZfAnnotation\EventListener\RouteListener;
use ZfAnnotationTest\AnnotationTestCase;

/**
 * @group zfa-router
 * @group zfa-router-resolve
 */
class ParserResolvesControllerTest extends AnnotationTestCase
{

    protected function setUp()
    {
        $this->listener = new RouteListener;
    }

    public function testIndexRouteCorrected()
    {
        $controllerConfig = array(
            'controllers' => array(
                'invokables' => array(
                    'AliasedController' => TestAsset\DefinedController::class
                )
            )
        );
        $route = $this->parse(TestAsset\DefinedController::class, $controllerConfig)['router']['routes']['index'];

        $expected = array(
            'type' => 'literal',
            'priority' => 0,
            'options' => array(
                'route' => '/index',
                'defaults' => array(
                    'controller' => 'AliasedController',
                    'action' => 'index',
                ),
                'constraints' => null,
            ),
            'may_terminate' => true,
            'child_routes' => array(),
        );

        $this->assertEquals($expected, $route);
    }

}
