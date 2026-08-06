<?php

namespace App\Http\Middleware;

use App\Models\Country;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;


class UserMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        
        if (!Auth::guard('web')->check()) {
            // Return redirect response properly
            return redirect()->route('user-login'); // Make sure this route exists
        }
        $user = Auth::guard('web')->user();
        if ($user->user_status == 1) {
            
            Auth::logout();
            return redirect()->route('user-login')->withErrors([
                'email' => 'Your account has been blocked by the admin.',
            ]);
        } else {
            if($user->country_id) {
                $country = Country::where("id", $user->country_id)->first();
                $time_zone = json_decode($country->timezones, true);

                if(isset($time_zone[0]["zoneName"])) {
                    config(['app.timezone' => $time_zone[0]["zoneName"]]);
                }
            }
        }

       

        // Continue processing the request if authenticated
        return $next($request);
    }
}
