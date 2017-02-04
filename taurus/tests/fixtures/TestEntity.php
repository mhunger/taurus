<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 04/02/17
 * Time: 19:09
 */

namespace taurus\tests\fixtures;

/**
 * Class TestEntity
 * @package taurus\tests\fixtures
 *
 * @Entity(table="test_table")
 */
class TestEntity
{

    /**
     * @var int
     * @Id
     * @Column(name="test_id")
     */
    public $idTestField;

    /**
     * @var string
     * @Column(name="test_field")
     */
    public $testField;
}