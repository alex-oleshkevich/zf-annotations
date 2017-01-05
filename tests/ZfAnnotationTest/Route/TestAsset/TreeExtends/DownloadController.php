<?php
namespace ZfAnnotationTest\Route\TestAsset\TreeExtends;

use ZfAnnotation\Annotation as Router;
use Zend\Mvc\Controller\AbstractActionController;

/**
 * @Router\Route(extends="backend", name="downloads", route="/downloads", mayTerminate=true)
 */
class DownloadController extends AbstractActionController
{

}