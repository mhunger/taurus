import {Component, ElementRef} from '@angular/core';
import { Exercise } from '../model/exercise';
import { ExerciseService } from './exercise.service';
import {ModelDataBrokerService} from "../exercise-form/model-data-broker.service";
import {NgbActiveModal, NgbModal} from "@ng-bootstrap/ng-bootstrap";
import {ExerciseFormComponent} from "../exercise-form/exercise-form.component";

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

  constructor(private exerciseService: ExerciseService, private modelDataBroker: ModelDataBrokerService,
  private modalService: NgbModal, private activeModal: NgbActiveModal) {
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

  onSelectExercise(exercise: Exercise, formContent: ElementRef) {
    this.modelDataBroker.formModelSet(exercise);
    this.selectedExercise = exercise;
    this.modalService.open(formContent).result.then((result) => {
        console.log('Closed to...');
    }, (reason) => {
        console.log('Clicked close button')
    });
  }
}
