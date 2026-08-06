<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AgencyRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name'   => 'required|string|max:255',
            'headline' => 'required|string|max:255',
            'short_desc' => 'required|string',
            'long_desc'  => 'nullable|string',
            'email'    => 'required|email|unique:agencies,email',
            'phone'  => 'nullable|string|max:20',
            'telegram' => 'nullable|url',
            'facebook' => 'nullable|url',
            'instagram' => 'nullable|url',
            'linkedin' => 'nullable|url',
            'address' => 'nullable|string',
            'website' => 'nullable|url',
            'photo'  => 'nullable|image|max:2048',
            'media.*' => 'nullable|mimetypes:image/*,video/*|max:51200',

            // Team validation
            'team' => 'required|array|min:1',
            'team.*.name' => 'required|string|max:255',
            'team.*.age'  => 'nullable|integer|min:1|max:120',
            'team.*.gender' => 'nullable|in:male,female,other',
            'team.*.description' => 'nullable|string',
            'team.*.photo' => 'nullable|image|max:2048',
        ];
    }

    public function messages()
    {
        return [
            // Team messages
            'team.required' => 'At least one team member is required.',
            'team.min'      => 'At least one team member is required.',
            'team.*.name.required' => 'Each team member must have a name.',

            // Other custom messages (optional, can override default)
            'name.required'     => 'Agency name is required.',
            'headline.required' => 'Headline is required.',
            'short_desc.required' => 'Short description is required.',
            'email.required'    => 'Email is required.',
            'email.email'       => 'Please enter a valid email address.',
            'email.unique'      => 'This email is already registered.',
        ];
    }
}
