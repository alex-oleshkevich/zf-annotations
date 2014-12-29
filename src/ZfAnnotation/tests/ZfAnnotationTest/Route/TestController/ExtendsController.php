<?php
namespace ZfAnnotationTest\Route\TestController;

use ZfAnnotation\Annotation as Router;
use Zend\Mvc\Controller\AbstractActionController;

/**
 * @Router\Route(extends="default/help", name="root", route="/root")
 */
class ExtendsController extends AbstractActionController
{
    /**
     * @Router\Route
     */
    public function indexAction()
    {}

}