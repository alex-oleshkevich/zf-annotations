<?php

namespace ZfAnnotation\Annotation;

/**
 * A controller annotation.
 * @Annotation
 */
class Filter extends Service
{
    /**
     * @var string
     */
    public $serviceManagerKey = 'filters';
}
