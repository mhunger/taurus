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
     * @Column(entity="TestEntity")
     */
    public $entity;

    public $instance;

    /**
     * @Setter(property="id")
     */
    public function method() {

    }
}
