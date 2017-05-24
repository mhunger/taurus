/**
 * Created by michaelhunger on 04/05/17.
 */
import {MuscleGroup} from "./muscle-group";

export class ExerciseGroup {
    id: number;
    name: string;
    difficulty: string;
    muscleGroup: MuscleGroup;

    constructor(id: number, name: string, difficulty: string, muscleGroup: MuscleGroup) {
        this.id = id;
        this.name = name;
        this.difficulty = difficulty;
        this.muscleGroup = muscleGroup;
    }
}