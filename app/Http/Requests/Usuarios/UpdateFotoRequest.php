<?php

namespace App\Http\Requests\Usuarios;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFotoRequest extends FormRequest
{

     public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'perfil' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];

    }
    
}