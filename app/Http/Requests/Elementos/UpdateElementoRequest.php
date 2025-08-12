<?php

namespace App\Http\Requests\Elementos;

use Illuminate\Foundation\Http\FormRequest;

class UpdateElementoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nombre' => ['sometimes', 'string', 'max:70'],
            'descripcion' => ['sometimes', 'string', 'max:205'],
            'imagen_elemento' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'fk_categoria' => ['sometimes', 'exists:categorias,id_categoria'],
            'fk_unidad_medida' => ['sometimes', 'exists:unidades_medida,id_unidad'],
            'fk_caracteristica' => ['nullable', 'exists:caracteristicas,id_caracteristica'],
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.string' => 'El nombre debe ser una cadena de texto.',
            'nombre.max' => 'El nombre no puede tener más de 70 caracteres.',

            'descripcion.string' => 'La descripción debe ser una cadena de texto.',
            'descripcion.max' => 'La descripción no puede tener más de 205 caracteres.',


            'imagen_elemento.string' => 'La imagen debe ser una cadena de texto.',
            'imagen_elemento.max' => 'La ruta de la imagen no puede tener más de 255 caracteres.',

            'fk_categoria.exists' => 'La categoría seleccionada no es válida.',
            'fk_unidad_medida.exists' => 'La unidad de medida seleccionada no es válida.',
            'fk_caracteristica.exists' => 'La característica seleccionada no es válida.',
        ];
    }
}
