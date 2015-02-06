<?php

namespace ZfAnnotation\Annotation\Serializer;

use ZfAnnotation\Annotation\AbstractFactory as BaseAbstractFactory;

/**
 * @Annotation
 */
class AbstractFactory extends BaseAbstractFactory
{

    /**
     * @var string
     */
    public $serviceManagerKey = 'serializers';

}
