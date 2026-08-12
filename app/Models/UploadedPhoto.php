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
        'custom_alt_text',
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

    /**
     * Get auto-generated or custom alt text for the photo.
     */
    public function getAltTextAttribute()
    {
        if (!empty($this->custom_alt_text)) {
            return $this->custom_alt_text;
        }

        $user = $this->user;
        if ($user) {
            $name = $user->listing_title ?? $user->nickname ?? $user->name ?? 'SexyDevil Escort';
            $city = $user->city ?? '';
            return trim($name . ($city ? ' Escort in ' . $city : ' Escort Photo'));
        }

        return 'SexyDevil Escort Photo';
    }
}
