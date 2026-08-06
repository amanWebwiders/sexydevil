<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;
    public function states() {
        return $this->hasMany(State::class);
    }

    public function users() {
        $current_date = now()->format('Y-m-d');
        return $this->hasMany(User::class)->where( ['admin_status' => 'approved', ['users.plan_start_date', '<=', $current_date], ['users.plan_end_date', '>=', $current_date]] );
    }

    public function activeUsers() {
        return $this->users()->activeApproved();
    }

    protected $casts = [
        'emoji' => 'string', // 👈 always cast emoji to string
    ];

}
