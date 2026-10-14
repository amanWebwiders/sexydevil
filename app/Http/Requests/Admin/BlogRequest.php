<?php

namespace App\Http\Requests\Admin;

use App\Models\Blog;
use App\Models\City;
use App\Models\State;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class BlogRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    /**
     * Normalise the slug and blank optional values before validating.
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'slug' => Str::slug($this->input('slug') ?: $this->input('title')),
            'categories' => array_values(array_filter((array) $this->input('categories', []))),
            'slug_auto' => $this->boolean('slug_auto'),
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        // The unsaved-preview endpoint has no route parameter and sends the article id instead.
        $blogId = $this->route('blog_post') ?: $this->input('id');
        $publishing = in_array($this->input('status'), [Blog::STATUS_PUBLISHED, Blog::STATUS_SCHEDULED], true);
        $mediaPath = function (string $folder) {
            return function ($attribute, $value, $fail) use ($folder) {
                if (!preg_match('#^uploads/blogs/' . $folder . '/[A-Za-z0-9_\-]+\.[a-z0-9]{2,5}$#', $value) || !is_file(public_path($value))) {
                    $fail('The selected file is not a valid uploaded blog media file.');
                }
            };
        };

        return [
            'title' => ['required', 'string', 'max:255'],
            // Auto-generated slugs are made unique by the service, typed slugs must be unique already.
            'slug' => array_merge(['required', 'string', 'max:255'], $this->boolean('slug_auto') ? [] : [Rule::unique('blogs', 'slug')->ignore($blogId)]),
            'slug_auto' => ['boolean'],
            'excerpt' => ['nullable', 'string', 'max:1000'],
            'content' => [$publishing ? 'required' : 'nullable', 'string', 'max:4000000'],
            'status' => ['required', Rule::in(array_keys(Blog::STATUSES))],
            'published_at' => array_merge(['nullable', 'date'], $this->input('status') === Blog::STATUS_SCHEDULED ? ['required', 'after:now'] : []),
            'author_id' => ['nullable', 'integer', 'exists:admin,id'],

            'categories' => ['array'],
            'categories.*' => ['integer', 'exists:blog_categories,id'],

            'featured_media_type' => ['required', 'in:image,video'],
            'featured_image' => ['nullable', 'string', $mediaPath('images')],
            'featured_image_alt' => ['nullable', 'string', 'max:255'],
            'featured_video' => ['nullable', 'string', $mediaPath('videos')],
            'featured_video_url' => ['nullable', 'url', 'max:500', function ($attribute, $value, $fail) {
                if (!Blog::videoEmbedUrl($value)) {
                    $fail('Only YouTube, Vimeo and Dailymotion video links are supported.');
                }
            }],

            'country_id' => ['nullable', 'integer', 'exists:countries,id'],
            'state_id' => ['nullable', 'integer', function ($attribute, $value, $fail) {
                if (!State::where('id', $value)->where('country_id', $this->input('country_id'))->exists()) {
                    $fail('The selected state does not belong to the selected country.');
                }
            }],
            'city_id' => ['nullable', 'integer', function ($attribute, $value, $fail) {
                if (!City::where('id', $value)->where('state_id', $this->input('state_id'))->exists()) {
                    $fail('The selected city does not belong to the selected state.');
                }
            }],

            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:500'],
            'meta_keywords' => ['nullable', 'string', 'max:1000'],
            'canonical_url' => ['nullable', 'url', 'max:500', 'regex:#^https?://#i'],
            'robots_index' => ['required', 'in:index,noindex'],
            'robots_follow' => ['required', 'in:follow,nofollow'],
        ];
    }

    public function messages(): array
    {
        return [
            'slug.unique' => 'This URL slug is already used by another article.',
            'content.required' => 'Write some content before publishing the article.',
            'published_at.after' => 'Pick a future date and time to schedule the article.',
            'canonical_url.regex' => 'The canonical URL must start with http:// or https://.',
        ];
    }

    public function attributes(): array
    {
        return [
            'published_at' => 'publish date',
            'featured_video_url' => 'video URL',
            'country_id' => 'country',
            'state_id' => 'state',
            'city_id' => 'city',
        ];
    }
}
