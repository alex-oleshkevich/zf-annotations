<?php

namespace ZfAnnotationTest\Factory;

use PHPUnit\Framework\TestCase;
use Zend\EventManager\EventManager;
use Zend\ServiceManager\ServiceManager;
use ZfAnnotation\Factory\AnnotationReaderFactory;
use ZfAnnotation\Factory\ClassParserFactory;
use ZfAnnotation\Parser\ClassParser;

/**
 * Description of ClassParserCreateFactoryTest
 *
 * @group zfa-factory
 * @group zfa-factory-classparser
 * @author Alex Oleshkevich <alex.oleshkevich@gmail.com>
 */
class ClassParserCreateFactoryTest extends TestCase
{

    protected $config = [
        'zf_annotation' => [
            'ignored_annotations' => [],
            'annotations' => [],
            'namespaces' => [],
            'event_listeners' => [],
            'cache' => null,
            'cache_debug' => true
        ]
    ];

    public function testCanCreateViaServiceManager()
    {
        $sm = new ServiceManager([
            'factories' => [
                'ZfAnnotation\AnnotationReader' => AnnotationReaderFactory::class,
                'ClassParser' => ClassParserFactory::class,
            ]
        ]);
        $sm->setService('EventManager', new EventManager);
        $sm->setService('Config', $this->config);

        $this->assertInstanceOf(ClassParser::class, $sm->get('ClassParser'));
    }

    public function testCanCreateViaStaticMethod()
    {
        $eventManager = new EventManager;
        $annotationReader = AnnotationReaderFactory::factory($this->config['zf_annotation']);
        $this->assertInstanceOf(ClassParser::class, ClassParserFactory::factory($this->config, $eventManager, $annotationReader));
    }

}
