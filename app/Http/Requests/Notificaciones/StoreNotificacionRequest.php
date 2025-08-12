<?php

namespace App\Http\Requests\Notificaciones;

use Illuminate\Foundation\Http\FormRequest;

class CreateNotificacionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'titulo' => ['required', 'string', 'max:205'],
            'mensaje' => ['nullable', 'string', 'max:500'],
            'leido' => ['nullable', 'boolean'],
            'requiere_accion' => ['nullable', 'boolean'],
            'estado' => ['nullable', 'string', 'max:50'],
            'data' => ['nullable', 'json'],
            'fk_usuario' => ['required', 'exists:users,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'titulo.required' => 'El título es obligatorio',
            'titulo.max' => 'El título no puede exceder los 205 caracteres',
            'mensaje.max' => 'El mensaje no puede exceder los 500 caracteres',
            'leido.boolean' => 'El campo leído debe ser verdadero o falso',
            'requiere_accion.boolean' => 'El campo requiere acción debe ser verdadero o falso',
            'estado.max' => 'El estado no puede exceder los 50 caracteres',
            'data.json' => 'El campo data debe ser un JSON válido',
            'fk_usuario.required' => 'El usuario es obligatorio',
            'fk_usuario.exists' => 'El usuario no existe',
        ];
    }
}
