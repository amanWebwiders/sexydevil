<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'quickie_rates' => 'array',
    ];
    public function country()
    {
        return $this->belongsTo(CountryCode::class, 'phone_code', 'code');
    }

    public function nationality()
    {
        return $this->belongsTo(CountryCode::class, 'country_id', 'id');
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }
    public function gender()
    {
        return $this->belongsTo(Gender::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
    public function countries()
    {
        return $this->belongsTo(Country::class, 'country_id', 'id');
    }

    public function state()
    {
        return $this->belongsTo(State::class, 'state_id', 'id');
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id', 'id');
    }

    public function ethnicity()
    {
        return $this->belongsTo(Ethnicity::class, 'ethnicity_id', 'id');
    }
    public function bodyType()
    {
        return $this->belongsTo(BodyType::class, 'body_type_id', 'id');
    }
    public function haircolor()
    {
        return $this->belongsTo(HairColor::class, 'hair_color_id', 'id');
    }
    public function hairLength()
    {
        return $this->belongsTo(HairLength::class, 'hair_length_id', 'id');
    }
    public function hairType()
    {
        return $this->belongsTo(HairType::class, 'hair_type_id', 'id');
    }
    public function eyeColor()
    {
        return $this->belongsTo(EyeColor::class, 'eye_color_id', 'id');
    }
    public function pubicHair()
    {
        return $this->belongsTo(PubicHair::class, 'pubic_hair_id', 'id');
    }
    public function reviewsReceived()
    {
        return $this->hasMany(Review::class, 'reviewer_id');
    }

    // Reviews this user has written (they are the reviewer)
    public function reviewsGiven()
    {
        return $this->hasMany(Review::class, 'user_id');
    }
    public function escortServices()
    {
        return $this->hasMany(UserEscortService::class, 'user_id');
    }

    public function wishlist()
    {
        return $this->hasMany(Wishlist::class, 'favourite_user_id');
    }

    public function favouritedBy()
    {
        $loggedInUser = auth()->user()->id ?? null;
        return $this->hasMany(Wishlist::class, 'favourite_user_id')->where('user_id', $loggedInUser);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function viewsReceived()
    {
        return $this->hasMany(View::class, 'viewed_id');
    }

    public function totalProfileViews()
    {
        return $this->viewsReceived()->count();
    }

    public function images()
    {
        return $this->hasMany(UploadedPhoto::class, 'user_id')->where(['is_approved' => 1, 'hide_show' => 1])->orderBy('sequence', 'ASC');
    }
    public function videos() {
        return $this->hasMany(Video::class, 'user_id');
    }

    public function is_featured() {
        return $this->hasOne(FeatureDevil::class, 'user_id')->where('feature_devils.date', '=', now()->format('Y-m-d'));
    }

    public function checkIsReviewed($user_id)
    {
        return $this->reviewsReceived()->where('user_id', $user_id)->exists();
    }

    public function stories()
    {
        return $this->hasMany(NewsAndStory::class, 'user_id')
            ->where(function ($query) {
                $query->whereNull('validity')
                      ->orWhere('validity', '>=', now());
            })
            ->orderBy('id', 'desc');
    }

    public function scopeActiveApproved($query) {
        $current_date = now()->format('Y-m-d');

        return $query->where('admin_status', 'approved')
                    ->where('plan_start_date', '<=', $current_date)
                    ->where('plan_end_date', '>=', $current_date);
    }
}
