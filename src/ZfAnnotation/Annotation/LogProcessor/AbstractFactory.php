<?php

namespace ZfAnnotation\Annotation\LogProcessor;

use ZfAnnotation\Annotation\AbstractFactory as BaseAbstractFactory;

/**
 * @Annotation
 */
class AbstractFactory extends BaseAbstractFactory
{

    /**
     * @var string
     */
    public $serviceManagerKey = 'log_processors';

}
