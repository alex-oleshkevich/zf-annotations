<?php

namespace ZfAnnotationTest\Route;

use ZfAnnotation\EventListener\RouteListener;
use ZfAnnotationTest\AnnotationTestCase;

/**
 * @group zfa-router
 * @group zfa-router-priority
 */
class PriorityRouteAnnotationTest extends AnnotationTestCase
{

    protected function setUp()
    {
        $this->listener = new RouteListener;
    }

    public function testPriorityAdded()
    {
        $config = $this->parse(TestAsset\PriorityController::class)['router']['routes'];

        $expected = array(
            'index' =>
            array(
                'type' => 'segment',
                'options' =>
                array(
                    'route' => '/root/:id/:method',
                    'defaults' =>
                    array(
                        'controller' => TestAsset\PriorityController::class,
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
