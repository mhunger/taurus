<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 04/02/17
 * Time: 22:20
 */

namespace taurus\tests\fitnessmanager;

use taurus\framework\Container;
use taurus\framework\config\TaurusContainerConfig;
use taurus\framework\Http\HttpJsonResponse;
use taurus\tests\AbstractDatabaseTest;
use taurus\framework\mock\MockServer;

/**
 * Class GetAllWorkoutsControllerTest
 * @package taurus\tests\fitnessmanager
 */
class GetAllWorkoutsControllerTest extends AbstractDatabaseTest
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
     * @throws \taurus\framework\error\ContainerCannotInstantiateService
     */
    public function testGetMethod()
    {
        /** @var MockServer $mockServer */
        $mockServer = Container::getInstance()
            ->getService(TaurusContainerConfig::SERVICE_MOCK_SERVER);

        $actualResponse = $mockServer->get(
            '/api/items',
            'GET',
            []
        );

        $this->assertJsonStringEqualsJsonFile(
            $this->getJsonResultsFilePath('getAllWorkoutsControllerTest-testGetMethod.json'),
            $actualResponse,
            "Controller to get all workouts did not return correct result"
        );
    }
}
