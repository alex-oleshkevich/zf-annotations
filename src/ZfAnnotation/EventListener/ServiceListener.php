<?php

namespace ZfAnnotation\EventListener;

use Exception;
use Zend\Code\Scanner\ClassScanner;
use ZfAnnotation\Annotation\Service;
use ZfAnnotation\Event\ParseEvent;
use ZfAnnotation\EventListener\ListenerInterface;

class ServiceListener implements ListenerInterface
{
    const PRIORITY = 1;

    /**
     * @var array
     */
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

        if (!$annotation instanceof Service) {
            return false;
        }

        if (!$annotation->getName()) {
            $annotation->setName($class->getName());
        }

        switch ($annotation->getType()) {
            case 'invokable':
                $this->definitions[$annotation->getServiceManagerKey()]['invokables'][$annotation->getName()] = $class->getName();
                break;
            case 'factory':
                $this->definitions[$annotation->getServiceManagerKey()]['factories'][$annotation->getName()] = $class->getName();
                break;
            default:
                throw new Exception('[Annotation] AbstractService annotation must have "type" property value. Seen in ' . $class->getName());
        }

        if (is_bool($annotation->getShared())) {
            $this->definitions[$annotation->getServiceManagerKey()]['shared'][$annotation->getName()] = $annotation->isShared();
        }

        if ($annotation->hasAliases()) {
            foreach ($annotation->getAliases() as $alias) {
                $this->definitions[$annotation->getServiceManagerKey()]['aliases'][$alias] = $annotation->getName();
            }
        }
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
