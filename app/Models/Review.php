<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;



class Review extends Model
{
    protected $fillable = [
        'user_id',
        'reviewer_id',
        'rating',
        'comment',
        'photo_accurate',
        'agreement_fulfilled',
        'is_smoker',
        'hygiene',
        'ambience',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id'); // reviewed user
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewer_id'); // who gave review
    }
}
