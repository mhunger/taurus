/**
 * Created by michaelhunger on 06/04/17.
 */
import {Injectable} from '@angular/core';
import {Exercise} from '../model/exercise';
import {Headers, Http} from "@angular/http";

import '../../../node_modules/rxjs/add/operator/toPromise';

@Injectable()
export class ExerciseService {
    private exerciseUrl = '/api/exercises';

    private headers = new Headers({'Content-Type': 'application/json'});

    constructor(private http: Http) {
    }

    getExercises(): Promise<Exercise[]> {

        return this.http.get(this.exerciseUrl)
            .toPromise()
            .then((response) => {
                console.log(response.json());
                return response.json() as Exercise[]
            })
            .catch(this.handleError)
    }

    getExercise(id: number): Promise<Exercise> {
        const url = `/api/exercise?id=${id}`;
        return this.http.get(url)
            .toPromise()
            .then(response => {
                console.log(response.json());
                return response.json().data as Exercise;
            })
            .catch(this.handleError);

    }

    saveExercise(exercise: any): Promise<string> {
        return this.http
            .put('/api/exercise', JSON.stringify({exercise: exercise}), {headers: this.headers})
            .toPromise()
            .then(res => res.statusText)
            .catch(this.handleError);
    }

    private handleError(error: any): Promise<any> {
        console.log('An error occurred when trying to receive exercises');
        return Promise.reject(error.message || error);
    }
}
