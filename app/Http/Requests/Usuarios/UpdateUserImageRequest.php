<?php

   namespace App\Http\Requests\Usuarios;

   use Illuminate\Foundation\Http\FormRequest;

   class UpdateUserImageRequest extends FormRequest
   {
       public function authorize(): bool
       {
           return true; 
       }

       public function rules(): array
       {
           return [
               'perfil' => ['sometimes','image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
           ];
       }


       public function messages()
    {
        return [

            'perfil.image'         =>      'El perfil debe ser una imagen',
            'perfil.max'            =>      'El perfil no puede exceder los 2048 caracteres',
        ];

        }
   }