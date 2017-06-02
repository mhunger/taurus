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
import { ExerciseFormData  } from './exercise-form';
import {TaurusForm} from "../taurus/taurus-form.component";

@Component({
    templateUrl: './exercise-form.component.html',
    selector: 'exercise-form'
})

export class ExerciseFormComponent extends TaurusForm implements OnInit, OnChanges {
    @Input() exercise: Exercise;

    public exerciseGroups: Array<ExerciseGroup>;
    public workoutLocations: Array<WorkoutLocation>;

    @Input() public inlineForm: boolean = false;

    constructor(protected optionService: SelectBoxDataService,
                private modelDataBrokerService: ModelDataBrokerService,
                private exerciseBuilder: ExerciseBuilderService,
                protected formBuilder: FormBuilder,
                private exerciseService: ExerciseService) {
        super(optionService, formBuilder);

        modelDataBrokerService.modelDataPubSub$.subscribe(
            exercise => {
                this.exercise = exercise;
            }
        );
    }

    init() {
        this.formData = new ExerciseFormData().formData;
    }

    ngOnChanges(): void {
        this.form.reset();
        this.form.setValue({
            id: this.exercise.id,
            name: this.exercise.name,
            difficulty: this.exercise.difficulty,
            variant: this.exercise.variantName,
            exerciseGroup: this.exercise.exerciseGroup.id,
            workoutLocation: this.exercise.workoutLocation.id
        });
    }

    ngOnInit(): void {
        if (this.inlineForm == false && !this.exercise) {
            this.exercise = this.exerciseBuilder.build();
        }
    }

    getOptions(): void {
        console.log(this);
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
        this.exercise.difficulty = this.form.value.difficulty;
        this.exercise.variantName = this.form.value.variant;
        this.exercise.name = this.form.value.name;
        this.exercise.id = this.form.value.id;
        this.exercise.exerciseGroup = this.exerciseGroups.filter(v => v.id == this.form.value.exerciseGroup)[0];
        this.exercise.workoutLocation = this.workoutLocations.filter((v) => v.id == this.form.value.workoutLocation)[0];

        this.modelDataBrokerService.formUpdatedWithModel(this.exercise);
        this.exerciseService.saveExercise(this.exercise);
    }
}
