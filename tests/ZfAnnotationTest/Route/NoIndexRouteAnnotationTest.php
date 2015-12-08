<?php

namespace ZfAnnotationTest\Route;

use ZfAnnotation\EventListener\RouteListener;
use ZfAnnotationTest\AnnotationTestCase;

/**
 * @group no-index
 */
class NoIndexRouteAnnotationTest extends AnnotationTestCase
{

    protected function setUp()
    {
        $this->listener = new RouteListener;
    }

    public function testIndexRouteCorrected()
    {
        $config = $this->parse('ZfAnnotationTest\Route\TestController\NoIndexRouteController')['router']['routes'];

        $expected = array(
            'root' => array(
                'type' => 'literal',
                'priority' => 0,
                'options' => array(
                    'route' => '/root',
                    'defaults' => array(
                        'controller' => 'ZfAnnotationTest\Route\TestController\NoIndexRouteController',
                        'action' => 'index'
                    ),
                    'constraints' => null
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'index' => array(
                        'type' => 'literal',
                        'priority' => 0,
                        'options' => array(
                            'route' => '/index',
                            'defaults' => array(
                                'controller' => 'ZfAnnotationTest\Route\TestController\NoIndexRouteController',
                                'action' => 'index'
                            ),
                            'constraints' => null
                        ),
                        'may_terminate' => true,
                        'child_routes' => array()
                    ),
                    'edit' => array(
                        'type' => 'literal',
                        'priority' => 0,
                        'options' => array(
                            'route' => '/edit',
                            'defaults' => array(
                                'controller' => 'ZfAnnotationTest\Route\TestController\NoIndexRouteController',
                                'action' => 'edit'
                            ),
                            'constraints' => null
                        ),
                        'may_terminate' => true,
                        'child_routes' => array()
                    ),
                    'remove' => array(
                        'type' => 'literal',
                        'priority' => 0,
                        'options' => array(
                            'route' => '/remove',
                            'defaults' => array(
                                'controller' => 'ZfAnnotationTest\Route\TestController\NoIndexRouteController',
                                'action' => 'remove'
                            ),
                            'constraints' => null
                        ),
                        'may_terminate' => true,
                        'child_routes' => array()
                    )
                )
            )
        );

        $this->assertEquals($expected, $config);
    }

}
