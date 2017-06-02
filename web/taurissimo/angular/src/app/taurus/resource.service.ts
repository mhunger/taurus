import {Headers, Http} from "@angular/http";
import {Injectable} from "@angular/core";

@Injectable()
export class ResourceService {
    private headers = new Headers({'Content-Type': 'application/json'});

    constructor(private http: Http) {
    }

    /**
     * Save a resource using Taurus Rest api. This method will update the original model from the form
     * and then pass this on
     * @param resource
     */
    saveResource(resource: any) {
        if(resource.id) {
            return this.http
                .put('/api/exercise', JSON.stringify({exercise: this.prepareResource(resource)}), {headers: this.headers})
                .toPromise()
                .then(res => res.statusText)
                .catch(this.handleError);
        } else {
            return this.http
                .post('/api/exercise', JSON.stringify({exercise: this.prepareResource(resource)}), {headers: this.headers})
                .toPromise()
                .then(res => res.statusText)
                .catch(this.handleError);
        }
    }

    /**
     * Prepare a resource using a Taurus Rest API. This method will basically
     * decide whether the resource should be fit for put or post
     *
     * @param resource
     */
    prepareResource(resource: any) {
        const resourceToSave = {
            name: resource.name,
            difficulty: resource.difficulty,
            variantName: resource.variantName,
            exerciseGroup: resource.exerciseGroup.id,
            workoutLocation: resource.workoutLocation.id
        };

        if(resource.id) {
            resourceToSave['id'] = resource.id;
        }

        return resourceToSave;
    }

    private handleError(error: any): Promise<any> {
        console.log('An error occurred when trying to receive exercises');
        return Promise.reject(error.message || error);
    }
}
