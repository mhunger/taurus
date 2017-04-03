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
use taurus\framework\db\query\Specification;
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
     * @param string $entityClass
     * @param string|null $path
     * @param bool $multi
     * @return string
     */
    private function getApiPath(string $entityClass, string $path = null, bool $multi = false): string
    {
        if ($path === null) {
            $path = strtolower(basename(str_replace('\\', '/', $entityClass)));
        } else {
            $path = str_replace('/', '', $path);
        }

        return $this->addPluralToPath($path, $multi);
    }

    /**
     * @param string $path
     * @param bool $isPlural
     * @return string
     */
    private function addPluralToPath(string $path, bool $isPlural = false): string
    {
        if ($isPlural) {
            if (substr($path, -1) == 's') {
                $path .= 'es';
            } else {
                $path .= 's';
            }
        }

        return $path;
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
            $this->getApiPath($entityClass, $path),
            $saveEntityController
        );
    }

    /**
     * @param string $entityClass
     * @param null $url
     * @param GetAllEntitiesService|null $getAllEntitiesService
     * @return BasicRoute
     */
    public function cget(string $entityClass, $url = null, GetAllEntitiesService $getAllEntitiesService = null): BasicRoute
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
            $this->getApiPath($entityClass, $url, true),
            $getAllEntitiesController
        );
    }

    /**
     * @param string $entityClass
     * @param null $url
     * @param UpdateEntityService|null $updateEntityService
     * @return BasicRoute
     */
    public function put(string $entityClass, $url = null, UpdateEntityService $updateEntityService = null): BasicRoute
    {
        if($updateEntityService === null) {
            /** @var UpdateEntityDefaultServiceImpl $updateEntityService */
            $updateEntityService = Container::getInstance()->getService(TaurusContainerConfig::SERVICE_DEFAULT_PUT_ENTITY_SERVICE);
            $updateEntityService->setEntityClass($entityClass);
        }

        /** @var UpdateEntityApiController $updateEntityController */
        $updateEntityController = Container::getInstance()->getService(TaurusContainerConfig::SERVICE_DEFAULT_PUT_ENTITY_CONTROLLER);
        $updateEntityController->setService($updateEntityService);

        return new BasicRoute(
            'PUT',
            $this->getApiPath($entityClass, $url),
            $updateEntityController
        );
    }

    public function cgetBySpec(string $entityClass, string $specification, $url = null, GetBySpecificationService $getBySpecificationService = null): BasicRoute
    {
        if($getBySpecificationService === null) {
            /** @var GetBySpecificationDefaultServiceImpl $getBySpecificationService */
            $getBySpecificationService = Container::getInstance()->getService(TaurusContainerConfig::SERVICE_DEFAULT_GETBYSPEC_DEFAULT_SERVICE);
        }

        $getBySpecificationService->setEntityClass($entityClass);
        $getBySpecificationService->setSpecificationClass($specification);

        /** @var GetBySpecificationApiController $getBySpecificationController */
        $getBySpecificationController = Container::getInstance()->getService(TaurusContainerConfig::SERVICE_DEFAULT_GETBYSPEC_CONTROLLER);
        $getBySpecificationController->setGetBySpecificationService($getBySpecificationService);

        return new BasicRoute(
            'GET',
            $this->getApiPath($entityClass, $url),
            $getBySpecificationController
        );
    }
}
