<?php

/**
 * Annotation module for Zend Framework 2.
 *
 * @link      https://github.com/alex-oleshkevich/zf-annotations the canonical source repository.
 * @copyright Copyright (c) 2014-2016 Alex Oleshkevich <alex.oleshkevich@gmail.com>
 * @license   http://en.wikipedia.org/wiki/MIT_License MIT
 */

namespace ZfAnnotation\Parser;

use Zend\Code\Annotation\AnnotationCollection;
use Zend\Code\Annotation\AnnotationInterface;
use Zend\Code\Scanner\ClassScanner;

/**
 * Contains class definition and its annotations.
 */
class ClassAnnotationHolder
{

    /**
     *
     * @var ClassScanner
     */
    protected $class;

    /**
     *
     * @var AnnotationCollection
     */
    protected $annotations;

    /**
     *
     * @var MethodAnnotationHolder[]
     */
    protected $methods = [];

    /**
     * 
     * @param ClassScanner $class
     */
    public function __construct(ClassScanner $class)
    {
        $this->class = $class;
        $this->annotations = new AnnotationCollection;
    }

    /**
     * 
     * @return ClassScanner
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * 
     * @param AnnotationInterface $annotation
     */
    public function addAnnotation(AnnotationInterface $annotation)
    {
        $this->annotations->append($annotation);
    }

    /**
     * 
     * @return AnnotationCollection
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
