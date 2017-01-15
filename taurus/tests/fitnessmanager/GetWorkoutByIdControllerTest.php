<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 19/12/16
 * Time: 20:49
 */

namespace taurus\tests\fitnessmanager;


use PHPUnit\Framework\TestCase;
use taurus\framework\Container;
use taurus\framework\container\TaurusContainerConfig;
use taurus\framework\Http\HttpJsonResponse;
use taurus\framework\mock\MockServer;
use taurus\framework\routing\Request;
use taurus\tests\fixtures\TestContainerConfig;

class GetWorkoutByIdControllerTest extends TestCase {

    public function setUp() {
            
    }

    public function testGetMethod() {
        /** @var MockServer $mockServer */
        $mockServer = Container::getInstance()->setContainerConfig(
            new TestContainerConfig()
        )->getService(TaurusContainerConfig::SERVICE_MOCK_SERVER);
        $actualResponse = $mockServer->get('/api/items', 'GET');

        $responseObj = new \stdClass();
        $responseObj->text = 'Items GetRequest handled';

        $expectedResponse = (new HttpJsonResponse(201, $responseObj))->getJson();

        $this->assertEquals(
            $expectedResponse,
            $actualResponse,
            "Controller did not load correct response"
        );
    }
}