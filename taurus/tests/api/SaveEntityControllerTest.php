<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 22/02/17
 * Time: 20:39
 */

namespace taurus\tests\api;


use fitnessmanager\exercise\Exercise;
use fitnessmanager\exercise\ExerciseGroup;
use fitnessmanager\exercise\MuscleGroup;
use fitnessmanager\workout\WorkoutLocation;
use taurus\framework\api\SaveEntityApiController;
use taurus\framework\api\SaveEntityDefaultServiceImpl;
use taurus\framework\config\TaurusContainerConfig;
use taurus\framework\Container;
use taurus\framework\db\entity\BaseRepository;

use taurus\framework\mock\MockRequest;
use taurus\tests\AbstractDatabaseTest;

class SaveEntityControllerTest extends AbstractDatabaseTest
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
            'exercise.xml'
        ];
    }

    public function testDefaultSaveEntityController()
    {
        $mockRequest = (new MockRequest())
            ->setMethod('POST')
            ->setUrl('/exercise')
            ->setRequestVariables([
                'exercise' => [
                    'name' => 'TestExercise',
                    'difficulty' => 'TestDifficulty',
                    'variant_name' => 'TestVariant',
                    'exercise_group_id' => 1,
                    'workout_location_id' => 1
                ]
            ]);

        $this->controller->handleRequest($mockRequest);

        $expectedEntity = (new Exercise())->setId(5)
            ->setName('TestExercise')
            ->setDifficulty('TestDifficulty')
            ->setVariantName('TestVariant')
            ->setWorkoutLocation(
                (new WorkoutLocation())->setId(1)->setName('TUM Sportzentrum')
            )->setExerciseGroup(
                (new ExerciseGroup())->setId(1)->setName('Pullups')->setDifficulty('hard')
                    ->setMuscleGroup(
                        (new MuscleGroup())->setId(5)->setName('Back')
                    )
            );

        /** @var BaseRepository $baserepo */
        $baserepo = Container::getInstance()->getService(TaurusContainerConfig::SERVICE_BASE_REPOSITORY);
        $actualEntity = $baserepo->findOne(5, Exercise::class);

        $this->assertEquals(
            $expectedEntity,
            $actualEntity,
            'Could not store exercise entity correctly in save Default entity controller'
        );
    }
}
