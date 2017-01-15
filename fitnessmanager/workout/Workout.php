<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 15/01/17
 * Time: 19:50
 */

namespace fitnessmanager\workout;

/**
 * Class Workout
 * @package fitnessmanager\workout
 *
 * @Model(table="workout")
 */
class Workout {

    /**
     * @Column(name="id")
     * @var \DateTime
     */
    public $id;

    /**
     * @Column(name="date")
     */
    public $date;

    /**
     * @param \DateTime $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @param mixed $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }
}