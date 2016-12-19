<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 23/10/16
 * Time: 11:18
 */

namespace taurus\framework\routing;

use taurus\framework\Environment;
use taurus\framework\exception\RouteNotFoundException;
use taurus\framework\Http\HttpJsonResponse;

class Router {
    /** @var RouteConfig */
    private $routeConfig;

    /** @var bool */
    private $requestHandled = false;

    /** @var Environment */
    private $environment;

    public function __construct(RouteConfig $routeConfig, Environment $environment) {
        $this->routeConfig = $routeConfig;
        $this->environment = $environment;
    }

    /**
     * @param Request $request
     * @return HttpJsonResponse
     */
    public function route(Request $request) {
        $url = $request->getUrl();
        $method = $request->getMethod();

        try {
            $controller = $this->routeConfig->getRoute($method, $url);
            $body = $controller->handleRequest($request);

            if($this->isTestEnvironment()) {
                $this->requestHandled = true;
                return new HttpJsonResponse(201, $body);
            } else {
                (new HttpJsonResponse(201, $body))->send();
                $this->requestHandled = true;
            }
        } catch(RouteNotFoundException $e) {
            if(!$this->isTestEnvironment()) {
                (new HttpJsonResponse(404, $e->getMessage()))->send();
            }
        } catch(\Exception $ex) {
            if(!$this->isTestEnvironment()) {
                (new HttpJsonResponse(500, $ex->getMessage()))->send();
            }
        }
    }

    public function isTestEnvironment() {
        return $this->environment->getName() === Environment::TEST;
    }

    /**
     * @return boolean
     */
    public function isRequestHandled()
    {
        return $this->requestHandled;
    }
}