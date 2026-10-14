<?php

namespace App\Services\Front;

use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\City;
use App\Models\Country;
use App\Models\State;

class BlogServices
{
    public function findLiveBySlug(string $slug): ?Blog
    {
        return Blog::live()
            ->with(['categories', 'author', 'country', 'state', 'city'])
            ->where('slug', $slug)
            ->first();
    }

    /**
     * Data for the public /blogs listing: live articles filtered by the query string, the
     * filter dropdown options (only locations/categories that actually have live articles)
     * and the sidebar widgets.
     */
    public function listingViewData(array $input, int $perPage = 12): array
    {
        $filters = [
            'country_id' => (int) ($input['country'] ?? 0) ?: null,
            'state_id' => (int) ($input['state'] ?? 0) ?: null,
            'city_id' => (int) ($input['city'] ?? 0) ?: null,
            'category' => is_string($input['category'] ?? null) ? $input['category'] : null,
            'q' => is_string($input['q'] ?? null) ? mb_substr(trim($input['q']), 0, 100) : null,
        ];
        // A state/city only applies inside its parent, mirroring the dependent dropdowns.
        if (!$filters['country_id']) {
            $filters['state_id'] = null;
        }
        if (!$filters['state_id']) {
            $filters['city_id'] = null;
        }

        $category = $filters['category'] ? BlogCategory::active()->where('slug', $filters['category'])->first() : null;

        $blogs = Blog::live()
            ->with(['categories:id,name,slug', 'author:id,name', 'country:id,name', 'state:id,name', 'city:id,name'])
            ->when($filters['country_id'], fn ($q, $id) => $q->where('country_id', $id))
            ->when($filters['state_id'], fn ($q, $id) => $q->where('state_id', $id))
            ->when($filters['city_id'], fn ($q, $id) => $q->where('city_id', $id))
            // An unknown or inactive category slug matches nothing rather than silently showing everything.
            ->when($filters['category'], fn ($q) => $q->whereHas('categories', fn ($c) => $c->where('blog_categories.id', $category ? $category->id : 0)))
            ->when($filters['q'], function ($q, $term) {
                $like = '%' . addcslashes($term, '%_\\') . '%';
                $q->where(fn ($w) => $w->where('title', 'like', $like)->orWhere('excerpt', 'like', $like));
            })
            ->orderByDesc('published_at')
            ->orderByDesc('id')
            ->paginate($perPage)
            ->withQueryString();

        $liveLocations = Blog::live();
        $countryIds = (clone $liveLocations)->whereNotNull('country_id')->distinct()->pluck('country_id');
        $stateIds = $filters['country_id'] ? (clone $liveLocations)->where('country_id', $filters['country_id'])->whereNotNull('state_id')->distinct()->pluck('state_id') : collect();
        $cityIds = $filters['state_id'] ? (clone $liveLocations)->where('state_id', $filters['state_id'])->whereNotNull('city_id')->distinct()->pluck('city_id') : collect();

        $topics = BlogCategory::active()
            ->withCount(['blogs' => fn ($q) => $q->live()])
            ->having('blogs_count', '>', 0)
            ->orderByDesc('blogs_count')
            ->orderBy('name')
            ->get(['id', 'name', 'slug']);

        return [
            'blogs' => $blogs,
            'filters' => $filters,
            'activeCategory' => $category,
            'isFiltered' => (bool) array_filter($filters),
            'filterCountries' => $countryIds->isEmpty() ? collect() : Country::whereIn('id', $countryIds)->orderBy('name')->get(['id', 'name']),
            'filterStates' => $stateIds->isEmpty() ? collect() : State::whereIn('id', $stateIds)->orderBy('name')->get(['id', 'name']),
            'filterCities' => $cityIds->isEmpty() ? collect() : City::whereIn('id', $cityIds)->orderBy('name')->get(['id', 'name']),
            'blogTopics' => $topics,
            'recentBlogs' => Blog::live()->orderByDesc('published_at')->limit(5)
                ->get(['id', 'title', 'slug', 'featured_image', 'featured_image_alt', 'published_at']),
        ];
    }

    /**
     * Data shared by the public article page and the admin preview, including the SEO
     * object consumed by front.layout.head (same shape as location SEO content).
     */
    public function articleViewData(Blog $blog, bool $isPreview = false): array
    {
        $recentBlogs = Blog::live()
            ->when($blog->id, fn ($q) => $q->where('id', '!=', $blog->id))
            ->orderByDesc('published_at')
            ->limit(4)
            ->get(['id', 'title', 'slug', 'featured_image', 'featured_image_alt', 'published_at']);

        $topics = BlogCategory::active()
            ->withCount(['blogs' => fn ($q) => $q->live()])
            ->having('blogs_count', '>', 0)
            ->orderByDesc('blogs_count')
            ->limit(8)
            ->get(['id', 'name', 'slug']);

        $publicUrl = $blog->slug ? route('blog.show', $blog->slug) : url('/blogs');

        $seo = (object) [
            'meta_title' => $blog->seo_title,
            'meta_description' => $blog->seo_description,
            'meta_keywords' => $blog->meta_keywords,
            'canonical_url' => $blog->canonical_url ?: $publicUrl,
            // Previews must never be indexed, whatever the article settings say.
            'robots_setting' => $isPreview ? 'noindex, nofollow' : $blog->robots,
            'image_alt_text' => $blog->featured_image_alt,
            'og_image' => $blog->featured_image,
        ];

        return [
            'locationSeoContent' => ['data' => $seo],
            'recentBlogs' => $recentBlogs,
            'blogTopics' => $topics,
            'isPreview' => $isPreview,
        ];
    }
}
