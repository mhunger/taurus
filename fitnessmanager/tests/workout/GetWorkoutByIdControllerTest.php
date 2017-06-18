<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 19/12/16
 * Time: 20:49
 */

namespace taurus\tests\fitnessmanager;


use fitnessmanager\tests\AbstractFitnessManagerDatabaseTest;
use taurus\framework\Container;
use taurus\framework\config\TaurusContainerConfig;
use taurus\framework\mock\MockServer;


class GetWorkoutByIdControllerTest extends AbstractFitnessManagerDatabaseTest
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
            '/fitness-api/item',
            'GET',
            ['id' => 1]
        );

        $this->compareResultToFixture(
            $actualResponse,
            __FUNCTION__,
            'Could not get workout by id correctly'
        );
    }
}
