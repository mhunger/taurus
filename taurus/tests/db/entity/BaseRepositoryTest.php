<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 05/02/17
 * Time: 16:51
 */

namespace taurus\tests\db\entity;


use PDO;
use PHPUnit_Extensions_Database_DataSet_IDataSet;
use PHPUnit_Extensions_Database_DB_IDatabaseConnection;
use taurus\tests\AbstractDatabaseTest;

class BaseRepositoryTest extends AbstractDatabaseTest
{


    public function __construct()
    {
        $this->fixtureFiles = [
            'exercise.xml'
        ];
    }

    public function testInsert()
    {
        $this->getConnection()->createDataSet();
    }
}
