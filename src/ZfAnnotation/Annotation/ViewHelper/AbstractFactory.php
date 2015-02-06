<?php

namespace ZfAnnotation\Annotation\ViewHelper;

use ZfAnnotation\Annotation\AbstractFactory as BaseAbstractFactory;

/**
 * @Annotation
 */
class AbstractFactory extends BaseAbstractFactory
{

    /**
     * @var string
     */
    public $serviceManagerKey = 'view_helpers';

}
