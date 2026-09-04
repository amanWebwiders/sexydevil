<?php
namespace App\Http\Requests\FrontEnd;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Set to true to allow all users to send messages
    }

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
            'phone_code' => 'required|exists:country_codes,code',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
          
        ];
        
        if ($this->type == 2) {                
            $rules['dob'] = 'required';
            $rules['country_id'] = 'required';
            $rules['document_image'] = 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:20480';
            $rules['holding_document_image'] = 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:20480';
            $rules['media'] = 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:20480';
            $rules['identity_photos'] = 'required|array|min:1|max:2';
            $rules['identity_photos.*'] = 'image|mimes:jpeg,png,jpg,webp,gif|max:20480';
        }
        return $rules;

    }

    public function messages()
    {
        return [
            'name.required' => 'The name field is required.',
            'email.required' => 'The email field is required.',
            'email.email' => 'Please enter a valid email address.',
            'dob.required' => 'Please select your Date of Birth.',
            'country_id.required' => 'Please select your country.',
            'identity_photos.required' => 'Please upload at least 1 verification photo of yourself.',
            'identity_photos.*.image' => 'The uploaded file must be an image.',
            'identity_photos.*.mimes' => 'Photos must be in JPEG, JPG, PNG, or WEBP format.',
            'identity_photos.*.max' => 'Each image must not exceed 20MB in size.',
            'document_image.max' => 'The identification document photo must not exceed 20MB.',
            'holding_document_image.max' => 'The photo holding document must not exceed 20MB.',
            'media.max' => 'The photo holding paper must not exceed 20MB.',
        ];
    }
}
