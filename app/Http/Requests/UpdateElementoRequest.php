<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateElementoRequest extends FormRequest
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
                'max:50',
                Rule::unique('elementos', 'nombre')->ignore($this->route('elemento')->id),
                'alpha_space',
            ],

            'descripcion' => [
                'sometimes',
                'string',
                'min:5',
                'max:1000',
            ],

            'stock' => [
                'sometimes',
                'integer',
                'min:0',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            // nombre
            'nombre.sometimes'    => 'El nombre es obligatorio.',
            'nombre.string'       => 'El nombre debe ser una cadena de texto.',
            'nombre.max'          => 'El nombre no puede superar los 50 caracteres.',
            'nombre.unique'       => 'Ya existe un elemento con este nombre.',
            'nombre.alpha_space'  => 'El nombre solo puede contener letras, números y espacios.',

            // descripcion
            'descripcion.sometimes' => 'La descripción es obligatoria.',
            'descripcion.string'    => 'La descripción debe ser una cadena de texto.',
            'descripcion.min'       => 'La descripción debe tener al menos 5 caracteres.',
            'descripcion.max'       => 'La descripción no puede superar los 1000 caracteres.',

            // stock
            'stock.sometimes' => 'El campo stock es obligatorio.',
            'stock.integer'   => 'El stock debe ser un número entero.',
            'stock.min'       => 'El stock no puede ser menor que 0.',
        ];
    }
}
