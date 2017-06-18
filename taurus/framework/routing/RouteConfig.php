<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 18/06/17
 * Time: 13:16
 */
namespace taurus\framework\routing;

use taurus\framework\exception\RouteNotFoundException;
use taurus\framework\http\Controller;


/**
 * Class TaurusTestRouteConfig
 * @package taurus\framework\routing
 */
interface RouteConfig
{
    /**
     * @param string $method
     * @param string $path
     * @param $controller
     * @return RouteConfig
     */
    public function addRoute(string $method, string $path, $controller): RouteConfig;

    /**
     * @param BasicRoute $basicRoute
     * @return RouteConfig
     */
    public function addDefaultRoute(BasicRoute $basicRoute): RouteConfig;

    /**
     * @return array
     */
    public function getRoutes();

    /**
     * @param $method
     * @param $path
     * @return mixed
     * @throws RouteNotFoundException
     */
    public function getRoute($method, $path): Controller;
}