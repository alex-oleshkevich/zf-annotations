<?php

namespace ZfAnnotation\EventListener;

use Exception;
use Zend\Code\Scanner\ClassScanner;
use ZfAnnotation\Annotation\Delegator;
use ZfAnnotation\EventListener\ListenerInterface;
use ZfAnnotation\Event\ParseEvent;

class DelegatorListener implements ListenerInterface
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

        if (!$annotation instanceof Delegator) {
            return false;
        }

        if (!$annotation->hasFor()) {
            throw new Exception('[Annotation] Delegator annotation must contain "for" parameter.');
        }

        $this->definitions[$annotation->getServiceManagerKey()]['delegators'][$annotation->getFor()][] = $class->getName();
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
