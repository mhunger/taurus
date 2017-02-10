<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 05/02/17
 * Time: 15:36
 */

namespace taurus\tests\db\entity;


use PHPUnit\Framework\TestCase;
use taurus\framework\annotation\Annotation;
use taurus\framework\annotation\AnnotationProperty;
use taurus\framework\Container;
use taurus\framework\config\TaurusContainerConfig;
use taurus\framework\db\entity\EntityMetaDataStore;
use taurus\tests\fixtures\TestEntity;

/**
 * Class EntityMetaDataStoreTest
 * @package taurus\tests\db\entity
 */
class EntityMetaDataStoreTest extends TestCase
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
            'idTestField' => new Annotation(EntityMetaDataStore::ENTITY_ANNOTATION_COLUMN,
                [
                    new AnnotationProperty(
                        EntityMetaDataStore::ANNOTATION_PROPERTY_COLUMN_NAME,
                        'test_id'
                    )
                ]
            ),
            'testField' => new Annotation(EntityMetaDataStore::ENTITY_ANNOTATION_COLUMN,
                [
                    new AnnotationProperty(
                        EntityMetaDataStore::ANNOTATION_PROPERTY_COLUMN_NAME,
                        'test_field'
                    )
                ])
        ];

        $actualResult = $this->subject
            ->getEntityMetaData(TestEntity::class)
            ->getColumns(new TestEntity());

        $this->assertEquals(
            $expectedResult,
            $actualResult,
            'Columns did not match or were not in correct order'
        );
    }
}
