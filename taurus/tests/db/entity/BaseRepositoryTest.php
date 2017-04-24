<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 05/02/17
 * Time: 16:51
 */

namespace taurus\tests\db\entity;

use fitnessmanager\exercise\Exercise;
use fitnessmanager\exercise\ExerciseGroup;
use fitnessmanager\exercise\MuscleGroup;
use fitnessmanager\workout\Workout;
use fitnessmanager\workout\WorkoutLocation;
use taurus\framework\Container;
use taurus\framework\config\TaurusContainerConfig;
use taurus\framework\db\entity\BaseRepository;
use taurus\tests\AbstractDatabaseTest;
use taurus\tests\fixtures\ExerciseBuilder;

/**
 * Class BaseRepositoryTest
 * @package taurus\tests\db\entity
 */
class BaseRepositoryTest extends AbstractDatabaseTest
{

    /** @var BaseRepository */
    private $subject;

    public function setUp()
    {
        parent::setUp();
        $this->subject = Container::getInstance()
            ->getService(TaurusContainerConfig::SERVICE_BASE_REPOSITORY);
    }

    public function testFindOne() {
        /** @var $exerciseBuilder ExerciseBuilder */
        $exerciseBuilder = Container::getInstance()->getService(TaurusContainerConfig::SERVICE_EXERCISE_BUILDER);

        $this->assertEquals(
            $exerciseBuilder->build(3, 'Pull-Up', 'hard', 'Chinup', 1, 'TUM Sportzentrum', 1, 'Pullups', 'hard', 5, 'Back', [(new Exercise())->setId(3)]),
            $this->subject->findOne(3, Exercise::class),
            'Could not load complete entity using base repository in base repo test'
        );
    }

    /**
     *
     */
    public function testInsert()
    {
        $expectedEntity = (new Exercise())
            ->setId(5)
            ->setName('Reverse Push-Up')
            ->setDifficulty('medium')
            ->setVariantName('Two-Bars')
            ->setWorkoutLocation(
                (new WorkoutLocation())->setId(1)->setName('TUM Sportzentrum')
            )->setExerciseGroup(
                (new ExerciseGroup())->setId(2)->setName('Pushups')->setDifficulty('medium')
                ->setMuscleGroup(
                    (new MuscleGroup())->setId(1)->setName('Chest')
                )
            );

        $this->subject->save($expectedEntity);

        $actualEntity = $this->subject->findOne(5, Exercise::class);

        $this->assertEquals(
            $expectedEntity,
            $actualEntity,
            'The entity was not saved correctly'
        );
    }

    /**
     *
     */
    public function testDelete()
    {
        $workout = (new Workout())
            ->setId(2);

        $this->assertInstanceOf(
            Workout::class,
            $this->subject->findOne(2, get_class($workout))
        );

        $this->subject->delete($workout);

        $this->assertNull(
            $this->subject->findOne(2, get_class($workout)),
            'Object was not deleted'
        );
    }

    public function testUpdate()
    {
        /** @var Workout $expectedWorkout */
        $expectedWorkout = $this->subject->findOne(2, Workout::class);
        $expectedWorkout->setDate('2017-01-01 00:00:00');
        $this->subject->update($expectedWorkout);
        $actualWorkout = $this->subject->findOne(2, Workout::class);

        $this->assertEquals(
            $expectedWorkout,
            $actualWorkout,
            'Object was not updated correctly'
        );
    }

    public function testFindAll()
    {
        $this->markTestIncomplete('The findAll method is implicitly tested with the default service for getting all entities. Can be done later');
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
            'workout.xml'
        ];
    }
}
