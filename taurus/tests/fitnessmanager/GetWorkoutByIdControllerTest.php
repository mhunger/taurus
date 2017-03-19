<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 19/12/16
 * Time: 20:49
 */

namespace taurus\tests\fitnessmanager;


use taurus\framework\Container;
use taurus\framework\config\TaurusContainerConfig;
use taurus\framework\http\HttpJsonResponse;
use taurus\framework\mock\MockServer;
use taurus\tests\AbstractDatabaseTest;


class GetWorkoutByIdControllerTest extends AbstractDatabaseTest
{
    /**
     * @return array
     */
    function getFixtureFiles(): array
    {
        return [
            'workout_location.xml',
            'workout.xml'
        ];
    }

    /**
     *
     */
    public function testGetMethod() {
        /** @var MockServer $mockServer */
        $mockServer = Container::getInstance()
            ->getService(TaurusContainerConfig::SERVICE_MOCK_SERVER);
        $actualResponse = $mockServer->get(
            '/api/item',
            'GET',
            ['id' => 1]
        );


        $json = '{"id":"1","date":"2012-01-01 12:00:00", "workoutLocation": {"id": 1, "name": "TUM Sportzentrum"}}';
        $responseObj = json_decode($json);

        $expectedResponse = (new HttpJsonResponse(201, $responseObj))->getJson();

        $this->assertEquals(
            $expectedResponse,
            $actualResponse,
            "Controller did not load correct response"
        );
    }
}
