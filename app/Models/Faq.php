<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    use HasFactory;

    protected $table = 'faqs';

    protected $fillable = [
        'question',
        'answer',
        'category',
        'order',
        'status',
    ];

    protected $casts = [
        'status' => 'integer',
        'order' => 'integer',
    ];

    /**
     * Scope active FAQs
     */
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    /**
     * Scope ordered FAQs
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc')->orderBy('id', 'asc');
    }
}
