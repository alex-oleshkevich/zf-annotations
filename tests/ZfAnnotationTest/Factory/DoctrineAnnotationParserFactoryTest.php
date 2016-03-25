<?php

namespace ZfAnnotationTest\Factory;

use PHPUnit_Framework_TestCase;
use Zend\Code\Annotation\Parser\DoctrineAnnotationParser;
use Zend\ServiceManager\Config;
use Zend\ServiceManager\ServiceManager;
use ZfAnnotation\Service\DoctrineAnnotationParserFactory;

/**
 *
 * @group zfa-factories
 * @author Alex Oleshkevich <alex.oleshkevich@gmail.com>
 */
class DoctrineAnnotationParserFactoryTest2 extends PHPUnit_Framework_TestCase
{

    public function testCanCreateViaServiceManager()
    {
        $sm = new ServiceManager([
            'factories' => [
                'DoctrineAnnotationParser' => DoctrineAnnotationParserFactory::class
            ]
        ]);
        $sm->setService('Config', [
            'zf_annotation' => [
                'annotations' => []
            ]
        ]);

        $this->assertInstanceOf(DoctrineAnnotationParser::class, $sm->get('DoctrineAnnotationParser'));
    }

    public function testCanCreateViaStaticMethod()
    {
        $this->assertInstanceOf(DoctrineAnnotationParser::class, DoctrineAnnotationParserFactory::factory([]));
    }
}
