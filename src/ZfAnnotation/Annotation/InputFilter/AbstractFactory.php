<?php

namespace ZfAnnotation\Annotation\InputFilter;

use ZfAnnotation\Annotation\AbstractFactory as BaseAbstractFactory;

/**
 * @Annotation
 */
class AbstractFactory extends BaseAbstractFactory
{

    /**
     * @var string
     */
    public $serviceManagerKey = 'input_filters';

}
