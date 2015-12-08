<?php

namespace ZfAnnotation\Service\TestService;

use ZfAnnotation\Annotation\Service;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * @Service(type="factory")
 */
class FactoryService implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        
    }

}
