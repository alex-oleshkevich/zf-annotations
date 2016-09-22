<?php

namespace ZfAnnotationTest\Service;

use ZfAnnotation\EventListener\ServiceListener;
use ZfAnnotation\Exception\InvalidAnnotationException;
use ZfAnnotationTest\AnnotationTestCase;

class_alias(InvalidAnnotationException::class, 'ZfaInvalidAnnotationException');

/**
 * @group zfa-service
 */
class ServiceTest extends AnnotationTestCase
{

    protected function setUp()
    {
        $this->listener = new ServiceListener;
    }

    public function testReturnsAllData()
    {
        $actual = $this->parse(TestAsset\CompleteServiceDefinition::class);
        $expected = array(
            'my_service_manager' => array(
                'invokables' => array(
                    'complete_service' => TestAsset\CompleteServiceDefinition::class,
                ),
                'shared' => array(
                    'complete_service' => false,
                ),
                'aliases' => array(
                    'cservice' => 'complete_service',
                    'shared_cservice' => 'complete_service',
                ),
            ),
        );
        $this->assertEquals($expected, $actual);
    }

    /**
     * @group zfa-service-factory
     */
    public function testFactoryService()
    {
        $actual = $this->parse(TestAsset\FactoryService::class);
        $expected = array(
            'service_manager' => array(
                'factories' => array(
                    TestAsset\FactoryService::class => TestAsset\FactoryService::class,
                ),
            ),
        );
        $this->assertEquals($expected, $actual);
    }

    /**
     * @expectedException ZfaInvalidAnnotationException
     */
    public function testInvalidFactoryService()
    {
        $this->parse(TestAsset\InvalidFactoryService::class);
    }

    public function testAbstractFactoryService()
    {
        $actual = $this->parse(TestAsset\AbstractFactoryService::class);
        $expected = array(
            'service_manager' => array(
                'abstract_factories' => array(
                    TestAsset\AbstractFactoryService::class,
                ),
            ),
        );
        $this->assertEquals($expected, $actual);
    }

    /**
     * @expectedException ZfaInvalidAnnotationException
     */
    public function testInvalidAbstractFactoryService()
    {
        $this->parse(TestAsset\InvalidAbstractFactoryService::class);
    }

    public function testDelegator()
    {
        $actual = $this->parse(TestAsset\Delegator::class);
        $expected = array(
            'service_manager' => array(
                'delegators' => array(
                    'IndexController' => array(
                        TestAsset\Delegator::class,
                    )
                ),
            ),
        );
        $this->assertEquals($expected, $actual);
    }

    /**
     * @expectedException ZfaInvalidAnnotationException
     */
    public function testInvalidDelegator()
    {
        $this->parse(TestAsset\InvalidDelegator::class);
    }

    /**
     * @expectedException ZfaInvalidAnnotationException
     */
    public function testInvalidDelegatorNoFor()
    {
        $this->parse(TestAsset\InvalidDelegatorNoFor::class);
    }

}
