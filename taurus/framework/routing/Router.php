<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 23/10/16
 * Time: 11:18
 */

namespace taurus\framework\routing;

use taurus\framework\exception\RouteNotFoundException;
use taurus\framework\Http\HttpJsonResponse;

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
            $body = $controller->handleRequest($request);
            (new HttpJsonResponse(201, $body))->send();
            $this->requestHandled = true;

        } catch(RouteNotFoundException $e) {
            echo "Could not find route [$url] [$method]";
        } catch(\Exception $ex) {
            echo "Ups something went wrong trying to handle the request";
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