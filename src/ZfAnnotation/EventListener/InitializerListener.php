<?php

namespace ZfAnnotation\EventListener;

use Zend\Code\Scanner\ClassScanner;
use ZfAnnotation\Annotation\Initializer;
use ZfAnnotation\EventListener\ListenerInterface;
use ZfAnnotation\Event\ParseEvent;

class InitializerListener implements ListenerInterface
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

        if (!$annotation instanceof Initializer) {
            return false;
        }

        $this->definitions[$annotation->getServiceManagerKey()]['initializers'][] = $class->getName();
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
