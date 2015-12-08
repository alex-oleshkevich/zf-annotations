<?php

namespace ZfAnnotation\Service\TestService;

use ZfAnnotation\Annotation\Service;
use Zend\ServiceManager\InitializerInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * @Service(type="initializer")
 */
class Initializer implements InitializerInterface
{

    public function initialize($instance, ServiceLocatorInterface $serviceLocator)
    {
        
    }

}
