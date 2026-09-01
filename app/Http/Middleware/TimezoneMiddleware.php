<?php

namespace App\Http\Middleware;

use App\Models\Country;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TimezoneMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $segments = request()->segments();
        $lastSegment = request()->segment(count(request()->segments()));
        // Example: /escortService/model-search/india
        if (isset($segments[1])) {
            $extraValue = $segments[1]; // "india"
        } else if(isset($lastSegment)) {
            $extraValue = $lastSegment;
        } else {
            $extraValue = null; // nothing
        }
        $current_timezone = config('app.timezone');

        /* if ($request->hasHeader('X-Timezone')) {
            $tz = $request->header('X-Timezone');
        } else  */
        $tz = '[{"zoneName":"'.$current_timezone.'"}]';
        if ($request->country_id) {
            $countryData = Country::select('countries.*')->where('id', $request->country_id)->first();
            $tz = $countryData?->timezones ?? '[{"zoneName":"'.$current_timezone.'"}]';
        } else if ($extraValue && !in_array($extraValue, ["home", "edit-profile", "update-password", "photo", "video", "availabilities", "rate", "active-escorts", "recommend-escorts", "lowcost-escorts", "about-us", "favourite-list", "news-stories", "video", "user-login", "choose", "user-signup", "profile", "model-search", "manually-boost"])) {
            // Lookup country by name or city
           $query = Country::join('cities', 'countries.id', 'cities.country_id');
            if(isset($extraValue)) {
                $keywords = str_replace("+", " ", $extraValue);
                $query->where(function($q) use ($keywords) {
                    $q->where('countries.name', 'like', "%{$keywords}%")
                    ->orWhere('cities.name', 'like', "{$keywords}");
                });
            }
            $countryData = $query->select('countries.*')->first();
            $tz = $countryData?->timezones ?? '[{"zoneName":"'.$current_timezone.'"}]';
        } 

        
        $correted_tz = json_decode($tz, true);
        $zoneName = $correted_tz[0]['zoneName'] ?? $current_timezone;
        if($zoneName !== $current_timezone) {
            config(['app.timezone' => $zoneName]);
            date_default_timezone_set($zoneName);            
        }
        /* config(['app.timezone' => $tz]);
        date_default_timezone_set($tz); */
        return $next($request);
    }
}
