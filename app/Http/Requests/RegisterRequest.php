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
            'documento' => [
                'required',
                'integer'
            ],
            'nombre' => [
                'required',
                'string',
                'max:255',
                'regex:/^[\pL\s\-]+$/u'
            ],
            'apellido' => [
                'required',
                'string',
                'max:255',
                'regex:/^[\pL\s\-]+$/u'
            ],
            'edad' => [
                'required',
                'integer'
            ],
            'telefono' => [
                'required',
                'integer'
            ],
            'correo' => [
                'required',
                'string',
                'email',
                'max:255',
                'unique:users,correo',
            ],
             'estado' => [
                'required',
                'boolean'
            ],
            'cargo' => [
                'required',
                'string',
                'max:50',
                'regex:/^[\pL\s\-]+$/u'
            ],
            'password' => [
                'required',
                'string',
                'min:8'
            ],
            'password_confirmation' => [
                'required',
                'same:password'
            ],
            'perfil' => [
                'string',
                'max:255',
                'regex:/^[\pL\s\-]+$/u'
            ],
            'fk_rol' => ['required', 'exists:roles,id_rol'],
        ];
    }

    public function messages()
    {
        return [
            'documento.required'       =>      'El documento es obligatorio',
            'documento.integer'         =>      'El documento debe ser un numero',

            'nombre.required'       =>      'El nombre es obligatorio',
            'nombre.string'         =>      'El nombre debe ser una cadena de texto',
            'nombre.max'            =>      'El nombre no puede exceder los 255 caracteres',

            'apellido.required'       =>      'El apellido es obligatorio',
            'apellido.string'         =>      'El apellido debe ser una cadena de texto',
            'apellido.max'            =>      'El apellido no puede exceder los 255 caracteres',

            'edad.required'       =>      'La edad es obligatoria',
            'edad.integer'         =>      'La edad debe ser un numero',

            'telefono.required'       =>      'El telefono es obligatorio',
            'telefono.integer'         =>      'El telefono debe ser un integer',

            'correo.required'      =>      'El correo es obligatorio',
            'correo.email'         =>      'El correo debe tener un formato valido',
            'correo.max'           =>      'El correo no puede exceder los 255 caracteres',
            'correo.unique'        =>      'El correo ya esta registrado en la BD',

            'estado.required'       =>      'El estado es obligatorio',
            'estado.boolean'         =>      'El estado debe ser un boolean',

            'cargo.required'       =>      'El cargo es obligatorio',
            'cargo.string'         =>      'El cargo debe ser una cadena de texto',
            'cargo.max'            =>      'El cargo no puede exceder los 50 caracteres',

            'password.required'    =>      'La contraseña es obligatorio',
            'password.min'         =>      'La contraseña debe tener minimo 8 caracteres',

            'password_confirmation.required'            =>      'Es necesario confirmar la contraseña',
            'password_confirmation.same'                =>      'La contraseñas no coinciden',

            'perfil.string'         =>      'El perfil debe ser una cadena de texto',
            'perfil.max'            =>      'El perfil no puede exceder los 255 caracteres',

            'fk_rol.required'       =>      'El rol es obligatorio',
            'fk_rol.in'             =>      'El rol debe ser "1" o "2" o "3"',

        ];
    }
}
