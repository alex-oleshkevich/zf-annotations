<?php

namespace ZfAnnotationTest\Service\TestAsset;

use ZfAnnotation\Annotation\Service;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\DelegatorFactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * @Service(type="delegator")
 */
class InvalidDelegatorNoFor implements DelegatorFactoryInterface
{

    public function createDelegatorWithName(ServiceLocatorInterface $serviceLocator, $name, $requestedName, $callback)
    {
        
    }

    public function __invoke(ContainerInterface $container, $name, callable $callback, array $options = null)
    {
        
    }

}
