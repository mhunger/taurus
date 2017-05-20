/**
 * Created by michaelhunger on 19/05/17.
 */

import {Subject} from "rxjs/Subject";

export class ModelDataBrokerService {

    private modelDataPubSub = new Subject<any>();
    private modelDataSetPubSub = new Subject<any>();

    public modelDataPubSub$ = this.modelDataPubSub.asObservable();
    public modelDataSetPubSub$ = this.modelDataSetPubSub.asObservable();

    formUpdatedWithModel(model: any) {
        this.modelDataSetPubSub.next(model);
    }

    formModelSet(model: any) {
        this.modelDataPubSub.next(model);
    }
}
