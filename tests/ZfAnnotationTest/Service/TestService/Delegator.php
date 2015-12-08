<?php

namespace ZfAnnotation\Service\TestService;

use ZfAnnotation\Annotation\Service;
use Zend\ServiceManager\DelegatorFactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * @Service(type="delegator", for="IndexController")
 */
class Delegator implements DelegatorFactoryInterface
{

    public function createDelegatorWithName(ServiceLocatorInterface $serviceLocator, $name, $requestedName, $callback)
    {
        
    }

}
