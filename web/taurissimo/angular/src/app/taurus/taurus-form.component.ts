import {Component} from "@angular/core";
import {FormBuilder, FormGroup} from "@angular/forms";
import {SelectBoxDataService} from "../exercise-form/selectbox-data.service";


export abstract class TaurusForm {
    protected formData: {};

    protected form: FormGroup;

    constructor(
        protected optionService: SelectBoxDataService,
        protected formBuilder: FormBuilder
    ) {
        this.getOptions();
        this.init();
        this.createForm();
    }

    createForm() {
        this.form = this.formBuilder.group(this.formData);
    }

    abstract init();

    abstract getOptions();
}