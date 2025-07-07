<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategoriaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nombre' => ['nullable', 'string', 'max:70'],
            'codigo_unpsc' => ['nullable', 'string'],
            'estado' => ['nullable', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.string' => 'El nombre debe ser una cadena de texto',
            'nombre.max' => 'El nombre no debe superar los 70 caracteres',

            'codigo_unpsc.string' => 'El código UNSPSC debe ser texto',

            'estado.boolean' => 'El estado debe ser verdadero o falso',
        ];
    }
}
