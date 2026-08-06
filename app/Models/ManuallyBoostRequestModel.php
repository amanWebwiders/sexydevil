<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManuallyBoostRequestModel extends Model {
    use HasFactory;

    protected $table = 'manually_boost_requests';
    protected $primaryKey = 'id';
    protected $fillable = [
        'user_id',
        'ups_quantity',
        'status'
    ];
}
