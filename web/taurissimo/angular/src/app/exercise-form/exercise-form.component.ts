/**
 * Created by michaelhunger on 06/04/17.
 */
import {AfterViewInit, Component, ElementRef, Input, OnInit} from '@angular/core';
import {Exercise} from "../model/exercise";
import {Http} from "@angular/http";
import {SelectBoxDataService} from "./selectbox-data.service";
import {ExerciseService} from "../exercise/exercise.service";
import {ModelDataBrokerService} from "./model-data-broker.service";
import {ExerciseGroup} from "../model/exercise-group";
import {WorkoutLocation} from "../model/workout-location";
import {ExerciseBuilderService} from "../model/exercise-builder.service";

@Component({
    templateUrl: './exercise-form.component.html',
    selector: 'exercise-form'
})

export class ExerciseFormComponent implements OnInit{
    @Input() exercise: Exercise;

    private selectedExerciseGroup: number;
    private selectedWorkoutLocation: number;

    public exerciseGroups: Array<ExerciseGroup>;
    public workoutLocations: Array<WorkoutLocation>;

    @Input() public inlineForm: boolean = false;

    constructor(private http: Http,
                private optionService: SelectBoxDataService,
                private exerciseService: ExerciseService,
                private modelDataBrokerService: ModelDataBrokerService,
                private exerciseBuilder: ExerciseBuilderService
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

    ngOnInit(): void {
        if(this.inlineForm == false && !this.exercise) {
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
        this.selectedExerciseGroup = e;
        this.exercise.exerciseGroup = this.exerciseGroups.filter(v => v.id == e)[0];
        this.modelDataBrokerService.formUpdatedWithModel(this.exercise);

    }

    setLocation(e: any, o: any) {

        this.selectedWorkoutLocation = e;
        this.exercise.workoutLocation = this.workoutLocations.filter((v) => v.id == e)[0];
        this.modelDataBrokerService.formUpdatedWithModel(this.exercise);
    }
}
