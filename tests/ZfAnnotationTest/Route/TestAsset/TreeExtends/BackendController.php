<?php
namespace ZfAnnotationTest\Route\TestAsset\TreeExtends;

use ZfAnnotation\Annotation as Router;
use Zend\Mvc\Controller\AbstractActionController;

/**
 * @Router\Route(name="backend", route="/dashboard", mayTerminate=true)
 */
class BackendController extends AbstractActionController
{

}