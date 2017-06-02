/**
 * Created by michaelhunger on 06/04/17.
 */
import {Component, Input, OnInit, OnChanges} from '@angular/core';
import {Exercise} from "../model/exercise";
import {SelectBoxDataService} from "./selectbox-data.service";
import {ModelDataBrokerService} from "./model-data-broker.service";
import {ExerciseGroup} from "../model/exercise-group";
import {WorkoutLocation} from "../model/workout-location";
import { ExerciseBuilderService} from "../model/exercise-builder.service";
import { FormGroup, FormBuilder } from "@angular/forms";
import {ExerciseService} from "../exercise/exercise.service";

@Component({
    templateUrl: './exercise-form.component.html',
    selector: 'exercise-form'
})

export class ExerciseFormComponent implements OnInit, OnChanges {
    @Input() exercise: Exercise;
    exerciseForm: FormGroup;

    private selectedExerciseGroup: number;
    private selectedWorkoutLocation: number;

    public exerciseGroups: Array<ExerciseGroup>;
    public workoutLocations: Array<WorkoutLocation>;

    @Input() public inlineForm: boolean = false;

    constructor(private optionService: SelectBoxDataService,
                private modelDataBrokerService: ModelDataBrokerService,
                private exerciseBuilder: ExerciseBuilderService,
                private formBuilder: FormBuilder,
                private exerciseService: ExerciseService) {
        this.getOptions();
        this.createForm();
        modelDataBrokerService.modelDataPubSub$.subscribe(
            exercise => {
                this.exercise = exercise;
                this.selectedExerciseGroup = exercise.exerciseGroup.id;
                this.selectedWorkoutLocation = exercise.workoutLocation.id
            }
        );
    }


    ngOnChanges(): void {
        this.exerciseForm.reset();
        this.exerciseForm.setValue({
            id: this.exercise.id,
            name: this.exercise.name,
            difficulty: this.exercise.difficulty,
            variant: this.exercise.variantName,
            exerciseGroup: this.exercise.exerciseGroup.id,
            workoutLocation: this.exercise.workoutLocation.id
        });
    }

    createForm() {
        this.exerciseForm = this.formBuilder.group({
            id: '',
            name: '',
            difficulty: '',
            variant: '',
            exerciseGroup: '',
            workoutLocation: ''
        });
    }

    ngOnInit(): void {
        if (this.inlineForm == false && !this.exercise) {
            this.exercise = this.exerciseBuilder.build();
        }
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

    saveExercise() {
        this.exercise.difficulty = this.exerciseForm.value.difficulty;
        this.exercise.variantName = this.exerciseForm.value.variant;
        this.exercise.name = this.exerciseForm.value.name;
        this.exercise.id = this.exerciseForm.value.id;
        this.exercise.exerciseGroup = this.exerciseGroups.filter(v => v.id == this.exerciseForm.value.exerciseGroup)[0];
        this.exercise.workoutLocation = this.workoutLocations.filter((v) => v.id == this.exerciseForm.value.workoutLocation)[0];

        this.modelDataBrokerService.formUpdatedWithModel(this.exercise);
        this.exerciseService.saveExercise(this.exercise);
    }
}
