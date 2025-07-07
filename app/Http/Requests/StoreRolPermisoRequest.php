<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRolPermisoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'estado' => ['nullable', 'boolean'],
            'fk_permiso' => ['required', 'exists:permisos,id_permiso'],
            'fk_rol' => ['required', 'exists:roles,id_rol'],
        ];
    }

    public function messages(): array
    {
        return [
            'estado.boolean' => 'El estado debe ser verdadero o falso',

            'fk_permiso.required' => 'El permiso es obligatorio',
            'fk_permiso.exists' => 'El permiso seleccionado no existe',

            'fk_rol.required' => 'El rol es obligatorio',
            'fk_rol.exists' => 'El rol seleccionado no existe',
        ];
    }
}
