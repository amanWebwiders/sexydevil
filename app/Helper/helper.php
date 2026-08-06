<?php

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Models\{Wishlist, User};
use Illuminate\Support\Facades\Auth;

if (!function_exists('getCurrentSlot')) {
    function getCurrentSlot(): int {
        /*
                00:00–01:59 → slot 0  
        02:00–03:59 → slot 1  
        ...
        22:00–23:59 → slot 11*/
        $hour = now()->hour;
        return intdiv($hour, 2); // 0–11
    }
}
if (!function_exists('errorResponse')) {
    function errorResponse($message = 'error', $error = new stdClass(), $status = 0, $responseCode = 500)
    {
        return response()->json(['status' => $status, 'message' => $message ?? __('message.statusZero'), 'data' => new stdClass(), 'errors' => $error], $responseCode);
    }
}

if (!function_exists('getWishlistClass')) {
    function getWishlistClass($favourite_user_id)
    {
        if (Auth::guard('web')->check()) {
            return \App\Models\Wishlist::where('favourite_user_id', $favourite_user_id)
                ->where('user_id', Auth::guard('web')->id())
                ->exists() ? 'fa-solid fa-heart text-danger' : 'fa-regular fa-heart';
        }
        return 'fa-regular fa-heart'; // default for guests
    }
}

if (!function_exists('getBoostedViews')) {
    /**
     * Returns visually boosted profile view count & label (does not affect real stats).
     *
     * @param int $realCount   Real view count from DB
     * @param float $multiplier Factor to boost display (e.g., 2.5)
     * @param int $minViews    Minimum display value for empty/new profiles
     * @param bool $randomDrift Whether to add a small random drift for dynamism
     * @return array
     */
if (!function_exists('getBoostedViews')) {
    /**
     * Returns visually boosted profile view count & label (same for same user in session).
     */
    function getBoostedViews(
        int $realCount,
        string $profileId,
        float $multiplier = 2.5,
        int $minViews = 1000,
        bool $randomDrift = true
    ): array {
        // Create a unique session key for this profile
        $sessionKey = "boosted_views_{$profileId}";

        // If already calculated for this user, return it
        if (session()->has($sessionKey)) {
            return session()->get($sessionKey);
        }

        // Apply multiplier and ensure minimum
        $boostedCount = max(round($realCount * $multiplier), $minViews);

        // Add small random change to make it feel "live" (but same for the session)
        if ($randomDrift) {
            $boostedCount += rand(0, 15);
        }

        // Popularity label logic
        $label = '';
        if ($boostedCount > 1000) {
            $label = '🔥 Very popular today';
        } elseif ($boostedCount > 500) {
            $label = '📊 Trending now';
        }

        $data = [
            'count' => $boostedCount,
            'label' => $label
        ];

        // Store in session for consistency
        session()->put($sessionKey, $data);

        return $data;
    }
}
if (!function_exists('currentCityContry')) {
    function currentCityContry(){
        /* $ip = request()->ip();
        $res = file_get_contents('https://www.iplocate.io/api/lookup/'.$ip );
        $res = json_decode($res); */

        $cityName = $res->city ?? "Indore";
        $stateName = $res->subdivision ?? 'Indore';
        $countryName = $res->country ?? "India";
        return ["city" => $cityName, 'country'=> $countryName, 'state' =>$stateName];
    }
}
}
if (!function_exists('emojiToCountryCode')) {

    function emojiToCountryCode($emoji)
    {
        $codePoints = mb_convert_encoding($emoji, 'UTF-32', 'UTF-8');
        $codeArray = unpack('N*', $codePoints);

        $countryCode = '';
        foreach ($codeArray as $code) {
            $countryCode .= chr($code - 127397); // Convert regional indicator symbols to letters
        }

        return $countryCode; // e.g. 🇮🇳 => "IN"
    }
}

if (!function_exists('format_price_dot')) {
    
    function format_price_dot($number)
    {
        // Ensure it's a number and format with dot as thousand separator, no decimals
        return number_format((float) $number, 0, '', '.');
    }
}

if (!function_exists('generateUniqueUserCode')) {
    function generateUniqueUserCode(){
        do {
            $code = 'USER' . Str::upper(Str::random(10));
        } while (User::where('unique_user_id', $code)->exists());
        return $code;
    }
}

if (!function_exists('UserData')) {
    function UserData($id, $field = ["users.id"]){
        return User::select($field)->find($id);
    }
}

