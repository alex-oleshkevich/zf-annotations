<?php
namespace ZfAnnotationTest\Route\TestController;

use ZfAnnotation\Annotation as Router;
use Zend\Mvc\Controller\AbstractActionController;

class NoBaseController extends AbstractActionController
{
    /**
     * @Router\Route(
     *     name="complete-definition",
     *     route="/complete-definition/:id/:method",
     *     type="segment",
     *     defaults={"controller": "nobase", "action": "complete-definition-action"},
     *     constraints={"id": "\d+", "method": "\w+"}
     * )
     */
    public function completeDefinitionAction()
    {}

    /**
     * @Router\Route(
     *     route="/route",
     *     type="literal",
     *     defaults={"controller": "nobase", "action": "no-route"}
     * )
     */
    public function noRouteNameAction()
    {}

    /**
     * @Router\Route(
     *     type="literal",
     *     defaults={"controller": "nobase", "action": "no-route"}
     * )
     */
    public function noRouteAction()
    {}

    /**
     * @Router\Route(
     *     defaults={"controller": "nobase", "action": "no-route"}
     * )
     */
    public function noTypeAction()
    {}

    /**
     * @Router\Route(
     *     defaults={"action": "no-route"}
     * )
     */
    public function noControllerAction()
    {}

    /**
     * @Router\Route
     */
    public function noActionAction()
    {}
}