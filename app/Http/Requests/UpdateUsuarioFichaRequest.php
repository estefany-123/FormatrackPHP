<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUsuarioFichaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'fk_ficha' => ['sometimes', 'exists:fichas,id_ficha'],
            'fk_usuario' => ['sometimes', 'exists:users,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'fk_ficha.exists' => 'La ficha seleccionada no existe',
            'fk_usuario.exists' => 'El usuario seleccionado no existe',
        ];
    }
}
