/**
 * Created by michaelhunger on 06/04/17.
 */
import {Component, Input, OnInit, OnChanges} from '@angular/core';
import {SelectBoxDataService} from "./selectbox-data.service";
import {ModelDataBrokerService} from "./model-data-broker.service";
import {ExerciseGroup} from "../model/exercise-group";
import {WorkoutLocation} from "../model/workout-location";
import { ExerciseBuilderService} from "../model/exercise-builder.service";
import {ExerciseService} from "../exercise/exercise.service";
import { ExerciseFormData  } from './exercise-form';
import {TaurusForm} from "../taurus/taurus-form.component";
import {ResourceService} from "../taurus/resource.service";
import {FormBuilder} from "@angular/forms";

@Component({
    templateUrl: './exercise-form.component.html',
    selector: 'exercise-form'
})

export class ExerciseFormComponent extends TaurusForm implements OnInit, OnChanges {
    public exerciseGroups: Array<ExerciseGroup>;
    public workoutLocations: Array<WorkoutLocation>;

    constructor(protected optionService: SelectBoxDataService,
                protected modelDataBrokerService: ModelDataBrokerService,
                private exerciseBuilder: ExerciseBuilderService,
                protected formBuilder: FormBuilder,
                protected resourceService: ResourceService) {
        super(optionService, formBuilder, modelDataBrokerService, resourceService);
    }

    init() {
        this.formData = new ExerciseFormData().formData;
    }

    ngOnChanges(): void {
        this.form.reset();
        this.form.setValue({
            name: this.resource.name,
            difficulty: this.resource.difficulty,
            variant: this.resource.variantName,
            exerciseGroup: this.resource.exerciseGroup.id,
            workoutLocation: this.resource.workoutLocation.id
        });
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

    mapFormModelToResource() {
        this.resource.difficulty = this.form.value.difficulty;
        this.resource.variantName = this.form.value.variant;
        this.resource.name = this.form.value.name;
        this.resource.id = this.form.value.id;
        this.resource.exerciseGroup = this.exerciseGroups.filter(v => v.id == this.form.value.exerciseGroup)[0];
        this.resource.workoutLocation = this.workoutLocations.filter((v) => v.id == this.form.value.workoutLocation)[0];
    }


    buildResource() {
        this.resource = this.exerciseBuilder.build();
    }
}
