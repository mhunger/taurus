<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 23/10/16
 * Time: 14:26
 */

namespace taurus\tests;


use PHPUnit\Framework\TestCase;
use taurus\framework\api\ApiBuilder;
use taurus\framework\Environment;
use taurus\framework\mock\MockRequest;


use taurus\framework\routing\Router;
use taurus\framework\routing\RouteConfig;


class RouterTest extends TestCase {

    /** @var Router */
    private $router;

    private $mockRequest;

    public function setUp() {
        $this->markTestSkipped('This is skipped, because router requires separate config');
        $this->mockRequest = new MockRequest();

        $this->mockRequest->setMethod('GET');
        $this->mockRequest->setUrl('/api/item');
        $this->mockRequest->setRequestVariables([
            'id' => 1
        ]);

        $this->router = new Router(
            new RouteConfig(RouteConfig::API_BASE_PATH, new ApiBuilder()),
            new Environment(Environment::TEST)
        );
    }

    public function testRoute() {
        $this->assertEquals(true, $this->router->isRequestHandled(), "Could not handle request");
    }
}