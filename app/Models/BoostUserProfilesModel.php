<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BoostUserProfilesModel extends Model
{
    use HasFactory;

    protected $table = 'boost_user_profiles';
    protected $primaryKey = 'id';
    protected $fillable = [
        'user_id',
        'ups_quantity',
        'boosted_from',
        'boosted_to',
    ];

}
