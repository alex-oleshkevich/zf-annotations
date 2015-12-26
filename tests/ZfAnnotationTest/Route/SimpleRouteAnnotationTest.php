<?php

namespace ZfAnnotationTest\Route;

use ZfAnnotation\EventListener\RouteListener;
use ZfAnnotationTest\AnnotationTestCase;

class SimpleRouteAnnotationTest extends AnnotationTestCase
{

    protected function setUp()
    {
        $this->listener = new RouteListener;
    }

    /**
     * @group test
     */
    public function testAllParamsSetAndAccessible()
    {
        $route = $this->parse('ZfAnnotationTest\Route\TestController\NoBaseController')['router']['routes']['complete-definition'];

        $expected = array(
            'type' => 'segment',
            'priority' => 0,
            'options' => array(
                'route' => '/complete-definition/:id/:method',
                'defaults' => array(
                    'controller' => 'nobase',
                    'action' => 'complete-definition-action',
                ),
                'constraints' => array(
                    'id' => '\\d+',
                    'method' => '\\w+',
                ),
            ),
            'may_terminate' => true,
            'child_routes' => array(),
        );

        $this->assertEquals($expected, $route);
    }

    public function testAutodetectRouteName()
    {
        $config = $this->parse('ZfAnnotationTest\Route\TestController\NoBaseController')['router']['routes'];
        $this->assertArrayHasKey('no-route-name', $config);

        $routeArray = array(
            'type' => 'literal',
            'priority' => 0,
            'options' => array(
                'route' => '/route',
                'defaults' => array(
                    'controller' => 'nobase',
                    'action' => 'no-route'
                ),
                'constraints' => null
            ),
            'may_terminate' => true,
            'child_routes' => array(),
        );

        $this->assertEquals($routeArray, $config['no-route-name']);
    }

    public function testAutodetectRoute()
    {
        $config = $this->parse('ZfAnnotationTest\Route\TestController\NoBaseController')['router']['routes'];
        $this->assertArrayHasKey('no-route', $config);

        $routeArray = array(
            'type' => 'literal',
            'priority' => 0,
            'options' => array(
                'route' => '/no-route',
                'defaults' => array(
                    'controller' => 'nobase',
                    'action' => 'no-route'
                ),
                'constraints' => null
            ),
            'may_terminate' => true,
            'child_routes' => array(),
        );

        $this->assertEquals($routeArray, $config['no-route']);
    }

    public function testAutodetectType()
    {
        $config = $this->parse('ZfAnnotationTest\Route\TestController\NoBaseController')['router']['routes'];
        $this->assertArrayHasKey('no-type', $config);

        $routeArray = array(
            'type' => 'literal',
            'priority' => 0,
            'options' => array(
                'route' => '/no-type',
                'defaults' => array(
                    'controller' => 'nobase',
                    'action' => 'no-route'
                ),
                'constraints' => null
            ),
            'may_terminate' => true,
            'child_routes' => array(),
        );

        $this->assertEquals($routeArray, $config['no-type']);
    }

    public function testAutodetectController()
    {
        $config = $this->parse('ZfAnnotationTest\Route\TestController\NoBaseController')['router']['routes'];
        $this->assertArrayHasKey('no-controller', $config);

        $routeArray = array(
            'type' => 'literal',
            'priority' => 0,
            'options' => array(
                'route' => '/no-controller',
                'defaults' => array(
                    'controller' => 'ZfAnnotationTest\Route\TestController\NoBaseController',
                    'action' => 'no-route'
                ),
                'constraints' => null
            ),
            'may_terminate' => true,
            'child_routes' => array(),
        );

        $this->assertEquals($routeArray, $config['no-controller']);
    }

    public function testAutodetectAction()
    {
        $config = $this->parse('ZfAnnotationTest\Route\TestController\NoBaseController')['router']['routes'];
        $this->assertArrayHasKey('no-action', $config);

        $routeArray = array(
            'type' => 'literal',
            'priority' => 0,
            'options' => array(
                'route' => '/no-action',
                'defaults' => array(
                    'controller' => 'ZfAnnotationTest\Route\TestController\NoBaseController',
                    'action' => 'no-action'
                ),
                'constraints' => null
            ),
            'may_terminate' => true,
            'child_routes' => array(),
        );

        $this->assertEquals($routeArray, $config['no-action']);
    }

}
