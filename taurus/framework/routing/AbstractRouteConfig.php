<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 18/06/17
 * Time: 13:18
 */

namespace taurus\framework\routing;

use taurus\framework\api\ApiBuilder;
use taurus\framework\api\AuthenticationHandlerService;
use taurus\framework\exception\RouteNotFoundException;
use taurus\framework\http\Controller;

class AbstractRouteConfig implements RouteConfig
{
    /**
     * @var string
     */
    protected $base;
    /**
     * @var array
     */
    protected $routes = [];

    /** @var ApiBuilder */
    protected $apiBuilder;

    /**
     * TaurusTestRouteConfig constructor.
     * @param string $base
     * @param ApiBuilder $apiBuilder
     */
    public function __construct($base = '', ApiBuilder $apiBuilder)
    {
        $this->base = $base;
        $this->apiBuilder = $apiBuilder;
    }

    /**
     * @param string $method
     * @param string $path
     * @param $controller
     * @return RouteConfig
     */
    public function addRoute(string $method, string $path, $controller): RouteConfig
    {
        $this->routes[] = new BasicRoute(
            $method,
            $path,
            $controller
        );

        return $this;
    }

    /**
     * @param BasicRoute $basicRoute
     * @return RouteConfig
     */
    public function addDefaultRoute(BasicRoute $basicRoute): RouteConfig
    {
        $this->routes[] = $basicRoute;

        return $this;
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
    public function getRoute($method, $path): Controller
    {
        if($this->base !== null) {
            $path = str_replace("/" . $this->base . "/", "", $path);
        }

        /** @var Route $route */
        foreach ($this->routes as $route) {
            if ($route->getMethod() == $method && $route->getPath() == $path) {
                return $route->getController();
            }
        }

        throw new RouteNotFoundException($method, $path);
    }
}