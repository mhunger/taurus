<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 25/02/17
 * Time: 18:58
 */

namespace fitnessmanager\workout;


use taurus\framework\db\Entity;

/**
 * Class WorkoutLocation
 * @package fitnessmanager\workout
 *
 * @Entity(table="workout_location")
 */
class WorkoutLocation implements Entity
{
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
}