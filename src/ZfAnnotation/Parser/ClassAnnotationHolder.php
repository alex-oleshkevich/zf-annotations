<?php
namespace ZfAnnotation\Parser;

use Zend\Code\Annotation\AnnotationCollection;
use Zend\Code\Annotation\AnnotationInterface;
use Zend\Code\Scanner\ClassScanner;

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
    protected $methods = array();
    
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
