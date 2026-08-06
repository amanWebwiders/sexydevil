<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class Admin extends Authenticatable
{
    use HasFactory, Notifiable;
    protected $table = 'admin';
    protected $primaryKey = "id";
    protected $guarded = [];
    protected $hidden = [
        'password', 'remember_token',
    ];
    public function occupation()
    {
        return $this->belongsTo(Occupation::class, 'occupation_id');
    }
   
}
