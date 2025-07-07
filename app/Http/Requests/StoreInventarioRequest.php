<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreInventarioRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'stock' => ['required', 'integer', 'min:0'],
            'estado' => ['required', 'boolean'],
            'fk_elemento' => ['required', 'exists:elementos,id_elemento'],
            'fk_sitio' => ['required', 'exists:sitios,id_sitio'],
        ];
    }

    public function messages(): array
    {
        return [
            'stock.required' => 'El stock es obligatorio',
            'stock.integer' => 'El stock debe ser un número entero',
            'stock.min' => 'El stock no puede ser negativo',

            'estado.required' => 'El estado es obligatorio',
            'estado.boolean' => 'El estado debe ser verdadero o falso',

            'fk_elemento.required' => 'El elemento es obligatorio',
            'fk_elemento.exists' => 'El elemento seleccionado no existe',

            'fk_sitio.required' => 'El sitio es obligatorio',
            'fk_sitio.exists' => 'El sitio seleccionado no existe',
        ];
    }
}
