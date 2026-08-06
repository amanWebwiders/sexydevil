<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\{User, Country};
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Http;

class BlockCountries
{
    public function handle(Request $request, Closure $next)
    {

        // Get profile ID from route
        $escortId = $request->route('id');

        // Fetch escort (change 'User' to your model if needed)
        $escort = User::find($escortId);

        if (!$escort) {
            abort(404, 'Profile not found');
        }
        $blockedCountries = json_decode($escort->blocked_countries, true) ?? [];
        // dd($blockedCountries);
        $ip = $request->ip();

        $response = Http::get("http://ip-api.com/json/{$ip}?fields=status,countryCode");

        if ($response->successful() && $response['status'] === 'success') {
            $countryCode = strtoupper($response['countryCode']);
            
            // Match with your countries table
            $country = Country::where('iso2', $countryCode)->first();
// dd($blockedCountries);
            if ($country && in_array($country->id, $blockedCountries)) {
                
                abort(403, 'Sorry, this profile is unavailable in your region.');
            }
        }

        // Get visitor country code from IP

        return $next($request);
    }
}
