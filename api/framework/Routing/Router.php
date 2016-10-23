<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 23/10/16
 * Time: 11:18
 */

namespace api\framework\routing;

use api\framework\exception\RouteNotFoundException;

class Router {
    private $routeConfig;

    private $requestHandled = false;

    public function __construct(RouteConfig $routeConfig) {
        $this->routeConfig = $routeConfig;
    }

    public function route(Request $request) {
        $url = $request->getUrl();
        $method = $request->getMethod();

        try {
            $controller = $this->routeConfig->getRoute($method, $url);
            $controller->handleRequest();
            $this->requestHandled = true;

        } catch(RouteNotFoundException $e) {
            echo "Could not find route [$url] [$method]";
        }
    }

    /**
     * @return boolean
     */
    public function isRequestHandled()
    {
        return $this->requestHandled;
    }
}