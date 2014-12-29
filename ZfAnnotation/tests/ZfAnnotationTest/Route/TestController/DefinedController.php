<?php
namespace ZfAnnotationTest\Route\TestController;

use ZfAnnotation\Annotation as Router;
use Zend\Mvc\Controller\AbstractActionController;

class DefinedController extends AbstractActionController
{
    /**
     * @Router\Route
     */
    public function indexAction()
    {}

}