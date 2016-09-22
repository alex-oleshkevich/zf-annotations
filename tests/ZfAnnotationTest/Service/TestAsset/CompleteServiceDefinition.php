<?php

namespace ZfAnnotationTest\Service\TestAsset;

use ZfAnnotation\Annotation\Service;

/**
 * @Service(
 *      name="complete_service", 
 *      type="invokable", 
 *      shared=false, 
 *      aliases={"cservice", "shared_cservice"}, 
 *      serviceManager="my_service_manager"
 * )
 */
class CompleteServiceDefinition
{
    
}
