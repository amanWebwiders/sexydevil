<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewsAndStory extends Model
{
    use HasFactory;
    protected $table = 'news_and_stories';

    protected $fillable = [
        'user_id',
        'title',
        'text',
        'images',
        'videos',
        'validity',
        'thumbnail'
    ];

    protected $casts = [
        'images' => 'array',
        'videos' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
