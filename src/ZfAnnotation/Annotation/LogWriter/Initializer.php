<?php

namespace ZfAnnotation\Annotation\LogWriter;

use ZfAnnotation\Annotation\Initializer as BaseInitializer;

/**
 * @Annotation
 */
class Initializer extends BaseInitializer
{

    /**
     * @var string
     */
    public $serviceManagerKey = 'log_writers';

}
