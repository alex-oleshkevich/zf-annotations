<?php

namespace ZfAnnotation\Service\TestService;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\DelegatorFactoryInterface;
use ZfAnnotation\Annotation\Service;

/**
 * @Service(type="delegator", for="IndexController")
 */
class Delegator implements DelegatorFactoryInterface
{

    public function __invoke(ContainerInterface $container, $name, $callback, array $options = null)
    {
        
    }

}
