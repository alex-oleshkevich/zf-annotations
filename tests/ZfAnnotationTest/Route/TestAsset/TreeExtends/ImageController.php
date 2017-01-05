<?php
namespace ZfAnnotationTest\Route\TestAsset\TreeExtends;

use ZfAnnotation\Annotation as Router;
use Zend\Mvc\Controller\AbstractActionController;

/**
 * @Router\Route(extends="backend/downloads", name="image", route="/image")
 */
class ImageController extends AbstractActionController
{

}