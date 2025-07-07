<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProgramaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nombre' => [
                'required',
                'string',
                'max:100',
                'unique:programas,nombre'
            ],
            'estado' => [
                'required',
                'boolean'
            ],
            'fk_area' => [
                'required',
                'exists:areas,id_area'
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required' => 'El nombre del programa es obligatorio',
            'nombre.string' => 'El nombre debe ser una cadena de texto',
            'nombre.max' => 'El nombre no puede exceder los 100 caracteres',
            'nombre.unique' => 'Este programa ya existe en la base de datos',

            'estado.required' => 'El estado es obligatorio',
            'estado.boolean' => 'El estado debe ser verdadero o falso',

            'fk_area.required' => 'El área es obligatoria',
            'fk_area.exists' => 'El área seleccionada no existe',
        ];
    }
}
