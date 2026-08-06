<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EscortService extends Model
{
    protected $fillable = ['category_id', 'name'];

    public function category()
    {
        return $this->belongsTo(EscortServiceCategory::class, 'category_id');
    }

    public function selections()
    {
        return $this->hasMany(EscortServiceSelection::class, 'service_id');
    }
}
