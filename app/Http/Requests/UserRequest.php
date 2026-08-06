<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
      public function rules()
    {
      
       $rules = [
            'name' => 'required|string|max:255',
            'phone_code' => 'required',
            'phone' => [
                'required',
                'string',
                'max:20',
                function ($attribute, $value, $fail) {
                    $countryCodeId = request()->input('phone_code');
                    
                    $exists = \DB::table('users')
                        ->where('phone', $value)
                        ->where('phone_code', $countryCodeId)
                        ->exists();
                        
                    if ($exists) {
                        $fail('The combination of phone and country code has already been taken.');
                    }
                }
            ],
            'phone_code' => 'required|exists:country_codes,id',
           'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
          
        ];
        
          if ($this->type == 2) {
           
        $rules['identity_photos'] = 'required|array|min:1|max:2';
        $rules['identity_photos.*'] = 'image|mimes:jpeg,png,jpg|max:2048';
    }
     return $rules;

    }

    public function messages()
    {
        return [
            'name.required' => 'The name field is required.',
            'email.required' => 'The email field is required.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'This email is already in use.',
            'password.required' => 'The password field is required.',
            'password.min' => 'The password must be at least 6 characters.',
            'occupation_id.exists' => 'Selected occupation does not exist.',
            'fee.numeric' => 'Fee must be a valid number.',
            'fee.min' => 'Fee cannot be negative.',
            'phone.required' => 'The phone number is required.',
            'country_code_id.required' => 'Please select a country code.',
            'country_code_id.exists' => 'Selected country code is invalid.',
        ];
    }
}
