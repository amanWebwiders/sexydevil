<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EscortServiceCategory extends Model
{
    protected $fillable = ['name'];

    public function services()
    {
        return $this->hasMany(EscortService::class, 'category_id');
    }
}
