<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRolPermisoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'estado' => ['sometimes', 'required', 'boolean'],
            'fk_rol' => ['sometimes',  'exists:roles,id_rol'],
            'fk_permiso' => ['sometimes',  'exists:permisos,id_permiso'],
        ];
    }

    public function messages(): array
    {
        return [
            'estado.required' => 'El estado es obligatorio',
            'fk_rol.exists' => 'el rol seleccionada no existe',
            'fk_permiso.exists' => 'el permiso seleccionada no existe',
        ];
    }
}
