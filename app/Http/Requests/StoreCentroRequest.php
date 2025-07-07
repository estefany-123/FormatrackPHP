<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCentroRequest extends FormRequest
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
                'unique:centros,nombre'
            ],
            'estado' => [
                'required',
                'boolean'
            ],
            'fk_municipio' => [
                'required',
                'exists:municipios,id_municipio'
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required' => 'El nombre del centro es obligatorio',
            'nombre.string' => 'El nombre debe ser una cadena de texto',
            'nombre.max' => 'El nombre no puede exceder los 100 caracteres',
            'nombre.unique' => 'Este centro ya existe en la base de datos',

            'estado.required' => 'El estado es obligatorio',
            'estado.boolean' => 'El estado debe ser verdadero o falso',

            'fk_municipio.required' => 'El municipio es obligatorio',
            'fk_municipio.exists' => 'El municipio seleccionado no existe',
        ];
    }
}
