<?php

namespace App\Http\Requests\Rutas;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRutaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nombre' => ['string', 'max:205']
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.string' => 'El nombre debe ser texto',
            'nombre.max' => 'El nombre no puede superar los 205 caracteres',
        ];
    }
}
