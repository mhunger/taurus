<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 23/10/16
 * Time: 14:26
 */

namespace taurus\tests;


use PHPUnit\Framework\TestCase;
use taurus\framework\Environment;
use taurus\framework\routing\Request;
use taurus\framework\routing\Router;
use taurus\framework\routing\RouteConfig;
use fitnessmanager\workout\GetWorkoutByIdController;
use taurus\framework\Controller;

class RouterTest extends TestCase {

    /** @var Router */
    private $router;

    public function setUp() {
        $this->requestMethod = 'GET';
        $this->requestUri = '/api/items';

        $_SERVER['REQUEST_METHOD'] = $this->requestMethod;
        $_SERVER['REQUEST_URI'] = $this->requestUri;

        $this->router = new Router(
            new RouteConfig('api'),
            new Environment(Environment::TEST)
        );
    }

    public function testRoute() {
        $controller = $this->router->route(new Request());
        $this->assertEquals(true, $this->router->isRequestHandled(), "Could not handle request");
    }
}