<?php

namespace App\Http\Requests\Municipios;

use Illuminate\Foundation\Http\FormRequest;

class StoreMunicipioRequest extends FormRequest
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
                'unique:municipios,nombre'
            ],
            'departamento' => [
                'required',
                'string',
                'max:100'
            ],
            'estado' => [
                'required',
                'boolean'
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required' => 'El nombre del municipio es obligatorio',
            'nombre.string' => 'El nombre debe ser una cadena de texto',
            'nombre.max' => 'El nombre no puede exceder los 100 caracteres',
            'nombre.unique' => 'Este municipio ya existe en la base de datos',

            'departamento.required' => 'El departamento es obligatorio',
            'departamento.string' => 'El departamento debe ser una cadena de texto',
            'departamento.max' => 'El departamento no puede exceder los 100 caracteres',

            'estado.required' => 'El estado es obligatorio',
            'estado.boolean' => 'El estado debe ser verdadero o falso',
        ];
    }
}
