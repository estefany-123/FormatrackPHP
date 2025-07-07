<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMovimientoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'descripcion' => ['nullable', 'string', 'max:205'],
            'cantidad' => ['nullable', 'integer', 'min:1'],
            'hora_ingreso' => ['nullable', 'date_format:H:i'],
            'hora_salida' => ['nullable', 'date_format:H:i'],
            'aceptado' => ['nullable', 'boolean'],
            'en_proceso' => ['nullable', 'boolean'],
            'cancelado' => ['nullable', 'boolean'],
            'devolutivo' => ['nullable', 'boolean'],
            'no_devolutivo' => ['nullable', 'boolean'],
            'fecha_devolucion' => ['nullable', 'date'],
            'lugar_destino' => ['nullable', 'string', 'max:255'],

            'fk_inventario' => ['required', 'exists:inventarios,id_inventario'],
            'fk_sitio' => ['required', 'exists:sitios,id_sitio'],
            'fk_tipo_movimiento' => ['required', 'exists:tipo_movimientos,id_tipo_movimiento'],
            'fk_usuario' => ['required', 'exists:usuarios,id_usuario'],
        ];
    }

    public function messages(): array
    {
        return [
            'descripcion.string' => 'La descripción debe ser texto',
            'descripcion.max' => 'La descripción no puede exceder los 205 caracteres',

            'cantidad.integer' => 'La cantidad debe ser un número entero',
            'cantidad.min' => 'La cantidad debe ser al menos 1',

            'hora_ingreso.date_format' => 'La hora de ingreso debe tener formato HH:MM',
            'hora_salida.date_format' => 'La hora de salida debe tener formato HH:MM',

            'aceptado.boolean' => 'El campo aceptado debe ser verdadero o falso',
            'en_proceso.boolean' => 'El campo en proceso debe ser verdadero o falso',
            'cancelado.boolean' => 'El campo cancelado debe ser verdadero o falso',
            'devolutivo.boolean' => 'El campo devolutivo debe ser verdadero o falso',
            'no_devolutivo.boolean' => 'El campo no devolutivo debe ser verdadero o falso',

            'fecha_devolucion.date' => 'La fecha de devolución debe ser válida',

            'lugar_destino.string' => 'El lugar de destino debe ser texto',
            'lugar_destino.max' => 'El lugar de destino no puede exceder los 255 caracteres',

            'fk_inventario.required' => 'El inventario es obligatorio',
            'fk_inventario.exists' => 'El inventario no existe',

            'fk_sitio.required' => 'El sitio es obligatorio',
            'fk_sitio.exists' => 'El sitio no existe',

            'fk_tipo_movimiento.required' => 'El tipo de movimiento es obligatorio',
            'fk_tipo_movimiento.exists' => 'El tipo de movimiento no existe',

            'fk_usuario.required' => 'El usuario es obligatorio',
            'fk_usuario.exists' => 'El usuario no existe',
        ];
    }
}
