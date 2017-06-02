import {Component, Input} from "@angular/core";
import {FormBuilder, FormGroup} from "@angular/forms";
import {SelectBoxDataService} from "../exercise-form/selectbox-data.service";
import {ModelDataBrokerService} from "../exercise-form/model-data-broker.service";
import {ResourceService} from "./resource.service";

export abstract class TaurusForm {
    protected formData: {};

    protected form: FormGroup;

    @Input() protected resource;

    @Input() public inlineForm: boolean = false;

    constructor(
        protected optionService: SelectBoxDataService,
        protected formBuilder: FormBuilder,
        protected modelDataBrokerService: ModelDataBrokerService,
        protected resourceService: ResourceService
    ) {
        this.getOptions();
        this.init();
        this.createForm();

        modelDataBrokerService.modelDataPubSub$.subscribe(
            resource => {
                this.resource = resource;
            }
        );
    }

    createForm() {
        this.form = this.formBuilder.group(this.formData);
    }

    abstract init();

    abstract getOptions();

    saveResource() {
        this.mapFormModelToResource();
        this.modelDataBrokerService.formUpdatedWithModel(this.resource);
        this.resourceService.saveResource(this.resource);
    }

    abstract mapFormModelToResource();

    ngOnInit(): void {
        if (this.inlineForm == false && !this.resource) {
            this.resource = this.buildResource();
        }
    }

    abstract buildResource();
}