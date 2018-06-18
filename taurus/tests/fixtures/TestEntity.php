<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 04/02/17
 * Time: 19:09
 */

namespace taurus\tests\fixtures;

use taurus\framework\db\Entity;
use taurus\framework\annotation\Json;
use taurus\framework\db\entity\types\GeoPoint;

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
     * @Json(type="number")
     */
    public $idTestField;

    /**
     * @var string
     * @Column(name="test_field")
     * @Json(type="string")
     */
    public $testField;

    /**
     * @var string
     * @PasswordHash(algo="PASSWORD_BCRYPT", cost="12")
     * @Column(name="password")
     */
    public $password;


    /**
     * @var GeoPoint
     * @GeoPoint()
     * @Column(name="geo_location")
     */
    public $point;


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

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @return mixed
     */
    public function getPoint(): ?GeoPoint
    {
        return $this->point;
    }

    /**
     * @param mixed $point
     */
    public function setPoint(GeoPoint $point)
    {
        $this->point = $point;
    }
}
