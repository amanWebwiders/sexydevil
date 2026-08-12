<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\City;
use App\Models\Agency;
use App\Models\LocationSeoContent;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class SitemapController extends Controller
{
    public function index()
    {
        try {
            $urls = [];

            // 1. Fetch Noindex Exclusions from LocationSeoContent table
            $noindexEntries = LocationSeoContent::where(function ($q) {
                $q->where('robots_setting', 'like', '%noindex%')
                  ->orWhere('robots_setting', 'like', '%no_index%')
                  ->orWhere('robots_setting', 'like', '%no index%');
            })->get();

            $noindexCities = $noindexEntries->pluck('city')->filter()->map(fn($item) => strtolower($item))->toArray();
            $noindexTitles = $noindexEntries->pluck('title')->filter()->map(fn($item) => strtolower($item))->toArray();

            // 2. Static Pages
            $staticPages = [
                ['loc' => url('/'), 'priority' => '1.0', 'changefreq' => 'daily', 'lastmod' => now()->format('Y-m-d'), 'title' => 'Home'],
                ['loc' => url('/about-us'), 'priority' => '0.8', 'changefreq' => 'monthly', 'lastmod' => now()->format('Y-m-d'), 'title' => 'About Us'],
                ['loc' => url('/contact-us'), 'priority' => '0.8', 'changefreq' => 'monthly', 'lastmod' => now()->format('Y-m-d'), 'title' => 'Contact Us'],
                ['loc' => url('/terms-condition'), 'priority' => '0.8', 'changefreq' => 'monthly', 'lastmod' => now()->format('Y-m-d'), 'title' => 'Terms & Conditions'],
            ];

            foreach ($staticPages as $page) {
                if (!in_array(strtolower($page['title']), $noindexTitles)) {
                    $urls[] = $page;
                }
            }

            // 3. Category / List Directory Pages
            $categoryPages = [
                ['loc' => url('/new-escorts'), 'priority' => '0.9', 'changefreq' => 'daily', 'lastmod' => now()->format('Y-m-d'), 'title' => 'New Escorts'],
                ['loc' => url('/active-escorts'), 'priority' => '0.9', 'changefreq' => 'daily', 'lastmod' => now()->format('Y-m-d'), 'title' => 'Active Escorts'],
                ['loc' => url('/lowcost-escorts'), 'priority' => '0.9', 'changefreq' => 'daily', 'lastmod' => now()->format('Y-m-d'), 'title' => 'Lowcost Escorts'],
                ['loc' => url('/recommend-escorts'), 'priority' => '0.9', 'changefreq' => 'daily', 'lastmod' => now()->format('Y-m-d'), 'title' => 'Recommend Escorts'],
                ['loc' => url('/reels'), 'priority' => '0.8', 'changefreq' => 'daily', 'lastmod' => now()->format('Y-m-d'), 'title' => 'Hot Stories'],
                ['loc' => url('/user/agencies'), 'priority' => '0.8', 'changefreq' => 'weekly', 'lastmod' => now()->format('Y-m-d'), 'title' => 'Agencies'],
            ];

            foreach ($categoryPages as $cat) {
                if (!in_array(strtolower($cat['title']), $noindexTitles)) {
                    $urls[] = $cat;
                }
            }

            // 4. Dynamic City Pages (Cities with active approved users)
            $cities = City::whereHas('users', function ($query) {
                $query->activeApproved();
            })->orWhereHas('users')->get();

            $addedCities = [];
            foreach ($cities as $city) {
                $cityName = trim($city->name);
                if (empty($cityName) || in_array(strtolower($cityName), $addedCities) || in_array(strtolower($cityName), $noindexCities)) {
                    continue;
                }
                $addedCities[] = strtolower($cityName);

                $cityUrl = url('/' . urlencode($cityName));
                $urls[] = [
                    'loc' => $cityUrl,
                    'priority' => '0.9',
                    'changefreq' => 'daily',
                    'lastmod' => $city->updated_at ? $city->updated_at->format('Y-m-d') : now()->format('Y-m-d'),
                ];
            }

            // 5. Dynamic Escort Profiles (Active & Approved)
            $current_date = now()->format('Y-m-d');
            $escorts = User::where('type', 2)
                ->where('admin_status', 'approved')
                ->where('user_status', 0)
                ->where(function($q) use ($current_date) {
                    $q->whereNull('plan_end_date')
                      ->orWhere(function($sub) use ($current_date) {
                          $sub->where('plan_start_date', '<=', $current_date)
                              ->where('plan_end_date', '>=', $current_date);
                      });
                })->get();

            foreach ($escorts as $escort) {
                $urls[] = [
                    'loc' => route('user.profile.show', $escort->id),
                    'priority' => '0.8',
                    'changefreq' => 'daily',
                    'lastmod' => $escort->updated_at ? $escort->updated_at->format('Y-m-d') : now()->format('Y-m-d'),
                ];
            }

            // 6. Dynamic Agencies
            $agencies = Agency::all();
            foreach ($agencies as $agency) {
                $urls[] = [
                    'loc' => url('/user/agency-detail/' . $agency->id),
                    'priority' => '0.7',
                    'changefreq' => 'weekly',
                    'lastmod' => $agency->updated_at ? $agency->updated_at->format('Y-m-d') : now()->format('Y-m-d'),
                ];
            }

            // Deduplicate URLs based on 'loc' key
            $uniqueUrls = collect($urls)->unique('loc')->values()->all();

            return response()->view('front.sitemap', ['urls' => $uniqueUrls], 200)
                ->header('Content-Type', 'text/xml');

        } catch (\Exception $e) {
            Log::error("Sitemap generation error: " . $e->getMessage());
            return response()->make("Error generating sitemap: " . $e->getMessage(), 500);
        }
    }
}
