<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 23/10/16
 * Time: 14:26
 */

namespace tests;


use taurus\framework\routing\Request;
use taurus\framework\routing\Router;
use taurus\framework\routing\RouteConfig;
use taurus\item\WorkoutController;
use taurus\framework\Controller;

class RouterTest extends \PHPUnit_Framework_TestCase {

    private $router;

    public function setUp() {
        $this->requestMethod = 'GET';
        $this->requestUri = '/api/items';

        $_SERVER['REQUEST_METHOD'] = $this->requestMethod;
        $_SERVER['REQUEST_URI'] = $this->requestUri;

        $routeConfig = new RouteConfig("api");

        $this->router = new Router($routeConfig);

    }

    public function testRoute() {
        $controller = $this->router->route(new Request());
        $this->assertEquals(true, $this->router->isRequestHandled(), "Could not handle request");
    }
}