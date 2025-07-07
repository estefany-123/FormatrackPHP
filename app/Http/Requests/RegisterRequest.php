<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
                'regex:/^[\pL\s\-]+$/u'
            ],
            'fk_rol' => ['required', 'exists:roles,id_rol'],

            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                'unique:users,email',
            ],
            'password' => [
                'required',
                'string',
                'min:6'
            ],
            'password_confirmation' => [
                'required',
                'same:password'
            ]
        ];
    }

    public function messages()
    {
        return [
            'name.required'       =>      'El nombre es obligatorio',
            'name.string'         =>      'El nombre debe ser una cadena de texto',
            'name.max'            =>      'El nombre no puede exceder los 50 caracteres',
            'name.unique'         =>      'El nombre ya existe en la base de datos',



            'fk_rol.required'       =>      'El rol es obligatorio',
            'fk_rol.in'             =>      'El rol debe ser "1" o "2" o "3"',

            'email.required'      =>      'El email es obligatorio',
            'email.email'         =>      'El email debe tener un formato valido',
            'email.max'           =>      'El email no puede exceder los 255 caracteres',
            'email.unique'        =>      'El email ya esta registrado en la BD',



            'password.required'    =>      'La contraseña es obligatorio',
            'password.min'         =>      'La contraseña debe tener minimo 6 caracteres',

            'password_confirmation.required'            =>      'Es necesario confirmar la contraseña',
            'password_confirmation.same'                =>      'La contraseñas no coinciden',

        ];
    }
}
