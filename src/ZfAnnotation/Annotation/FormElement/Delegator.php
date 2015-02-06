<?php

namespace ZfAnnotation\Annotation\FormElement;

use ZfAnnotation\Annotation\Delegator as BaseDelegator;

/**
 * @Annotation
 */
class Delegator extends BaseDelegator
{

    /**
     * @var string
     */
    public $serviceManagerKey = 'form_elements';

}
