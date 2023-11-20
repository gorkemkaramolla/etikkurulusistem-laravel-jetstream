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
     */
    public function rules(): array
    {
        return [
            'name' => 'required',
            'lastname' => 'required',
            'ogrenci_no' => 'required',
            'email' => 'required|email',
            'path_basvuru_form' => 'required|mimes:pdf|max:2048',     
            'path_gonullu_onam_form' => 'required|mimes:pdf|max:2048',     
            'path_olcek_izinleri_form' => 'required|mimes:pdf|max:2048',
            'path_anket_form' => 'required|mimes:pdf|max:2048',
        ];
    }
}
