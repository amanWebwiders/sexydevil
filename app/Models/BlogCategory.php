<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogCategory extends Model
{
    use HasFactory;

    protected $table = 'blog_categories';

    protected $fillable = [
        'name',
        'slug',
        'description',
        'status',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'canonical_url',
        'robots_index',
        'robots_follow',
    ];

    protected $casts = [
        'status' => 'integer',
    ];

    public function blogs()
    {
        return $this->belongsToMany(Blog::class, 'blog_blog_category');
    }

    /**
     * Scope active categories
     */
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    /**
     * Robots meta tag value, e.g. "index, follow"
     */
    public function getRobotsAttribute()
    {
        return $this->robots_index . ', ' . $this->robots_follow;
    }
}
