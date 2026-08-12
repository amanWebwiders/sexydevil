<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Front\UserServices;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Repository\Eloquent\UserRepository;
use App\Repository\Eloquent\{AdminRepository, GenderRepository, CommonRepository, ManuallyBoostRequestRepository, CountryRepository, LocationSeoContentRepository};
use App\Traits\ImageUploadTrait;
use Carbon\Carbon;

class ModelController extends Controller
{
    use ImageUploadTrait;
    protected $userServices;
    protected $userRepository, $GenderRepository, $CommonRepository, $locationSeoContentRepository;
    protected $AdminRepository;
    private $dataObject, $manuallyBoostRequestRepository, $countryRepository;


    public function __construct(CommonRepository $CommonRepository, GenderRepository $GenderRepository, AdminRepository $AdminRepository, UserServices $userServices, UserRepository $userRepository, ManuallyBoostRequestRepository $manuallyBoostRequestRepository, CountryRepository $countryRepository, LocationSeoContentRepository $locationSeoContentRepository)
    {
        $this->userServices = $userServices;
        $this->userRepository = $userRepository;
        $this->AdminRepository = $AdminRepository;
        $this->GenderRepository = $GenderRepository;
        $this->CommonRepository = $CommonRepository;
        $this->manuallyBoostRequestRepository = $manuallyBoostRequestRepository;
        $this->countryRepository = $countryRepository;
        $this->locationSeoContentRepository = $locationSeoContentRepository;
    }


