<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfile extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'required', 'min:3',
            'email' => 'required', 'email',
            'file_image' => 'nullable|image' 
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'The name field is required.',
            'email.required' => 'The email field is required.',
            'file_image.image' => 'The file must be an image.',
        ];
    }
}
