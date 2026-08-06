<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Country;
use App\Repository\Eloquent\{GenderRepository, CommonRepository,CountryRepository};
use App\Models\EscortServiceCategory;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        view()->composer('*', function ($view) {
             $countryRepo = app(CountryRepository::class);
            $view->with('country', $countryRepo->getCountryWithUserCount());
            $view->with('countries', Country::orderby('name')->get());
            $view->with('categories', EscortServiceCategory::all());
            // Resolve GenderRepository via service container
            $genderRepo = app(GenderRepository::class);
            $commonRepo = app(CommonRepository::class);

            $view->with('gender', $genderRepo->getAll());
            $view->with('hairType', $commonRepo->setModel(new \App\Models\HairType())->getAll());
            $view->with('hairColor', $commonRepo->setModel(new \App\Models\HairColor())->getAll());
            $view->with('nationality', $commonRepo->setModel(new \App\Models\Nationality())->getAll());
            $view->with('ethnicity', $commonRepo->setModel(new \App\Models\Ethnicity())->getAll());
            $view->with('language', $commonRepo->setModel(new \App\Models\Language())->getAll());
            $view->with('bodyType', $commonRepo->setModel(new \App\Models\BodyType())->getAll());
            $view->with('eyeColor', $commonRepo->setModel(new \App\Models\EyeColor())->getAll());
            $view->with('pubicHair', $commonRepo->setModel(new \App\Models\PubicHair())->getAll());
            
        });
        
         if (app()->environment('production')) {
            URL::forceScheme('https');
        }
    }
}
