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
            'numero' => [
                'required',
                'string',
                'max:20',
                'unique:fichas,numero'
            ],
            'estado' => [
                'required',
                'boolean'
            ],
            'fk_programa' => [
                'required',
                'exists:programas,id_programa'
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'numero.required' => 'El número de ficha es obligatorio',
            'numero.string' => 'El número debe ser una cadena de texto',
            'numero.max' => 'El número no debe exceder los 20 caracteres',
            'numero.unique' => 'Este número de ficha ya existe en la base de datos',

            'estado.required' => 'El estado es obligatorio',
            'estado.boolean' => 'El estado debe ser verdadero o falso',

            'fk_programa.required' => 'El programa es obligatorio',
            'fk_programa.exists' => 'El programa seleccionado no existe',
        ];
    }
}
