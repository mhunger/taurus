<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 22/02/17
 * Time: 20:07
 */

namespace taurus\tests\api;


use fitnessmanager\exercise\Exercise;
use fitnessmanager\exercise\ExerciseGroup;
use fitnessmanager\exercise\MuscleGroup;
use fitnessmanager\workout\WorkoutLocation;
use taurus\framework\api\SaveEntityDefaultServiceImpl;
use taurus\framework\config\TaurusContainerConfig;
use taurus\framework\Container;
use taurus\framework\db\entity\BaseRepository;
use taurus\framework\http\HttpResponse;
use taurus\framework\mock\MockRequest;
use taurus\tests\AbstractDatabaseTest;

class SaveEntityDefaultServiceImplTest extends AbstractDatabaseTest
{
    /** @var SaveEntityDefaultServiceImpl */
    private $service;

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

    public function setUp()
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        $this->service = Container::getInstance()->getService(TaurusContainerConfig::SERVICE_DEFAULT_SAVE_ENTITY_SERVICE);
    }

    public function testSaveEntityInPost()
    {
        $mockRequest = (new MockRequest())
            ->setMethod('POST')
            ->setUrl('/exercise')
            ->setInputBody([
                'exercise' => [
                    'name' => 'TestExercise',
                    'difficulty' => 'TestDifficulty',
                    'variant_name' => 'TestVariant',
                    'exercise_group_id' => 1,
                    'workout_location_id' => 1
                ]
            ]);

        $this->service->setEntityClass(Exercise::class);
        $this->service->saveEntity($mockRequest);

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

        $mockServer = Container::getInstance()->getService(TaurusContainerConfig::SERVICE_MOCK_SERVER);
        $actualResponse = $mockServer->get(
            '/api/exercise',
            'GET',
            ['id' => 5]
        );

        $this->compareResultToFixture(
            $actualResponse,
            __FUNCTION__,
            'Could not store exercise entity correctly in SaveentityDefault Service'
        );
    }
}
