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

class RouteConfig {
    private $base;
    private $routes = [];

    public function __construct($base = '') {
        $this->base = $base;

        $this->routes = [
            'GET' => [
                'items' => Container::getInstance()->getService(FitnessManagerConfig::SERVICE_WORKOUT_CONTROLLER),
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
