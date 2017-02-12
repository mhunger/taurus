<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 15/01/17
 * Time: 19:50
 */

namespace fitnessmanager\workout;

use taurus\framework\db\Entity;

/**
 * Class Workout
 * @package fitnessmanager\workout
 *
 * @Entity(table="workout")
 */
class Workout implements Entity {

    /**
     * @Id
     * @Column(name="id")
     * @var int
     */
    public $id;

    /**
     * @Column(name="date")
     * @var \DateTime
     */
    public $date;

    /**
     * @param $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @param $date
     * @return $this
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }


}