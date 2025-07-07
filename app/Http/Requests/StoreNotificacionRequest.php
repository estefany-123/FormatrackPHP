<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreNotificacionRequest extends FormRequest
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
            'fk_usuario' => ['required', 'exists:users,id_usuario'],
        ];
    }

    public function messages(): array
    {
        return [
            'titulo.required' => 'El título es obligatorio',
            'titulo.string' => 'El título debe ser texto',
            'titulo.max' => 'El título no puede superar los 205 caracteres',

            'mensaje.string' => 'El mensaje debe ser texto',
            'mensaje.max' => 'El mensaje no puede superar los 500 caracteres',

            'leido.boolean' => 'Debe ser verdadero o falso',
            'requiere_accion.boolean' => 'Debe ser verdadero o falso',

            'estado.string' => 'El estado debe ser texto',
            'estado.max' => 'El estado no puede superar los 50 caracteres',

            'data.json' => 'El campo data debe estar en formato JSON',

            'fk_usuario.required' => 'Debe asociarse un usuario',
            'fk_usuario.exists' => 'El usuario seleccionado no existe',
        ];
    }
}
