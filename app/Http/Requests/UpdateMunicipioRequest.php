<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMunicipioRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nombre' => ['required', 'string', 'max:70'],
            'departamento' => ['nullable', 'string', 'max:100'],
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required' => 'El nombre es obligatorio',
            'nombre.string' => 'El nombre debe ser texto',
            'nombre.max' => 'No puede superar los 70 caracteres',

            'departamento.string' => 'El departamento debe ser texto',
            'departamento.max' => 'No puede superar los 100 caracteres',
        ];
    }
}
