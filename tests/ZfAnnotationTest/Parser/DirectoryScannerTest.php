<?php

namespace ZfAnnotationTest\Parser;

use PHPUnit\Framework\TestCase;
use ReflectionClass;
use ZfAnnotation\Parser\DirectoryScanner;
use ZfAnnotationTest\Parser\Assets\ClassAsset;

/**
 * @group zfa-parser
 */
class DirectoryScannerTest extends TestCase
{

    public function testYieldsClasses()
    {
        $scanner = new DirectoryScanner;
        foreach ($scanner->scan(__DIR__ . '/Assets') as $class) {
            $this->assertEquals(ClassAsset::class, $class);
        }
    }

}
