<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserAvailability extends Model
{
    protected $fillable = ['user_id', 'day', 'start_time', 'end_time','all_day'];
}