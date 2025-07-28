<?php

namespace App\Http\Requests\Usuarios;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
                'integer',
            ],
            'password' => [
                'required',
                'string',
                'min:8'
            ]
        ];
    }

    public function messages()
    {
        return [
            'documento.required'      =>      'El documento es obligatorio',
            'documento.max'           =>      'El documento no puede exceder los 10 caracteres',
            'password.required'    =>     'La contraseña es obligatorio',
            'password.min'         =>     'La contraseña debe tener minimo 6 caracteres',
        ];
    }
}
