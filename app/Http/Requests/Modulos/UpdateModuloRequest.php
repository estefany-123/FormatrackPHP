<?php

namespace App\Http\Requests\Modulos;

use Illuminate\Foundation\Http\FormRequest;

class UpdateModuloRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nombre' => [ 'string', 'max:70'],
            'descripcion' => ['nullable', 'string', 'max:205']
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.string' => 'El nombre debe ser texto',
            'nombre.max' => 'El nombre no puede superar los 70 caracteres',

            'descripcion.string' => 'La descripción debe ser texto',
            'descripcion.max' => 'La descripción no puede superar los 205 caracteres',

        ];
    }
}
