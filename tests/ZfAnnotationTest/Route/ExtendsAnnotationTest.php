<?php

namespace ZfAnnotationTest\Route;

use ZfAnnotation\EventListener\RouteListener;
use ZfAnnotationTest\AnnotationTestCase;

/**
 * @group zfa-router
 * @group zfa-router-extends
 */
class ExtendsAnnotationTest extends AnnotationTestCase
{

    protected function setUp()
    {
        $this->listener = new RouteListener;
    }

    public function testIndexRouteCorrected()
    {
        $routeConfig = array(
            'default' => array(
                'type' => 'literal',
                'priority' => 0,
                'options' => array(
                    'route' => '/'
                ),
                'child_routes' => array(
                    'help' => array(
                        'type' => 'literal',
                        'priority' => 0,
                        'options' => array(
                            'route' => '/help'
                        ),
                    )
                )
            )
        );

        $config = array_replace_recursive($this->parse(TestAsset\ExtendsController::class)['router']['routes'], $routeConfig);

        $expected = array(
            'default' => array(
                'type' => 'literal',
                'priority' => 0,
                'options' => array(
                    'route' => '/'
                ),
                'child_routes' => array(
                    'help' => array(
                        'type' => 'literal',
                        'priority' => 0,
                        'options' => array(
                            'route' => '/help'
                        ),
                        'child_routes' => array(
                            'root' => array(
                                'type' => 'literal',
                                'priority' => 0,
                                'options' => array(
                                    'route' => '/root',
                                    'defaults' => array(
                                        'controller' => TestAsset\ExtendsController::class,
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
                                                'controller' => TestAsset\ExtendsController::class,
                                                'action' => 'index'
                                            ),
                                            'constraints' => null
                                        ),
                                        'may_terminate' => true,
                                        'child_routes' => array()
                                    )
                                )
                            )
                        ),
                    )
                ),
            )
        );

        $this->assertEquals($expected, $config);
    }

}
