<?php

namespace App\Services\Front;

use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\City;
use App\Models\Country;
use App\Models\State;
use Illuminate\Support\Str;

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
     * Resolve the slug segments of a listing URL (/blogs/category/{category}/{country}/{state}/{city})
     * to models. Returns null when any given segment is unknown, so the page can 404.
     *
     * @return array{category:?BlogCategory, country:?Country, state:?State, city:?City}|null
     */
    public function resolveListingPath(?string $category, ?string $country, ?string $state, ?string $city): ?array
    {
        $resolved = ['category' => null, 'country' => null, 'state' => null, 'city' => null];

        if ($category !== null && !($resolved['category'] = BlogCategory::active()->where('slug', $category)->first())) {
            return null;
        }
        if ($country !== null && !($resolved['country'] = $this->matchSlug(Country::query(), $country))) {
            return null;
        }
        if ($state !== null && !($resolved['state'] = $this->matchSlug(State::where('country_id', $resolved['country']->id), $state))) {
            return null;
        }
        if ($city !== null && !($resolved['city'] = $this->matchSlug(City::where('state_id', $resolved['state']->id), $city))) {
            return null;
        }

        return $resolved;
    }

    /**
     * Pretty URL of a listing, e.g. /blogs/category/guides/colombia/antioquia/medellin?q=tips
     */
    public function listingUrl(?BlogCategory $category = null, ?Country $country = null, ?State $state = null, ?City $city = null, array $query = []): string
    {
        $segments = $category ? ['category', $category->slug] : [];
        foreach ([$country, $state, $city] as $place) {
            // A state/city is only meaningful below its parent.
            if (!$place) {
                break;
            }
            $segments[] = Str::slug($place->name);
        }

        $query = array_filter($query, fn ($value) => $value !== null && $value !== '');

        return rtrim(route('blogs') . '/' . implode('/', $segments), '/') . ($query ? '?' . http_build_query($query) : '');
    }

    /**
     * Pretty URL for a query-string listing (the filter form, or old ?country=12 links), or null when
     * there is nothing to convert. Values may be slugs or numeric ids; unknown ones are dropped.
     */
    public function legacyListingUrl(array $query): ?string
    {
        if (!array_intersect_key($query, array_flip(['category', 'country', 'state', 'city']))) {
            return null;
        }

        $find = function ($builder, $value) {
            if (!is_string($value) || $value === '') {
                return null;
            }

            return ctype_digit($value) ? $builder->find((int) $value) : $this->matchSlug($builder, $value);
        };

        $category = is_string($query['category'] ?? null) && $query['category'] !== ''
            ? BlogCategory::active()->where('slug', $query['category'])->first()
            : null;
        $country = $find(Country::query(), $query['country'] ?? null);
        $state = $country ? $find(State::where('country_id', $country->id), $query['state'] ?? null) : null;
        $city = $state ? $find(City::where('state_id', $state->id), $query['city'] ?? null) : null;

        return $this->listingUrl($category, $country, $state, $city, ['q' => is_string($query['q'] ?? null) ? trim($query['q']) : null]);
    }

    /**
     * Data for the public /blogs listing: live articles for the resolved category/location and
     * keyword, the filter dropdown options and the sidebar widgets.
     */
    public function listingViewData(array $current, ?string $keyword, int $perPage = 12): array
    {
        $keyword = is_string($keyword) ? mb_substr(trim($keyword), 0, 100) : '';

        $blogs = Blog::live()
            ->with(['categories:id,name,slug', 'author:id,name', 'country:id,name', 'state:id,name', 'city:id,name'])
            ->when($current['category'], fn ($q, $category) => $q->whereHas('categories', fn ($c) => $c->where('blog_categories.id', $category->id)))
            ->when($current['country'], fn ($q, $country) => $q->where('country_id', $country->id))
            ->when($current['state'], fn ($q, $state) => $q->where('state_id', $state->id))
            ->when($current['city'], fn ($q, $city) => $q->where('city_id', $city->id))
            ->when($keyword !== '', function ($q) use ($keyword) {
                $like = '%' . addcslashes($keyword, '%_\\') . '%';
                $q->where(fn ($w) => $w->where('title', 'like', $like)->orWhere('excerpt', 'like', $like));
            })
            ->orderByDesc('published_at')
            ->orderByDesc('id')
            ->paginate($perPage)
            ->withQueryString();

        $topics = BlogCategory::active()
            ->withCount(['blogs' => fn ($q) => $q->live()])
            ->having('blogs_count', '>', 0)
            ->orderByDesc('blogs_count')
            ->orderBy('name')
            ->get(['id', 'name', 'slug']);

        return [
            'blogs' => $blogs,
            'current' => $current,
            'keyword' => $keyword,
            'locationLabel' => collect([$current['city'], $current['state'], $current['country']])->filter()->pluck('name')->implode(', '),
            'isFiltered' => (bool) array_filter($current) || $keyword !== '',
            // Only locations that have live articles (in the selected category), each with its article count.
            'filterCountries' => $this->locationOptions(Country::class, 'country_id', [], $current['category'], $current['country']),
            'filterStates' => $current['country']
                ? $this->locationOptions(State::class, 'state_id', ['country_id' => $current['country']->id], $current['category'], $current['state'])
                : collect(),
            'filterCities' => $current['state']
                ? $this->locationOptions(City::class, 'city_id', ['state_id' => $current['state']->id], $current['category'], $current['city'])
                : collect(),
            'blogTopics' => $topics,
            'recentBlogs' => Blog::live()->orderByDesc('published_at')->limit(5)
                ->get(['id', 'title', 'slug', 'featured_image', 'featured_image_alt', 'published_at']),
        ];
    }

    /**
     * Listing URL for the location an article is tagged with, or null when it has none.
     */
    public function articleLocationUrl(Blog $blog): ?string
    {
        return $blog->country ? $this->listingUrl(null, $blog->country, $blog->state, $blog->state ? $blog->city : null) : null;
    }

    /**
     * Indexable listing pages for the sitemap: every category and location (country, state, city)
     * that has at least one live, indexable article.
     *
     * @return array<int, array{loc:string, lastmod:string}>
     */
    public function sitemapListingUrls(): array
    {
        $urls = [];
        $add = function (string $loc, $lastmod) use (&$urls) {
            if (!isset($urls[$loc]) || $urls[$loc]->lt($lastmod)) {
                $urls[$loc] = $lastmod;
            }
        };

        $blogs = Blog::live()->where('robots_index', 'index')
            ->with(['categories' => fn ($q) => $q->active(), 'country:id,name', 'state:id,name', 'city:id,name'])
            ->get(['id', 'country_id', 'state_id', 'city_id', 'updated_at']);

        foreach ($blogs as $blog) {
            foreach ($blog->categories as $category) {
                $add($this->listingUrl($category), $blog->updated_at);
            }
            if ($blog->country) {
                $add($this->listingUrl(null, $blog->country), $blog->updated_at);
                if ($blog->state) {
                    $add($this->listingUrl(null, $blog->country, $blog->state), $blog->updated_at);
                    if ($blog->city) {
                        $add($this->listingUrl(null, $blog->country, $blog->state, $blog->city), $blog->updated_at);
                    }
                }
            }
        }

        return collect($urls)->map(fn ($lastmod, $loc) => ['loc' => $loc, 'lastmod' => $lastmod->format('Y-m-d')])->values()->all();
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
            // Footer text managed under Location SEO Content (title "Blog"), shown below every blog page.
            'content' => app(UserServices::class)->getLocationSeoContent(null, 'Blog')['data']->content ?? '',
        ];

        return [
            'locationSeoContent' => ['data' => $seo],
            'recentBlogs' => $recentBlogs,
            'blogTopics' => $topics,
            'isPreview' => $isPreview,
        ];
    }

    /**
     * Filter dropdown options for one location level: the places with at least one live article
     * (optionally in a category and below a parent location), sorted by name, each with a blogs_count.
     * The currently selected place is always kept so the dropdown still shows the active filter.
     */
    private function locationOptions(string $model, string $column, array $parent, ?BlogCategory $category, $selected)
    {
        $counts = Blog::live()
            ->when($category, fn ($q) => $q->whereHas('categories', fn ($c) => $c->where('blog_categories.id', $category->id)))
            ->where($parent)
            ->whereNotNull($column)
            ->selectRaw("{$column} as place_id, count(*) as aggregate")
            ->groupBy($column)
            ->pluck('aggregate', 'place_id');

        $ids = $counts->keys()->when($selected, fn ($ids) => $ids->push($selected->id))->unique();

        return $model::whereIn('id', $ids)
            ->orderBy('name')
            ->get(['id', 'name'])
            ->each(fn ($place) => $place->blogs_count = (int) ($counts[$place->id] ?? 0));
    }

    /**
     * First record in the query whose name slugifies to the given slug (location tables have no slug column).
     */
    private function matchSlug($query, string $slug)
    {
        return $query->get(['id', 'name'])->first(fn ($place) => Str::slug($place->name) === $slug);
    }
}
