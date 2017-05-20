/**
 * Created by michaelhunger on 06/04/17.
 */
import {Component, Input, OnInit} from '@angular/core';
import {Exercise} from "../model/exercise";
import {Select2OptionData} from "ng2-select2";
import {Http} from "@angular/http";
import {SelectBoxDataService} from "./selectbox-data.service";
import {ExerciseService} from "../exercise/exercise.service";
import {ModelDataBrokerService} from "./model-data-broker.service";

@Component({
    templateUrl: './exercise-form.component.html',
    selector: 'exercise-form'
})

export class ExerciseFormComponent {
    exercise: Exercise;

    private selectedExerciseGroup: number;
    private selectedWorkoutLocation: number;

    public exerciseGroups: Array<Select2OptionData>;
    public workoutLocations: Array<Select2OptionData>;

    constructor(private http: Http,
                private optionService: SelectBoxDataService,
                private exerciseService: ExerciseService,
                private modelDataBrokerService: ModelDataBrokerService
    ) {
        this.getOptions();
        modelDataBrokerService.modelDataPubSub$.subscribe(
            exercise => {
                this.exercise = exercise;
                this.selectedExerciseGroup = exercise.exerciseGroup.id;
                this.selectedWorkoutLocation = exercise.workoutLocation.id
            }
        );
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
        console.log(e);
        this.selectedExerciseGroup = e.value;
        this.exercise.exerciseGroup = this.optionService.getItemForBoxData('/api/exercisegroups', e.value);
        this.modelDataBrokerService.formUpdatedWithModel(this.exercise);
        console.log('new group');

    }

    setLocation(e: any, o: any) {
        console.log(e);
        this.selectedWorkoutLocation = e.value;
        this.exercise.workoutLocation = this.optionService.getItemForBoxData('/api/workoutlocations', e.value);
        console.log('testlocation');
        this.modelDataBrokerService.formUpdatedWithModel(this.exercise);
    }
}
