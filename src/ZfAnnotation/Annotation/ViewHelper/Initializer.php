<?php

namespace ZfAnnotation\Annotation\ViewHelper;

use ZfAnnotation\Annotation\Initializer as BaseInitializer;

/**
 * @Annotation
 */
class Initializer extends BaseInitializer
{

    /**
     * @var string
     */
    public $serviceManagerKey = 'view_helpers';

}
