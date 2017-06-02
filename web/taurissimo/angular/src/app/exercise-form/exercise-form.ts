import {TaurusFormData} from "../taurus/taurus-form-data";
export class ExerciseFormData implements TaurusFormData {
  formData = {
    id: '',
    name: '',
    variant: '',
    difficulty: '',
    exerciseGroup: '',
    workoutLocation: ''
  }
}