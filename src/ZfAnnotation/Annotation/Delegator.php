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
 * @Annotation
 */
class Delegator implements AnnotationInterface
{
    public $for;

    /**
     * @var string
     */
    public $serviceManagerKey = 'service_manager';

    public function hasFor()
    {
        return (bool) $this->for;
    }

    public function getFor()
    {
        return $this->for;
    }

    /**
     * @param array $content
     */
    public function initialize($content)
    {
    }

    public function getServiceManagerKey()
    {
        return $this->serviceManagerKey;
    }

}
