<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCodigoInventarioRequest extends FormRequest
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
            'codigo' => 'required|string|max:255',
            'uso' => 'required|boolean',
            'baja' => 'required|boolean',
            'fk_inventario' => 'required|exists:inventarios,id_inventario',
        ];
    }

    /**
     * Mensajes personalizados.
     */
    public function messages(): array
    {
        return [
            'codigo.required' => 'El campo código es obligatorio.',
            'codigo.string' => 'El código debe ser un texto válido.',
            'codigo.max' => 'El código no debe exceder los 255 caracteres.',

            'uso.required' => 'El campo uso es obligatorio.',
            'uso.boolean' => 'El valor de uso debe ser verdadero o falso.',

            'baja.required' => 'El campo baja es obligatorio.',
            'baja.boolean' => 'El valor de baja debe ser verdadero o falso.',

            'fk_inventario.required' => 'El campo inventario es obligatorio.',
            'fk_inventario.exists' => 'El inventario seleccionado no existe en la base de datos.',
        ];
    }
}
