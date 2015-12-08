<?php

namespace ZfAnnotation\Service\TestService;

use ZfAnnotation\Annotation\Service;
use Zend\ServiceManager\AbstractFactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * @Service(type="abstractFactory")
 */
class AbstractFactoryService implements AbstractFactoryInterface
{

    public function canCreateServiceWithName(ServiceLocatorInterface $serviceLocator, $name, $requestedName)
    {
        
    }

    public function createServiceWithName(ServiceLocatorInterface $serviceLocator, $name, $requestedName)
    {
        
    }

}
