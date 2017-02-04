<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 23/10/16
 * Time: 11:19
 */

namespace taurus\framework\routing;

use fitnessmanager\config\FitnessManagerConfig;
use taurus\framework\Container;
use taurus\framework\exception\RouteNotFoundException;

/**
 * Class RouteConfig
 * @package taurus\framework\routing
 */
class RouteConfig {

    const API_BASE_PATH = 'api';
    /**
     * @var string
     */
    private $base;
    /**
     * @var array
     */
    private $routes = [];

    /**
     * @param string $base
     * @throws \taurus\framework\error\ContainerCannotInstantiateService
     */
    public function __construct($base = '') {
        $this->base = $base;

        $this->routes = [
            'GET' => [
                'item' => Container::getInstance()->getService(FitnessManagerConfig::SERVICE_GET_WORKOUT_BY_ID_CONTROLLER),
                'items' => Container::getInstance()->getService(FitnessManagerConfig::SERVICE_GET_WORKOUTS_CONTROLLER)
            ]
        ];
    }

    /**
     * @return array
     */
    public function getRoutes()
    {
        return $this->routes;
    }

    /**
     * @param $method
     * @param $path
     * @return mixed
     * @throws RouteNotFoundException
     */
    public function getRoute($method, $path) {
        if($this->base !== null) {
            $path = str_replace("/" . $this->base . "/", "", $path);
        }


        if(isset($this->routes[$method]) && isset($this->routes[$method][$path])) {
            return $this->routes[$method][$path];
        }

        throw new RouteNotFoundException($method, $path);
    }
}
