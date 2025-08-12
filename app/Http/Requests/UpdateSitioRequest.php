<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSitioRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nombre' => ['required', 'string', 'max:70'],
            'persona_encargada' => ['required', 'string', 'max:70'],
            'ubicacion' => ['required', 'string', 'max:70'],
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required' => 'El nombre es obligatorio',
            'nombre.string' => 'El nombre debe ser texto',
            'nombre.max' => 'No puede superar los 70 caracteres',

            'persona_encargada.required' => 'El persona_encargada es obligatorio',
            'persona_encargada.string' => 'El persona_encargada debe ser texto',
            'persona_encargada.max' => 'No puede superar los 70 caracteres',

            'ubicacion.required' => 'El ubicacion es obligatorio',
            'ubicacion.string' => 'El ubicacion debe ser texto',
            'ubicacion.max' => 'No puede superar los 70 caracteres',
        ];
    }
}
