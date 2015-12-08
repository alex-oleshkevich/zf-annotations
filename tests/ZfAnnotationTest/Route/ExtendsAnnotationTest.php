<?php

namespace ZfAnnotationTest\Route;

use ZfAnnotation\EventListener\RouteListener;
use ZfAnnotationTest\AnnotationTestCase;

/**
 * @group extends
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
        
        $config = array_replace_recursive($this->parse('ZfAnnotationTest\Route\TestController\ExtendsController')['router']['routes'], $routeConfig);

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
                                        'controller' => 'ZfAnnotationTest\Route\TestController\ExtendsController',
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
                                                'controller' => 'ZfAnnotationTest\Route\TestController\ExtendsController',
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
