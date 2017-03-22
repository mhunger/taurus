<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 20/02/17
 * Time: 20:28
 */

namespace taurus\framework\api;


use taurus\framework\db\Entity;
use taurus\framework\error\Http404NotFoundException;
use taurus\framework\http\Controller;
use taurus\framework\routing\Request;


/**
 * Controller to automatically handle request where an id is passed that will load an entity. The entity
 * has to be injected beforehand, so that the controller can call the respective baserepo method.
 *
 * Also there will be a service, which gets the id as parameter and returns the entity. This service can be overwritten,
 * if required and configured later in the API configuration.
 *
 * Class GetByIdApiController
 * @package taurus\framework\api
 */
class GetByIdApiController implements Controller
{
    /** @var GetEntityByIdService */
    private $getEntityByIdService;

    /** @var string */
    private $idParamName;

    /**
     * @param Request $request
     * @return Entity
     * @throws Http404NotFoundException
     */
    public function handleRequest(Request $request): Entity
    {
        return $this->getEntityByIdService->getEntityById(
            $request->getRequestParamByName($this->idParamName)
        );
    }

    /**
     * @param GetEntityByIdService $getEntityByIdService
     */
    public function setGetEntityByIdService(GetEntityByIdService $getEntityByIdService)
    {
        $this->getEntityByIdService = $getEntityByIdService;
    }

    /**
     * @param string $idParamName
     */
    public function setIdParamName(string $idParamName)
    {
        $this->idParamName = $idParamName;
    }
}
