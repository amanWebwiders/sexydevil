<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PlanRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        $rules = [
            'title' => ['nullable', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'cost' => ['required', 'numeric', 'min:0'],
            'days' => ['required', 'integer'],
           
        ];

        if ($this->isMethod('post')) {
            $rules['title'][] = 'unique:plans'; 
        } elseif ($this->isMethod('put') || $this->isMethod('patch')) {
            $planId = $this->route('id'); // Adjust this based on how you pass the ID

            $rules['title'][] = Rule::unique('plans')->ignore($planId); // Ensure title is unique except for the current record
        }

        return $rules;
    }
}
