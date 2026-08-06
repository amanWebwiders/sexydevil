<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agency extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'headline',
        'short_desc',
        'long_desc',
        'email',
        'phone',
        'social_media',
        'address',
        'photo',
        'website',
    ];

    public function teams()
    {
        return $this->hasMany(AgencyTeam::class);
    }

    public function media()
    {
        return $this->hasMany(AgencyMedia::class);
    }
}