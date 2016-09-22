<?php

namespace ZfAnnotationTest\Service\TestAsset;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use ZfAnnotation\Annotation\Service;

/**
 * @Service(type="factory")
 */
class FactoryService implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        
    }

}
