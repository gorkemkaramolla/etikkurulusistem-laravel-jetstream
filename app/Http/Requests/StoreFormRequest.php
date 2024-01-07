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
        return [];
    }
    public function rules(): array
    {
        return [
            //forms
            'onam_path' => 'required|file|mimes:pdf|max:4096', // Adjust the mime type and max file size as needed
            'kurum_izinleri_path' => 'nullable|file|mimes:pdf|max:4096',

            'anket_path' => 'required|file|mimes:pdf|max:4096',
            // Validation for the "application_informations" table
            'application_semester' => 'required|in:güz,bahar',
            'temel_alan_bilgisi' => 'required|string',
            'academic_year' => 'required|integer',
            'application_type' => 'required|string',
            'work_qualification' => 'required|string',
            'research_type' => 'required|string',
            'institution_permission' => 'required|string',
            'research_start_date' => 'required|date',
            'research_end_date' => 'required|date',

            // Validation for the "research_informations" table
            'research_title' => 'required|string',
            'research_subject_purpose' => 'required|string',
            'research_unique_value' => 'required|string',
            'research_hypothesis' => 'required|string',
            'research_method' => 'required|string',
            'research_universe' => 'required|string',
            'research_forms' => 'required|string',
            'research_data_collection' => 'required|string',
            'research_restrictions' => 'required|string',
            'research_place_date' => 'required|string',
            'research_literature_review' => 'required|string',

            // Validation for the "researcher_informations" table
            'name' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'advisor' => 'required|string|max:255',
            'gsm' => 'required|string|max:10',
            'student_no' => 'required|string|max:11',

            'email' => 'required|email',

            'ana_bilim_dali' => 'required|string|max:255',
            'program' => 'required|string|max:255',



        ];
    }
}
