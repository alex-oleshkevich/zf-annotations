<?php

namespace ZfAnnotationTest\Factory;

use PHPUnit_Framework_TestCase;
use Zend\Code\Annotation\AnnotationManager;
use Zend\EventManager\EventManager;
use Zend\ServiceManager\ServiceManager;
use ZfAnnotation\Parser\ClassParser;
use ZfAnnotation\Service\AnnotationManagerFactory;
use ZfAnnotation\Service\ClassParserFactory;
use ZfAnnotation\Service\DoctrineAnnotationParserFactory;

/**
 * Description of ClassParserCreateFactoryTest
 *
 * @group zfa-factories
 * @group zfa-class-parser
 * @author Alex Oleshkevich <alex.oleshkevich@gmail.com>
 */
class ClassParserCreateFactoryTest extends PHPUnit_Framework_TestCase
{
    public function testCanCreateViaServiceManager()
    {
        $sm = new ServiceManager([
            'factories' => [
                'ZfAnnotation\DoctrineAnnotationParser' => DoctrineAnnotationParserFactory::class,
                'ZfAnnotation\AnnotationManager' => AnnotationManagerFactory::class,
                'ClassParser' => ClassParserFactory::class
            ]
        ]);
        $sm->setService('EventManager', new EventManager);
        $sm->setService('Config', [
            'zf_annotation' => [
                'annotations' => [],
                'event_listeners' => []
            ]
        ]);
        
        $this->assertInstanceOf(ClassParser::class, $sm->get('ClassParser'));
    }

    public function testCanCreateViaStaticMethod()
    {
        $config = [
            'zf_annotation' => [
                'annotations' => [],
                'event_listeners' => []
            ]
        ];
        $eventManager = new EventManager;
        $annotationManager = new AnnotationManager;
        $this->assertInstanceOf(ClassParser::class, ClassParserFactory::factory($config, $eventManager, $annotationManager));
    }
}