    public function search(Request $request, $city = null)
    {
        if ($request->has('city') && !empty($request->city)) {
            $mycity = urlencode($request->city);
            return redirect()->route('model.search', ["city" => $mycity] );
        }
        $invalid_route = ["edit-profile", "update-password", "photo", "video", "availabilities", "rate", "active-escorts", "recommend-escorts", "lowcost-escorts", "about-us", "contact-us", "terms-condition", "terms-conditions", "terms-and-conditions", "favourite-list", "news-stories", "user-login", "choose", "user-signup", "profile", "manually-boost", "new-escorts", "reels", "gallery", "sitemap.xml", "home"];
        if($city && in_array(strtolower($city), $invalid_route)) {
            return redirect()->route('model.search', ["city" => 'home'] );
        }
        $city = isset($city) && $city != "home" ? $city:null;
        $filters = [];
        if ($request->filled('name')) {
            $filters['search_term'] = $request->name;
        }
        $all_request = $request->all();
        if ($request->filled('country_id')) {
            $filters['users.country_id'] = $request->country_id;
            $country = $this->countryRepository->getSingleRecordWhere(["id" => $request->country_id]);
            $locationSeoCity = (int)$request->country_id;
            $time_zone = json_decode($country->timezones, true);
            session()->put('SeoType', 'country');
            if(isset($time_zone[0]["zoneName"])) {
                config(['app.timezone' => $time_zone[0]["zoneName"]]);
            }
        } else if($request->filled('submit_country')) {
            $filters['users.country_id'] = $request->submit_country;
            $country = $this->countryRepository->getSingleRecordWhere(["id" => $request->submit_country]);
            $locationSeoCity = (int)$request->submit_country;
            $time_zone = json_decode($country->timezones, true);
            session()->put('SeoType', 'country');
            if(isset($time_zone[0]["zoneName"])) {
                config(['app.timezone' => $time_zone[0]["zoneName"]]);
            }
        } else {
            $city === null ? session()->put('SeoType', 'worldwide') : null;
            $locationSeoCity = $city;
        }
        if ($request->filled('state_id')) {
            session()->put('SeoType', 'state');
            $locationSeoCity = (int)$request->state_id;
            $filters['users.state_id'] = $request->state_id;
        } else if($request->filled('submit_state_id')) {
            session()->put('SeoType', 'state');
            $locationSeoCity = (int)$request->submit_state_id;
            $filters['users.state_id'] = $request->submit_state_id;
        }

        if ($request->filled('city_id')) {
            session()->put('SeoType', 'city');
            $locationSeoCity = (int)$request->city_id;
            $filters['city_id'] = $request->city_id;
        } else if($request->filled('submit_city_id')) {
            session()->put('SeoType', 'city');
            $locationSeoCity = (int)$request->submit_city_id;
            $filters['city_id'] = $request->submit_city_id;
        }
        //dd($locationSeoCity);
        //if ($request->filled('price_min') && $request->filled('price_max')) {
        // $priceMin = $request->price_min ?? 0;
        // $priceMax = $request->price_max ?? 10000;

        // $filters['rates'] = ['between', [(int) $priceMin, (int) $priceMax]];
        // }

        if ($request->filled('gender')) {
            $filters['gender_id'] = $request->gender;
        }

        // if ($request->filled('videocall')) {
        //     $filters['videocall'] = $request->videocall;
        // }

        if ($request->filled('incall')) {
            $filters['incall_outcall'] = 1;
        }

        if ($request->filled('outcall')) {
            $filters['incall_outcall'] = 0;
        }

        if (!empty(array_filter((array) $request->category))) {
            $filters['category_id'] = ['IN', (array) $request->category];
        }

        if (!empty(array_filter((array) $request->sub_category))) {
            $filters['sub_category_id'] = ['IN', (array) $request->sub_category];
        }

        if ($request->filled('age')) {
            $filters['displayed_age'] = $request->age;
        }

        if (!empty(array_filter((array) $request->breast_size))) {
            $filters['breast_size'] = ['IN', (array) $request->breast_size];
        }

        if ($request->filled('hair_type')) {
            $filters['hair_type_id'] = $request->hair_type;
        }

        if ($request->filled('body_type_id')) {
            $filters['body_type_id'] = $request->body_type_id;
        }

        if ($request->filled('hair_color')) {
            $filters['hair_color_id'] = $request->hair_color;
        }
        if ($request->filled('eye_color_id')) {
            $filters['eye_color_id'] = $request->eye_color_id;
        }
        if ($request->filled('pubic_hair_id')) {
            $filters['pubic_hair_id'] = $request->pubic_hair_id;
        }
        if ($request->filled('nationality')) {
            $filters['nationality'] = $request->nationality;
        }

        if ($request->filled('ethnicity')) {
            $filters['ethnicity_id'] = $request->ethnicity;
        }

        if ($request->filled('sex_location')) {
            $filters['sex_location'] = $request->sex_location;
        }
        if (!empty(array_filter((array) $request->language))) {

            $filters['languages'] = ['IN', (array) $request->language]; // where language is an array
        }

        if ($request->filled('tattoo')) {
            $filters['tattoo'] = $request->tattoo;
        }

        if ($request->filled('piercing')) {
            $filters['piercing'] = $request->piercing;
        }

        if ($request->filled('sexual_orientation')) {
            $filters['sexual_orientation'] = $request->sexual_orientation;
        }


        if (!empty(array_filter((array) $request->payment_method))) {
            $filters['payment_method'] = ['IN', $request->payment_method];
        }
        if ($request->filled('weight_range')) {
            switch ($request->weight_range) {
                case 'under_45':
                    $filters['weight_kg'] = ['<', 45];
                    break;
                case '45_55':
                    $filters['weight_kg'] = ['BETWEEN', [45, 55]];
                    break;
                case '55_65':
                    $filters['weight_kg'] = ['BETWEEN', [55, 65]];
                    break;
                case '65_75':
                    $filters['weight_kg'] = ['BETWEEN', [65, 75]];
                    break;
                case 'over_75':
                    $filters['weight_kg'] = ['>', 75];
                    break;
            }
        }
        if ($request->filled('height_range')) {
            switch ($request->height_range) {
                case 'under_150':
                    $filters['height_cm'] = ['<', 150];
                    break;
                case '150_160':
                    $filters['height_cm'] = ['BETWEEN', [150, 160]];
                    break;
                case '160_170':
                    $filters['height_cm'] = ['BETWEEN', [160, 170]];
                    break;
                case '170_180':
                    $filters['height_cm'] = ['BETWEEN', [170, 180]];
                    break;
                case 'over_180':
                    $filters['height_cm'] = ['>', 180];
                    break;
            }
        }


        // Always filter only type 2 (as per your logic)
        $current_date = now()->format('Y-m-d');

        $filters['users.type'] = 2;
        $filters['admin_status'] = 'approved';
        $filters['plan_start_date'] = ["<=", $current_date];
        $filters['plan_end_date'] = [">=", $current_date];
        // dd($filters);
        $orderByArray = [];

        if ($request->filled('orderBy') && $request->filled('orderDirection')) {
            $orderByArray = [$request->orderBy => $request->orderDirection];
        } else {

            // fallback from path
            $path = $request->path();

            if (str_contains($path, 'new-escorts')) {

                $orderByArray = ['created_at' => 'desc'];
                $byWhere['created_at'] = ['>=', now()->subDays(14)];
            } elseif (str_contains($path, 'recommend-escorts')) {
                $orderByArray = ['top3status' => 'desc'];
            } elseif (str_contains($path, 'active-escorts')) {
                $orderByArray = ['last_active' => 'desc'];
            } elseif (str_contains($path, 'lowcost-escorts')) {
                $orderByArray = ['average_quickie_rate' => 'asc'];
            }
        }

        $page = $request->get('page', 1);
        // dd($page);
        $output["code"] = 400;
        $boost_profiles = [];
        if($request->filled('is_filter_click')) {
            session(['fetched_rec' => []]);
            session(['fetched_total_rec' => collect([])]);
        }
        if($request->ajax() == false || $request->filled('is_filter_click')) {
            session(['fetched_rec' => []]);
            $MyResults = $this->userRepository->getByWhereSearch($filters, $orderByArray, 8,'model-search', $city);
            $grouped = $MyResults->where('is_my_boosted', 0)->groupBy('visibility');
            //dump($grouped->toArray());
            //put last record to first position in each group
            if(isset($grouped) && !empty($grouped->toArray())) {
                $grouped = $grouped->map(function ($items) {
                    if ($items->isNotEmpty()) {
                        $items->prepend($items->pop());
                    }
                    return $items;
                });
            }
            //set rotation_pos based on new sequence
            if(isset($MyResults) && $MyResults->isNotEmpty() && isset($grouped) && !empty($grouped->toArray())) {
                //dd($grouped);
                foreach ($grouped as $planId => $groupUsers) {
                    $total_records = $groupUsers->count();
                    //dump($total_records);
                    //dump('pppppp');
                    foreach ($groupUsers as $key => $user) {
                        //26 - (26-(0+1)) = 1
                        $sequenceNumber = $total_records - ($total_records-($key + 1));

                        DB::table('users')->where('id', $user->id)->update([
                            'rotation_pos' => $sequenceNumber
                        ]);
                    }
                    //break;
                }
                session(['fetched_total_rec' => $MyResults]);            
            } else {
                session(['fetched_total_rec' => collect([])]);
            }
        }
        //dd(session('fetched_total_rec'));
        $output["code"] = (isset($MyResults) && !$MyResults->isNotEmpty()) ? 400:200;
        if($request->ajax() == true && session('fetched_total_rec')->isNotEmpty()) {
            $already_ids = session('fetched_rec');
            $results = session('fetched_total_rec')->whereNotIn('id', $already_ids)->take(8);
            $fetched_rec = $results->pluck('id')->toArray();

            /* $MyResults = $this->userRepository->getByWhereSearch($filters, $orderByArray, 8,$page, $city); */
            $output["code"] = (isset($results) && !$results->isNotEmpty()) ? 400:200;
            //$page = ($output["code"] == 400) ? 1 : $page;    
        } else if($output["code"] == 200 && $request->ajax() == false) {
            $results = session('fetched_total_rec')->take(8);            
            $fetched_rec = $results->pluck('id')->toArray();
            $output["code"] = (isset($results) && !$results->isNotEmpty()) ? 400:200;
        } else {
            $results = collect([]);
            $output["code"] = 400;
        }
        //$fetched_result = collect($MyResults)->pluck('id');
        /* ✅ MERGE WITH EXISTING SESSION */
        if($output["code"] == 200) {
            $existing = session('fetched_rec', []);   // get old or empty array
            $merged   = array_values(array_unique(array_merge($existing, $fetched_rec)));            
            session(['fetched_rec' => $merged]);
        }
        $allUserIds = $results->flatMap(function ($item) {
            return $item->favouritedBy->pluck('favourite_user_id');
        })
        ->unique()
        ->values()->toArray();
        $favorites = json_decode($request->cookie('favorites', '[]'), true);
        // Merge + unique + normalize to integers
        $favorite_users = collect($allUserIds)
            ->merge($favorites)
            ->map(function ($id) { return (int) $id; })  // ensure integer
            ->unique()
            ->values()
            ->toArray();
            
        $locationSeoContent = $this->userServices->getLocationSeoContent($locationSeoCity, "All Escorts");        
        if ($request->ajax()) {
            // Convert paginated data to a collection and shuffle it
            $output["list"] = view('partials.model_cards', compact('results', 'favorite_users'))->render();
            $output["page"] = $output["code"] == 200 ? $page + 1 : $page;
            $output["content"] = $locationSeoContent['data']->content ?? null;
            return response()->json($output);
        }
        $url = route('model.search', ['city' => $city ?? ""]);
        return view('front.model-list', compact('results', 'city', 'favorite_users', 'url', 'boost_profiles', 'all_request', 'locationSeoContent'));
    }


