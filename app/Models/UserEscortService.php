<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserEscortService extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category_id',
        'service_id',
        'selection_id',
    ];

    /**
     * Get the user associated with this service.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the category of the escort service.
     */
    public function category()
    {
        return $this->belongsTo(EscortServiceCategory::class, 'category_id');
    }

    /**
     * Get the service of the escort.
     */
    public function service()
    {
        return $this->belongsTo(EscortService::class, 'service_id');
    }

    /**
     * Get the selection under the service.
     */
    public function selection()
    {
        return $this->belongsTo(EscortServiceSelection::class, 'selection_id');
    }
}
