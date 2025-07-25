<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAreaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nombre' => ['nullable', 'string', 'max:70'],
            'estado' => ['nullable', 'boolean'],
            'fk_sede' => ['required', 'exists:sedes,id_sede'],
            'fk_usuario' => ['nullable', 'exists:users,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.string' => 'El nombre debe ser texto',
            'nombre.max' => 'El nombre no debe superar los 70 caracteres',

            'estado.boolean' => 'El estado debe ser verdadero o falso',

            'fk_sede.required' => 'La sede es obligatoria',
            'fk_sede.exists' => 'La sede seleccionada no existe',

            'fk_usuario.exists' => 'El usuario seleccionado no existe',
        ];
    }
}
