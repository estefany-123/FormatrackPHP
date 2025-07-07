<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
            ],
            'password' => [
                'required',
                'string',
                'min:5'

            ]
        ];
    }

    public function messages()
    {
        return [
            'email.required'      =>      'El email es obligatorio',
            'email.email'         =>      'El email no puede tener menos de 5 caracteres',
            'email.max'           =>      'El email no puede exceder los 255 caracteres',
            'password.required'    =>     'La contraseña es obligatorio',
            'password.min'         =>     'La contraseña debe tener minimo 6 caracteres',
        ];
    }
}
