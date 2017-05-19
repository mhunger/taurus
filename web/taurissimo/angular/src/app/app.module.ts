import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';
import { FormsModule } from '@angular/forms';
import { HttpModule } from '@angular/http';
import { RouterModule } from '@angular/router';

import { AppComponent } from './app.component';
import { ExerciseComponent } from './exercise/exercise.component';
import { ExerciseService } from "./exercise/exercise.service";
import { ExerciseFormComponent } from './exercise-form/exercise-form.component';
import { Select2Module } from 'ng2-select2';
import { SelectBoxDataService } from "./exercise-form/selectbox-data.service";
import {ModelDataBrokerService} from "./exercise-form/model-data-broker.service";

@NgModule({
  declarations: [
    AppComponent,
    ExerciseComponent,
    ExerciseFormComponent
  ],
  imports: [
    BrowserModule,
    FormsModule,
    HttpModule,
    Select2Module,
    RouterModule.forRoot([
      {
        path: 'exercises',
        component: ExerciseComponent
      },
      {
        path: 'exercise',
        component: ExerciseFormComponent
      },
      {
        path: '',
        redirectTo: '/exercise',
        pathMatch: 'full',
      }
    ])
  ],
  providers: [ExerciseService, SelectBoxDataService, ModelDataBrokerService],
  bootstrap: [AppComponent]
})

export class AppModule { }
