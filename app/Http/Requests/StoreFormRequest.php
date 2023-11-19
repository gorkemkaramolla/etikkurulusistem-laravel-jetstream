<?php

namespace App\Http\Requests;

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
     */
    public function rules(): array
    {
        return [
        'name' => 'required|string|max:255',
        'tc_kimlik_no' => 'required|string|max:255',
        'calisma_basligi' => 'required|string|max:255',
        'calisma_programi' => 'required|string|max:255',
        'path_gonullu_onam_form' => 'required|string|max:255',
        'path_anket_form' => 'required|string|max:255',
        'path_olcek_izinleri_form' => 'required|string|max:255',
        ];
    }
}
