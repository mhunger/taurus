<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 04/02/17
 * Time: 19:06
 */

namespace taurus\tests\db\entity;


use PHPUnit\Framework\TestCase;
use taurus\framework\Container;
use taurus\framework\config\TaurusContainerConfig;
use taurus\framework\db\entity\EntityMetaDataImpl;
use taurus\tests\fixtures\TestEntity;

class EntityMetaDataImplTest extends TestCase
{

    /** @var EntityMetaDataImpl */
    private $entityMetaDataImpl;

    public function setUp()
    {
        $this->entityMetaDataImpl = Container::getInstance()->getService(TaurusContainerConfig::SERVICE_ENTITY_METADATA);
    }

    public function testEntityMetaDataGetIdField()
    {
        $actualFieldName = $this->entityMetaDataImpl->getIdField(TestEntity::class);
        $expectedFieldName = 'test_id';

        $this->assertEquals(
            $actualFieldName,
            $expectedFieldName,
            "The id field was not correctly read. Expected: [" . $expectedFieldName . '] got [' . $actualFieldName . ']'
        );
    }

    public function testEntityMetaDataGetTableName()
    {
        $actualTableName = $this->entityMetaDataImpl->getTable(TestEntity::class);
        $expectedTableName = 'test_table';

        $this->assertEquals(
            $actualTableName,
            $expectedTableName,
            "The table name was not correct. Expected: [" . $expectedTableName . '] got [' . $actualTableName . ']'
        );
    }

    public function testGetColumnsFromEntity()
    {
        $expectedResult = [
            'test_id',
            'test_field'
        ];

        $actualResult = $this->entityMetaDataImpl->getColumns(TestEntity::class);
        $this->assertEquals(
            $expectedResult,
            $actualResult,
            'Did not receive the column list correctly from meta data'
        );
    }
}
