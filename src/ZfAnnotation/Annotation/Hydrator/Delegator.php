<?php

namespace ZfAnnotation\Annotation\Hydrator;

use ZfAnnotation\Annotation\Delegator as BaseDelegator;

/**
 * @Annotation
 */
class Delegator extends BaseDelegator
{

    /**
     * @var string
     */
    public $serviceManagerKey = 'hydrators';

}
