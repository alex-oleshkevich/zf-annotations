<?php

namespace ZfAnnotationTest\Route;

use ZfAnnotationTest\AbstractAnnotationTestCase;

/**
 * @group resolve
 */
class ParserResolvesControllerTest extends AbstractAnnotationTestCase
{

    public function testIndexRouteCorrected()
    {
        $config = $this->parse('ZfAnnotationTest\Route\TestController\DefinedController')['router']['routes'];

        /* @var $route Route */
        $route = current($config);

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
