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
        $segments = request()->segments();
        $lastSegment = request()->segment(count(request()->segments()));
        // Example: /escortService/model-search/india
        if (isset($segments[1]) && !in_array($segments[1], ['agencies'])) {
            $extraValue = $segments[1]; // "india"
        } else if(isset($lastSegment)) {
            $extraValue = $lastSegment;
        } else {
            $extraValue = null; // nothing
        }
        $city = isset($extraValue) && !in_array($extraValue, ["boost-users"]) ? $extraValue:"";
        // Share data with all views

        //dd($city);
        View::composer('*', function ($view) use($city) {
            $view->with('globalData', ContactSetting::where("id", 1)->first()); // replace with your query
            $view->with('city', $city); // replace with your query
        });
    }
}
