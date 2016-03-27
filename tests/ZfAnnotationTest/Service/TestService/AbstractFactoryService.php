<?php

namespace ZfAnnotation\Service\TestService;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\AbstractFactoryInterface;
use ZfAnnotation\Annotation\Service;

/**
 * @Service(type="abstractFactory")
 */
class AbstractFactoryService implements AbstractFactoryInterface
{
    public function canCreate(ContainerInterface $container, $requestedName)
    {
        
    }

}
