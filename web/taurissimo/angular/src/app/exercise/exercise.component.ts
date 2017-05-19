import { Component } from '@angular/core';
import { Exercise } from '../model/exercise';
import { ExerciseService } from './exercise.service';

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

  constructor(private exerciseService: ExerciseService) {
    this.getExercises();
  }

  getExercises(): void {
    this.exerciseService.getExercises().then(
      exercises => this.exercises = exercises
    );
  }

  onSelectExercise(exercise: Exercise) {
    this.selectedExercise = exercise;
  }
}
