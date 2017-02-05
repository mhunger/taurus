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
use taurus\framework\http\HttpJsonResponse;
use taurus\framework\mock\MockServer;
use taurus\tests\AbstractDatabaseTest;
use taurus\tests\fixtures\GlobalVariablesMock;
use taurus\tests\fixtures\TestContainerConfig;

class GetWorkoutByIdControllerTest extends AbstractDatabaseTest
{

    public function __construct()
    {
        $this->fixtureFiles = [
            'workout.xml'
        ];
    }
    public function testGetMethod() {
        $this->getConnection()->createDataSet();
        /** @var MockServer $mockServer */
        $mockServer = Container::getInstance()->setContainerConfig(
            new TestContainerConfig()
        )->getService(TaurusContainerConfig::SERVICE_MOCK_SERVER);
        $actualResponse = $mockServer->get(
            '/api/item',
            'GET',
            ['id' => 1]
        );


        $json = '[{"id":"1","date":"2012-01-01 12:00:00"}]';
        $responseObj = json_decode($json);

        $expectedResponse = (new HttpJsonResponse(201, $responseObj))->getJson();

        $this->assertEquals(
            $expectedResponse,
            $actualResponse,
            "Controller did not load correct response"
        );
    }
}