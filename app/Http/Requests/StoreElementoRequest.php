<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreElementoRequest extends FormRequest
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
                'required',
                'string',
                'max:50',
                'unique:elementos,nombre',
                'alpha_space'
            ],
            'descripcion' => [
                'required',
                'text',
                'max:1000',
                'min:5'
            ],'stock' => [
                'required',
                'integer',
                'min:0'
            ],

        ];
    }

    public function message(){
        return[
            'nombre.required'       =>      'El nombre es obligatorio',
            'nombre.string'         =>      'El nombre debe ser una cadena de texto',
            'nombre.max'            =>      'El nombre no puede exceder los 50 caracteres',
            'nombre.unique'          =>     'El nombre ya existe en la base de datos',



            'descripcion.required'       =>      'El descripcion es obligatorio',
            'descripcion.text'         =>      'El descripcion debe ser una cadena de texto',
            'descripcion.max'            =>      'El descripcion no puede exceder los 1000 caracteres',
            'descripcion.min'            =>      'El descripcion no puede tener menos de 5 caracteres',


            
            'stock.required'       =>      'El stock es obligatorio',
            'stock.integer'         =>      'El stock debe ser un entero',
            'stock.min'            =>      'El stock no debe ser un numero negativo',
            
        ];
    }
}
