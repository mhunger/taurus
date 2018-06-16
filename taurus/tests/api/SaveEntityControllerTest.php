<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 22/02/17
 * Time: 20:39
 */

namespace taurus\tests\api;


use taurus\tests\testmodel\Exercise;
use taurus\tests\testmodel\ExerciseGroup;
use taurus\tests\testmodel\MuscleGroup;
use taurus\tests\testmodel\WorkoutLocation;
use taurus\framework\api\SaveEntityApiController;
use taurus\framework\api\SaveEntityDefaultServiceImpl;
use taurus\framework\config\TaurusContainerConfig;
use taurus\framework\Container;
use taurus\framework\db\entity\BaseRepository;

use taurus\framework\mock\MockRequest;
use taurus\framework\mock\MockServer;
use taurus\tests\AbstractTaurusDatabaseTest;

class SaveEntityControllerTest extends AbstractTaurusDatabaseTest
{
    /** @var SaveEntityApiController */
    private $controller;

    public function setUp()
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        /** @var SaveEntityApiController $controller */
        $controller = Container::getInstance()->getService(TaurusContainerConfig::SERVICE_DEFAULT_SAVE_ENTITY_CONTROLLER);
        /** @var SaveEntityDefaultServiceImpl $service */
        $service = Container::getInstance()->getService(TaurusContainerConfig::SERVICE_DEFAULT_SAVE_ENTITY_SERVICE);
        $service->setEntityClass(Exercise::class);
        $controller->setService($service);
        $this->controller = $controller;
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
            'exercise.xml',
            'user.xml'
        ];
    }

    public function testDefaultSaveEntityController()
    {
        $mockRequest = (Container::getInstance()->getService(TaurusContainerConfig::SERVICE_MOCK_REQUEST))
            ->setMethod('POST')
            ->setUrl('/exercise')
            ->setInputBody([
                'exercise' => [
                    'name' => 'TestExercise',
                    'difficulty' => 'TestDifficulty',
                    'variantName' => 'TestVariant',
                    'exerciseGroup' => 1,
                    'workoutLocation' => 1
                ]
            ]);

        $this->controller->handleRequest($mockRequest);

        /** @var MockServer $mockServer */
        $mockServer = Container::getInstance()->getService(TaurusContainerConfig::SERVICE_MOCK_SERVER);
        $actualResponse = $mockServer->get(
            '/api/exercise',
            'GET',
            ['id' => 7]
        );

        $this->compareResultToFixture(
            $actualResponse,
            __FUNCTION__,
            'Could not store exercise using default controller'
        );
    }

    public function testPointDataSavedCorrectly()
    {
        $token = $this->login();
        /** @var MockRequest $mockRequest */
        $mockRequest = (Container::getInstance()->getService(TaurusContainerConfig::SERVICE_MOCK_REQUEST))
            ->setMethod('POST')
            ->setUrl('/workout-location')
            ->setInputBody([
                'workoutlocation' => [
                    'name' => 'Home',
                    'geoLocation' => '1, 2'
                ]
            ])
            ->addHeader('x-token', $token->getEncodedTokenString());


        /** @var SaveEntityDefaultServiceImpl $service */
        $service = Container::getInstance()->getService(TaurusContainerConfig::SERVICE_DEFAULT_SAVE_ENTITY_SERVICE);
        $service->setEntityClass(WorkoutLocation::class);
        $this->controller->setService($service);
        $this->controller->handleRequest($mockRequest);

        /** @var MockServer $mockServer */
        $mockServer = Container::getInstance()->getService(TaurusContainerConfig::SERVICE_MOCK_SERVER);
        $actualResponse = $mockServer->get(
            '/api/workout-location',
            'GET',
            ['id' => 4],
            [],
            ['x-token' => $token->getEncodedTokenString()]
        );

        $this->compareResultToFixture(
            $actualResponse,
            __FUNCTION__,
            'Could not store exercise using default controller'
        );
    }
}
