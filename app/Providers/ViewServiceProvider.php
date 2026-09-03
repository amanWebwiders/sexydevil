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

        View::composer('*', function ($view) use ($invalid_routes) {
            $request = request();
            $segments = $request->segments();
            $city = "";

            if (!empty($segments)) {
                $firstSegment = strtolower($segments[0]);
                if (count($segments) >= 2 && in_array($firstSegment, ['model-search', 'new-escorts', 'active-escorts', 'recommend-escorts', 'lowcost-escorts', 'reels', 'agencies'])) {
                    $city = $segments[1];
                } else if (count($segments) == 1) {
                    if (!in_array($firstSegment, $invalid_routes)) {
                        $city = $segments[0];
                    }
                }
            }

            $view->with('globalData', ContactSetting::where("id", 1)->first());
            $view->with('city', urldecode($city));
        });
    }
}
