<?php
namespace App\Http\Requests\Usuarios;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest{

    public function authorize(): bool{
        return true;
    }

    public function rules(): array
    {
        return [
            'nombre' => [
                'required',
                'string',
                'max:255',
                'regex:/^[\pL\s\-]+$/u'
            ],
            'apellido' => [
                'string',
                'max:255',
                'regex:/^[\pL\s\-]+$/u'
            ],
            'edad' => [
                'integer'
            ],
            'telefono' => [
                'integer'
            ],
            'correo' => [
                'string',
                'email',
                'max:255',
                'unique:users,correo',
            ],
            'cargo' => [
                'string',
                'max:50',
                'regex:/^[\pL\s\-]+$/u'
            ],
        ];

    }


    public function messages():array
    {
        return[
            'nombre.required'       =>      'El nombre es obligatorio',
            'nombre.string'         =>      'El nombre debe ser una cadena de texto',
            'nombre.max'            =>      'El nombre no puede exceder los 255 caracteres',

            'apellido.string'         =>      'El apellido debe ser una cadena de texto',
            'apellido.max'            =>      'El apellido no puede exceder los 255 caracteres',

            'edad.integer'         =>      'La edad debe ser un numero',

            'telefono.integer'         =>      'El telefono debe ser un integer',

            'correo.email'         =>      'El correo debe tener un formato valido',
            'correo.max'           =>      'El correo no puede exceder los 255 caracteres',
            'correo.unique'        =>      'El correo ya esta registrado en la BD',

            'cargo.string'         =>      'El cargo debe ser una cadena de texto',
            'cargo.max'            =>      'El cargo no puede exceder los 50 caracteres',
        ];
        
    }
}