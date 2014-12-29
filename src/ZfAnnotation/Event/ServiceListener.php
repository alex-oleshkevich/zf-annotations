<?php

namespace ZfAnnotation\Event;

use Zend\Code\Scanner\ClassScanner;
use ZfAnnotation\Annotation\Service;
use ZfAnnotation\Event\ListenerInterface;
use ZfAnnotation\Event\ParseEvent;

class ServiceListener implements ListenerInterface
{
    const PRIORITY = 1;
    
    const SERVICE_MANAGER_KEY = 'service_manager';
    
    /**
     * @var array
     */
    protected $invokables = array();
    
    /**
     * @var array
     */
    protected $factories = array();
    
    /**
     * @var array
     */
    protected $abstractFactories = array();
    
    /**
     * @var array
     */
    protected $initializers = array();
    
    /**
     * @var array
     */
    protected $delegators = array();
    
    /**
     * @var array
     */
    protected $shared = array();
    
    /**
     * @var array
     */
    protected $aliases = array();

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
        
        if ($annotation instanceof Service) {
            if (!$annotation->getName()) {
                $annotation->setName($class->getName());
            }
            
            switch ($annotation->getType()) {
                case 'invokable':
                    $this->invokables[$annotation->getName()] = $class->getName();
                    break;
                case 'factory':
                    $this->factories[$annotation->getName()] = $class->getName();
                    break;
                case 'abstract_factory':
                    $this->abstractFactories[$annotation->getName()] = $class->getName();
                    break;
                case 'initializer':
                    $this->initializers[$annotation->getName()] = $class->getName();
                    break;
            }
            
            if (in_array($annotation->getType(), ['invokable', 'factory'])) {
                $this->shared[$annotation->getName()] = $annotation->getShared();
            }
            
            foreach ($annotation->getAliases() as $alias) {
                $this->aliases[$alias] = $annotation->getName();
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
        var_dump($this->invokables);
        $event->getTarget()->set(static::SERVICE_MANAGER_KEY, array(
            'invokables' => $this->invokables,
            'factories' => $this->factories,
            'abstract_factories' => $this->abstractFactories,
            'initializers' => $this->initializers,
            'delegators' => $this->delegators,
            'shared' => $this->shared,
            'aliases' => $this->aliases
        ));
    }

    public function getPriority()
    {
        return self::PRIORITY;
    }
}
