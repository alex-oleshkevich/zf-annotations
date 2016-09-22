<?php

/**
 * Annotation module for Zend Framework 2.
 *
 * @link      https://github.com/alex-oleshkevich/zf-annotations the canonical source repository.
 * @copyright Copyright (c) 2014-2016 Alex Oleshkevich <alex.oleshkevich@gmail.com>
 * @license   http://en.wikipedia.org/wiki/MIT_License MIT
 */

namespace ZfAnnotation\Parser;

use ReflectionMethod;

/**
 * Contains method definition and its annotations.
 */
class MethodAnnotationHolder
{

    /**
     *
     * @var ReflectionMethod
     */
    protected $method;

    /**
     *
     * @var array
     */
    protected $annotations = [];

    /**
     * 
     * @param ReflectionMethod $method
     */
    public function __construct(ReflectionMethod $method)
    {
        $this->method = $method;
    }

    /**
     * 
     * @return ReflectionMethod
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * 
     * @param object $annotation
     */
    public function addAnnotation($annotation)
    {
        $this->annotations[] = $annotation;
    }

    /**
     * 
     * @return array
     */
    public function getAnnotations()
    {
        return $this->annotations;
    }

}
