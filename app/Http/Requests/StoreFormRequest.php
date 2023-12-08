<?php

namespace App\Http\Requests;

use App\Rules\MaxFileSize;
use Illuminate\Foundation\Http\FormRequest;

class StoreFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */   public function messages(): array
    {
        return [
            'gsm.unique' => 'Girilen telefon numarasıyla daha önce başvuru yapılmıştır.',
            'email.unique' => 'Girilen e-posta adresiyle daha önce başvuru yapılmıştır.',
            'student_no.unique' => 'Girilen öğrenci numarasıyla daha önce başvuru yapılmıştır.',
        ];
    }
    public function rules(): array
    {
        return [
            //forms 
            "document_number"=>"required|string|max:50",
            // Validation for the "application_informations" table
            'application_semester' => 'required|in:güz,bahar',
            'temel_alan_bilgisi' => 'required|string|max:50',
            'academic_year' => 'required|integer',
            'application_type' => 'required|string|max:50',
            'work_qualification' => 'required|string|max:50',
            'research_type' => 'required|string|max:50',
            'institution_permission' => 'required|string|max:100',
            'research_start_date' => 'required|date',
            'research_end_date' => 'required|date',
            
            // Validation for the "research_informations" table
            'research_title' => 'required|string|max:100',
            'research_subject_purpose' => 'required|string|max:255',
            'research_unique_value' => 'required|string|max:255',
            'research_hypothesis' => 'required|string|max:255',
            'research_method' => 'required|string|max:255',
            'research_universe' => 'required|string|max:255',
            'research_forms' => 'required|string|max:255',
            'research_data_collection' => 'required|string|max:255',
            'research_restrictions' => 'required|string|max:255',
            'research_place_date' => 'required|string|max:255',
            'research_literature_review' => 'required|string|max:255',

            // Validation for the "researcher_informations" table
            'name' => 'required|string|max:32',
            'lastname' => 'required|string|max:32',
            'advisor' => 'required|string|max:32',
            'gsm' => 'required|string|max:10|unique:researcher_informations,gsm',
            'email' => 'required|email|unique:researcher_informations,email',
            'major' => 'required|string|max:100',
            'department' => 'required|string|max:100',
            'student_no' => 'required|string|max:11|unique:researcher_informations,student_no',
        ];
    }

}
