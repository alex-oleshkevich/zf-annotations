<?php

namespace ZfAnnotationTest\Route;

use ZfAnnotation\EventListener\RouteListener;
use ZfAnnotationTest\AnnotationTestCase;

/**
 * @group resolve
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
                    'AliasedController' => 'ZfAnnotationTest\Route\TestController\DefinedController'
                )
            )
        );
        $route = $this->parse('ZfAnnotationTest\Route\TestController\DefinedController', $controllerConfig)['router']['routes']['index'];

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
