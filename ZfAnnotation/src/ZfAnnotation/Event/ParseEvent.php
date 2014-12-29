<?php
namespace ZfAnnotation\Event;

use Zend\EventManager\Event;

class ParseEvent extends Event
{
    const EVENT_BEGIN = 'parse-begin';
    const EVENT_CLASS_ANNOTATION = 'class-annotation';
    const EVENT_METHOD_ANNOTATION = 'method-annotation';
    const EVENT_FINISH = 'parse-finish';
}