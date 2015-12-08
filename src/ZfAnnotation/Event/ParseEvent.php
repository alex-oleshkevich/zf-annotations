<?php

/**
 * Annotation module for Zend Framework 2.
 *
 * @link      https://github.com/alex-oleshkevich/zf-annotations the canonical source repository.
 * @copyright Copyright (c) 2014-2016 Alex Oleshkevich <alex.oleshkevich@gmail.com>
 * @license   http://en.wikipedia.org/wiki/MIT_License MIT
 */

namespace ZfAnnotation\Event;

use Zend\EventManager\Event;
use Zend\Stdlib\ArrayUtils;
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
        $this->result = ArrayUtils::merge($this->result, $array);
        return $this->result;
    }

}
