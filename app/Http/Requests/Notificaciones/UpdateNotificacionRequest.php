<?php

namespace App\Http\Requests\Notificaciones;

use Illuminate\Foundation\Http\FormRequest;

class UpdateNotificacionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'titulo' => ['sometimes', 'string', 'max:205'],
            'mensaje' => ['sometimes', 'nullable', 'string', 'max:500'],
            'leido' => ['sometimes', 'boolean'],
            'requiere_accion' => ['sometimes', 'boolean'],
            'estado' => ['sometimes', 'nullable', 'string', 'max:50'],
            'data' => ['sometimes', 'nullable', 'json'],
            'fk_usuario' => ['sometimes', 'exists:users,id'],
        ];
    }
}
