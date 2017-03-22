<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 21/03/17
 * Time: 20:45
 */

namespace taurus\tests\fixtures;


use fitnessmanager\exercise\Exercise;
use fitnessmanager\exercise\ExerciseGroup;
use fitnessmanager\exercise\MuscleGroup;
use fitnessmanager\workout\WorkoutLocation;

class ExerciseBuilder
{

    /**
     * @param int $id
     * @param string $name
     * @param string $difficulty
     * @param string $variant
     * @param int $workoutLocationId
     * @param string $workoutLocationName
     * @param int $exerciseGroupId
     * @param string $exerciseName
     * @param string $exerciseDifficulty
     * @param int $muscleGroupId
     * @param string $muscleGroupName
     * @return Exercise
     */
    public function build(
        int $id,
        string $name,
        string $difficulty,
        string $variant,
        int $workoutLocationId,
        string $workoutLocationName,
        int $exerciseGroupId,
        string $exerciseName,
        string $exerciseDifficulty,
        int $muscleGroupId,
        string $muscleGroupName
    ): Exercise {
        return (new Exercise())
            ->setId($id)
            ->setName($name)
            ->setDifficulty($difficulty)
            ->setVariantName($variant)
            ->setWorkoutLocation(
                (new WorkoutLocation())->setId($workoutLocationId)->setName($workoutLocationName)
            )->setExerciseGroup(
                (new ExerciseGroup())->setId($exerciseGroupId)->setName($exerciseName)->setDifficulty($exerciseDifficulty)
                    ->setMuscleGroup(
                        (new MuscleGroup())->setId($muscleGroupId)->setName($muscleGroupName)
                    )
            );
    }
}