    public function newEscort(Request $request, $city = null)
    {
        if ($request->has('city') && !empty($request->city)) {
            $mycity = urlencode($request->city);
            return redirect()->route('new.escorts', ["city" => $mycity] );
        }
        $invalid_route = ["edit-profile", "update-password", "photo", "video", "availabilities", "rate", "active-escorts", "recommend-escorts", "lowcost-escorts", "about-us", "favourite-list", "news-stories", "video", "user-login", "choose", "user-signup", "profile", "manually-boost", "new-escorts", "reels"];
        if($city && in_array($city, $invalid_route)) {
            return redirect()->route('new.escorts', ["city" => 'home'] );
        }
        $city = $locationSeoCity = isset($city) && $city != "home" ? $city:null;
        
        $filters = [];
        if ($request->filled('name')) {
            $filters['search_term'] = $request->name;
        }

        if ($request->filled('country_id')) {
            $filters['country_id'] = $request->country_id;

            $now = Carbon::now(config('app.timezone'));   

        }

        if ($request->filled('state_id')) {
            $filters['state_id'] = $request->state_id;
        }

        if ($request->filled('city_id')) {
            $filters['city_id'] = $request->city_id;
        }

        //if ($request->filled('price_min') && $request->filled('price_max')) {
        //   $filters['rates'] = ['between', [(int) $request->price_min, (int) $request->price_max]];
        // }


        if ($request->filled('gender')) {
            $filters['gender_id'] = $request->gender;
        }

        // if ($request->filled('videocall')) {
        //     $filters['videocall'] = $request->videocall;
        // }

        if ($request->filled('incall')) {
            $filters['incall_outcall'] = 1;
        }

        if ($request->filled('outcall')) {
            $filters['incall_outcall'] = 0;
        }

        if (!empty(array_filter((array) $request->category))) {
            $filters['category_id'] = ['IN', (array) $request->category];
        }

        if (!empty(array_filter((array) $request->sub_category))) {
            $filters['sub_category_id'] = ['IN', (array) $request->sub_category];
        }

        if ($request->filled('age')) {
            $filters['displayed_age'] = $request->age;
        }

        if (!empty(array_filter((array) $request->breast_size))) {
            $filters['breast_size'] = ['IN', (array) $request->breast_size];
        }

        if ($request->filled('hair_type')) {
            $filters['hair_type_id'] = $request->hair_type;
        }

        if ($request->filled('body_type_id')) {
            $filters['body_type_id'] = $request->body_type_id;
        }

        if ($request->filled('hair_color')) {
            $filters['hair_color_id'] = $request->hair_color;
        }
        if ($request->filled('eye_color_id')) {
            $filters['eye_color_id'] = $request->eye_color_id;
        }
        if ($request->filled('pubic_hair_id')) {
            $filters['pubic_hair_id'] = $request->pubic_hair_id;
        }
        if ($request->filled('nationality')) {
            $filters['nationality'] = $request->nationality;
        }

        if ($request->filled('ethnicity')) {
            $filters['ethnicity_id'] = $request->ethnicity;
        }

        if ($request->filled('sex_location')) {
            $filters['sex_location'] = $request->sex_location;
        }
        if (!empty(array_filter((array) $request->language))) {

            $filters['languages'] = ['IN', (array) $request->language]; // where language is an array
        }

        if ($request->filled('tattoo')) {
            $filters['tattoo'] = $request->tattoo;
        }

        if ($request->filled('piercing')) {
            $filters['piercing'] = $request->piercing;
        }

        if ($request->filled('sexual_orientation')) {
            $filters['sexual_orientation'] = $request->sexual_orientation;
        }


        if (!empty(array_filter((array) $request->payment_method))) {
            $filters['payment_method'] = ['IN', $request->payment_method];
        }
        if ($request->filled('weight_range')) {
            switch ($request->weight_range) {
                case 'under_45':
                    $filters['weight_kg'] = ['<', 45];
                    break;
                case '45_55':
                    $filters['weight_kg'] = ['BETWEEN', [45, 55]];
                    break;
                case '55_65':
                    $filters['weight_kg'] = ['BETWEEN', [55, 65]];
                    break;
                case '65_75':
                    $filters['weight_kg'] = ['BETWEEN', [65, 75]];
                    break;
                case 'over_75':
                    $filters['weight_kg'] = ['>', 75];
                    break;
            }
        }
        if ($request->filled('height_range')) {
            switch ($request->height_range) {
                case 'under_150':
                    $filters['height_cm'] = ['<', 150];
                    break;
                case '150_160':
                    $filters['height_cm'] = ['BETWEEN', [150, 160]];
                    break;
                case '160_170':
                    $filters['height_cm'] = ['BETWEEN', [160, 170]];
                    break;
                case '170_180':
                    $filters['height_cm'] = ['BETWEEN', [170, 180]];
                    break;
                case 'over_180':
                    $filters['height_cm'] = ['>', 180];
                    break;
            }
        }


        // Always filter only type 2 (as per your logic)
        $filters['users.type'] = 2;
        $filters['admin_status'] = 'approved';
        $filters['user_status'] = 0;


        $filters['users.created_at'] = ['>=', now()->subDays(14)];
        // dd($filters);

        $page = $request->get('page', 1);
        if($request->ajax() == false) {
            session(['fetched_rec' => []]);
            $results = $this->userRepository->getByWhereSearch($filters, [], 8,$page, $city);
        }
        // dd($results);
        $output["code"] = (isset($results) && !$results->isNotEmpty()) ? 400:200;
        $locationSeoContent = $this->userServices->getLocationSeoContent($locationSeoCity, "New Escorts");        
        if($request->ajax() == true) {
            //dd(1231);
            $results = $this->userRepository->getByWhereSearch($filters, [], 8,$page);
            $output["code"] = (isset($results) && !$results->isNotEmpty()) ? 400:200;
            //$page = ($output["code"] == 400) ? 1 : $page;
        } 

        $fetched_result = collect($results)->pluck('id');
        /* ✅ MERGE WITH EXISTING SESSION */
        $existing = session('fetched_rec', []);   // get old or empty array
        $merged   = array_values(array_unique(array_merge($existing, $fetched_result->toArray())));
        
        session(['fetched_rec' => $merged]);
        $allUserIds = $results->flatMap(function ($item) {
            return $item->favouritedBy->pluck('favourite_user_id');
        })
        ->unique()
        ->values()->toArray();
        $favorites = json_decode($request->cookie('favorites', '[]'), true);
        // Merge + unique + normalize to integers
        $favorite_users = collect($allUserIds)
            ->merge($favorites)
            ->map(function ($id) { return (int) $id; })  // ensure integer
            ->unique()
            ->values()
            ->toArray();
        if ($request->ajax()) {            
            // Convert paginated data to a collection and shuffle it
            $output["list"] = view('partials.model_cards', compact('results', 'favorite_users'))->render();
            $output["page"] = $page + 1;
            $output["content"] = $locationSeoContent['data']->content ?? null;
            return response()->json($output);
        }
        $url = route('new.escorts', ['city' => $city ?? ""]);

        return view('front.model-list', compact('results', 'favorite_users', 'city', 'url', 'locationSeoContent'));
    }




