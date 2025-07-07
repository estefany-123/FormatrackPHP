<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSedeRequest extends FormRequest
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
                'unique:sedes,nombre'
            ],
            'estado' => [
                'required',
                'boolean'
            ],
            'fk_centro' => [
                'required',
                'exists:centros,id_centro'
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required' => 'El nombre de la sede es obligatorio',
            'nombre.string' => 'El nombre debe ser una cadena de texto',
            'nombre.max' => 'El nombre no puede exceder los 100 caracteres',
            'nombre.unique' => 'Esta sede ya existe en la base de datos',

            'estado.required' => 'El estado es obligatorio',
            'estado.boolean' => 'El estado debe ser verdadero o falso',

            'fk_centro.required' => 'El centro es obligatorio',
            'fk_centro.exists' => 'El centro seleccionado no existe',
        ];
    }
}
