<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUsuarioRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'documento' => ['nullable', 'integer', 'unique:users,documento'],
            'nombre' => ['nullable', 'string', 'max:70'],
            'apellido' => ['nullable', 'string', 'max:70'],
            'edad' => ['nullable', 'integer', 'min:0'],
            'telefono' => ['nullable', 'string', 'max:15'],
            'correo' => ['nullable', 'email', 'max:70'],
            'estado' => ['nullable', 'boolean'],
            'cargo' => ['nullable', 'string', 'max:70'],
            'password' => ['nullable', 'string', 'min:6'],
            'perfil' => ['nullable', 'string', 'max:255'],
            'fk_rol' => ['nullable', 'exists:roles,id_rol'],
        ];
    }

    public function messages(): array
    {
        return [
            'documento.integer' => 'El documento debe ser un número',
            'documento.unique' => 'Este documento ya está registrado',

            'nombre.string' => 'El nombre debe ser texto',
            'nombre.max' => 'El nombre no puede tener más de 70 caracteres',

            'apellido.string' => 'El apellido debe ser texto',
            'apellido.max' => 'El apellido no puede tener más de 70 caracteres',

            'edad.integer' => 'La edad debe ser un número entero',
            'edad.min' => 'La edad no puede ser negativa',

            'telefono.string' => 'El teléfono debe ser texto',
            'telefono.max' => 'El teléfono no puede superar los 15 caracteres',

            'correo.email' => 'Debe ser un correo electrónico válido',
            'correo.max' => 'El correo no puede superar los 70 caracteres',

            'estado.boolean' => 'El estado debe ser verdadero o falso',

            'cargo.string' => 'El cargo debe ser texto',
            'cargo.max' => 'El cargo no puede superar los 70 caracteres',

            'password.string' => 'La contraseña debe ser texto',
            'password.min' => 'La contraseña debe tener al menos 6 caracteres',

            'perfil.string' => 'El perfil debe ser texto',
            'perfil.max' => 'El perfil no puede superar los 255 caracteres',

            'fk_rol.exists' => 'El rol seleccionado no existe',
        ];
    }
}
