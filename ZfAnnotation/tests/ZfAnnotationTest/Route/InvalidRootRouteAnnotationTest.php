<?php

namespace ZfAnnotationTest\Route;

use ZfAnnotationTest\AbstractAnnotationTestCase;

/**
 * @group invalid-root-node
 */
class InvalidRootRouteAnnotationTest extends AbstractAnnotationTestCase
{

    /**
     * @expectedException ZfAnnotation\Exception\InvalidArgumentException
     */
    public function testExceptionThrown()
    {
        $this->parse('ZfAnnotationTest\Route\TestController\InvalidRootRouteController')['router']['routes'];
    }

}
