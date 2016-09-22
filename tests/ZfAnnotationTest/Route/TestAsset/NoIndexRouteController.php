<?php
namespace ZfAnnotationTest\Route\TestAsset;

use ZfAnnotation\Annotation\Route;
use Zend\Mvc\Controller\AbstractActionController;

/**
 * @Route(name="root", route="/root")
 */
class NoIndexRouteController extends AbstractActionController
{
    /**
     * @Route
     */
    public function indexAction()
    {}

    /**
     * @Route
     */
    public function editAction()
    {}

    /**
     * @Route
     */
    public function removeAction()
    {}
}