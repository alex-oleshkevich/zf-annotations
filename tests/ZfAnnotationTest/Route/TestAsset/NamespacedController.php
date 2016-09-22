<?php
namespace ZfAnnotationTest\Route\TestAsset;

use ZfAnnotation\Annotation\Route;
use Zend\Mvc\Controller\AbstractActionController;

/**
 * @Route(
 *     name="root",
 *     route="/root/:id/:method",
 *     type="segment",
 *     defaults={"controller": "namespaced", "action": "index"},
 *     constraints={"id": "\d+", "method": "\w+"}
 * )
 */
class NamespacedController extends AbstractActionController
{
    /**
     * @Route(
     *     name="index",
     *     route="/root/:id/:method",
     *     type="segment",
     *     defaults={"controller": "nobase", "action": "complete-definition-action"},
     *     constraints={"id": "\d+", "method": "\w+"}
     * )
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