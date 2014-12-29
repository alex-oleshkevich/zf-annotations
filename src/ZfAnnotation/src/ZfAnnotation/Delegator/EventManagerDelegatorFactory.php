<?php
/**
 * Annotated Router module for Zend Framework 2
 *
 * @link      https://github.com/alex-oleshkevich/zf2-annotated-routerfor the canonical source repository
 * @copyright Copyright (c) 2014 Alex Oleshkevich <alex.oleshkevich@gmail.com>
 * @license   http://en.wikipedia.org/wiki/MIT_License MIT
 */

namespace ZfAnnotation\Delegator;

use Zend\EventManager\EventManager;
use Zend\ServiceManager\DelegatorFactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use ZfAnnotation\Event\ParseEvent;

class EventManagerDelegatorFactory implements DelegatorFactoryInterface
{
    /**
     * @param ServiceLocatorInterface $serviceLocator
     * @param string $name
     * @param string $requestedName
     * @param callable $callback
     * @return EventManagereption
     */
    public function createDelegatorWithName(ServiceLocatorInterface $serviceLocator, $name, $requestedName, $callback)
    {
        /* @var $eventManager EventManager */
        $eventManager = $callback();
        $listeners = $serviceLocator->get('Config')['zf_annotation']['event_listeners'];
        foreach ($listeners as $listener) {
            $listenerInstance = new $listener; 
            $eventManager->attach(ParseEvent::EVENT_CLASS_ANNOTATION, array($listenerInstance, 'onClassAnnotationParsed'));
            $eventManager->attach(ParseEvent::EVENT_METHOD_ANNOTATION, array($listenerInstance, 'onMethodAnnotationParsed'));
            $eventManager->attach(ParseEvent::EVENT_FINISH, array($listenerInstance, 'onFinish'));
        }
        return $eventManager;
    }

}