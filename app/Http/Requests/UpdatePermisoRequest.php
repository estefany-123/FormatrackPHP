<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePermisoRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'permiso' => ['sometimes', 'string', 'max:70'],
        ];
    }

    public function messages(): array
    {
        return [
            'permiso.required' => 'El permiso es obligatorio',
            'permiso.string' => 'El permiso debe ser texto',
            'permiso.max' => 'No puede superar los 70 caracteres',
        ];
    }
}