    public function storeReview(Request $request)
    {


        try {
            $reviewedUserId = $request->reviewed_user_id;

            $user = auth()->user();

            $user = $this->userRepository->getOne(['id' => $user->id]);

            $reviewData = $this->userRepository->getOneReview(['user_id' => $user->id, 'reviewer_id' => $reviewedUserId]);

            if ($reviewData) {
                return response()->json(['message' => 'You have already submitted a review.'], 409);
            }

            $data =  $this->userRepository->createReview([
                'user_id' => $user->id,
                'reviewer_id' => $reviewedUserId,
                'rating' => $request->rating,
                'comment' => $request->comment,
                'photo_accurate' => $request->photo_accurate,
                'agreement_fulfilled' => $request->agreement_fulfilled,
                'is_smoker' => $request->is_smoker,
                'hygiene' => $request->hygiene,
                'ambience' => $request->ambience,

            ]);

            return response()->json(['message' => 'Review submitted successfully.']);
        } catch (\Exception $e) {
            Log::error("Error in HomeController.saveContactUsData(): " . $e->getMessage());
            return response()->json(['status' => 0, 'message' => __('message.statusZero'), 'data' => $this->dataObject, 'error' => $this->dataObject], 500);
        }
    }

    public function activeEscort(Request $request, $city = null)
    {
        if ($request->has('city') && !empty($request->city)) {
            $mycity = urlencode($request->city);
            return redirect()->route('active.escorts', ["city" => $mycity] );
        }
        $invalid_route = ["edit-profile", "update-password", "photo", "video", "availabilities", "rate", "active-escorts", "recommend-escorts", "lowcost-escorts", "about-us", "favourite-list", "news-stories", "video", "user-login", "choose", "user-signup", "profile", "manually-boost", "new-escorts", "reels"];
        if($city && in_array($city, $invalid_route)) {
            return redirect()->route('active.escorts', ["city" => 'home'] );
        }
        $city = isset($city) && $city != "home" ? $city:null;

        $filters = [];
        if ($request->filled('name')) {
            $filters['search_term'] = $request->name;
        }

        if ($request->filled('country_id')) {
            $filters['country_id'] = $request->country_id;
        }

        if ($request->filled('state_id')) {
            $filters['state_id'] = $request->state_id;
        }

        if ($request->filled('city_id')) {
            $filters['city_id'] = $request->city_id;
        }

        //if ($request->filled('price_min') && $request->filled('price_max')) {
        //  $filters['rates'] = ['between', [(int) $request->price_min, (int) $request->price_max]];
        // }

        if ($request->filled('gender')) {
            $filters['gender_id'] = $request->gender;
        }

        // if ($request->filled('videocall')) {
        //     $filters['videocall'] = $request->videocall;
        // }

        if ($request->filled('incall')) {
            $filters['incall_outcall'] = 1;
        }

        if ($request->filled('outcall')) {
            $filters['incall_outcall'] = 0;
        }

        if (!empty(array_filter((array) $request->category))) {
            $filters['category_id'] = ['IN', (array) $request->category];
        }

        if (!empty(array_filter((array) $request->sub_category))) {
            $filters['sub_category_id'] = ['IN', (array) $request->sub_category];
        }

        if ($request->filled('age')) {
            $filters['displayed_age'] = $request->age;
        }

        if (!empty(array_filter((array) $request->breast_size))) {
            $filters['breast_size'] = ['IN', (array) $request->breast_size];
        }

        if ($request->filled('hair_type')) {
            $filters['hair_type_id'] = $request->hair_type;
        }

        if ($request->filled('body_type_id')) {
            $filters['body_type_id'] = $request->body_type_id;
        }

        if ($request->filled('hair_color')) {
            $filters['hair_color_id'] = $request->hair_color;
        }
        if ($request->filled('eye_color_id')) {
            $filters['eye_color_id'] = $request->eye_color_id;
        }
        if ($request->filled('pubic_hair_id')) {
            $filters['pubic_hair_id'] = $request->pubic_hair_id;
        }
        if ($request->filled('nationality')) {
            $filters['nationality'] = $request->nationality;
        }

        if ($request->filled('ethnicity')) {
            $filters['ethnicity_id'] = $request->ethnicity;
        }

        if ($request->filled('sex_location')) {
            $filters['sex_location'] = $request->sex_location;
        }
        if (!empty(array_filter((array) $request->language))) {

            $filters['languages'] = ['IN', (array) $request->language]; // where language is an array
        }

        if ($request->filled('tattoo')) {
            $filters['tattoo'] = $request->tattoo;
        }

        if ($request->filled('piercing')) {
            $filters['piercing'] = $request->piercing;
        }

        if ($request->filled('sexual_orientation')) {
            $filters['sexual_orientation'] = $request->sexual_orientation;
        }


        if (!empty(array_filter((array) $request->payment_method))) {
            $filters['payment_method'] = ['IN', $request->payment_method];
        }
        if ($request->filled('weight_range')) {
            switch ($request->weight_range) {
                case 'under_45':
                    $filters['weight_kg'] = ['<', 45];
                    break;
                case '45_55':
                    $filters['weight_kg'] = ['BETWEEN', [45, 55]];
                    break;
                case '55_65':
                    $filters['weight_kg'] = ['BETWEEN', [55, 65]];
                    break;
                case '65_75':
                    $filters['weight_kg'] = ['BETWEEN', [65, 75]];
                    break;
                case 'over_75':
                    $filters['weight_kg'] = ['>', 75];
                    break;
            }
        }
        if ($request->filled('height_range')) {
            switch ($request->height_range) {
                case 'under_150':
                    $filters['height_cm'] = ['<', 150];
                    break;
                case '150_160':
                    $filters['height_cm'] = ['BETWEEN', [150, 160]];
                    break;
                case '160_170':
                    $filters['height_cm'] = ['BETWEEN', [160, 170]];
                    break;
                case '170_180':
                    $filters['height_cm'] = ['BETWEEN', [170, 180]];
                    break;
                case 'over_180':
                    $filters['height_cm'] = ['>', 180];
                    break;
            }
        }


        // Always filter only type 2 (as per your logic)
        $filters['users.type'] = 2;
        $filters['admin_status'] = 'approved';
        $filters['user_status'] = 0;
        $filters['is_online'] = 1;

        // dd($filters);
        $page = $request->get('page', 1);
        if($request->ajax() == false) {
            session(['fetched_rec' => []]);
            $results = $this->userRepository->getByWhereSearch($filters, [], 8,$page, $city);
        }
        $output["code"] = (isset($results) && !$results->isNotEmpty()) ? 400:200;

        if($request->ajax() == true) {
            //dd(1231);
            $results = $this->userRepository->getByWhereSearch($filters, [], 8,$page);
            $output["code"] = (isset($results) && !$results->isNotEmpty()) ? 400:200;
            //$page = ($output["code"] == 400) ? 1 : $page;
        }
        $fetched_result = collect($results)->pluck('id');
        /* ✅ MERGE WITH EXISTING SESSION */
        $existing = session('fetched_rec', []);   // get old or empty array
        $merged   = array_values(array_unique(array_merge($existing, $fetched_result->toArray())));
        
        session(['fetched_rec' => $merged]);
        $allUserIds = $results->flatMap(function ($item) {
            return $item->favouritedBy->pluck('favourite_user_id');
        })
        ->unique()
        ->values()->toArray();
        $favorites = json_decode($request->cookie('favorites', '[]'), true);
        // Merge + unique + normalize to integers
        $favorite_users = collect($allUserIds)
            ->merge($favorites)
            ->map(function ($id) { return (int) $id; })  // ensure integer
            ->unique()
            ->values()
            ->toArray();
        $locationSeoCity = (int)null;
        if($request->has('country_id') && $request->country_id) {
            $locationSeoCity = (int)$request->country_id;
        } else if($request->has('state_id') && $request->state_id) {
            $locationSeoCity = (int)$request->state_id;
        } else if($request->has('city_id') && $request->city_id) {
            $locationSeoCity = (int)$request->city_id;
        } else {
            $locationSeoCity = $city;
        }
        $locationSeoContent = $this->userServices->getLocationSeoContent($locationSeoCity, "Active Escorts");
        if ($request->ajax()) {
            // Convert paginated data to a collection and shuffle it
            $output["list"] = view('partials.model_cards', compact('results', 'favorite_users'))->render();
            $output["page"] = $page + 1;
            $output["content"] = $locationSeoContent['data']->content ?? null;
            return response()->json($output);
        }
        $url = route('active.escorts', ['city' => $city ?? "home"]);
        return view('front.model-list', compact('results', 'url', 'favorite_users', 'city', 'locationSeoContent'));
    }


