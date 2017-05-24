import {Exercise} from "./exercise";
import {ExerciseGroup} from "./exercise-group";
import {WorkoutLocation} from "./workout-location";
import {MuscleGroup} from "./muscle-group";
import {Injectable} from "@angular/core";
/**
 * Created by michaelhunger on 20/05/17.
 *
 * Build a new exercise template. This can also be used to create an empty exercise.
 *
 */

@Injectable()
export class ExerciseBuilderService {
    build(exerciseId: number = null, exerciseName: string = null,
    exerciseDifficulty: string = null, exerciseVariant: string = null,
    exerciseGroupName: string = null, exerciseGroupId: number = null, exerciseGroupDifficulty: string = null,
    muscleGroupId: number = null, muscleGroupName: string = null, workoutLocationId: number = null,
    workoutLocationName: string = null): Exercise {

        return new Exercise(exerciseId, exerciseName, exerciseDifficulty, exerciseVariant,
            new ExerciseGroup(
                exerciseGroupId,
                exerciseGroupName,
                exerciseGroupDifficulty,
                new MuscleGroup(muscleGroupId, muscleGroupName)
            ),
            new WorkoutLocation(workoutLocationId, workoutLocationName)
        );
    }
}