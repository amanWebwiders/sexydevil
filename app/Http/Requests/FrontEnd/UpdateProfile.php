<?php

namespace App\Http\Requests\FrontEnd;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfile extends FormRequest
{
    public function rules()
    {
        $rules = [
            'name'  => 'required|string|min:3',
            'email' => 'required|email',
            'nickname' => 'required|string|min:3',
        ];

        if ($this->input('type') == 2) {
            $rules['description'] = 'required|string|min:200';
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'name.required' => 'The name field is required.',
            'nickname.required' => 'The nickname field is required.',
            'email.required' => 'The email field is required.',
        ];
    }
}
