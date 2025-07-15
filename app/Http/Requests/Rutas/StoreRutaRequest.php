<?php

namespace App\Http\Requests\Rutas;

use Illuminate\Foundation\Http\FormRequest;

class StoreRutaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nombre' => ['string', 'max:205'],
            'href' => ['required', 'string', 'max:205'],
            'icono' => ['required', 'string', 'max:205'],
            'listed' => ['required', 'boolean'],
            'estado' => [ 'boolean'],
            'fk_modulo' => ['required', 'exists:modulos,id_modulo'],
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.string' => 'El nombre debe ser texto',
            'nombre.max' => 'El nombre no puede superar los 205 caracteres',

            'href.required' => 'El href es obligatorio',
            'href.string' => 'El href debe ser texto',
            'href.max' => 'El href no puede superar los 205 caracteres',

            'icono.required' => 'El icono es obligatorio',
            'icono.string' => 'El icono debe ser texto',
            'icono.max' => 'El icono no puede superar los 205 caracteres',

            'listed.required' => 'El campo listed es obligatorio',
            'listed.boolean' => 'El campo listed debe ser verdadero o falso',

            'estado.boolean' => 'El estado debe ser verdadero o falso',

            'fk_modulo.required' => 'El módulo es obligatorio',
            'fk_modulo.exists' => 'El módulo seleccionado no existe',
        ];
    }
}
