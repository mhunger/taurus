import {TaurusFormData} from "../taurus/taurus-form-data";
export class ExerciseFormData implements TaurusFormData {
  formData = {
    name: '',
    variant: '',
    difficulty: '',
    exerciseGroup: '',
    workoutLocation: ''
  }
}
