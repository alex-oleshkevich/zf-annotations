<?php

namespace ZfAnnotationTest\Factory;

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\CachedReader;
use PHPUnit\Framework\TestCase;
use Zend\ServiceManager\ServiceManager;
use ZfAnnotation\Factory\AnnotationReaderFactory;

/**
 *
 * @group zfa-factory
 * @author Alex Oleshkevich <alex.oleshkevich@gmail.com>
 */
class AnnotationReaderFactoryTest extends TestCase
{

    protected $config = [
        'zf_annotation' => [
            'ignored_annotations' => [],
            'annotations' => [],
            'namespaces' => [
                'ZfAnnotation\Annotation'
            ],
            'cache' => false,
            'cache_debug' => true
        ]
    ];

    public function testCanCreateViaServiceManager()
    {
        $sm = new ServiceManager([
            'factories' => [
                'AnnotationReader' => AnnotationReaderFactory::class
            ]
        ]);
        $sm->setService('Config', $this->config);
        $this->assertInstanceOf(AnnotationReader::class, $sm->get('AnnotationReader'));
    }

    public function testCanCreateViaStaticMethod()
    {
        $this->assertInstanceOf(AnnotationReader::class, AnnotationReaderFactory::factory($this->config['zf_annotation']));
    }

    public function testCreatesCachedReader()
    {
        $config = $this->config;
        $config['zf_annotation']['cache'] = sys_get_temp_dir();
        $this->assertInstanceOf(CachedReader::class, AnnotationReaderFactory::factory($config['zf_annotation']));
    }

}
