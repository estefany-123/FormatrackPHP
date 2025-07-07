<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePermisoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'permiso' => ['nullable', 'string', 'max:100'],
            'fk_ruta' => ['required', 'exists:rutas,id_ruta'],
        ];
    }

    public function messages(): array
    {
        return [
            'permiso.string' => 'El permiso debe ser texto',
            'permiso.max' => 'El permiso no puede superar los 100 caracteres',

            'fk_ruta.required' => 'La ruta es obligatoria',
            'fk_ruta.exists' => 'La ruta seleccionada no existe',
        ];
    }
}
