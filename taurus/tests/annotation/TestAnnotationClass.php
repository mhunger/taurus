<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 16/12/16
 * Time: 11:51
 */
namespace taurus\tests\annotation;

use taurus\tests\fixtures\TestEntity;

/**
 * Class TestAnnotationClass
 * @Entity(table="test")
 */
class TestAnnotationClass {

    /**
     * @var int
     * @Id
     * @Column(name="test_id")
     */
    public $id;

    /**
     * @var string
     * @Column(name="id")
     */
    public $test;

    /**
     * @var TestEntity
     * @Column(name="TestEntity")
     * @OneToOne(entity="\taurus\framework\db\Entity\TestEntity", column="entity_id_column", reference_table="test_table", reference_table_field="id_test")
     */
    public $entity;

    /**
     * @var
     * @OneToOne(entity="\taurus\framework\db\Entity\TestEntity", reference_table="test_table", column="entity_id_column", reference_table_field="id_test")
     */
    public $instance;

    /**
     * @Setter(attribute="id")
     */
    public function method() {

    }
}
