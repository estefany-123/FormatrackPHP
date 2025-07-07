<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCodigoInventarioRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'codigo' => ['required', 'string'],
            'uso' => ['nullable', 'boolean'],
            'baja' => ['nullable', 'boolean'],
            'fk_inventario' => ['required', 'exists:inventarios,id_inventario'],
        ];
    }

    public function messages(): array
    {
        return [
            'codigo.required' => 'El código es obligatorio',
            'codigo.string' => 'El código debe ser una cadena de texto',

            'uso.boolean' => 'El campo uso debe ser verdadero o falso',
            'baja.boolean' => 'El campo baja debe ser verdadero o falso',

            'fk_inventario.required' => 'El inventario es obligatorio',
            'fk_inventario.exists' => 'El inventario seleccionado no existe',
        ];
    }
}
