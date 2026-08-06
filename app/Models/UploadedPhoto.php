<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UploadedPhoto extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'file_path',
        'is_approved',
        'orignal_file_path'
    ];

    /**
     * Get the user who uploaded the photo.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
