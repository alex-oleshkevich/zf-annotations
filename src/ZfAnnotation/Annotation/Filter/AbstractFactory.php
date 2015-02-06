<?php

namespace ZfAnnotation\Annotation\Filter;

use ZfAnnotation\Annotation\AbstractFactory as BaseAbstractFactory;

/**
 * @Annotation
 */
class AbstractFactory extends BaseAbstractFactory
{

    /**
     * @var string
     */
    public $serviceManagerKey = 'filters';

}
