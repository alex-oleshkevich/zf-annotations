<?php

namespace ZfAnnotation\Annotation\LogProcessor;

use ZfAnnotation\Annotation\Initializer as BaseInitializer;

/**
 * @Annotation
 */
class Initializer extends BaseInitializer
{

    /**
     * @var string
     */
    public $serviceManagerKey = 'log_processors';

}
