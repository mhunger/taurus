<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 21/03/17
 * Time: 20:35
 */

namespace taurus\tests\api;


use taurus\tests\testmodel\Exercise;
use taurus\framework\config\TaurusContainerConfig;
use taurus\framework\Container;
use taurus\framework\db\entity\BaseRepository;
use taurus\framework\mock\MockServer;
use taurus\framework\routing\Request;
use taurus\tests\AbstractTaurusDatabaseTest;
use taurus\tests\fixtures\ExerciseBuilder;

class UpdateEntityApiControllerTest extends AbstractTaurusDatabaseTest
{
    public function setUp()
    {
        parent::setUp();
    }

    public function testUpdateEntity()
    {
        /** @var MockServer $mockServer */
        $mockServer = Container::getInstance()->getService(TaurusContainerConfig::SERVICE_MOCK_SERVER);
        $mockServer->get(
            '/api/exercise',
            Request::HTTP_PUT,
            [],
            [
                'exercise' => [
                    'id' => 3,
                    'name' => 'TestExercise',
                    'difficulty' => 'TestDifficulty',
                    'variantName' => 'TestVariant',
                    'exerciseGroup' => 1,
                    'workoutLocation' => 1
                ]
            ]
        );

        $mockServer = Container::getInstance()->getService(TaurusContainerConfig::SERVICE_MOCK_SERVER);
        $actualResponse = $mockServer->get(
            '/api/exercise',
            'GET',
            ['id' => 3]
        );

        $this->compareResultToFixture(
            $actualResponse,
            __FUNCTION__,
            'Could not store existing entity with default service'
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
