<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\ContactSetting;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $invalid_routes = [
            "home", "model-search", "new-escorts", "active-escorts", "recommend-escorts", 
            "lowcost-escorts", "reels", "agencies", "agency-detail", "about-us", 
            "contact-us", "terms-condition", "terms-conditions", "terms-and-conditions", 
            "user-login", "login", "choose", "signup", "user-signup", "user-forgot-password", 
            "user-email-verify", "favourite-list", "manually-boost", "news-stories", 
            "video", "photo", "rate", "availabilities", "edit-profile", "update-password", 
            "profile", "boost-users", "sitemap.xml", "robots.txt", "faq", "faqs"
        ];

        $location_subpages = [
            'model-search', 'new-escorts', 'active-escorts', 
            'recommend-escorts', 'lowcost-escorts', 'reels', 'agencies'
        ];

        View::composer('*', function ($view) use ($invalid_routes, $location_subpages) {
            $request = request();
            $segments = $request->segments();
            $city = "";

            if (!empty($segments)) {
                $firstSegment = strtolower($segments[0]);

                // Case 1: /user/agencies/{city?}
                if (count($segments) >= 3 && $firstSegment === 'user' && strtolower($segments[1]) === 'agencies') {
                    $city = urldecode($segments[2]);
                    session(['selected_location' => $city]);
                } else if (count($segments) == 2 && $firstSegment === 'user' && strtolower($segments[1]) === 'agencies') {
                    session()->forget('selected_location');
                    $city = "";
                }
                // Case 2: Subpages with city parameter (e.g. /model-search/Colombia or /reels/Medellín)
                else if (count($segments) >= 2 && in_array($firstSegment, $location_subpages)) {
                    $city = urldecode($segments[1]);
                    session(['selected_location' => $city]);
                }
                // Case 3: Subpages explicitly WITHOUT city (e.g. /model-search, /reels, /new-escorts)
                else if (count($segments) == 1 && in_array($firstSegment, $location_subpages)) {
                    session()->forget('selected_location');
                    $city = "";
                }
                // Case 4: /home (Worldwide TOPS / Rankings)
                else if (count($segments) == 1 && $firstSegment === 'home') {
                    session()->forget('selected_location');
                    $city = "";
                }
                // Case 5: Location page (e.g. /Colombia, /Medellín, /Spain)
                else if (count($segments) == 1 && !in_array($firstSegment, $invalid_routes)) {
                    $city = urldecode($segments[0]);
                    session(['selected_location' => $city]);
                }
                // Case 6: Fallback for static/content pages (e.g. /contact-us, /about-us)
                else {
                    $city = session('selected_location', '');
                }
            } else {
                // Root URL / (Landing / Enter page)
                $city = session('selected_location', '');
            }

            $view->with('globalData', ContactSetting::where("id", 1)->first());
            $view->with('city', $city);
        });
    }
}
