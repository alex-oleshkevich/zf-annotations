<?php

namespace ZfAnnotationTest\Route;

use ZfAnnotation\EventListener\RouteListener;
use ZfAnnotationTest\AnnotationTestCase;

/**
 * @group priority
 */
class PriorityRouteAnnotationTest extends AnnotationTestCase
{

    protected function setUp()
    {
        $this->listener = new RouteListener;
    }

    public function testPriorityAdded()
    {
        $config = $this->parse('ZfAnnotationTest\Route\TestController\PriorityController')['router']['routes'];

        $expected = array(
            'index' =>
            array(
                'type' => 'segment',
                'options' =>
                array(
                    'route' => '/root/:id/:method',
                    'defaults' =>
                    array(
                        'controller' => 'ZfAnnotationTest\\Route\\TestController\\PriorityController',
                        'action' => 'index',
                    ),
                    'constraints' =>
                    array(
                        'id' => '\\d+',
                        'method' => '\\w+',
                    ),
                ),
                'priority' => 1000,
                'may_terminate' => true,
                'child_routes' =>
                array(
                ),
            ),
        );

        $this->assertEquals($expected, $config);
    }

}
