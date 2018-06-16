<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 25/02/17
 * Time: 18:58
 */

namespace taurus\tests\testmodel;


use taurus\framework\db\Entity;
use taurus\framework\db\entity\types\GeoPoint;
use taurus\framework\annotation\Column;

/**
 * Class WorkoutLocation
 * @package fitnessmanager\workout
 *
 * @Entity(table="workout_location")
 */
class WorkoutLocation implements Entity
{

    const TABLE_NAME = 'workout_location';
    /**
     * @var int
     * @Id
     * @Column(name="id")
     */
    public $id;

    /**
     * @var string
     * @Column(name="name")
     */
    public $name;

    /**
     * @var GeoPoint
     * @Column(name="geo_location")
     * @GeoPoint()
     */
    public $geoLocation;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }



    /**
     * @param int $id
     * @return $this
     */
    public function setId(int $id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function setName(string $name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return GeoPoint
     */
    public function getGeoLocation()
    {
        return $this->geoLocation;
    }

    /**
     * @param GeoPoint $geoLocation
     */
    public function setGeoLocation($geoLocation = null)
    {
        $this->geoLocation = $geoLocation;
    }
}