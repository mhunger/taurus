import { Component } from '@angular/core';
import { Exercise } from '../model/exercise';
import { ExerciseService } from './exercise.service';
import {ModelDataBrokerService} from "../exercise-form/model-data-broker.service";

@Component({
  selector: 'my-exercises',
  templateUrl: './exercise.component.html',
  styleUrls: ['./exercise.component.css'],
  providers: []
})

export class ExerciseComponent {
  title = 'Exercises';
  exercises: Exercise[];
  selectedExercise: Exercise;

  constructor(private exerciseService: ExerciseService, private modelDataBroker: ModelDataBrokerService) {
    this.getExercises();
    modelDataBroker.modelDataSetPubSub$.subscribe(
        exercise => {
          this.exercises = this.exercises.map(
              (v, i) => {
                if(v.id == exercise.id) {
                  return exercise
                }
                return v;
              }
          )
          this.selectedExercise = exercise;
        }
    );
  }

  getExercises(): void {
    this.exerciseService.getExercises().then(
      exercises => this.exercises = exercises
    );
  }

  onSelectExercise(exercise: Exercise) {
    this.modelDataBroker.formModelSet(exercise);
    this.selectedExercise = exercise;
  }
}
