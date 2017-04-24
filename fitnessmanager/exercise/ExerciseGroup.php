<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 19/03/17
 * Time: 12:47
 */

namespace fitnessmanager\exercise;

use taurus\framework\db\Entity;
use taurus\framework\annotation\OneToOne;
use taurus\framework\annotation\OneToMany;

/**
 * Class ExerciseGroup
 * @package fitnessmanager\exercise
 *
 * @Entity(table="exercise_group")
 */
class ExerciseGroup implements Entity
{
    /**
     * @var int
     * @Id
     * @Column(name="id")
     */
    public $id;

    /**
     * @var
     * @Column(name="name")
     */
    public $name;

    /**
     * @var
     * @Column(name="difficulty")
     */
    public $difficulty;

    /**
     * @var
     * @Column(name="muscle_group_id")
     * @OneToOne(entity="fitnessmanager\exercise\MuscleGroup", column="muscle_group_id", reference_table="muscle_group", reference_key_field="id")
     */
    public $muscleGroup;

    /**
     * @var array
     * @OneToMany(entity="fitnessmanager\exercise\Exercise", column="exercise_id", referenceTable="exercise", foreignKeyField="exercise_group_id")
     */
    public $exercises;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param $id
     * @return $this
     */
    public function setId(int $id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return mixed
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
     * @return mixed
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
     * @return mixed
     */
    public function getMuscleGroup()
    {
        return $this->muscleGroup;
    }

    /**
     * @param $muscleGroup
     * @return $this
     */
    public function setMuscleGroup($muscleGroup)
    {
        $this->muscleGroup = $muscleGroup;

        return $this;
    }

    /**
     * @return array
     */
    public function getExercises(): array
    {
        return $this->exercises;
    }

    /**
     * @param array $exercises
     * @return ExerciseGroup
     */
    public function setExercises(array $exercises): ExerciseGroup
    {
        $this->exercises = $exercises;
        return $this;
    }
}
