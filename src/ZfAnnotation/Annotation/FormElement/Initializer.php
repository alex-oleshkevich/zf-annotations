<?php

namespace ZfAnnotation\Annotation\FormElement;

use ZfAnnotation\Annotation\Initializer as BaseInitializer;

/**
 * @Annotation
 */
class Initializer extends BaseInitializer
{

    /**
     * @var string
     */
    public $serviceManagerKey = 'form_elements';

}
