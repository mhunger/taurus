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
import {ExerciseBuilderService} from '../model/exercise-builder.service';
import {ExerciseGroup} from "../model/exercise-group";
import {WorkoutLocation} from "../model/workout-location";

@Component({
    templateUrl: './exercise-form.component.html',
    selector: 'exercise-form'
})

export class ExerciseFormComponent {
    exercise: Exercise;

    private selectedExerciseGroup: number;
    private selectedWorkoutLocation: number;

    public exerciseGroups: Array<ExerciseGroup>;
    public workoutLocations: Array<WorkoutLocation>;

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
        this.optionService.getSelectBoxData('/api/workoutlocations')
            .then(
                workoutLocations => this.workoutLocations = workoutLocations
            );

        this.optionService.getSelectBoxData('/api/exercisegroups')
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
        this.exercise.exerciseGroup = this.exerciseGroups.filter(v => v.id == e)[0];
        this.modelDataBrokerService.formUpdatedWithModel(this.exercise);

    }

    setLocation(e: any, o: any) {

        this.selectedWorkoutLocation = e;
        this.exercise.workoutLocation = this.workoutLocations.filter((v) => v.id == e)[0];
        this.modelDataBrokerService.formUpdatedWithModel(this.exercise);
    }
}
