<?php
namespace ZfAnnotationTest\Route\TestController;

use ZfAnnotation\Annotation as Router;
use Zend\Mvc\Controller\AbstractActionController;

/**
 * @Router\Route
 */
class InvalidRootRouteController extends AbstractActionController
{
    /**
     * @Router\Route
     */
    public function indexAction()
    {}

    /**
     * @Router\Route
     */
    public function editAction()
    {}

    /**
     * @Router\Route
     */
    public function removeAction()
    {}
}