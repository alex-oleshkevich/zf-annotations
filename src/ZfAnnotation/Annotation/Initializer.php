<?php
/**
 * Annotated Router module for Zend Framework 2
 *
 * @link      https://github.com/alex-oleshkevich/zf2-annotated-routerfor the canonical source repository
 * @copyright Copyright (c) 2014 Alex Oleshkevich <alex.oleshkevich@gmail.com>
 * @license   http://en.wikipedia.org/wiki/MIT_License MIT
 */

namespace ZfAnnotation\Annotation;

use Zend\Code\Annotation\AnnotationInterface;

/**
 * @Annotation
 */
class Initializer implements AnnotationInterface
{
    /**
     * @var string
     */
    public $serviceManagerKey = 'service_manager';

    /**
     * @param array $content
     */
    public function initialize($content)
    {
    }

    public function getServiceManagerKey()
    {
        return $this->serviceManagerKey;
    }
}
