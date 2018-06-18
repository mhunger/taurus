<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 05/02/17
 * Time: 15:36
 */

namespace taurus\tests\db\entity;


use PHPUnit\Framework\TestCase;
use taurus\framework\annotation\AbstractAnnotation;
use taurus\framework\annotation\AnnotationProperty;
use taurus\framework\annotation\Column;
use taurus\framework\Container;
use taurus\framework\config\TaurusContainerConfig;
use taurus\framework\db\entity\EntityMetaDataStore;
use taurus\tests\AbstractTaurusTest;
use taurus\tests\fixtures\TestEntity;

/**
 * Class EntityMetaDataStoreTest
 * @package taurus\tests\db\entity
 */
class EntityMetaDataStoreTest extends AbstractTaurusTest
{

    /**
     * @var EntityMetaDataStore
     */
    private $subject;

    /**
     * @throws \taurus\framework\error\ContainerCannotInstantiateService
     */
    protected function setUp()
    {
        parent::setUp();
        $this->subject = Container::getInstance()->getService(TaurusContainerConfig::SERVICE_ENTITY_METADATA_STORE);
    }

    public function testGetColumns()
    {
        $expectedResult = [
            'idTestField' => new Column('idTestField', 'test_id'),
            'testField' => new Column('testField', 'test_field'),
            'password' => new Column('password', 'password'),
            'point' => new Column('point', 'geo_location')
        ];

        $actualResult = $this->subject
            ->getEntityMetaData(TestEntity::class)
            ->getColumns();

        $this->assertEquals(
            $expectedResult,
            $actualResult,
            'Columns did not match or were not in correct order'
        );
    }
}
