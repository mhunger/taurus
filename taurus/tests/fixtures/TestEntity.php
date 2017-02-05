<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 04/02/17
 * Time: 19:09
 */

namespace taurus\tests\fixtures;

use taurus\framework\db\Entity;

/**
 * Class TestEntity
 * @package taurus\tests\fixtures
 *
 * @Entity(table="test_table")
 */
class TestEntity implements Entity
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

    /**
     * @return int
     */
    public function getIdTestField()
    {
        return $this->idTestField;
    }

    /**
     * @param int $idTestField
     */
    public function setIdTestField($idTestField)
    {
        $this->idTestField = $idTestField;
    }

    /**
     * @return string
     */
    public function getTestField()
    {
        return $this->testField;
    }

    /**
     * @param string $testField
     */
    public function setTestField($testField)
    {
        $this->testField = $testField;
    }
}