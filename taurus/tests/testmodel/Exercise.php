<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 05/02/17
 * Time: 16:06
 */

namespace taurus\tests\testmodel;


use taurus\framework\db\Entity;
use taurus\framework\annotation\OneToOne;

/**
 * Class Exercise
 * @package fitnessmanager\exercise
 * @Entity(table="exercise")
 */
class Exercise implements Entity
{

    const EXERCISE_TABLE_NAME = 'exercise';

    /**
     * @var int
     * @Id
     * @Column(name="exercise_id")
     */
    public $id;

    /**
     * @var string
     * @Column(name="name")
     */
    public $name;

    /**
     * @var string
     * @Column(name="difficulty")
     */
    public $difficulty;

    /**
     * @var string
     * @Column(name="variant_name")
     */
    public $variantName;

    /**
     * @var ExerciseGroup
     * @Column(name="exercise_group_id")
     * @OneToOne(entity="taurus\tests\testmodel\ExerciseGroup", column="exercise_group_id", reference_table="exercise_group", reference_key_field="id")
     */
    public $exerciseGroup;

    /**
     * @var WorkoutLocation
     * @Column(name="workout_location_id")
     * @OneToOne(entity="taurus\tests\testmodel\WorkoutLocation", column="workout_location_id", reference_table="workout_location", reference_key_field="id")
     */
    public $workoutLocation;

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
    public function getName()
    {
        return $this->name;
    }


    /**
     * @param $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getDifficulty()
    {
        return $this->difficulty;
    }

    /**
     * @param $difficulty
     * @return $this
     */
    public function setDifficulty($difficulty)
    {
        $this->difficulty = $difficulty;

        return $this;
    }

    /**
     * @return string
     */
    public function getVariantName()
    {
        return $this->variantName;
    }

    /**
     * @param $variantName
     * @return $this
     */
    public function setVariantName($variantName)
    {
        $this->variantName = $variantName;

        return $this;
    }

    /**
     * @return ExerciseGroup
     */
    public function getExerciseGroup(): ExerciseGroup
    {
        return $this->exerciseGroup;
    }

    /**
     * @param ExerciseGroup $exerciseGroup
     * @return $this
     */
    public function setExerciseGroup(ExerciseGroup $exerciseGroup)
    {
        $this->exerciseGroup = $exerciseGroup;
        return $this;
    }

    /**
     * @return WorkoutLocation
     */
    public function getWorkoutLocation(): WorkoutLocation
    {
        return $this->workoutLocation;
    }

    /**
     * @param WorkoutLocation $workoutLocation
     * @return $this
     */
    public function setWorkoutLocation(WorkoutLocation $workoutLocation)
    {
        $this->workoutLocation = $workoutLocation;
        return $this;
    }
}
