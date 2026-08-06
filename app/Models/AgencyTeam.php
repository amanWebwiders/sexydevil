<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgencyTeam extends Model
{
    use HasFactory;

    protected $fillable = [
        'agency_id',
        'photo',
        'name',
        'description',
        'age',
        'gender',
    ];

    public function agency()
    {
        return $this->belongsTo(Agency::class);
    }
}