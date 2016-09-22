<?php
namespace ZfAnnotationTest\Route\TestAsset;

use ZfAnnotation\Annotation\Route;
use Zend\Mvc\Controller\AbstractActionController;

class PriorityController extends AbstractActionController
{
    /**
     * @Route(
     *     name="index",
     *     route="/root/:id/:method",
     *     type="segment",
     *     priority=1000,
     *     constraints={"id": "\d+", "method": "\w+"}
     * )
     */
    public function indexAction()
    {}
}