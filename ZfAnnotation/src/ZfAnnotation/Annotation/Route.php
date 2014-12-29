<?php
/**
 * Annotated Router module for Zend Framework 2
 *
 * @link      https://github.com/alex-oleshkevich/zf2-annotated-routerfor the canonical source repository
 * @copyright Copyright (c) 2014 Alex Oleshkevich <alex.oleshkevich@gmail.com>
 * @license   http://en.wikipedia.org/wiki/MIT_License MIT
 */

namespace ZfAnnotation\Annotation;

use ZfAnnotation\Exception\InvalidArgumentException;
use Zend\Code\Annotation\AnnotationInterface;

/**
 * A route annotation.
 * @Annotation
 */
class Route implements AnnotationInterface
{

    /**
     * Route name.
     * "name" key in standard config.
     *
     * @var string
     */
    public $name;

    /**
     * Route type.
     * "type" key in standard config.
     * Default is "literal".
     *
     * @var string
     */
    public $type;

    /**
     * A route.
     * "options.route" key in standard config.
     *
     * @var string
     */
    public $route;

    /**
     * Defaults for route.
     * "options.default.[controller|action]" key in standard config.
     *
     * @var array
     */
    public $defaults;

    /**
     * Constraints.
     * "options.constraints" key in standard config.
     *
     * @var array
     */
    public $constraints;

    /**
     * May route terminate?
     * "may_terminate" key in standard config.
     *
     * @var bool
     */
    public $mayTerminate = true;

    /**
     * A parent route which is going to be extended.
     * Has no key in config.
     *
     * @var string
     */
    public $extends;

    /**
     * Unused as AR currently supports only Doctrine's implementation of annotations.
     *
     * @param array $content
     */
    public function initialize($content)
    {
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return bool
     */
    public function hasName()
    {
        return (bool) $this->name;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return bool
     */
    public function hasType()
    {
        return (bool) $this->type;
    }

    /**
     * @return string
     */
    public function getRoute()
    {
        return $this->route;
    }

    /**
     * @return bool
     */
    public function hasRoute()
    {
        return (bool) $this->route;
    }

    /**
     * @return array
     */
    public function getDefaults()
    {
        return $this->defaults;
    }

    /**
     * @return bool
     */
    public function hasDefaults()
    {
        return is_array($this->defaults);
    }

    /**
     * @return array
     */
    public function getConstraints()
    {
        return $this->constraints;
    }

    /**
     * @param string $name
     * @return \ZfAnnotation\Annotation\Route
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @param string $type
     * @return \ZfAnnotation\Annotation\Route
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @param string $route
     * @return \ZfAnnotation\Annotation\Route
     */
    public function setRoute($route)
    {
        $this->route = $route;
        return $this;
    }

    /**
     * @param array $defaults
     * @return \ZfAnnotation\Annotation\Route
     */
    public function setDefaults(array $defaults = null)
    {
        $this->defaults = $defaults;
        return $this;
    }

    /**
     * @param array|null $constraints
     * @return \ZfAnnotation\Annotation\Route
     */
    public function setConstraints(array $constraints = null)
    {
        $this->constraints = $constraints;
        return $this;
    }

    /**
     * @param string $name
     * @return \ZfAnnotation\Annotation\Route
     */
    public function setDefaultController($name)
    {
        $this->defaults['controller'] = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getDefaultController()
    {
        return $this->defaults['controller'];
    }

    /**
     * @param string $name
     * @return \ZfAnnotation\Annotation\Route
     */
    public function setDefaultAction($name)
    {
        $this->defaults['action'] = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getDefaultAction()
    {
        return $this->defaults['action'];
    }

    /**
     * @return bool
     */
    public function hasDefaultController()
    {
        return $this->hasDefaults() && isset($this->defaults['controller']);
    }

    /**
     * @return bool
     */
    public function hasDefaultAction()
    {
        return $this->hasDefaults() && isset($this->defaults['action']);
    }

    /**
     * @return string
     */
    public function getExtends()
    {
        return $this->extends;
    }

    /**
     * @param string $extends
     * @return \ZfAnnotation\Annotation\Route
     */
    public function setExtends($extends)
    {
        $this->extends = $extends;
        return $this;
    }

    /**
     * @return bool
     */
    public function getMayTerminate()
    {
        return $this->mayTerminate;
    }

    /**
     * @param bool $flag
     * @return \ZfAnnotation\Annotation\Route
     */
    public function setMayTerminate($flag)
    {
        $this->mayTerminate = (bool) $flag;
        return $this;
    }

    /**
     * Extend this route with data from another one.
     *
     * @param AnnotationInterface $annotation
     */
    public function extend(AnnotationInterface $annotation)
    {
        $params = get_object_vars($annotation);
        foreach ($params as $property => $value) {
            if (property_exists($this, $property) && !in_array($property, ['name', 'route'])) {
                if (!$this->$property) {
                    $this->$property = $value;
                }
            }
        }
    }

}
