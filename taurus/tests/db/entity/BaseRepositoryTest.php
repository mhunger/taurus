<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 05/02/17
 * Time: 16:51
 */

namespace taurus\tests\db\entity;

use fitnessmanager\exercise\Exercise;
use fitnessmanager\workout\Workout;
use PDO;
use PHPUnit_Extensions_Database_DataSet_IDataSet;
use PHPUnit_Extensions_Database_DB_IDatabaseConnection;
use taurus\framework\Container;
use taurus\framework\config\TaurusContainerConfig;
use taurus\framework\db\entity\BaseRepository;
use taurus\tests\AbstractDatabaseTest;
use fitnessmanager\config\test\TestContainerConfig;

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

    /**
     *
     */
    public function testInsert()
    {
        $expectedEntity = (new Exercise())
            ->setId(5)
            ->setName('Reverse Push-Up')
            ->setDifficulty('medium')
            ->setVariantName('Two-Bars');

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
        /** @var Workout $workout */
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
            'exercise.xml',
            'workout.xml'
        ];
    }
}
