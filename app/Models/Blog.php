<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Blog extends Model
{
    use HasFactory;

    const STATUS_DRAFT = 'draft';
    const STATUS_PUBLISHED = 'published';
    const STATUS_SCHEDULED = 'scheduled';
    const STATUS_ARCHIVED = 'archived';

    const STATUSES = [
        self::STATUS_DRAFT => 'Draft',
        self::STATUS_PUBLISHED => 'Published',
        self::STATUS_SCHEDULED => 'Scheduled',
        self::STATUS_ARCHIVED => 'Archived',
    ];

    protected $table = 'blogs';

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'featured_image',
        'featured_image_alt',
        'featured_video',
        'featured_video_url',
        'featured_media_type',
        'author_id',
        'status',
        'published_at',
        'country_id',
        'state_id',
        'city_id',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'canonical_url',
        'robots_index',
        'robots_follow',
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    public function categories()
    {
        return $this->belongsToMany(BlogCategory::class, 'blog_blog_category');
    }

    public function author()
    {
        return $this->belongsTo(Admin::class, 'author_id');
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    /**
     * Publicly visible articles: published, or scheduled whose time has come.
     */
    public function scopeLive(Builder $query): Builder
    {
        return $query->whereIn('status', [self::STATUS_PUBLISHED, self::STATUS_SCHEDULED])
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }

    /**
     * Filter by the status an admin sees (scheduled posts past their time count as published).
     */
    public function scopeEffectiveStatus(Builder $query, string $status): Builder
    {
        switch ($status) {
            case self::STATUS_PUBLISHED:
                return $query->live();
            case self::STATUS_SCHEDULED:
                return $query->where('status', self::STATUS_SCHEDULED)->where('published_at', '>', now());
            default:
                return $query->where('status', $status);
        }
    }

    public function isLive(): bool
    {
        return in_array($this->status, [self::STATUS_PUBLISHED, self::STATUS_SCHEDULED], true)
            && $this->published_at
            && $this->published_at->lte(now());
    }

    public function getEffectiveStatusAttribute(): string
    {
        if ($this->status === self::STATUS_SCHEDULED && $this->isLive()) {
            return self::STATUS_PUBLISHED;
        }

        return $this->status;
    }

    public function getRobotsAttribute(): string
    {
        return $this->robots_index . ', ' . $this->robots_follow;
    }

    public function getFeaturedImageUrlAttribute(): ?string
    {
        return $this->featured_image ? asset($this->featured_image) : null;
    }

    public function getFeaturedVideoFileUrlAttribute(): ?string
    {
        return $this->featured_video ? asset($this->featured_video) : null;
    }

    public function getFeaturedVideoEmbedUrlAttribute(): ?string
    {
        return self::videoEmbedUrl($this->featured_video_url);
    }

    /**
     * Whether the article should show a video as its primary featured media.
     */
    public function getShowsFeaturedVideoAttribute(): bool
    {
        return $this->featured_media_type === 'video'
            && ($this->featured_video || $this->featured_video_embed_url);
    }

    public function getPlainTextAttribute(): string
    {
        return trim(preg_replace('/\s+/u', ' ', html_entity_decode(strip_tags(str_replace('<', ' <', (string) $this->content)))));
    }

    public function getReadingMinutesAttribute(): int
    {
        return max(1, (int) ceil(str_word_count($this->plain_text) / 200));
    }

    /**
     * Meta title, falling back to the article title.
     */
    public function getSeoTitleAttribute(): string
    {
        return $this->meta_title ?: $this->title;
    }

    /**
     * Meta description, falling back to the excerpt and then the content.
     */
    public function getSeoDescriptionAttribute(): string
    {
        if ($this->meta_description) {
            return $this->meta_description;
        }

        return Str::limit($this->excerpt ?: $this->plain_text, 157, '...');
    }

    /**
     * Simple SEO completeness checklist used by the admin listing.
     *
     * @return array{score:int, missing:array<int,string>}
     */
    public function seoChecklist(): array
    {
        $titleLength = mb_strlen($this->seo_title);
        $descriptionLength = mb_strlen((string) $this->meta_description);

        $checks = [
            'Meta title between 30 and 60 characters' => $titleLength >= 30 && $titleLength <= 60,
            'Custom meta description (70-160 characters)' => $descriptionLength >= 70 && $descriptionLength <= 160,
            'Meta keywords' => !empty($this->meta_keywords),
            'Excerpt' => !empty($this->excerpt),
            'Featured image with alt text' => $this->featured_image && $this->featured_image_alt,
            'At least one category' => $this->relationLoaded('categories') ? $this->categories->isNotEmpty() : $this->categories()->exists(),
            'Indexable by search engines' => $this->robots_index === 'index',
        ];

        $missing = array_keys(array_filter($checks, fn ($passed) => !$passed));

        return [
            'score' => (int) round((count($checks) - count($missing)) / count($checks) * 100),
            'missing' => $missing,
        ];
    }

    /**
     * Convert a YouTube / Vimeo / Dailymotion page URL into an embeddable player URL.
     * Returns null for anything unsupported, which doubles as validation.
     */
    public static function videoEmbedUrl(?string $url): ?string
    {
        if (!$url || !preg_match('#^https?://#i', $url)) {
            return null;
        }

        $parts = parse_url($url);
        $host = strtolower(preg_replace('/^(www\.|m\.)/', '', $parts['host'] ?? ''));
        $path = $parts['path'] ?? '';
        parse_str($parts['query'] ?? '', $query);

        if (in_array($host, ['youtube.com', 'youtube-nocookie.com'], true)) {
            if (!empty($query['v'])) {
                $id = $query['v'];
            } elseif (preg_match('#^/(?:embed|shorts|live)/([^/?]+)#', $path, $m)) {
                $id = $m[1];
            }
        } elseif ($host === 'youtu.be') {
            $id = ltrim($path, '/');
        }

        if (!empty($id)) {
            return preg_match('/^[A-Za-z0-9_-]{6,20}$/', $id) ? 'https://www.youtube-nocookie.com/embed/' . $id : null;
        }

        if (in_array($host, ['vimeo.com', 'player.vimeo.com'], true) && preg_match('#/(\d{5,12})#', $path, $m)) {
            return 'https://player.vimeo.com/video/' . $m[1];
        }

        if (in_array($host, ['dailymotion.com', 'dai.ly'], true) && preg_match('#^/(?:video/|embed/video/)?([A-Za-z0-9]{5,12})#', $path, $m)) {
            return 'https://www.dailymotion.com/embed/video/' . $m[1];
        }

        return null;
    }
}
