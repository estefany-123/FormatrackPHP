<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTipoMovimientoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nombre' => ['required', 'string', 'max:100', 'unique:tipo_movimientos,nombre'],
            'estado' => ['nullable', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required' => 'El nombre es obligatorio',
            'nombre.string' => 'El nombre debe ser una cadena de texto',
            'nombre.max' => 'El nombre no debe superar los 100 caracteres',
            'nombre.unique' => 'Ya existe un tipo de movimiento con este nombre',

            'estado.boolean' => 'El estado debe ser verdadero o falso',
        ];
    }
}
