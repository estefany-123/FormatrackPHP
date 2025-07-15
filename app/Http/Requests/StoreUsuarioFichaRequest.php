<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUsuarioFichaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'fk_ficha' => ['required', 'exists:fichas,id_ficha'],
            'fk_usuario' => ['required', 'exists:users,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'fk_ficha.required' => 'La ficha es obligatoria',
            'fk_ficha.exists' => 'La ficha seleccionada no existe',

            'fk_usuario.required' => 'El usuario es obligatorio',
            'fk_usuario.exists' => 'El usuario seleccionado no existe',
        ];
    }
}
