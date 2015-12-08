<?php
namespace ZfAnnotation\Event;

use Zend\EventManager\Event;
use ZfAnnotation\Parser\ClassAnnotationHolder;

/**
 * @property ClassAnnotationHolder $target
 * @method ClassAnnotationHolder getTarget()
 */
class ParseEvent extends Event
{
    const EVENT_CLASS_PARSED = 'zfa.class-parsed';
    
    /**
     *
     * @var array
     */
    protected $result = array();
    
    /**
     * 
     * @return array
     */
    public function getResult()
    {
        return $this->result;
    }
    
    /**
     * 
     * @param array $array
     * @return array
     */
    public function mergeResult(array $array)
    {
        $this->result = array_replace_recursive($this->result, $array);
        return $this->result;
    }
}