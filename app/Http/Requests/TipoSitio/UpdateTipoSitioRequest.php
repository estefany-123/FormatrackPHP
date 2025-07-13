<?php
namespace App\Http\Requests\TipoSitio;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTipoSitioRequest extends FormRequest {

    public function authorize(): bool{
        
        return true;
    }

    public function rules(): array {
        return [
            'nombre'  => ['required','string','max:70'],
            'estado'  =>['required','boolean']
        ];
    }

    public function message(): array{
        return[
            'nombre.required'  => 'El nombre es requerido',
            'nombre.string' => 'El nombre debe ser texto',
            'nombre.max' => 'No puede superar los 70 caracteres',

            'estado.required'  =>  'El estado es requerido',
            'estado.boolean'   =>  'El estado debe ser un boolean'
        ];
    }
}