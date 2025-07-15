<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreElementoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nombre' => [
                'required',
                'string',
                'max:50',
                'unique:elementos,nombre',
            ],
            'descripcion' => [
                'required',
                'string',
                'max:1000',
                'min:5'
            ],
            'perecedero' => ['required', 'boolean'],
            'no_perecedero' => ['required', 'boolean'],
            'estado' => ['required', 'boolean'],
            'baja' => ['required', 'boolean'],
            'imagen_elemento' => ['nullable', 'string'],
            'fk_categoria' => ['required', 'integer', 'exists:categorias,id_categoria'],
            'fk_unidad_medida' => ['required', 'integer', 'exists:unidades_medida,id_unidad'],
            'fk_caracteristica' => ['required', 'integer', 'exists:caracteristicas,id_caracteristica'],
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required' => 'El nombre es obligatorio',
            'nombre.string' => 'El nombre debe ser una cadena de texto',
            'nombre.max' => 'El nombre no puede exceder los 50 caracteres',
            'nombre.unique' => 'El nombre ya existe en la base de datos',

            'descripcion.required' => 'La descripción es obligatoria',
            'descripcion.string' => 'La descripción debe ser una cadena de texto',
            'descripcion.max' => 'La descripción no puede exceder los 1000 caracteres',
            'descripcion.min' => 'La descripción no puede tener menos de 5 caracteres',

            'perecedero.required' => 'El campo perecedero es obligatorio',
            'perecedero.boolean' => 'El campo perecedero debe ser verdadero o falso',

            'no_perecedero.required' => 'El campo no perecedero es obligatorio',
            'no_perecedero.boolean' => 'El campo no perecedero debe ser verdadero o falso',

            'estado.required' => 'El campo estado es obligatorio',
            'estado.boolean' => 'El campo estado debe ser verdadero o falso',

            'baja.required' => 'El campo baja es obligatorio',
            'baja.boolean' => 'El campo baja debe ser verdadero o falso',

            'imagen_elemento.string' => 'La imagen debe ser una cadena de texto',

            'fk_categoria.required' => 'La categoría es obligatoria',
            'fk_categoria.integer' => 'La categoría debe ser un número entero',
            'fk_categoria.exists' => 'La categoría seleccionada no existe',

            'fk_unidad_medida.required' => 'La unidad de medida es obligatoria',
            'fk_unidad_medida.integer' => 'La unidad de medida debe ser un número entero',
            'fk_unidad_medida.exists' => 'La unidad de medida seleccionada no existe',

            'fk_caracteristica.required' => 'La característica es obligatoria',
            'fk_caracteristica.integer' => 'La característica debe ser un número entero',
            'fk_caracteristica.exists' => 'La característica seleccionada no existe',
        ];
    }
}
