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
     * @var WorkoutLocation
     * @Column(name="workout_location_id")
     * @OneToOne(entity="fitnessmanager\workout\WorkoutLocation", column="workout_location_id", reference_table="workout_location", reference_key_field="id")
     */
    public $workoutLocation;

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

    /**
     * @return WorkoutLocation
     */
    public function getWorkoutLocation(): WorkoutLocation
    {
        return $this->workoutLocation;
    }

    /**
     * @param WorkoutLocation|null $workoutLocation
     * @return Workout
     */
    public function setWorkoutLocation(WorkoutLocation $workoutLocation = null): Workout
    {
        $this->workoutLocation = $workoutLocation;

        return $this;
    }
}
