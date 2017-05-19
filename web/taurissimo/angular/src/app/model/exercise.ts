import {ExerciseGroup} from "./exercise-group";
import {WorkoutLocation} from "./workout-location";
/**
 * Created by michaelhunger on 06/04/17.
 */

export class Exercise {
    id: number;
    name: string;
    difficulty: string;
    variantName: string;
    exerciseGroup: ExerciseGroup;
    workoutLocation: WorkoutLocation;

    /**
     * @param id
     * @param name
     * @param difficulty
     * @param variant
     * @param exerciseGroup
     * @param workoutLocation
     */
    constructor(id: number = null, name: string = null, difficulty: string = null,
                variant: string = null, exerciseGroup: ExerciseGroup = null,
                workoutLocation: WorkoutLocation = null) {
        this.id = id;
        this.name = name;
        this.difficulty = difficulty;
        this.variantName = variant;
        this.workoutLocation = workoutLocation;
        this.exerciseGroup = exerciseGroup;
    }
}
