<?php
/**
 * Annotation module for Zend Framework 2
 *
 * @link      https://github.com/alex-oleshkevich/zf-annotations the canonical source repository
 * @copyright Copyright (c) 2014 Alex Oleshkevich <alex.oleshkevich@gmail.com>
 * @license   http://en.wikipedia.org/wiki/MIT_License MIT
 */

namespace ZfAnnotation\Annotation;

use Zend\Code\Annotation\AnnotationInterface;

/**
 * A route annotation.
 * @Annotation
 */
class AbstractFactory implements AnnotationInterface
{

    /**
     * @var string
     */
    public $name;

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

    public function getServiceManagerKey()
    {
        return $this->serviceManagerKey;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function setServiceManagerKey($serviceManagerKey)
    {
        $this->serviceManagerKey = $serviceManagerKey;
    }

}
