<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 24/02/17
 * Time: 20:14
 */

namespace taurus\tests\api;


use taurus\tests\testmodel\Exercise;
use taurus\tests\testmodel\ExerciseGroup;
use taurus\tests\testmodel\MuscleGroup;
use taurus\tests\testmodel\WorkoutLocation;
use taurus\framework\api\GetAllEntitiesDefaultServiceImpl;
use taurus\framework\config\TaurusContainerConfig;
use taurus\framework\Container;
use taurus\tests\AbstractTaurusDatabaseTest;

class GetAllEntitiesDefaultServiceImplTest extends AbstractTaurusDatabaseTest
{
    /** @var GetAllEntitiesDefaultServiceImpl */
    private $service;

    public function setUp()
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        /** @var GetAllEntitiesDefaultServiceImpl $service */
        $service = Container::getInstance()->getService(TaurusContainerConfig::SERVICE_DEFAULT_GET_ALL_ENTITIES_SERVICE);
        $service->setEntityClass(Exercise::class);
        $this->service = $service;
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

    public function testGetAllEntities()
    {
        $this->markTestSkipped('This is tested implicitly with the test get all entities controller test');

        $expectedResult = [
            (new Exercise())->setId(3)->setName('Pull-Up')->setDifficulty('hard')->setVariantName('Chinup')
                ->setWorkoutLocation(
                    (new WorkoutLocation())->setId(1)->setName('TUM Sportzentrum')
                )->setExerciseGroup(
                    (new ExerciseGroup())->setId(1)->setName('Pullups')->setDifficulty('hard')
                        ->setMuscleGroup(
                            (new MuscleGroup())->setId(5)->setName('Back')
                        )
                ),
            (new Exercise())->setId(4)->setName('Push-Ups')->setDifficulty('medium')->setVariantName('Standing')
                ->setWorkoutLocation(
                    (new WorkoutLocation())->setId(1)->setName('TUM Sportzentrum')
                )->setExerciseGroup(
                    (new ExerciseGroup())->setId(2)->setName('Pushups')->setDifficulty('medium')
                        ->setMuscleGroup(
                            (new MuscleGroup())->setId(1)->setName('Chest')
                        )
                )
        ];

        $this->assertEquals(
            $expectedResult,
            $this->service->getAllEntities(
                Container::getInstance()->getService(TaurusContainerConfig::SERVICE_MOCK_REQUEST)
            ),
            'Could not load all entities in api default service implementation'
        );

    }
}
