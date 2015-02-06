<?php

namespace ZfAnnotationTest\Route;

use Zend\Code\Reflection\ClassReflection;
use ZfAnnotation\Annotation\Route;
use ZfAnnotation\Parser\ControllerAnnotationParser;
use ZfAnnotation\Service\RouteConfigBuilder;
use ZfAnnotationTest\AbstractAnnotationTestCase;
use ZfAnnotationTest\Route\TestController\NoBaseController;

class SimpleRouteAnnotationTest extends AbstractAnnotationTestCase
{

    /**
     * @group test
     */
    public function testAllParamsSetAndAccessible()
    {
        $config = $this->parse('ZfAnnotationTest\Route\TestController\NoBaseController')['router']['routes'];

        /* @var $route Route */
        $route = current($config);

        $expected = array(
            'type' => 'segment',
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
