<?php

namespace ZfAnnotation\Annotation\Hydrator;

use ZfAnnotation\Annotation\Initializer as BaseInitializer;

/**
 * @Annotation
 */
class Initializer extends BaseInitializer
{

    /**
     * @var string
     */
    public $serviceManagerKey = 'hydrators';

}
