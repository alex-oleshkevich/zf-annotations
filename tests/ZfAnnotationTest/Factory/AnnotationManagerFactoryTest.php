<?php

namespace ZfAnnotationTest\Factory;

use PHPUnit_Framework_TestCase;
use Zend\Code\Annotation\AnnotationManager;
use Zend\Code\Annotation\Parser\DoctrineAnnotationParser;
use Zend\ServiceManager\ServiceManager;
use ZfAnnotation\Service\AnnotationManagerFactory;
use ZfAnnotation\Service\DoctrineAnnotationParserFactory;

/**
 *
 * @group zfa-factories
 * @author Alex Oleshkevich <alex.oleshkevich@gmail.com>
 */
class AnnotationManagerFactoryTest extends PHPUnit_Framework_TestCase
{

    public function testCanCreateViaServiceManager()
    {
        $sm = new ServiceManager([
            'factories' => [
                'ZfAnnotation\DoctrineAnnotationParser' => DoctrineAnnotationParserFactory::class,
                'AnnotationManager' => AnnotationManagerFactory::class
            ]
        ]);
        $sm->setService('Config', [
            'zf_annotation' => [
                'annotations' => []
            ]
        ]);
        
        $this->assertInstanceOf(AnnotationManager::class, $sm->get('AnnotationManager'));
    }

    public function testCanCreateViaStaticMethod()
    {
        $this->assertInstanceOf(AnnotationManager::class, AnnotationManagerFactory::factory(new DoctrineAnnotationParser));
    }

}
