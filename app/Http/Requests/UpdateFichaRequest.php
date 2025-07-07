<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFichaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'codigo_ficha' => ['required', 'integer'],
        ];
    }

    public function messages(): array
    {
        return [
            'codigo_ficha.required' => 'El código de ficha es obligatorio',
            'codigo_ficha.integer' => 'El código de ficha debe ser un número entero',
        ];
    }
}
