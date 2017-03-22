<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 21/03/17
 * Time: 20:35
 */

namespace taurus\tests\api;


use fitnessmanager\exercise\Exercise;
use taurus\framework\config\TaurusContainerConfig;
use taurus\framework\Container;
use taurus\framework\db\entity\BaseRepository;
use taurus\framework\mock\MockServer;
use taurus\framework\routing\Request;
use taurus\tests\AbstractDatabaseTest;
use taurus\tests\fixtures\ExerciseBuilder;

class UpdateEntityApiControllerTest extends AbstractDatabaseTest
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
            [
                'exercise' => [
                    'exercise_id' => 3,
                    'name' => 'TestExercise',
                    'difficulty' => 'TestDifficulty',
                    'variant_name' => 'TestVariant',
                    'exercise_group_id' => 1,
                    'workout_location_id' => 1
                ]
            ]
        );

        /** @var ExerciseBuilder $builder */
        $builder = Container::getInstance()->getService(TaurusContainerConfig::SERVICE_EXERCISE_BUILDER);
        $expectedEntity = $builder->build(
            3,
            'TestExercise',
            'TestDifficulty',
            'TestVariant',
            1,
            'TUM Sportzentrum',
            1,
            'Pullups',
            'hard',
            5,
            'Back'
        );

        /** @var BaseRepository $baserepo */
        $baserepo = Container::getInstance()->getService(TaurusContainerConfig::SERVICE_BASE_REPOSITORY);
        $actualEntity = $baserepo->findOne(3, Exercise::class);

        $this->assertEquals(
            $expectedEntity,
            $actualEntity,
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
