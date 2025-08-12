<?php

namespace App\Http\Requests\Movimientos;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMovimientoRequest extends FormRequest
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
            'fecha_devolucion' => ['nullable', 'date'],
            'lugar_destino' => ['nullable', 'string', 'max:255'],

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

            'fecha_devolucion.date' => 'La fecha de devolución debe ser válida',

            'lugar_destino.string' => 'El lugar de destino debe ser texto',
            'lugar_destino.max' => 'El lugar de destino no puede exceder los 255 caracteres',
        ];
    }
}
