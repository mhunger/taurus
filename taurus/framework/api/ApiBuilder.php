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
    /** @var string */
    private $method;

    /** @var string */
    private $url;

    /** @var string */
    private $resourceClass;

    /** @var GetEntityByIdService */
    private $service;


    public function get(
        string $entityClass,
        string $path = null,
        $idNameParamField = 'id',
        string $getEntityByIdService = null
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

    private function getApiPath($entityClass, $path = null): string
    {
        if ($path === null) {
            return strtolower(basename(str_replace('\\', '/', $entityClass)));
        }

        return str_replace('/', '', $path);
    }

    /**
     * @param string $url
     * @return ApiBuilder
     */
    public function resource(string $url): ApiBuilder
    {
        $this->url = $url;

        return $this;
    }

    /**
     * @param GetEntityByIdService $entityByIdService
     * @return ApiBuilder
     */
    public function using(GetEntityByIdService $entityByIdService): ApiBuilder
    {
        $this->service = $entityByIdService;

        return $this;
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @return string
     */
    public function getResourceClass(): string
    {
        return $this->resourceClass;
    }

    /**
     * @return GetEntityByIdService
     */
    public function getService(): GetEntityByIdService
    {
        return $this->service;
    }
}
