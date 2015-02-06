<?php
/**
 * Annotation module for Zend Framework 2
 *
 * @link      https://github.com/alex-oleshkevich/zf-annotations the canonical source repository
 * @copyright Copyright (c) 2014 Alex Oleshkevich <alex.oleshkevich@gmail.com>
 * @license   http://en.wikipedia.org/wiki/MIT_License MIT
 */

namespace ZfAnnotation\Annotation;

/**
 * A controller annotation.
 * @Annotation
 */
class ControllerPlugin extends Service
{
    /**
     * @var string
     */
    public $serviceManagerKey = 'controller_plugins';
}
