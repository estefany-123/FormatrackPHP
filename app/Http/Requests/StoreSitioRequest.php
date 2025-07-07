<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSitioRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nombre' => ['nullable', 'string', 'max:70'],
            'persona_encargada' => ['nullable', 'string', 'max:70'],
            'ubicacion' => ['nullable', 'string', 'max:205'],
            'estado' => ['nullable', 'boolean'],
            'fk_area' => ['required', 'exists:areas,id_area'],
            'fk_tipo_sitio' => ['required', 'exists:tipo_sitios,id_tipo'],
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.string' => 'El nombre debe ser texto',
            'nombre.max' => 'El nombre no debe superar los 70 caracteres',

            'persona_encargada.string' => 'El nombre de la persona encargada debe ser texto',
            'persona_encargada.max' => 'No puede superar los 70 caracteres',

            'ubicacion.string' => 'La ubicación debe ser texto',
            'ubicacion.max' => 'La ubicación no debe superar los 205 caracteres',

            'estado.boolean' => 'El estado debe ser verdadero o falso',

            'fk_area.required' => 'El área es obligatoria',
            'fk_area.exists' => 'El área seleccionada no existe',

            'fk_tipo_sitio.required' => 'El tipo de sitio es obligatorio',
            'fk_tipo_sitio.exists' => 'El tipo de sitio seleccionado no existe',
        ];
    }
}
