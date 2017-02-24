<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 24/02/17
 * Time: 20:04
 */

namespace taurus\tests\api;


use taurus\framework\api\GetAllEntitiesService;
use taurus\framework\http\Controller;
use taurus\framework\routing\Request;

class GetAllEntitiesApiController implements Controller
{
    /** @var GetAllEntitiesService */
    private $service;

    /**
     * @param Request $request
     * @return mixed
     */
    public function handleRequest(Request $request): array
    {
        return $this->service->getAllEntities();
    }

    public function setGetAllEntitiesService(GetAllEntitiesService $getAllEntitiesService)
    {
        $this->service = $getAllEntitiesService;
    }
}
