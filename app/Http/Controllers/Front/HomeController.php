<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Front\UserServices;
use Illuminate\Support\Facades\Log;
use App\Repository\Eloquent\UserRepository;
use App\Repository\Eloquent\{AdminRepository, PlanRepository, CommonRepository, NewsandstoryRepository, TermsConditionsRepository, FeatureDevilRepository, CountryRepository, StateRepository, CityRepository};
use App\Http\Requests\FrontEnd\{
    UserRequest,
    LoginRequest,
    ContactRequest,
    UserChangePasswordRequest,
    UserForgotPasswordRequest,
    UserResetPasswordRequest
};
use Validator;
use App\Models\{EscortServiceCategory, UserEscortService};
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    protected $userServices;
    protected $userRepository;
    protected $PlanRepository;
    protected $AdminRepository, $CommonRepository, $NewsandstoryRepository, $termsConditionsRepository, $featureDevilRepository;
    private $dataObject, $countryRepository, $stateRepository, $cityRepository;
    public function __construct(NewsandstoryRepository $NewsandstoryRepository, CommonRepository $CommonRepository, AdminRepository $AdminRepository, UserServices $userServices, UserRepository $userRepository, PlanRepository $PlanRepository, TermsConditionsRepository $termsConditionsRepository,
        FeatureDevilRepository $featureDevilRepository,
        CountryRepository $countryRepository,
        StateRepository $stateRepository, CityRepository $cityRepository)
    {
        $this->userServices = $userServices;
        $this->userRepository = $userRepository;
        $this->AdminRepository = $AdminRepository;
        $this->PlanRepository = $PlanRepository;
        $this->CommonRepository = $CommonRepository;
        $this->NewsandstoryRepository = $NewsandstoryRepository;
        $this->termsConditionsRepository = $termsConditionsRepository;
        $this->featureDevilRepository = $featureDevilRepository;
        $this->countryRepository = $countryRepository;
        $this->stateRepository = $stateRepository;
        $this->cityRepository = $cityRepository;

    }

    public function index(Request $request, $city = null)
    {
        if ($request->has('city') && !empty($request->city)) {
            session()->put('SeoType', $request->type);
            return redirect()->to('/' . urlencode($request->city));
        } else if($request->has('city') && empty($request->city)) {
            session()->put('SeoType', 'worldwide');
            return redirect()->to('/home' . urlencode($request->city));
        }
        

        $top3User = [];//$this->userRepository->top3User(['users.type' => 2, 'top3status' => 1, 'user_status' => 0, 'admin_status' => 'approved'], ['users.*'], [], $city);
        //$this->userRepository->getByWhereWithLimit(['type' => 2, 'top3status' => 1, 'user_status' => 0, 'admin_status' => 'approved'], 3);
        $top6User = []; //$this->userRepository->getTopUsersCreatedToday();
        // dd($top6User);
        $NewUser = []; //$this->userRepository->getNewFaces();
        $city = isset($city) && $city != "home" ? $city:null;
        $locationSeo = $this->userServices->getLocationSeoContent($city, "Home");
        if (empty($locationSeo['data'])) {
            $locationSeo = $this->userServices->getLocationSeoContent($city, "Entry Page");
        }
        $topRatedUsers = $this->userRepository->getTopRatedUsers($city);

        $bestUsers = []; //$this->userRepository->getBestUsers();
        $allUsers = []; //$this->userRepository->getByWhereWithLimit(['type' => 2, 'user_status' => 0, 'admin_status' => 'approved'], 6);
        // dd($allUser);
        $current_date = now()->format('Y-m-d');
        $whereFeature = ['users.type' => 2, 
            'user_status' => 0, 
            'admin_status' => 'approved', 
            'feature_devils.date' => $current_date
        ]; 
        $featuredUsers = $this->userRepository->getFeaturedModels($whereFeature, $city);
        //dd($featuredUsers);
         //weekly top 3 divine obessions  
        $divineObessions = $this->userRepository->top3User([
            'users.type' => 2,
            'user_status' => 0,
            'admin_status' => 'approved',
            'gender_id' => 1,
            ['plan_start_date', '<=', $current_date],
            ['plan_end_date', '>=', $current_date]
        ], ['users.*'], $city);
        /* $this->userRepository->getByWhereWithLimit([
            'type' => 2,
            'user_status' => 0,
            'admin_status' => 'approved',
            'plan_id' => 3,
            'is_boosted' => 0,
            'plan_start_date <=' => $current_date,
            'plan_end_date >=' => $current_date
        ], 3, ['plan_start_date' => 'asc']); */
        //6 Devils You Can’t Miss Today
        $devilYou = $this->userRepository->devilForYou([
            'users.type' => 2,
            'user_status' => 0,
            'admin_status' => 'approved',
            'gender_id' => 1,
            ['plan_start_date', '<=', $current_date],
            ['plan_end_date', '>=', $current_date]
        ], $city, $current_date);
        /* $this->userRepository->getByWhereWithLimit([
            'type' => 2,
            'user_status' => 0,
            'admin_status' => 'approved',
            'plan_id' => 2,
            'is_boosted' => 0,
            'plan_start_date <=' => $current_date,
            'plan_end_date >=' => $current_date
        ], 6, ['plan_start_date' => 'asc']); */

        $FreshSins = $this->userRepository->top3User([
            'users.type' => 2,
            'user_status' => 0,
            'admin_status' => 'approved',
            'gender_id' => 1,
            ['users.created_at', '>=', now()->subDays(14)],
            ['plan_start_date', '<=', $current_date],
            ['plan_end_date', '>=', $current_date]
        ], ['users.*'], $city, 6, 'FreshSins');
        /*$this->userRepository->getByWhereWithLimit([
            'type' => 2,
            'user_status' => 0,
            'gender_id' => 1,
            'admin_status' => 'approved',
            'created_at >=' => now()->subDays(14)
        ], 6); */
        // dd($FreshSins);
        $spotlightx = $this->userRepository->top3User([
            'users.type' => 2,
            'user_status' => 0,
            'admin_status' => 'approved',
            ['gender_id', "!=", 1],
            ['plan_start_date', '<=', $current_date],
            ['plan_end_date', '>=', $current_date]
        ], ['users.*'], $city, 6);
        /* $this->userRepository->getByWhereWithLimit([
            'type' => 2,
            'user_status' => 0,
            'gender_id' => ['!=', 1],
            'admin_status' => 'approved'
        ], 5); */
        // dd($spotlightx);

        $favorite_users = json_decode($request->cookie('favorites', '[]'), true);

        $categories = EscortServiceCategory::with('services.selections')->get();

        return view('front.index', compact('spotlightx', 'top3User', 'categories', 'top6User', 'devilYou', 'NewUser', 'allUsers', 'FreshSins', 'divineObessions', 'topRatedUsers', 'bestUsers', 'featuredUsers', 'city', 'favorite_users', 'locationSeo'));
    }

    public function aboutUs()
    {
        $locationSeoContent = $this->userServices->getLocationSeoContent(null, "About Us");
        return view('front.about', compact('locationSeoContent'));
    }

    public function contactUs()
    {
        $locationSeoContent = $this->userServices->getLocationSeoContent(null, "Contact Us");
        return view('front.contact', compact('locationSeoContent'));
    }

    public function Login()
    {

        return view('front.login');
    }

    public function Signup()
    {
        $countryCodes = $this->AdminRepository->getCountryCode();
        // dd($countryCodes);
        return view('front.signup', compact('countryCodes'));
    }

    public function SignupAdveriser()
    {
        $countryCodes = $this->AdminRepository->getCountryCode();
        // dd($countryCodes);
        return view('front.signupAdveriser', compact('countryCodes'));
    }

    public function userForgotPassword()
    {

        return view('front.forget_password');
    }

    public function waiting()
    {
        $user = auth()->user();

        if ($user->admin_status == 'pending') {
            return view('front.waiting');
        } else {

            return redirect()->route('home');
        }
    }


    public function saveContactusUserData(ContactRequest $request)
    {
        try {

            $result = $this->userServices->saveContactUsData($request);
            if ($result) {
                return response()->json([
                    'status' => 1,
                    'message' => __('message.contact_msgs'),
                    'data' => [],
                    'success' => true,
                ]);
            } else {
                return response()->json([
                    'status' => 0,
                    'message' =>  __('message.statusZero'),
                    'data' => [],
                    'success' => false,
                ]);
            }
        } catch (\Exception $e) {
            Log::error("Error in HomeController.saveContactUsData(): " . $e->getMessage());
            return response()->json(['status' => 0, 'message' => __('message.statusZero'), 'data' => $this->dataObject, 'error' => $this->dataObject], 500);
        }
    }

    public function Register(UserRequest $request)
    {
        try {
            return $this->userServices->register($request);
        } catch (\Exception $e) {
            Log::error("Error in HomeController.Register(): " . $e->getMessage());
            return response()->json(['status' => 0, 'message' => __('message.statusZero'), 'data' => $this->dataObject, 'error' => $this->dataObject], 500);
        }
    }

    public function loginSubmit(LoginRequest $request)

    {

        try {

            $credentials = $request->only('email', 'password');

            if (Auth::attempt($credentials)) {
                $user = auth()->user();
                if ($user->user_status === 1) {
                    return response()->json(['message' => __('message.signin_block'), 'status' => 0]);
                }
                if (is_null($user->email_verified_at)) {
                    return response()->json([
                        'status' => 2,
                        'redirect_url' => route('user.email-verification'), // Or your desired route
                        'message' => 'Please verify your email.',
                    ]);
                }

                if ($user->type == 2 && is_null($user->plan_id)) {
                    return response()->json([
                        'status' => 2,
                        'redirect_url' => route('user.pricing'),
                        'message' => __('message.statusLogin'),
                    ]);
                }

                if ($user->type == 2 && $user->admin_status = 'pending') {
                    return response()->json([
                        'status' => 2,
                        'redirect_url' => route('user.waiting'),
                        'message' => __('message.statusLogin'),
                    ]);
                }



                return response()->json([
                    'status' => 1,
                    'message' => __('message.statusLogin'),
                ]);
            }

            return response()->json([
                'status' => 0,
                'message' => __('message.statusInvalid'),
            ]);
        } catch (Exception $e) {
            Log::error("HomeController:loginSubmit()" . $e->getLine() . " " . $e->getMessage());
            return response()->json(['status' => 0, 'message' => __('message.statusZero')]);
        }
    }
    public function logout()

    {

        try {
            $logout = Auth::logout();
            return redirect()->route('user-login');
        } catch (Exception $e) {
            Log::error("HomeController:logout()" . $e->getLine() . " " . $e->getMessage());
            return response()->json(['status' => 0, 'message' => __('message.statusZero')]);
        }
    }
    public function sendPassword(UserForgotPasswordRequest $request)
    {
        try {
            return $this->userServices->sendPassword($request);
        } catch (\Exception $e) {
            log::error('Error in HomeController/sendPassword :' . $e->getMessage() . 'in line' . $e->getLine());
            return response()->json(['status' => 0, 'message' => __('message.statusZero'), 'data' => $this->dataObject, 'error' => $this->dataObject], 500);
        }
    }
    public function changePassword(UserChangePasswordRequest $request)
    {
        try {
            $data = $request->all();
            // dd($data);
            $run = $this->userServices->changePassword($data);
            if ($run) {
                return response()->json(['status' => 1, 'message' => __('message.statusTwo', ['parameter' => 'Password']), 'data' => [], 'error' => []], 200);
            } else {
                return response()->json(['status' => 0, 'message' => __('message.password_not_match'), 'data' => [], 'error' => []], 500);
            }
        } catch (\Exception $e) {
            log::error('Error in HomeController/updateChangePassword :' . $e->getMessage() . 'in line' . $e->getLine());
            return response()->json(['status' => 0, 'message' => __('message.statusZero'), 'data' => [], 'error' => []], 500);
        }
    }



    public function pricing()
    {
        try {
            $data = $this->PlanRepository->getAll();
            $admindata = $this->AdminRepository->getOne(['id' => 1]);
            return view('front.pricing', compact('data', 'admindata'));
        } catch (\Exception $e) {
            Log::error("Error in HomeController.Register(): " . $e->getMessage());
            return response()->json(['status' => 0, 'message' => __('message.statusZero'), 'data' => $this->dataObject, 'error' => $this->dataObject], 500);
        }
    }
    public function pricingAfter()
    {
        try {
            $userid = Auth::guard('web')->user();
            $user = $this->userRepository->getOne(['id' => $userid->id]);
            $data = $this->PlanRepository->getAll();
            $admindata = $this->AdminRepository->getOne(['id' => 1]);
            return view('front.after-pricing', compact('data', 'admindata', 'user'));
        } catch (\Exception $e) {
            Log::error("Error in HomeController.Register(): " . $e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong.');            
            
            //return response()->json(['status' => 0, 'message' => __('message.statusZero'), 'data' => $this->dataObject, 'error' => $this->dataObject], 500);
        }
    }

    


    public function modelDetail($id, Request $request)
    {
        try {

            $user = $this->userRepository->getOne(['id' => $id]);
            // dd($user);
            if ($user) {
                $this->userRepository->logView(
                    $viewedId = $user->id,
                    $viewerId = auth()->id(), // null if guest
                    $viewedType = 'user',
                    $ip = request()->ip()
                );
                $uploadedPhotos = $this->userRepository->getByWhereuploadedPhoto(['user_id' => $user->id, "is_approved" => 1]);
                $uploadedVideos = $this->userRepository->getByWhereuploadedVideo(['user_id' => $user->id, "is_approved" => 1]);
                $availabilities = $this->userRepository->getByWhereuserAvailability(['user_id' => $user->id]);
                $language = $this->CommonRepository->setModel(new \App\Models\Language())->getAll();
                $countryCodes = $this->AdminRepository->getCountryCode();
                $categories = EscortServiceCategory::with('services.selections')->get();
                $selectedServices = UserEscortService::where('user_id', $user->id)
                    ->whereNull('selection_id')
                    ->pluck('service_id')
                    ->toArray();

                $selectedSelections = UserEscortService::where('user_id', $user->id)
                    ->whereNotNull('selection_id')
                    ->pluck('selection_id')
                    ->toArray();
                $favorites = json_decode($request->cookie('favorites', '[]'), true);
                $favorite_users = collect(["id" => isset($user->favouritedBy) && $user->favouritedBy->isNotEmpty() ? $user->favouritedBy->pluck('id')->toArray() : []])
                    ->merge($favorites)
                    ->map(function ($id) { return (int) $id; })  // ensure integer
                    ->unique()
                    ->values()
                    ->toArray();
                $newsstory =  $data = $this->NewsandstoryRepository->getByWhere(['user_id' => $user->id]);
                $locationSeoContent = $this->userServices->getLocationSeoContent($user->city_id ?? null, "Model Profile");
                $pageTitle = $user->nickname ?? $user->name;
                $seoOgImage = !empty($user->profile_image) ? config('app.img_url') . $user->profile_image : null;
                return view('front.model_detail', compact('newsstory', 'user', 'selectedServices', 'selectedSelections', 'categories', 'uploadedPhotos', 'uploadedVideos', 'availabilities', 'countryCodes', 'language' ,'favorite_users', 'locationSeoContent', 'pageTitle', 'seoOgImage'));
            }
        } catch (\Exception $e) {
            Log::error("Error in HomeController.Register(): " . $e->getMessage());
            return response()->json(['status' => 0, 'message' => __('message.statusZero'), 'data' => $this->dataObject, 'error' => $this->dataObject], 500);
        }
    }

    public function termsConditions() {
        try {
        $terms = $this->termsConditionsRepository->getAllData();
        $locationSeoContent = $this->userServices->getLocationSeoContent(null, "Terms & Conditions");
        return view('front.terms', compact('terms', 'locationSeoContent'));
        } catch (\Exception $exception) {
            Log::error("Error in " . __CLASS__ . "::" . __FUNCTION__ . ": " . $exception->getMessage());
            return redirect()->back()->with('error', 'Something went wrong.');            
        }
    }

    public function landing() {
        session()->forget('SeoType');
        $cityCountry = currentCityContry();
        $country = $this->countryRepository->getAllRecordWhere(["name" => $cityCountry["country"]], ['id', 'name']);
        //dump($country[0]->id);
        $state = $this->stateRepository->getAllRecordWhere(["country_id" => $country[0]->id ?? 1], ["id", "name", 'country_id'], 17);
        //dd($state->toArray());
        $Mystate = $this->stateRepository->getAllRecordWhere(["name" => $cityCountry["state"] ?? 1 ], ["id", "name", 'country_id'], 1);
        $MyCity = $this->cityRepository->getAllRecordWhere(["state_id" => $Mystate[0]->id ?? 1], ["id", "name"], 6);
        $allCountry = $this->countryRepository->getCountryWithUserCount([]);
        $locationSeo = $this->userServices->getLocationSeoContent("home", "Entry Page");
        if (empty($locationSeo['data'])) {
            $locationSeo = $this->userServices->getLocationSeoContent("home", "Home");
        }

        //dd($allCountry); 
                    /* $allCountry->map(function ($country) {
                $country['flag'] = asset('images/flags/'.strtolower(emojiToCountryCode($country['emoji']).'.svg')); // or make URL if using image flags
                return $country;
            }); */
        return view('front.enter', compact('country', 'state', 'MyCity', 'cityCountry', 'allCountry', 'locationSeo'));
    }
    public function getCitiesUsers(Request $request) {
        try {
            $current_date = now()->format('Y-m-d');
            $user_id = Auth::guard('web')->user() ?? 0;
            $where = [
                'users.type' => 2, 
                'user_status' => 0, 
                'admin_status' => 'approved',
                ['plan_start_date', '<=', $current_date],
                ['plan_end_date', '>=', $current_date],
                ['users.id', '!=', $user_id]
            ];
            $MyCity = $this->cityRepository->getUsersCount($where, $request->all());
            //dd($MyCity);
            return response()->json(["status" => $MyCity->isNotEmpty() ? 200:400, "data" => $MyCity->toArray()]);
        } catch (\Exception $exception) {
            Log::error("Error in " . __CLASS__ . "::" . __FUNCTION__ . ": " . $exception->getMessage());
            return response()->json(["status" => 400]);
        }  
    }
}
