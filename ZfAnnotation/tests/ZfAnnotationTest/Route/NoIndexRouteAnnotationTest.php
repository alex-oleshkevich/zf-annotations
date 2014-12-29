<?php

namespace ZfAnnotationTest\Route;

use ZfAnnotationTest\AbstractAnnotationTestCase;

/**
 * @group no-index
 */
class NoIndexRouteAnnotationTest extends AbstractAnnotationTestCase
{
    public function testIndexRouteCorrected()
    {
        $config = $this->parse('ZfAnnotationTest\Route\TestController\NoIndexRouteController')['router']['routes'];

        $expected = array(
            'root' => array(
                'type' => 'literal',
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
