<?php

namespace ZfAnnotation\Annotation\Serializer;

use ZfAnnotation\Annotation\Delegator as BaseDelegator;

/**
 * @Annotation
 */
class Delegator extends BaseDelegator
{

    /**
     * @var string
     */
    public $serviceManagerKey = 'serializers';

}
