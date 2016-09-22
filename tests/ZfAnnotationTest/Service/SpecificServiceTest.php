<?php

namespace ZfAnnotationTest\Service;

use ZfAnnotation\EventListener\ServiceListener;
use ZfAnnotationTest\AnnotationTestCase;

/**
 * @group zfa-service
 */
class SpecificServiceTest extends AnnotationTestCase
{
    protected $config;
    
    protected function setUp()
    {
        $this->listener = new ServiceListener;
        $this->config = $this->parse(TestAsset\SpecificService::class);
    }

    public function testController()
    {
        $this->assertArrayHasKey('controllers', $this->config);
        $this->assertArrayHasKey('controller_plugins', $this->config);
        $this->assertArrayHasKey('filters', $this->config);
        $this->assertArrayHasKey('form_elements', $this->config);
        $this->assertArrayHasKey('hydrators', $this->config);
        $this->assertArrayHasKey('input_filters', $this->config);
        $this->assertArrayHasKey('log_processors', $this->config);
        $this->assertArrayHasKey('log_writers', $this->config);
        $this->assertArrayHasKey('route_manager', $this->config);
        $this->assertArrayHasKey('serializers', $this->config);
        $this->assertArrayHasKey('validators', $this->config);
        $this->assertArrayHasKey('view_helpers', $this->config);
    }
}
