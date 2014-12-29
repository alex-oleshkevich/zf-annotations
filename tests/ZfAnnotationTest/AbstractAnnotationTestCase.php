<?php

namespace ZfAnnotationTest;

use PHPUnit_Framework_TestCase;
use Zend\Code\Annotation\AnnotationManager;
use Zend\Code\Annotation\Parser\DoctrineAnnotationParser;
use Zend\Code\Scanner\DirectoryScanner;
use Zend\EventManager\EventManager;
use ZfAnnotation\Config\Collection;
use ZfAnnotation\Event\ParseEvent;
use ZfAnnotation\Event\RouteListener;
use ZfAnnotation\Parser\ClassParser;

class AbstractAnnotationTestCase extends PHPUnit_Framework_TestCase
{

    public function parse($class)
    {
        $annotationManager = new AnnotationManager;
        $parser = new DoctrineAnnotationParser;
        $parser->registerAnnotation('ZfAnnotation\Annotation\Route');
        $annotationManager->attach($parser);

        $scanner = new DirectoryScanner('.');
        $class = $scanner->getClass($class);
        
        $eventManager = new EventManager;
        $listenerInstance = new RouteListener;
        $eventManager->attach(ParseEvent::EVENT_BEGIN, array($listenerInstance, 'onParseBegin'));
        $eventManager->attach(ParseEvent::EVENT_CLASS_ANNOTATION, array($listenerInstance, 'onClassAnnotationParsed'));
        $eventManager->attach(ParseEvent::EVENT_METHOD_ANNOTATION, array($listenerInstance, 'onMethodAnnotationParsed'));
        $eventManager->attach(ParseEvent::EVENT_FINISH, array($listenerInstance, 'onParseFinish'));

        $configCollection = new Collection(array(
            'controllers' => array(
                'invokables' => array(
                    'AliasedController' => 'ZfAnnotationTest\Route\TestController\DefinedController'
                )
            )
        ));
        
        $parser = new ClassParser([$class], $annotationManager, $eventManager, $configCollection);
        return $parser->parse();
    }

}
