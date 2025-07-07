<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreModuloRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nombre' => ['nullable', 'string', 'max:70'],
            'descripcion' => ['nullable', 'string', 'max:205'],
            'href' => ['nullable', 'string', 'max:205'],
            'icono' => ['required', 'string', 'max:205'],
            'estado' => ['nullable', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.string' => 'El nombre debe ser texto',
            'nombre.max' => 'El nombre no puede superar los 70 caracteres',

            'descripcion.string' => 'La descripción debe ser texto',
            'descripcion.max' => 'La descripción no puede superar los 205 caracteres',

            'href.string' => 'El href debe ser texto',
            'href.max' => 'El href no puede superar los 205 caracteres',

            'icono.required' => 'El icono es obligatorio',
            'icono.string' => 'El icono debe ser texto',
            'icono.max' => 'El icono no puede superar los 205 caracteres',

            'estado.boolean' => 'El estado debe ser verdadero o falso',
        ];
    }
}