    public function lowcostEscort(Request $request, $city = null)
    {
        if ($request->has('city') && !empty($request->city)) {
            $mycity = urlencode($request->city);
            return redirect()->route('lowcost.escorts', ["city" => $mycity] );
        }
        $invalid_route = ["edit-profile", "update-password", "photo", "video", "availabilities", "rate", "active-escorts", "recommend-escorts", "lowcost-escorts", "about-us", "favourite-list", "news-stories", "video", "user-login", "choose", "user-signup", "profile", "manually-boost", "new-escorts", "reels"];
        if($city && in_array($city, $invalid_route)) {
            return redirect()->route('lowcost.escorts', ["city" => 'home'] );
        }
        $city = isset($city) && $city != "home" ? $city:null;

        $filters = [];
        if ($request->filled('name')) {
            $filters['search_term'] = $request->name;
        }

        if ($request->filled('country_id')) {
            $filters['country_id'] = $request->country_id;
        }

        if ($request->filled('state_id')) {
            $filters['state_id'] = $request->state_id;
        }

        if ($request->filled('city_id')) {
            $filters['city_id'] = $request->city_id;
        }

        //if ($request->filled('price_min') && $request->filled('price_max')) {
        //$filters['rates'] = ['between', [(int) $request->price_min, (int) $request->price_max]];
        //}

        if ($request->filled('gender')) {
            $filters['gender_id'] = $request->gender;
        }

        // if ($request->filled('videocall')) {
        //     $filters['videocall'] = $request->videocall;
        // }

        if ($request->filled('incall')) {
            $filters['incall_outcall'] = 1;
        }

        if ($request->filled('outcall')) {
            $filters['incall_outcall'] = 0;
        }

        if (!empty(array_filter((array) $request->category))) {
            $filters['category_id'] = ['IN', (array) $request->category];
        }

        if (!empty(array_filter((array) $request->sub_category))) {
            $filters['sub_category_id'] = ['IN', (array) $request->sub_category];
        }

        if ($request->filled('age')) {
            $filters['displayed_age'] = $request->age;
        }

        if (!empty(array_filter((array) $request->breast_size))) {
            $filters['breast_size'] = ['IN', (array) $request->breast_size];
        }

        if ($request->filled('hair_type')) {
            $filters['hair_type_id'] = $request->hair_type;
        }

        if ($request->filled('body_type_id')) {
            $filters['body_type_id'] = $request->body_type_id;
        }

        if ($request->filled('hair_color')) {
            $filters['hair_color_id'] = $request->hair_color;
        }
        if ($request->filled('eye_color_id')) {
            $filters['eye_color_id'] = $request->eye_color_id;
        }
        if ($request->filled('pubic_hair_id')) {
            $filters['pubic_hair_id'] = $request->pubic_hair_id;
        }
        if ($request->filled('nationality')) {
            $filters['nationality'] = $request->nationality;
        }

        if ($request->filled('ethnicity')) {
            $filters['ethnicity_id'] = $request->ethnicity;
        }

        if ($request->filled('sex_location')) {
            $filters['sex_location'] = $request->sex_location;
        }
        if (!empty(array_filter((array) $request->language))) {

            $filters['languages'] = ['IN', (array) $request->language]; // where language is an array
        }

        if ($request->filled('tattoo')) {
            $filters['tattoo'] = $request->tattoo;
        }

        if ($request->filled('piercing')) {
            $filters['piercing'] = $request->piercing;
        }

        if ($request->filled('sexual_orientation')) {
            $filters['sexual_orientation'] = $request->sexual_orientation;
        }


        if (!empty(array_filter((array) $request->payment_method))) {
            $filters['payment_method'] = ['IN', $request->payment_method];
        }
        if ($request->filled('weight_range')) {
            switch ($request->weight_range) {
                case 'under_45':
                    $filters['weight_kg'] = ['<', 45];
                    break;
                case '45_55':
                    $filters['weight_kg'] = ['BETWEEN', [45, 55]];
                    break;
                case '55_65':
                    $filters['weight_kg'] = ['BETWEEN', [55, 65]];
                    break;
                case '65_75':
                    $filters['weight_kg'] = ['BETWEEN', [65, 75]];
                    break;
                case 'over_75':
                    $filters['weight_kg'] = ['>', 75];
                    break;
            }
        }
        if ($request->filled('height_range')) {
            switch ($request->height_range) {
                case 'under_150':
                    $filters['height_cm'] = ['<', 150];
                    break;
                case '150_160':
                    $filters['height_cm'] = ['BETWEEN', [150, 160]];
                    break;
                case '160_170':
                    $filters['height_cm'] = ['BETWEEN', [160, 170]];
                    break;
                case '170_180':
                    $filters['height_cm'] = ['BETWEEN', [170, 180]];
                    break;
                case 'over_180':
                    $filters['height_cm'] = ['>', 180];
                    break;
            }
        }


        // Always filter only type 2 (as per your logic)
        $filters['users.type'] = 2;
        $filters['admin_status'] = 'approved';
        $filters['user_status'] = 0;
        $orderBy = ['average_quickie_rate' => 'asc'];
        $page = $request->get('page', 1);
        if($request->ajax() == false) {
            session(['fetched_rec' => []]);
            $results = $this->userRepository->getByWhereSearch($filters, $orderBy, 8,$page, $city);
        }        
        $output["code"] = (isset($results) && !$results->isNotEmpty()) ? 400:200;

        if($request->ajax() == true) {
            //dd(1231);
            $results = $this->userRepository->getByWhereSearch($filters, $orderBy, 8,$page);
            $output["code"] = (isset($results) && !$results->isNotEmpty()) ? 400:200;
            //$page = ($output["code"] == 400) ? 1 : $page;
        }
        $fetched_result = collect($results)->pluck('id');
        /* ✅ MERGE WITH EXISTING SESSION */
        $existing = session('fetched_rec', []);   // get old or empty array
        $merged   = array_values(array_unique(array_merge($existing, $fetched_result->toArray())));
        
        session(['fetched_rec' => $merged]);
        $allUserIds = $results->flatMap(function ($item) {
            return $item->favouritedBy->pluck('favourite_user_id');
        })
        ->unique()
        ->values()->toArray();
        $favorites = json_decode($request->cookie('favorites', '[]'), true);
        // Merge + unique + normalize to integers
        $favorite_users = collect($allUserIds)
            ->merge($favorites)
            ->map(function ($id) { return (int) $id; })  // ensure integer
            ->unique()
            ->values()
            ->toArray();
        // dd($results);
        $locationSeoCity = (int)null;
        if($request->has('country_id') && $request->country_id) {
            $locationSeoCity = (int)$request->country_id;
        } else if($request->has('state_id') && $request->state_id) {
            $locationSeoCity = (int)$request->state_id;
        } else if($request->has('city_id') && $request->city_id) {
            $locationSeoCity = (int)$request->city_id;
        } else {
            $locationSeoCity = $city;
        }
        $locationSeoContent = $this->userServices->getLocationSeoContent($locationSeoCity, "Lowcost Escorts");
        if ($request->ajax()) {
            // Convert paginated data to a collection and shuffle it
            $output["list"] = view('partials.model_cards', compact('results', 'favorite_users'))->render();
            $output["page"] = $page + 1;
            $output["content"] = $locationSeoContent['data']->content ?? null;
            return response()->json($output);
        }
        $url = route('lowcost.escorts', ['city' => $city ?? "home"]);
        return view('front.model-list', compact('results', 'url', 'favorite_users', 'city', 'locationSeoContent'));
    }
    public function recommendEscort(Request $request, $city = null)
    {
        if ($request->has('city') && !empty($request->city)) {
            $mycity = urlencode($request->city);
            return redirect()->route('recommend.escorts', ["city" => $mycity] );
        }
        $invalid_route = ["edit-profile", "update-password", "photo", "video", "availabilities", "rate", "active-escorts", "recommend-escorts", "lowcost-escorts", "about-us", "favourite-list", "news-stories", "video", "user-login", "choose", "user-signup", "profile", "manually-boost", "new-escorts", "reels"];
        if($city && in_array($city, $invalid_route)) {
            return redirect()->route('recommend.escorts', ["city" => 'home'] );
        }
        $city = isset($city) && $city != "home" ? $city:null;

        $filters = [];
        if ($request->filled('name')) {
            $filters['search_term'] = $request->name;
        }

        if ($request->filled('country_id')) {
            $filters['country_id'] = $request->country_id;
        }

        if ($request->filled('state_id')) {
            $filters['state_id'] = $request->state_id;
        }

        if ($request->filled('city_id')) {
            $filters['city_id'] = $request->city_id;
        }

        //if ($request->filled('price_min') && $request->filled('price_max')) {
        //     $filters['rates'] = ['between', [(int) $request->price_min, (int) $request->price_max]];
        // }

        if ($request->filled('gender')) {
            $filters['gender_id'] = $request->gender;
        }

        // if ($request->filled('videocall')) {
        //     $filters['videocall'] = $request->videocall;
        // }

        if ($request->filled('incall')) {
            $filters['incall_outcall'] = 1;
        }

        if ($request->filled('outcall')) {
            $filters['incall_outcall'] = 0;
        }

        if (!empty(array_filter((array) $request->category))) {
            $filters['category_id'] = ['IN', (array) $request->category];
        }

        if (!empty(array_filter((array) $request->sub_category))) {
            $filters['sub_category_id'] = ['IN', (array) $request->sub_category];
        }

        if ($request->filled('age')) {
            $filters['displayed_age'] = $request->age;
        }

        if (!empty(array_filter((array) $request->breast_size))) {
            $filters['breast_size'] = ['IN', (array) $request->breast_size];
        }

        if ($request->filled('hair_type')) {
            $filters['hair_type_id'] = $request->hair_type;
        }

        if ($request->filled('body_type_id')) {
            $filters['body_type_id'] = $request->body_type_id;
        }

        if ($request->filled('hair_color')) {
            $filters['hair_color_id'] = $request->hair_color;
        }
        if ($request->filled('eye_color_id')) {
            $filters['eye_color_id'] = $request->eye_color_id;
        }
        if ($request->filled('pubic_hair_id')) {
            $filters['pubic_hair_id'] = $request->pubic_hair_id;
        }
        if ($request->filled('nationality')) {
            $filters['nationality'] = $request->nationality;
        }

        if ($request->filled('ethnicity')) {
            $filters['ethnicity_id'] = $request->ethnicity;
        }

        if ($request->filled('sex_location')) {
            $filters['sex_location'] = $request->sex_location;
        }
        if (!empty(array_filter((array) $request->language))) {

            $filters['languages'] = ['IN', (array) $request->language]; // where language is an array
        }

        if ($request->filled('tattoo')) {
            $filters['tattoo'] = $request->tattoo;
        }

        if ($request->filled('piercing')) {
            $filters['piercing'] = $request->piercing;
        }

        if ($request->filled('sexual_orientation')) {
            $filters['sexual_orientation'] = $request->sexual_orientation;
        }


        if (!empty(array_filter((array) $request->payment_method))) {
            $filters['payment_method'] = ['IN', $request->payment_method];
        }
        if ($request->filled('weight_range')) {
            switch ($request->weight_range) {
                case 'under_45':
                    $filters['weight_kg'] = ['<', 45];
                    break;
                case '45_55':
                    $filters['weight_kg'] = ['BETWEEN', [45, 55]];
                    break;
                case '55_65':
                    $filters['weight_kg'] = ['BETWEEN', [55, 65]];
                    break;
                case '65_75':
                    $filters['weight_kg'] = ['BETWEEN', [65, 75]];
                    break;
                case 'over_75':
                    $filters['weight_kg'] = ['>', 75];
                    break;
            }
        }
        if ($request->filled('height_range')) {
            switch ($request->height_range) {
                case 'under_150':
                    $filters['height_cm'] = ['<', 150];
                    break;
                case '150_160':
                    $filters['height_cm'] = ['BETWEEN', [150, 160]];
                    break;
                case '160_170':
                    $filters['height_cm'] = ['BETWEEN', [160, 170]];
                    break;
                case '170_180':
                    $filters['height_cm'] = ['BETWEEN', [170, 180]];
                    break;
                case 'over_180':
                    $filters['height_cm'] = ['>', 180];
                    break;
            }
        }


        // Always filter only type 2 (as per your logic)
        $filters['users.type'] = 2;
        $filters['admin_status'] = 'approved';
        $filters['user_status'] = 0;
        $orderBy = ['rating' => 'desc'];
        $page = $request->get('page', 1);
        if($request->ajax() == false) {
            session(['fetched_rec' => []]);
            $results = $this->userRepository->getByWhereSearch($filters, $orderBy, 8,$page, $city);
        } 
        $output["code"] = (isset($results) && !$results->isNotEmpty()) ? 400:200;

        if($request->ajax() == true) {
            //dd(1231);
            $results = $this->userRepository->getByWhereSearch($filters, $orderBy, 8,$page);
            $output["code"] = (isset($results) && !$results->isNotEmpty()) ? 400:200;
            //$page = ($output["code"] == 400) ? 1 : $page;
        }
        $fetched_result = collect($results)->pluck('id');
        /* ✅ MERGE WITH EXISTING SESSION */
        $existing = session('fetched_rec', []);   // get old or empty array
        $merged   = array_values(array_unique(array_merge($existing, $fetched_result->toArray())));
        
        session(['fetched_rec' => $merged]);
        $allUserIds = $results->flatMap(function ($item) {
            return $item->favouritedBy->pluck('favourite_user_id');
        })
        ->unique()
        ->values()->toArray();
        $favorites = json_decode($request->cookie('favorites', '[]'), true);
        // Merge + unique + normalize to integers
        $favorite_users = collect($allUserIds)
            ->merge($favorites)
            ->map(function ($id) { return (int) $id; })  // ensure integer
            ->unique()
            ->values()
            ->toArray();
        $locationSeoCity = (int)null;
        if($request->has('country_id') && $request->country_id) {
            $locationSeoCity = (int)$request->country_id;
        } else if($request->has('state_id') && $request->state_id) {
            $locationSeoCity = (int)$request->state_id;
        } else if($request->has('city_id') && $request->city_id) {
            $locationSeoCity = (int)$request->city_id;
        } else {
            $locationSeoCity = $city;
        }
        $locationSeoContent = $this->userServices->getLocationSeoContent($locationSeoCity, "Recommend Escorts");
        if ($request->ajax()) {
            // Convert paginated data to a collection and shuffle it
            $output["list"] = view('partials.model_cards', compact('results', 'favorite_users'))->render();
            $output["page"] = $page + 1;
            $output["content"] = $locationSeoContent['data']->content ?? null;
            return response()->json($output);
        }
        $url = route('recommend.escorts', ['city' => $city ?? "home"]);
        return view('front.model-list', compact('results', 'url', 'favorite_users', 'city', 'locationSeoContent'));
    }
}
