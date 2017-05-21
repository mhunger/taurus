import {Select2OptionData} from "ng2-select2";
import {Http} from "@angular/http";
import {Injectable} from "@angular/core";
/**
 * Created by michaelhunger on 15/05/17.
 */

@Injectable()
export class SelectBoxDataService {
    constructor(private http: Http) { }
    /**
     *
     * @param url
     * @param mapper
     */
    getSelectBoxData(url: string): Promise<any> {
        return this.http.get(url)
            .toPromise()
            .then(response => {
                let options: any[] = [];

                for(let entry of response.json()) {
                    options.push(entry);
                }

                return options;
            })
            .catch((error => console.log(error)));
    }
}