<?php
/**
 * Annotated Router module for Zend Framework 2
 *
 * @link      https://github.com/alex-oleshkevich/zf2-annotated-routerfor the canonical source repository
 * @copyright Copyright (c) 2014 Alex Oleshkevich <alex.oleshkevich@gmail.com>
 * @license   http://en.wikipedia.org/wiki/MIT_License MIT
 */

namespace ZfAnnotation\Annotation;

use Zend\Code\Annotation\AnnotationInterface;

/**
 * A route annotation.
 * @Annotation
 */
class Service implements AnnotationInterface
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
    public $aliases = array();

    /**
     * @var string
     */
    public $serviceManagerKey = 'service_manager';

    /**
     * @param array $content
     */
    public function initialize($content)
    {
    }

    public function getName()
    {
        return $this->name;
    }

    public function hasType()
    {
        return (bool) $this->type;
    }

    public function getType()
    {
        return $this->type;
    }

    public function isShared()
    {
        return $this->shared;
    }

    public function getShared()
    {
        return $this->shared;
    }

    public function hasAliases()
    {
        return !empty($this->getAliases());
    }

    public function getAliases()
    {
        return (array) $this->aliases;
    }

    public function getServiceManagerKey()
    {
        return $this->serviceManagerKey;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function setType($type)
    {
        $this->type = $type;
    }

    public function setShared($shared)
    {
        $this->shared = $shared;
    }

    public function setAliases($aliases)
    {
        $this->aliases = $aliases;
    }

}
