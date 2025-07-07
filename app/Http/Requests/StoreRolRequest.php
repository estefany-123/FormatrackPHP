<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRolRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nombre' => ['required', 'string', 'max:100', 'unique:roles,nombre'],
            'estado' => ['nullable', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required' => 'El nombre del rol es obligatorio',
            'nombre.string' => 'El nombre debe ser texto',
            'nombre.max' => 'El nombre no puede superar los 100 caracteres',
            'nombre.unique' => 'Este rol ya existe',

            'estado.boolean' => 'El estado debe ser verdadero o falso',
        ];
    }
}
