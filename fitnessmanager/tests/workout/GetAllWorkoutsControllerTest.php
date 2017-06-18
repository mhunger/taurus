<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 04/02/17
 * Time: 22:20
 */

namespace taurus\tests\fitnessmanager;

use fitnessmanager\tests\AbstractFitnessManagerDatabaseTest;
use taurus\framework\Container;
use taurus\framework\config\TaurusContainerConfig;
use taurus\framework\mock\MockServer;

/**
 * Class GetAllWorkoutsControllerTest
 * @package taurus\tests\fitnessmanager
 */
class GetAllWorkoutsControllerTest extends AbstractFitnessManagerDatabaseTest
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
            '/fitness-api/items',
            'GET',
            []
        );

        $this->compareResultToFixture(
            $actualResponse,
            __FUNCTION__,
            "Controller to get all workouts did not return correct result"
        );
    }
}
