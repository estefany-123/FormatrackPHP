<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFichaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'codigo_ficha' => [
                'required',
                'string',
                'max:20',
                'unique:fichas,codigo_ficha'
            ],
            'estado' => [
                'required',
                'boolean'
            ],
            'fk_programa' => [
                'required',
                'exists:programa_formacion,id_programa'
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'codigo_ficha.required' => 'El codigo_ficha de ficha es obligatorio',
            'codigo_ficha.string' => 'El codigo_ficha debe ser una cadena de texto',
            'codigo_ficha.max' => 'El codigo_ficha no debe exceder los 20 caracteres',
            'codigo_ficha.unique' => 'Este codigo_ficha de ficha ya existe en la base de datos',

            'estado.required' => 'El estado es obligatorio',
            'estado.boolean' => 'El estado debe ser verdadero o falso',

            'fk_programa.required' => 'El programa es obligatorio',
            'fk_programa.exists' => 'El programa seleccionado no existe',
        ];
    }
}
