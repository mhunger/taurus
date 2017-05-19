/**
 * Created by michaelhunger on 06/04/17.
 */
import {Component, Input, OnInit} from '@angular/core';
import {Exercise} from "../exercise/exercise";
import {Select2OptionData} from "ng2-select2";
import {Http} from "@angular/http";
import {SelectBoxDataService} from "./selectbox-data.service";
import {ExerciseService} from "../exercise/exercise.service";

@Component({
    templateUrl: './exercise-form.component.html',
    selector: 'exercise-form'
})

export class ExerciseFormComponent {
    @Input() exercise: Exercise = new Exercise();

    private selectedExerciseGroup: number;
    private selectedWorkoutLocation: number;

    public exerciseGroups: Array<Select2OptionData>;
    public workoutLocations: Array<Select2OptionData>;


    constructor(private http: Http, private optionService: SelectBoxDataService, private exerciseService: ExerciseService) {
        this.getOptions();
    }

    getOptions(): void {
        this.optionService.getSelectBoxData('/api/workoutlocations', entry => ({
            id: entry.id,
            text: entry.name
        } as Select2OptionData))
            .then(
                workoutLocations => this.workoutLocations = workoutLocations
            );

        this.optionService.getSelectBoxData('/api/exercisegroups', entry => ({
            id: entry.id,
            text: entry.name,
            additional: entry
        } as Select2OptionData))
            .then(
                exerciseGroups => this.exerciseGroups = exerciseGroups
            )
    }

    saveExercise(exercise: Exercise) {
        this.exerciseService.saveExercise({
            id: this.exercise.id,
            name: this.exercise.name,
            variantName: this.exercise.variantName,
            difficulty: this.exercise.difficulty,
            exerciseGroup: this.selectedExerciseGroup,
            workoutLocation: this.selectedWorkoutLocation
        });
    }

    setGroup(e: any) {
        this.selectedExerciseGroup = e.value;
    }

    setLocation(e: any, o: any) {
        this.selectedWorkoutLocation = e.value;
    }
}
