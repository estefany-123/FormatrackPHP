<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateInventarioRequest extends FormRequest
{
    /**
     * Autoriza la solicitud.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Reglas de validación.
     */
    public function rules(): array
    {
        return [
            'stock' => 'required|integer|min:0',
        ];
    }

    /**
     * Mensajes personalizados.
     */
    public function messages(): array
    {
        return [
            'stock.required' => 'El campo stock es obligatorio.',
            'stock.integer' => 'El stock debe ser un número entero.',
            'stock.min' => 'El stock no puede ser negativo.',
        ];
    }
}
