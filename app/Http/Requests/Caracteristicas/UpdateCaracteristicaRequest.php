<?php

namespace App\Http\Requests\Caracteristicas;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCaracteristicaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nombre' => ['string', 'max:70']
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.string' => 'El nombre debe ser una cadena de texto',
            'nombre.max' => 'El nombre no debe superar los 70 caracteres'
        ];
    }
}
