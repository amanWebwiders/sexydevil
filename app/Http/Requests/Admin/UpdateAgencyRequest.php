<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\Agency;


class UpdateAgencyRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        // dd($this->all());
        return [
            'name'     => 'required|string|max:255',
            'email'    => [
                'nullable',
                'email',
                Rule::unique('agencies', 'email')->ignore($this->agency),
            ],
            'phone'    => 'nullable|string|max:20',
            'telegram' => 'nullable|url',
            'facebook' => 'nullable|url',
            'instagram'=> 'nullable|url',
            'linkedin' => 'nullable|url',

            'photo'    => 'nullable|image|max:2048',
            'media.*'  => 'nullable|mimetypes:image/*,video/*|max:51200',

            // Team validation
            'team'     => 'nullable|array',
            'team.*.name'        => 'nullable|string|max:255',
            'team.*.age'         => 'nullable|integer|min:1|max:120',
            'team.*.gender'      => 'nullable|in:male,female,other',
            'team.*.description' => 'nullable|string',
            'team.*.photo'       => 'nullable|image|max:2048',
        ];
    }

    public function withValidator($validator)
{
    $validator->after(function ($validator) {
        $agencyId = $this->route('agency'); // this is just the ID
        $agency = Agency::find($agencyId);  // now it’s a model

        $existingTeams = $agency && $agency->teams()->count() > 0;

        $submittedTeams = collect($this->input('team', []))
            ->filter(fn($t) => !empty($t['name']));

        if (!$existingTeams && $submittedTeams->isEmpty()) {
            $validator->errors()->add('team', 'At least one team member is required.');
        }
    });
}
}
