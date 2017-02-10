<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 05/02/17
 * Time: 16:51
 */

namespace taurus\tests\db\entity;

use fitnessmanager\exercise\Exercise;
use PDO;
use PHPUnit_Extensions_Database_DataSet_IDataSet;
use PHPUnit_Extensions_Database_DB_IDatabaseConnection;
use taurus\framework\Container;
use taurus\framework\config\TaurusContainerConfig;
use taurus\framework\db\entity\BaseRepository;
use taurus\tests\AbstractDatabaseTest;
use fitnessmanager\config\test\TestContainerConfig;

class BaseRepositoryTest extends AbstractDatabaseTest
{

    /** @var BaseRepository */
    private $subject;

    public function __construct()
    {
        $this->fixtureFiles = [
            'exercise.xml'
        ];

        $this->subject = Container::getInstance()
            ->setContainerConfig(
                new TestContainerConfig()
            )->getService(TaurusContainerConfig::SERVICE_BASE_REPOSITORY);
    }

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
}
