<?php

namespace ZfAnnotationTest\Service;

use ZfAnnotation\EventListener\ServiceListener;
use ZfAnnotation\Exception\InvalidAnnotationException;
use ZfAnnotation\Service\TestService\AbstractFactoryService;
use ZfAnnotation\Service\TestService\CompleteServiceDefinition;
use ZfAnnotation\Service\TestService\Delegator;
use ZfAnnotation\Service\TestService\FactoryService;
use ZfAnnotation\Service\TestService\InvalidAbstractFactoryService;
use ZfAnnotation\Service\TestService\InvalidDelegator;
use ZfAnnotation\Service\TestService\InvalidDelegatorNoFor;
use ZfAnnotation\Service\TestService\InvalidFactoryService;
use ZfAnnotationTest\AnnotationTestCase;

class_alias(InvalidAnnotationException::class, 'ZfaInvalidAnnotationException');

/**
 * @group service
 */
class ServiceTest extends AnnotationTestCase
{

    protected function setUp()
    {
        $this->listener = new ServiceListener;
    }

    public function testReturnsAllData()
    {
        $actual = $this->parse(CompleteServiceDefinition::class);
        $expected = array(
            'my_service_manager' => array(
                'invokables' => array(
                    'complete_service' => 'ZfAnnotation\Service\TestService\CompleteServiceDefinition',
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
    
    public function testFactoryService()
    {
        $actual = $this->parse(FactoryService::class);
        $expected = array(
            'service_manager' => array(
                'factories' => array(
                    'ZfAnnotation\Service\TestService\FactoryService' => 'ZfAnnotation\Service\TestService\FactoryService',
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
        $this->parse(InvalidFactoryService::class);
    }
    
    public function testAbstractFactoryService()
    {
        $actual = $this->parse(AbstractFactoryService::class);
        $expected = array(
            'service_manager' => array(
                'abstract_factories' => array(
                    'ZfAnnotation\Service\TestService\AbstractFactoryService',
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
        $this->parse(InvalidAbstractFactoryService::class);
    }
    
    public function testDelegator()
    {
        $actual = $this->parse(Delegator::class);
        $expected = array(
            'service_manager' => array(
                'delegators' => array(
                    'IndexController' => array(
                        'ZfAnnotation\Service\TestService\Delegator',
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
        $this->parse(InvalidDelegator::class);
    }
    
    
    /**
     * @expectedException ZfaInvalidAnnotationException
     */
    public function testInvalidDelegatorNoFor()
    {
        $this->parse(InvalidDelegatorNoFor::class);
    }
    
}
