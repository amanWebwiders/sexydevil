<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class BlogCategoryRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    /**
     * Normalise the slug (fall back to the name) before validating.
     */
    protected function prepareForValidation()
    {
        $this->merge(['slug' => Str::slug($this->input('slug') ?: $this->input('name'))]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', Rule::unique('blog_categories', 'slug')->ignore($this->route('blog_category'))],
            'description' => ['nullable', 'string'],
            'status' => ['required', 'in:0,1'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string'],
            'meta_keywords' => ['nullable', 'string'],
            'canonical_url' => ['nullable', 'url', 'max:500'],
            'robots_index' => ['required', 'in:index,noindex'],
            'robots_follow' => ['required', 'in:follow,nofollow'],
        ];
    }

    public function messages(): array
    {
        return [
            'slug.unique' => 'This slug is already used by another category.',
        ];
    }
}
