<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 04/02/17
 * Time: 22:20
 */

namespace taurus\tests\fitnessmanager;


use PHPUnit\Framework\TestCase;
use taurus\framework\Container;
use taurus\framework\container\TaurusContainerConfig;
use taurus\framework\Http\HttpJsonResponse;
use taurus\tests\AbstractDatabaseTest;
use taurus\tests\fixtures\TestContainerConfig;
use taurus\framework\mock\MockServer;

/**
 * Class GetAllWorkoutsControllerTest
 * @package taurus\tests\fitnessmanager
 */
class GetAllWorkoutsControllerTest extends AbstractDatabaseTest
{
    public function __construct()
    {
        $this->fixtureFiles = [
            'workout.xml'
        ];
    }

    /**
     * @throws \taurus\framework\error\ContainerCannotInstantiateService
     */
    public function testGetMethod()
    {
        /** @var MockServer $mockServer */
        $mockServer = Container::getInstance()->setContainerConfig(
            new TestContainerConfig()
        )->getService(TaurusContainerConfig::SERVICE_MOCK_SERVER);
        $actualResponse = $mockServer->get(
            '/api/items',
            'GET',
            []
        );

        $json = '[{"id":"1","date":"2012-01-01 12:00:00"},{"id":"2","date":"2015-01-01 04:00:00"}]';
        $responseObj = json_decode($json);

        $expectedResponse = (new HttpJsonResponse(201, $responseObj))->getJson();

        $this->assertEquals(
            $expectedResponse,
            $actualResponse,
            "Controller to get all workouts did not return correct result"
        );
    }
}
