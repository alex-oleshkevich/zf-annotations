<?php

namespace ZfAnnotation\EventListener;

use Zend\Code\Scanner\ClassScanner;
use ZfAnnotation\Annotation\AbstractFactory;
use ZfAnnotation\EventListener\ListenerInterface;
use ZfAnnotation\Event\ParseEvent;

class AbstractFactoryListener implements ListenerInterface
{

    const PRIORITY = 1;

    protected $definitions = array();

    /**
     * @param ParseEvent $event
     */
    public function onParseBegin(ParseEvent $event)
    {

    }

    /**
     * @param ParseEvent $event
     */
    public function onClassAnnotationParsed(ParseEvent $event)
    {
        /* @var $annotation Service */
        $annotation = $event->getTarget();

        /* @var $class ClassScanner */
        $class = $event->getParam('class');

        if (!$annotation instanceof AbstractFactory) {
            return false;
        }

        if (!$annotation->getName()) {
            $annotation->setName($class->getName());
        }

        $this->definitions[$annotation->getServiceManagerKey()]['abstract_factories'][$annotation->getName()] = $class->getName();
    }

    /**
     * @param ParseEvent $event
     */
    public function onMethodAnnotationParsed(ParseEvent $event)
    {

    }

    /**
     * @param ParseEvent $event
     */
    public function onParseFinish(ParseEvent $event)
    {
        $event->getTarget()->merge($this->definitions);
    }

    public function getPriority()
    {
        return self::PRIORITY;
    }
}
