<?php

namespace ZfAnnotation\EventListener;

use ZfAnnotation\Event\ParseEvent;

interface ListenerInterface
{
    public function getPriority();
    public function onParseBegin(ParseEvent $event);
    public function onClassAnnotationParsed(ParseEvent $event);
    public function onMethodAnnotationParsed(ParseEvent $event);
    public function onParseFinish(ParseEvent $event);
}