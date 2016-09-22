<?php

namespace ZfAnnotationTest\Parser;

use PHPUnit_Framework_TestCase;
use ReflectionClass;
use ZfAnnotation\Parser\DirectoryScanner;
use ZfAnnotationTest\Parser\Assets\ClassAsset;

/**
 * @group zfa-parser
 */
class DirectoryScannerTest extends PHPUnit_Framework_TestCase
{

    public function testYieldsClasses()
    {
        $scanner = new DirectoryScanner;
        foreach ($scanner->scan(__DIR__ . '/Assets') as $class) {
            $this->assertEquals(ClassAsset::class, $class);
        }
    }

}
