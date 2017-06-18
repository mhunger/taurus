<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 21/03/17
 * Time: 20:45
 */

namespace taurus\tests\fixtures;


use taurus\tests\testmodel\Exercise;
use taurus\tests\testmodel\ExerciseGroup;
use taurus\tests\testmodel\MuscleGroup;
use taurus\tests\testmodel\WorkoutLocation;

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
     * @param string $exerciseGroupName
     * @param string $exerciseGroupDifficulty
     * @param int $muscleGroupId
     * @param string $muscleGroupName
     * @param array $exercises
     * @return \taurus\tests\testmodel\Exercise
     */
    public function build(
        int $id,
        string $name,
        string $difficulty,
        string $variant,
        int $workoutLocationId,
        string $workoutLocationName,
        int $exerciseGroupId,
        string $exerciseGroupName,
        string $exerciseGroupDifficulty,
        int $muscleGroupId,
        string $muscleGroupName,
        array $exercises
    ): Exercise {
        return (new Exercise())
            ->setId($id)
            ->setName($name)
            ->setDifficulty($difficulty)
            ->setVariantName($variant)
            ->setWorkoutLocation(
                (new WorkoutLocation())->setId($workoutLocationId)->setName($workoutLocationName)
            )->setExerciseGroup(
                (new ExerciseGroup())->setId($exerciseGroupId)->setName($exerciseGroupName)->setDifficulty($exerciseGroupDifficulty)->setExercises($exercises)
                    ->setMuscleGroup(
                        (new MuscleGroup())->setId($muscleGroupId)->setName($muscleGroupName)
                    )
            );
    }
}
