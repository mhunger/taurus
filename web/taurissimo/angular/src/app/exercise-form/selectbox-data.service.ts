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
    getSelectBoxData(url: string, mapper: (entry: any) => Select2OptionData): Promise<Select2OptionData[]> {
        return this.http.get(url)
            .toPromise()
            .then(response => {
                let options: Select2OptionData[] = [];

                for(let entry of response.json()) {
                    options.push(mapper(entry));
                }

                return options;
            })
            .catch((error => console.log(error)));
    }
}