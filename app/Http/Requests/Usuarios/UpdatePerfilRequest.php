<?php

namespace App\Http\Requests\Usuarios;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePerfilRequest extends FormRequest
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
            
            'nombre' => [
                'sometimes',
                'string',
                'max:255',
                'regex:/^[\pL\s\-]+$/u'
            ],
            'apellido' => [
                'sometimes',
                'string',
                'max:255',
                'regex:/^[\pL\s\-]+$/u'
            ],
            'edad' => [
                'sometimes',
                'integer'
            ],
            'telefono' => [
                'sometimes',
                'integer'
            ],
            'correo' => [
                'sometimes',
                'string',
                'email',
                'max:255',
                'unique:users,correo',
            ]
        ];
    }

    public function messages()
    {
        return [
            
            'nombre.string'         =>      'El nombre debe ser una cadena de texto',
            'nombre.max'            =>      'El nombre no puede exceder los 255 caracteres',
            
            'apellido.string'         =>      'El apellido debe ser una cadena de texto',
            'apellido.max'            =>      'El apellido no puede exceder los 255 caracteres',

            'edad.required'       =>      'La edad es obligatoria',
            'edad.integer'         =>      'La edad debe ser un numero',

            'telefono.required'       =>      'El telefono es obligatorio',
            'telefono.integer'         =>      'El telefono debe ser un integer',
            
            'correo.email'         =>      'El correo debe tener un formato valido',
            'correo.max'           =>      'El correo no puede exceder los 255 caracteres',
            'correo.unique'        =>      'El correo ya esta registrado en la BD',

        ];
    }
}
