<?php
namespace ZfAnnotation\Parser;

use Zend\Code\Annotation\AnnotationCollection;
use Zend\Code\Annotation\AnnotationInterface;
use Zend\Code\Scanner\MethodScanner;

class MethodAnnotationHolder
{
    /**
     *
     * @var MethodScanner
     */
    protected $method;
    
    /**
     *
     * @var AnnotationCollection
     */
    protected $annotations;
    
    /**
     * 
     * @param MethodScanner $method
     */
    public function __construct(MethodScanner $method)
    {
        $this->method = $method;
        $this->annotations = new AnnotationCollection;
    }
    
    /**
     * 
     * @return MethodScanner
     */
    public function getMethod()
    {
        return $this->method;
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
}
