<?php

/**
 * Annotation module for Zend Framework 2.
 *
 * @link      https://github.com/alex-oleshkevich/zf-annotations the canonical source repository.
 * @copyright Copyright (c) 2014-2016 Alex Oleshkevich <alex.oleshkevich@gmail.com>
 * @license   http://en.wikipedia.org/wiki/MIT_License MIT
 */

namespace ZfAnnotation\Annotation;

/**
 * A service annotation.
 * 
 * @Annotation
 */
class Service
{

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $type = 'invokable';

    /**
     * @var bool
     */
    public $shared;

    /**
     * @var array
     */
    public $aliases = [];

    /**
     * @var string
     */
    public $serviceManager = 'service_manager';

    /**
     * Used with delegator services.
     * 
     * @var string
     */
    public $for;

    /**
     * @var string
     */
    public $factoryClass;

    /**
     * @param array $content
     */
    public function initialize($content)
    {
        
    }

    /**
     * 
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * 
     * @return bool
     */
    public function hasType()
    {
        return (bool) $this->type;
    }

    /**
     * 
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * 
     * @return bool|null
     */
    public function getShared()
    {
        return $this->shared;
    }

    /**
     * 
     * @return array
     */
    public function getAliases()
    {
        return (array) $this->aliases;
    }

    /**
     * 
     * @return string
     */
    public function getServiceManager()
    {
        return $this->serviceManager;
    }

    /**
     * 
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * 
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * 
     * @param bool $shared
     */
    public function setShared($shared)
    {
        $this->shared = (bool) $shared;
    }

    /**
     * 
     * @param array $aliases
     */
    public function setAliases(array $aliases = [])
    {
        $this->aliases = $aliases;
    }

    /**
     * 
     * @return string
     */
    public function getFor()
    {
        return $this->for;
    }

    /**
     * 
     * @param string $for
     */
    public function setFor($for)
    {
        $this->for = $for;
    }

    /**
     * 
     * @return string
     */
    public function getFactoryClass()
    {
        return $this->factoryClass;
    }

    /**
     * 
     * @param string $factoryClass
     */
    public function setFactoryClass($factoryClass)
    {
        $this->factoryClass = $factoryClass;
    }

}
