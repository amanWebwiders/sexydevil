<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EscortServiceSelection extends Model
{
    protected $fillable = ['service_id', 'name'];

    public function service()
    {
        return $this->belongsTo(EscortService::class, 'service_id');
    }
}
