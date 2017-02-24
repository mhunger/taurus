<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 20/02/17
 * Time: 20:44
 */

namespace taurus\framework\api;

use taurus\framework\config\TaurusContainerConfig;
use taurus\framework\Container;
use taurus\framework\routing\BasicRoute;


/**
 * Class ApiBuilder
 * @package taurus\framework\api
 */
class ApiBuilder
{
    /**
     * @param string $entityClass
     * @param string|null $path
     * @param string $idNameParamField
     * @param GetEntityByIdService|null $getEntityByIdService
     * @return BasicRoute
     */
    public function get(
        string $entityClass,
        string $path = null,
        $idNameParamField = 'id',
        GetEntityByIdService $getEntityByIdService = null
    ): BasicRoute {
        /** @var GetByIdApiController $controller */
        $controller = Container::getInstance()->getService(TaurusContainerConfig::SERVICE_DEFAULT_GETBYID_CONTROLLER);

        if ($getEntityByIdService === null) {
            /** @var GetEntityByIdService $getEntityByIdService */
            $getEntityByIdService = Container::getInstance()->getService(TaurusContainerConfig::SERVICE_DEFAULT_GETBYID_SERVICE);
            $getEntityByIdService->setEntityClass($entityClass);

            $controller->setGetEntityByIdService($getEntityByIdService);
            $controller->setIdParamName($idNameParamField);
        }

        return new BasicRoute(
            'GET',
            $this->getApiPath($entityClass, $path),
            $controller
        );
    }

    /**
     * @param $entityClass
     * @param null $path
     * @return string
     */
    private function getApiPath($entityClass, $path = null): string
    {
        if ($path === null) {
            return strtolower(basename(str_replace('\\', '/', $entityClass)));
        }

        return str_replace('/', '', $path);
    }

    /**
     * @param string $entityClass
     * @param string|null $path
     * @param SaveEntityService $saveEntityService
     * @return BasicRoute
     */
    public function post(
        string $entityClass,
        string $path = null,
        SaveEntityService $saveEntityService = null
    ): BasicRoute
    {
        if ($saveEntityService === null) {
            /** @var SaveEntityService $saveEntityService */
            $saveEntityService = Container::getInstance()->getService(TaurusContainerConfig::SERVICE_DEFAULT_SAVE_ENTITY_SERVICE);
            $saveEntityService->setEntityClass($entityClass);
        }
        /** @var SaveEntityApiController $saveEntityController */
        $saveEntityController = Container::getInstance()->getService(TaurusContainerConfig::SERVICE_DEFAULT_SAVE_ENTITY_CONTROLLER);
        $saveEntityController->setService($saveEntityService);

        return new BasicRoute(
            'POST',
            $this->getApiPath($entityClass),
            $saveEntityController
        );
    }

    /**
     * @param string $entityClass
     * @param null $url
     * @param GetAllEntitiesService|null $getAllEntitiesService
     * @return BasicRoute
     */
    public function cget(string $entityClass, $url = null, GetAllEntitiesService $getAllEntitiesService = null)
    {
        if ($getAllEntitiesService === null) {
            /** @var GetAllEntitiesService $getAllEntitiesService */
            $getAllEntitiesService = Container::getInstance()->getService(TaurusContainerConfig::SERVICE_DEFAULT_GET_ALL_ENTITIES_SERVICE);
            $getAllEntitiesService->setEntityClass($entityClass);
        }

        /** @var GetAllEntitiesApiController $getAllEntitiesController */
        $getAllEntitiesController = Container::getInstance()->getService(TaurusContainerConfig::SERVICE_DEFAULT_GET_ALL_ENTITIES_CONTROLLER);
        $getAllEntitiesController->setGetAllEntitiesService($getAllEntitiesService);

        return new BasicRoute(
            'GET',
            $this->getApiPath($entityClass),
            $getAllEntitiesController
        );
    }
}
