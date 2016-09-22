<?php

/**
 * Annotation module for Zend Framework 2.
 *
 * @link      https://github.com/alex-oleshkevich/zf-annotations the canonical source repository.
 * @copyright Copyright (c) 2014-2016 Alex Oleshkevich <alex.oleshkevich@gmail.com>
 * @license   http://en.wikipedia.org/wiki/MIT_License MIT
 */

namespace ZfAnnotation\Parser;

use ReflectionClass;

/**
 * Contains class definition and its annotations.
 */
class ClassAnnotationHolder
{

    /**
     *
     * @var ReflectionClass
     */
    protected $class;

    /**
     *
     * @var array
     */
    protected $annotations = [];

    /**
     *
     * @var MethodAnnotationHolder[]
     */
    protected $methods = [];

    /**
     * 
     * @param ReflectionClass $class
     */
    public function __construct(ReflectionClass $class)
    {
        $this->class = $class;
    }

    /**
     * 
     * @return ReflectionClass
     */
    public function getClass()
    {
        return $this->class;
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

    /**
     * 
     * @param MethodAnnotationHolder $methodHolder
     */
    public function addMethod(MethodAnnotationHolder $methodHolder)
    {
        $this->methods[] = $methodHolder;
    }

    /**
     * 
     * @return MethodAnnotationHolder[]
     */
    public function getMethods()
    {
        return $this->methods;
    }

}
