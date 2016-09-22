<?php

namespace ZfAnnotationTest\Service\TestAsset;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\DelegatorFactoryInterface;
use ZfAnnotation\Annotation\Service;

/**
 * @Service(type="delegator", for="IndexController")
 */
class Delegator implements DelegatorFactoryInterface
{

    public function __invoke(ContainerInterface $container, $name, callable $callback, array $options = null)
    {
        
    }

}
