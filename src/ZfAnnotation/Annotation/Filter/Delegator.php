<?php

namespace ZfAnnotation\Annotation\Filter;

use ZfAnnotation\Annotation\Delegator as BaseDelegator;

/**
 * @Annotation
 */
class Delegator extends BaseDelegator
{

    /**
     * @var string
     */
    public $serviceManagerKey = 'filters';

}
