<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgencyMedia extends Model
{
    use HasFactory;

    protected $fillable = [
        'agency_id',
        'type', 
        'file_path',
    ];

    public function agency()
    {
        return $this->belongsTo(Agency::class);
    }
}
