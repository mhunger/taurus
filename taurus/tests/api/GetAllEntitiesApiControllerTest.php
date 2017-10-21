<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 24/02/17
 * Time: 21:08
 */

namespace taurus\tests\api;


use taurus\tests\testmodel\Exercise;
use taurus\framework\api\GetAllEntitiesApiController;
use taurus\framework\api\GetAllEntitiesDefaultServiceImpl;
use taurus\framework\config\TaurusContainerConfig;
use taurus\framework\Container;
use taurus\framework\mock\MockRequest;
use taurus\framework\mock\MockServer;
use taurus\tests\AbstractTaurusDatabaseTest;

class GetAllEntitiesApiControllerTest extends AbstractTaurusDatabaseTest
{
    /** @var GetAllEntitiesApiController */
    private $controller;

    public function setUp()
    {
        parent::setUp();
    }

    public function testGetAllEntities()
    {
        /** @var MockServer $mockServer */
        $mockServer = Container::getInstance()
            ->getService(TaurusContainerConfig::SERVICE_MOCK_SERVER);

        $actualResponse = $mockServer->get(
            '/api/exercises',
            'GET',
            []
        );

        $this->compareResultToFixture(
            $actualResponse,
            __FUNCTION__,
            'Could not get all resources for exercises through the standard api controller'
        );
    }


    /**
     * @return array
     */
    function getFixtureFiles(): array
    {
        return [
            'workout_location.xml',
            'muscle_group.xml',
            'exercise_group.xml',
            'exercise.xml'
        ];
    }
}
