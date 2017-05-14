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

        $this->compareResultToFixture(
            $actualResponse,
            __FUNCTION__,
            'Could not get workout by id correctly'
        );
    }
}
