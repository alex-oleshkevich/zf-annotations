<?php

namespace ZfAnnotation\Annotation\ViewHelper;

use ZfAnnotation\Annotation\Delegator as BaseDelegator;

/**
 * @Annotation
 */
class Delegator extends BaseDelegator
{

    /**
     * @var string
     */
    public $serviceManagerKey = 'view_helpers';

}
