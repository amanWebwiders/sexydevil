<?php

namespace App\Repository\Eloquent;

use Illuminate\Contracts\Cache\Repository as Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Models\Transaction;
use App\Models\User;
use App\Models\ContactUs;
use App\Models\UserEscortService;
use App\Models\EscortServiceSelection;
use App\Models\UploadedPhoto;
use App\Models\Video;
use App\Models\UserAvailability;
use App\Models\Review;
use App\Models\Wishlist;
use App\Models\View;
use App\Models\{UserDailyShow, userVisibilityLog};
use Illuminate\Support\Carbon;
use App\Repository\Eloquent\{CountryRepository, CityRepository};


class UserRepository extends BaseRepository

{

    protected $model, $userEscortService, $uploadedPhotomodel, $reviewmodel, $Viewmodel;
    protected $contactmodel, $transactionmodel, $escortServiceSelectionmodel, $videomodel, $userAvailability;
    protected $cache;
    protected $wishlist, $userDailyShow;
    protected $cityRepository, $countryRepository, $userVisibilityLog;

    public function __construct(View $Viewmodel, Wishlist $wishlist, Review $reviewmodel, UserAvailability $userAvailability, Video $videomodel, UploadedPhoto $uploadedPhotomodel, EscortServiceSelection $escortServiceSelectionmodel, UserEscortService $userEscortService, Transaction $transactionmodel, User $model, ContactUs $contactmodel, Cache $cache, UserDailyShow $userDailyShow, 
    CityRepository $cityRepository,
    CountryRepository $countryRepository,
    userVisibilityLog $userVisibilityLog)
    {

        $this->model = $model;
        $this->Viewmodel = $Viewmodel;
        $this->transactionmodel = $transactionmodel;
        $this->contactmodel = $contactmodel;
        $this->userEscortService = $userEscortService;
        $this->escortServiceSelectionmodel = $escortServiceSelectionmodel;
        $this->uploadedPhotomodel = $uploadedPhotomodel;
        $this->videomodel = $videomodel;
        $this->reviewmodel = $reviewmodel;
        $this->userAvailability = $userAvailability;
        $this->wishlist = $wishlist;
        $this->userDailyShow = $userDailyShow;
        $this->cityRepository = $cityRepository;
        $this->countryRepository = $countryRepository;
        $this->userVisibilityLog = $userVisibilityLog;
        parent::__construct($model, $cache);
    }

    //its a create function used insert data 

    public function create($allData)
    {
        try {
            return $this->model->create($allData);
        } catch (\Exception $e) {
            Log::error("Error in UserRepository.create(): " . $e->getMessage());
            throw $e;
        }
    }
    public function createAvailability($allData)
    {
        try {
            return  $this->userAvailability->create($allData);
        } catch (\Exception $e) {
            Log::error("Error in UserRepository.createAvailability(): " . $e->getMessage());
            throw $e;
        }
    }
    public function createReview($allData)
    {
        try {
            return $this->reviewmodel->create($allData);
        } catch (\Exception $e) {
            Log::error("Error in UserRepository.createReview(): " . $e->getMessage());
            throw $e;
        }
    }
    public function getOneAvailability($byWhere)
    {
        try {
            return $this->userAvailability->select('*')->where($byWhere)->first();
        } catch (\Exception $e) {
            Log::error("Error in UserRepository.getOnePhoto(): " . $e->getMessage());
            throw $e;
        }
    }

    public function getOneReview($byWhere)
    {
        try {
            return $this->reviewmodel->select('*')->where($byWhere)->first();
        } catch (\Exception $e) {
            Log::error("Error in UserRepository.getOneReview(): " . $e->getMessage());
            throw $e;
        }
    }
    public function deleteAvailability($byWhere)
    {
        try {
            return $this->userAvailability->where($byWhere)->delete();
        } catch (\Exception $e) {
            Log::error("Error in UserRepository.userAvailability(): " . $e->getMessage());
            return response()->json(['status' => '0', 'message' => __('message.statusZero')]);
        }
    }
    public function createVideo($allData)
    {
        try {
            return  $this->videomodel->create($allData);
        } catch (\Exception $e) {
            Log::error("Error in UserRepository.createVideo(): " . $e->getMessage());
            return false;
        }
    }
    public function createPhoto($allData)
    {
        try {
            return $this->uploadedPhotomodel->create($allData);
        } catch (\Exception $e) {
            Log::error("Error in UserRepository.create(): " . $e->getMessage());
            return false;

        }
    }

    public function createEscortService($allData)
    {
        try {
            return $this->userEscortService->create($allData);
        } catch (\Exception $e) {
            Log::error("Error in UserRepository.create(): " . $e->getMessage());
            throw $e;
        }
    }
    public function createtransaction($allData)
    {
        try {
            return $this->transactionmodel->create($allData);
        } catch (\Exception $e) {
            Log::error("Error in UserRepository.createtransaction(): " . $e->getMessage());
            throw $e;
        }
    }
    public function update($byWhere, $update)
    {
        try {
            // dd($update,$byWhere);
            return $this->model->where($byWhere)->update($update);
        } catch (\Exception $e) {
            Log::error("Error in UserRepository.update(): " . $e->getMessage());
            throw $e;
        }
    }

    public function getOnePhoto($byWhere)
    {
        try {
            return $this->uploadedPhotomodel->select('*')->where($byWhere)->first();
        } catch (\Exception $e) {
            Log::error("Error in UserRepository.getOnePhoto(): " . $e->getMessage());
            throw $e;
        }
    }
    public function getOneVideo($byWhere)
    {
        try {
            return $this->videomodel->select('*')->where($byWhere)->first();
        } catch (\Exception $e) {
            Log::error("Error in UserRepository.getOneVideo(): " . $e->getMessage());
            throw $e;
        }
    }
    public function getOne($byWhere)
    {
        try {
            return $this->model->with('likes', 'comments', 'favouritedBy', 'country', 'plan', 'gender', 'nationality', 'state', 'city', 'countries', 'ethnicity', 'bodyType', 'haircolor', 'hairLength', 'hairType', 'eyeColor', 'reviewsReceived', 'reviewsGiven','images','videos', 'favouritedBy')->select('*')->where($byWhere)->first();
        } catch (\Exception $e) {
            Log::error("Error in UserRepository.getOne(): " . $e->getMessage());
            throw $e;
        }
    }

    public function getSingleUser($byWhere, $select = ['*']) {
        try {
            return $this->model->select($select)->where($byWhere)->first();
        } catch (\Exception $e) {
            Log::error("Error in UserRepository.getOne(): " . $e->getMessage());
            throw $e;
        }
    }
    public function getOneescortServiceSelection($byWhere)
    {
        try {
            return $this->escortServiceSelectionmodel->with('service.category')->select('*')->where($byWhere)->first();
        } catch (\Exception $e) {
            Log::error("Error in UserRepository.getOne(): " . $e->getMessage());
            throw $e;
        }
    }



    public function getAll()
    {
        try {
            return $this->model->with('country', 'nationality')->orderBy('id', 'desc')->get();
        } catch (\Exception $e) {
            Log::error("Error in userRepository.getAll(): " . $e->getMessage());
            return response()->json(['status' => '0', 'message' => __('message.statusZero')]);
        }
    }

    public function getAllWhere(array $where, $select = ['*'], array $alreadyModels = []) {
        try {
            $query = $this->model->where($where)
            ->select($select);
            if(!empty($alreadyModels)) {
                $query->whereNotIn('id', $alreadyModels);
            }
            return $query->orderBy('id', 'desc')->get();
        } catch (\Exception $e) {
            Log::error("Error in userRepository.getAll(): " . $e->getMessage());
            return false;
        }
    }


    public function delete($byWhere)
    {
        try {
            return $this->model->where($byWhere)->delete();
        } catch (\Exception $e) {
            Log::error("Error in UserRepository.delete(): " . $e->getMessage());
            return response()->json(['status' => '0', 'message' => __('message.statusZero')]);
        }
    }
    public function deleteEscortService($byWhere)
    {
        try {
            return $this->userEscortService->where($byWhere)->delete();
        } catch (\Exception $e) {
            Log::error("Error in UserRepository.delete(): " . $e->getMessage());
            return response()->json(['status' => '0', 'message' => __('message.statusZero')]);
        }
    }
    public function usersByMyCurrentLocation(array $byWhere, $page)  {
        try { 
            $data = $this->model->with('country', 'plan', 'gender', 'nationality', 'state', 'city', 'countries', 'ethnicity', 'bodyType', 'haircolor', 'hairLength', 'hairType', 'eyeColor', 'reviewsReceived', 'reviewsGiven','videos','stories','stories.likes', 'stories.comments','images')->where($byWhere)->whereHas('stories')
            //->join('news_and_stories', 'news_and_stories.user_id', '=', 'users.id') // assuming stories.user_id → users.id
            /* ->select('users.*', 'news_and_stories.id as story_id', 'news_and_stories.user_id') // ✅ include for ORDER BY
            ->orderBy('news_and_stories.id', 'desc') */
            ->distinct()
            ->paginate(10, ['*'], 'page', $page);
            return $data->setCollection($data->getCollection()->shuffle());
        } catch (\Exception $e) {
            Log::error("Error in UserRepository.usersByMyCurrentLocation    (): " . $e->getMessage());
            return false;
        }
    }
    public function getByWhere($byWhere, $orderBy = ['id' => 'desc'])
    {
        try {
            $query = $this->model->with('country', 'plan', 'gender', 'nationality', 'state', 'city', 'countries', 'ethnicity', 'bodyType', 'haircolor', 'hairLength', 'hairType', 'eyeColor', 'reviewsReceived', 'reviewsGiven','videos','stories','stories.likes', 'stories.comments','images')->where(function ($query) use ($byWhere) {

                foreach ($byWhere as $column => $condition) {
                    if (is_array($condition)) {
                        if ($condition[0] === "IN") {
                            unset($condition[0]);
                            $query->whereIn($column, $condition);
                        } else {
                            $query->where($column, $condition[0], $condition[1]);
                        }
                    } else {
                        $query->where($column, $condition);
                    }
                }
            });

            // Construct the order by string
            $orderByString = '';
            foreach ($orderBy as $column => $direction) {
                $orderByString .= "$column $direction, ";
            }
            $orderByString = rtrim($orderByString, ', ');
            return $query->orderByRaw($orderByString)->get();
        } catch (\Exception $e) {
            Log::error("Error in UserRepository.getUsersByWhere(): " . $e->getMessage());
            return response()->json(['status' => '0', 'message' => __('message.statusZero')]);
        }
    }
    public function getByWhereWithLimit($byWhere, $limit = 10, $orderBy = null)
    {
        try {
            $query = $this->model->with([
                'country',
                'plan',
                'gender',
                'nationality',
                'state',
                'city',
                'countries',
                'ethnicity',
                'bodyType',
                'haircolor',
                'hairLength',
                'hairType',
                'eyeColor',
                'reviewsReceived',
                'reviewsGiven',
                'videos',
                'images',
                
            ])->where(function ($query) use ($byWhere) {

                foreach ($byWhere as $column => $condition) {
                    // Support 'column >=' => value format
                    if (strpos($column, ' ') !== false) {
                        [$col, $op] = explode(' ', $column, 2);
                        $query->where($col, $op, $condition);
                    }
                    // Support array condition ['>=', value] or ['IN', ...]
                    elseif (is_array($condition)) {
                        // Support IN clause: ['IN', val1, val2, ...]
                        if (strtoupper($condition[0]) === "IN") {
                            $query->whereIn($column, array_slice($condition, 1));
                        }
                        // Support operator format: ['>=', value]
                        elseif (count($condition) === 2) {
                            $query->where($column, $condition[0], $condition[1]);
                        } else {
                            // fallback: equality check with array
                            $query->where($column, $condition);
                        }
                    }
                    // Default '=' check
                    else {
                        $query->where($column, $condition);
                    }
                }
            });
            $query->distinct();
            // Handle ordering
            if ($orderBy) {
                foreach ($orderBy as $column => $direction) {
                    $query->orderBy($column, $direction);
                }
            } else {
                $query->inRandomOrder(); // default random order
            }

            return $query->limit($limit)->get();
        } catch (\Exception $e) {
            Log::error("Error in UserRepository.getByWhereWithLimit(): " . $e->getMessage());
            return response()->json(['status' => '0', 'message' => __('message.statusZero')]);
        }
    }
    
    public function getTopUsersCreatedToday($limit = 6)
    {
        return  $this->model->with('country', 'plan', 'gender', 'nationality', 'state', 'city', 'countries', 'ethnicity', 'bodyType', 'haircolor', 'hairLength', 'hairType', 'eyeColor', 'reviewsReceived', 'reviewsGiven','images')->where('type', 2)
            ->whereDate('created_at', today())->where('type', 2)
            ->where('user_status', 0)->where('top3status', 1)
            ->where('admin_status', 'approved')
            ->take($limit)
            ->inRandomOrder()->get();
    }

    public function getNewFaces($limit = 6)
    {
        $recentUsers = $this->model->with([
            'country',
            'plan',
            'gender',
            'nationality',
            'state',
            'city',
            'countries',
            'ethnicity',
            'bodyType',
            'haircolor',
            'hairLength',
            'hairType',
            'eyeColor',
            'reviewsReceived',
            'reviewsGiven','images'
        ])
            ->where('user_status', 0)
            ->where('admin_status', 'approved')->where('type', 2)
            ->where('created_at', '>=', Carbon::now()->subDays(7))
            ->orderBy('id', 'desc') // Latest first
            ->take(20) // Take more to randomize
            ->get();

        return $recentUsers->shuffle()->take($limit); // Pick 6 randomly from latest
    }

    public function getByWhereuploadedPhoto($byWhere, $orderBy = ['id' => 'desc'])
    {
        try {
            $query = $this->uploadedPhotomodel->where(function ($query) use ($byWhere) {

                foreach ($byWhere as $column => $condition) {
                    if (is_array($condition)) {
                        if ($condition[0] === "IN") {
                            unset($condition[0]);
                            $query->whereIn($column, $condition);
                        } else {
                            $query->where($column, $condition[0], $condition[1]);
                        }
                    } else {
                        $query->where($column, $condition);
                    }
                }
            });

            // Construct the order by string
            $orderByString = '';
            foreach ($orderBy as $column => $direction) {
                $orderByString .= "$column $direction, ";
            }
            $orderByString = rtrim($orderByString, ', ');
            return $query->orderByRaw($orderByString)->get();
        } catch (\Exception $e) {
            Log::error("Error in UserRepository.getByWhereuploadedPhoto(): " . $e->getMessage());
            return response()->json(['status' => '0', 'message' => __('message.statusZero')]);
        }
    }
    public function getByWhereuserAvailability($byWhere, $orderBy = ['id' => 'desc'])
    {
        try {
            $query = $this->userAvailability->where(function ($query) use ($byWhere) {

                foreach ($byWhere as $column => $condition) {
                    if (is_array($condition)) {
                        if ($condition[0] === "IN") {
                            unset($condition[0]);
                            $query->whereIn($column, $condition);
                        } else {
                            $query->where($column, $condition[0], $condition[1]);
                        }
                    } else {
                        $query->where($column, $condition);
                    }
                }
            });

            // Construct the order by string
            $orderByString = '';
            foreach ($orderBy as $column => $direction) {
                $orderByString .= "$column $direction, ";
            }
            $orderByString = rtrim($orderByString, ', ');
            return $query->orderByRaw($orderByString)->get();
        } catch (\Exception $e) {
            Log::error("Error in UserRepository.getByWhereuserAvailability(): " . $e->getMessage());
            return response()->json(['status' => '0', 'message' => __('message.statusZero')]);
        }
    }
    public function getByWhereuploadedVideo($byWhere, $orderBy = ['id' => 'desc'])
    {
        try {
            $query = $this->videomodel->where(function ($query) use ($byWhere) {

                foreach ($byWhere as $column => $condition) {
                    if (is_array($condition)) {
                        if ($condition[0] === "IN") {
                            unset($condition[0]);
                            $query->whereIn($column, $condition);
                        } else {
                            $query->where($column, $condition[0], $condition[1]);
                        }
                    } else {
                        $query->where($column, $condition);
                    }
                }
            });

            // Construct the order by string
            $orderByString = '';
            foreach ($orderBy as $column => $direction) {
                $orderByString .= "$column $direction, ";
            }
            $orderByString = rtrim($orderByString, ', ');
            return $query->orderByRaw($orderByString)->get();
        } catch (\Exception $e) {
            Log::error("Error in UserRepository.getByWhereuploadedPhoto(): " . $e->getMessage());
            return response()->json(['status' => '0', 'message' => __('message.statusZero')]);
        }
    }
    public function getTopRatedUsers($keywords = null, $limit = 5)
    {
        $query = $this->model
            ->with('country', 'plan', 'state', 'city', 'countries', 'reviewsReceived', 'reviewsGiven','images')
            ->whereHas('reviewsReceived')
            ->withAvg('reviewsReceived', 'rating') // calculate average rating
            ->having('reviews_received_avg_rating', '>=', 3.5)
            ->where('user_status', 0)->where('users.type', 2)
            ->where('admin_status', 'approved');
            
            if(isset($keywords)) {
                $parts = explode("+", $keywords);
                if(!empty($parts)) {
                    $query->leftJoin("cities", "users.city_id", "cities.id")
                    ->leftJoin("countries", "users.country_id", "countries.id")
                    ->leftJoin("states", "users.state_id", "states.id");
                        $query->where(function($q) use($parts) {
                            foreach ($parts as $key => $value) {
                            $q->orWhere('users.name', 'like', "%{$value}%")
                            ->orWhere('countries.name', 'like', "%{$value}%")
                            ->orWhere('cities.name', 'like', "%{$value}%")
                            ->orWhere('states.name', 'like', "%{$value}%");
                            }
                        });
                }
            }
            return $query->orderByDesc('reviews_received_avg_rating') // order by average rating
            ->inRandomOrder() // random tie-breaker
            ->take($limit)
            ->get()
            ->unique('id')
            ->values();
    }
    public function getBestUsers($limit = 6)
    {
        return $this->model
            ->with('country', 'plan', 'gender', 'nationality', 'state', 'city', 'countries', 'ethnicity', 'bodyType', 'haircolor', 'hairLength', 'hairType', 'eyeColor', 'reviewsReceived', 'reviewsGiven','images')
            ->where('type', 2)
            ->where('user_status', 0)
            ->where('admin_status', 'approved')
            ->inRandomOrder()
            ->take($limit * 2)
            ->get()
            ->unique('id')
            ->take($limit)
            ->values();
    }


    //create Contact Us data
    public function saveContactUsData($allData)
    {
        try {
            return $this->contactmodel->create($allData);
        } catch (\Exception $e) {
            Log::error("Error in UserRepository.saveContactUsData(): " . $e->getMessage());
            throw $e;
            // return response()->json(['status' => '0', 'message' => __('message.statusZero')]);
        }
    }

    public function getAllContactUs()
    {
        try {
            return $this->contactmodel->orderBy('id', 'desc')->get();
        } catch (\Exception $e) {
            Log::error("Error in userRepository.getAllContactUs(): " . $e->getMessage());
            return response()->json(['status' => '0', 'message' => __('message.statusZero')]);
        }
    }

    public function getContactUsOne($byWhere)
    {
        try {
            $data = $this->contactmodel->select('*')->where($byWhere)->first();
            return $data;
        } catch (\Exception $e) {
            Log::error("Error in UserRepository.getContactUsOne(): " . $e->getMessage());
            return response()->json(['status' => '0', 'message' => __('message.statusZero')]);
        }
    }
    public function updateContactUs($byWhere, $update)
    {
        try {
            // dd($update,$byWhere);
            return $this->contactmodel->where($byWhere)->update($update);
        } catch (\Exception $e) {
            Log::error("Error in UserRepository.updateContactUs(): " . $e->getMessage());
            throw $e;
        }
    }

    public function getByWhereSearch($byWhere, array $orderBy = [], $perPage = 10,$page = null, $keywords = null)
    {
        
        try {
                    // --- STEP 1: Define Window and Check/Reset Logic ---
/*         $throttleWindow = Carbon::now()->subMinutes(15);
        $now = Carbon::now();

        // IMPORTANT: Before selection, check all users whose window has expired
        // and reset their counter. This prevents a user with visibility=5 from being shown
        // indefinitely after 15 minutes have passed since their last show.
        $this->model->where('last_shown_at', '<', $throttleWindow)
        ->update([
            'shows_in_current_window' => 0,
        ]); */
            $now = Carbon::now(config('app.timezone'));   

            $query = $this->model->select('users.*', 'plans.visibility')->with([
                'country',
                'plan',
                'gender',
                'state',
                'city',
                'countries',
                'reviewsReceived',
                'reviewsGiven',
                'escortServices',
                'viewsReceived',
                'is_featured',
                'favouritedBy'
            ])->withAvg('reviewsReceived', 'rating')->where(function ($query) use ($byWhere) {

                // Define fields that should use LIKE
                $likeFields = ['users.name', 'users.slogan', 'users.description', 'users.nationality'];


                if (isset($byWhere['category_id']) || isset($byWhere['sub_category_id'])) {
                    $query->whereHas('escortServices', function ($q) use ($byWhere) {
                        if (isset($byWhere['category_id'][1])) {
                            $q->whereIn('category_id', $byWhere['category_id'][1]);
                        }
                        if (isset($byWhere['sub_category_id'][1])) {
                            $q->whereIn('service_id', $byWhere['sub_category_id'][1]);
                        }
                    });

                    // Remove from main loop to avoid re-processing
                    unset($byWhere['category_id'], $byWhere['sub_category_id']);
                }
                foreach ($byWhere as $column => $condition) {
                    if (empty($condition)) continue;

                    if (is_array($condition)) {
                        $operator = strtoupper($condition[0]);

                        if ($operator === "IN") {

                            // $query->whereIn($column, $condition[1]);
                            if (in_array($column, ['breast_size'])) {
                                foreach ($condition[1] as $value) {
                                    $query->whereJsonContains($column, $value);
                                }
                            } elseif (in_array($column, ['languages'])) {
                                foreach ($condition[1] as $value) {
                                    $query->whereJsonContains($column, $value);
                                }
                            } elseif (in_array($column, ['payment_method'])) {
                                foreach ($condition[1] as $value) {
                                    $query->whereJsonContains($column, $value);
                                }
                            } else {
                                $query->whereIn($column, $condition[1]);
                            }
                        } elseif ($operator === "BETWEEN") {
                            // dd($condition[1]);
                            $query->whereBetween($column, $condition[1]);
                        } else {
                            $query->where($column, $condition[0], $condition[1]);
                        }
                    } else {
                        if ($column === 'search_term') {
                            $query->where(function ($q) use ($likeFields, $condition) {
                                foreach ($likeFields as $field) {
                                    $q->orWhere($field, 'LIKE', '%' . $condition . '%');
                                }
                            });
                        } elseif (in_array($column, $likeFields)) {
                            $query->where($column, 'LIKE', '%' . $condition . '%');
                        } else {
                            $query->where($column, $condition);
                        }
                    }
                }
            });
            $already_ids = session('fetched_rec');
            if($page != "model-search" && isset($already_ids) && !empty($already_ids)) {
                $query->whereNotIn('users.id', $already_ids);
            }
            if(isset($keywords)) {
                $parts = explode("+", $keywords);
                if(!empty($parts)) {
                    
                    $query->leftJoin("cities", "users.city_id", "cities.id")
                        ->leftJoin("countries", "users.country_id", "countries.id")
                        ->leftJoin("states", "users.state_id", "states.id");
                         $query->where(function($q) use($parts, $byWhere) {
                             foreach ($parts as $key => $value) {
                                 if(!isset($byWhere["users.country_id"])) {
                                    $q->orWhere('users.name', 'like', "%{$value}%")
                                    ->orWhere('countries.name', 'like', "%{$value}%")
                                    ->orWhere('states.name', 'like', "%{$value}%")
                                    ->orWhere('cities.name', 'like', "%{$value}%");
                                } 
                             }
                         }); 
                }
            }

            // --- STEP 2: Get Eligible Users (Selectable) ---
            //->whereIn('users.id', [39,22,26,34,42,19,46,29])
            
            $query->join('plans', 'plans.id', '=', 'users.plan_id')
            ->leftJoin('boost_user_profiles as bup', function ($join) use ($now) {
                $join->on('bup.user_id', '=', 'users.id')
                    ->where('bup.boosted_from', '<=', $now)
                    ->where('bup.boosted_to', '>=', $now);
            })->selectRaw("
                CASE 
                    WHEN bup.user_id IS NOT NULL THEN 1
                    ELSE 0
                END AS is_my_boosted
            ");
            /* ->selectRaw("
                DATE_ADD(users.last_shown_at, INTERVAL 
                    CASE 
                        WHEN plans.visibility = 5 THEN 3
                        WHEN plans.visibility = 1 THEN 15
                        WHEN plans.visibility = 3 THEN 5
                        ELSE 30
                    END MINUTE
                ) AS next_show_time
            "); */
            //$query->havingRaw('next_show_time <= ?', [$now]);

            if (!empty($orderBy)) {
                foreach ($orderBy as $column => $direction) {
                    if ($column === 'average_quickie_rate') {
                        $query->whereNotNull('quickie_rates')
                            ->whereRaw("JSON_VALID(quickie_rates)");

                        $query->orderByRaw("
            (
                CAST(COALESCE(NULLIF(JSON_UNQUOTE(JSON_EXTRACT(quickie_rates, '$.\"24h\"')), ''), '0') AS DECIMAL(10,2)) +
                CAST(COALESCE(NULLIF(JSON_UNQUOTE(JSON_EXTRACT(quickie_rates, '$.\"1_hr\"')), ''), '0') AS DECIMAL(10,2)) +
                CAST(COALESCE(NULLIF(JSON_UNQUOTE(JSON_EXTRACT(quickie_rates, '$.\"2_hr\"')), ''), '0') AS DECIMAL(10,2)) +
                CAST(COALESCE(NULLIF(JSON_UNQUOTE(JSON_EXTRACT(quickie_rates, '$.\"3_hr\"')), ''), '0') AS DECIMAL(10,2)) +
                CAST(COALESCE(NULLIF(JSON_UNQUOTE(JSON_EXTRACT(quickie_rates, '$.\"30_min\"')), ''), '0') AS DECIMAL(10,2)) +
                CAST(COALESCE(NULLIF(JSON_UNQUOTE(JSON_EXTRACT(quickie_rates, '$.\"90_min\"')), ''), '0') AS DECIMAL(10,2)) +
                CAST(COALESCE(NULLIF(JSON_UNQUOTE(JSON_EXTRACT(quickie_rates, '$.\"overnight\"')), ''), '0') AS DECIMAL(10,2))
            ) / 7 {$direction}
            ");
                    } elseif ($column === 'rating') {
                        $query->orderBy('reviews_received_avg_rating', $direction);
                    } else {
                        $query->orderBy($column, $direction);
                    }
                }
            }
           $query->orderByDesc(DB::raw('bup.boosted_from'))->orderByDesc('is_my_boosted')->orderBy('plans.visibility', 'desc')->orderBy('rotation_pos', 'asc');
           if($page != "model-search") {
               $query->take($perPage * 2);
           }
           $results = $query->get()->unique('id')->values();
           if($page != "model-search") {
               return $results->take($perPage);
           }
           return $results;

        } catch (\Throwable $e) {
            Log::error("Error in UserRepository.getByWhereSearch(): " . $e->getMessage());
            return response()->json(['status' => '0', 'message' => __('message.statusZero')]);
        }
    }

    

    public function getByWherenew($byWhere, $orderBy = ['id' => 'desc'], $perPage = 10)
    {
        try {
            // dd($byWhere);
            $query = $this->model->with([
                'country',
                'plan',
                'gender',
                'nationality',
                'state',
                'city',
                'countries',
                'ethnicity',
                'bodyType',
                'haircolor',
                'hairLength',
                'hairType',
                'eyeColor',
                'reviewsReceived',
                'reviewsGiven',
                'escortServices',
                'viewsReceived',
            ])->withAvg('reviewsReceived', 'rating')->where(function ($query) use ($byWhere) {

                // Define fields that should use LIKE
                $likeFields = ['name', 'slogan', 'description', 'nationality'];
                if (isset($byWhere['category_id']) || isset($byWhere['sub_category_id'])) {
                    $query->whereHas('escortServices', function ($q) use ($byWhere) {
                        if (isset($byWhere['category_id'][1])) {
                            $q->whereIn('category_id', $byWhere['category_id'][1]);
                        }
                        if (isset($byWhere['sub_category_id'][1])) {
                            $q->whereIn('service_id', $byWhere['sub_category_id'][1]);
                        }
                    });

                    // Remove from main loop to avoid re-processing
                    unset($byWhere['category_id'], $byWhere['sub_category_id']);
                }
                foreach ($byWhere as $column => $condition) {
                    if (empty($condition)) continue;

                    if (is_array($condition)) {
                        $operator = strtoupper($condition[0]);

                        if ($operator === "IN") {

                            // $query->whereIn($column, $condition[1]);
                            if (in_array($column, ['breast_size'])) {
                                foreach ($condition[1] as $value) {
                                    $query->whereJsonContains($column, $value);
                                }
                            } elseif (in_array($column, ['languages'])) {
                                foreach ($condition[1] as $value) {
                                    $query->whereJsonContains($column, $value);
                                }
                            } elseif (in_array($column, ['payment_method'])) {
                                foreach ($condition[1] as $value) {
                                    $query->whereJsonContains($column, $value);
                                }
                            } else {
                                $query->whereIn($column, $condition[1]);
                            }
                        } elseif ($operator === "BETWEEN") {
                            $query->whereBetween($column, $condition[1]);
                        } else {
                            $query->where($column, $condition[0], $condition[1]);
                        }
                    } else {
                        if ($column === 'search_term') {
                            $query->where(function ($q) use ($likeFields, $condition) {
                                foreach ($likeFields as $field) {
                                    $q->orWhere($field, 'LIKE', '%' . $condition . '%');
                                }
                            });
                        } elseif (in_array($column, $likeFields)) {
                            $query->where($column, 'LIKE', '%' . $condition . '%');
                        } else {
                            $query->where($column, $condition);
                        }
                    }
                }
            });

            // Apply ordering
            // foreach ($orderBy as $column => $direction) {
            //     $query->orderBy($column, $direction);
            // }
            // $query->orderByDesc('top3status')
            //     ->orderByDesc('reviews_received_avg_rating');
            if (!empty($orderBy)) {
                foreach ($orderBy as $column => $direction) {
                    if ($column === 'average_quickie_rate') {
                        $query->whereNotNull('quickie_rates')
                            ->whereRaw("JSON_VALID(quickie_rates)");
                        $query->orderByRaw("
(
    CAST(COALESCE(NULLIF(JSON_UNQUOTE(JSON_EXTRACT(quickie_rates, '$.\"24h\"')), ''), '0') AS DECIMAL(10,2)) +
    CAST(COALESCE(NULLIF(JSON_UNQUOTE(JSON_EXTRACT(quickie_rates, '$.\"1_hr\"')), ''), '0') AS DECIMAL(10,2)) +
    CAST(COALESCE(NULLIF(JSON_UNQUOTE(JSON_EXTRACT(quickie_rates, '$.\"2_hr\"')), ''), '0') AS DECIMAL(10,2)) +
    CAST(COALESCE(NULLIF(JSON_UNQUOTE(JSON_EXTRACT(quickie_rates, '$.\"3_hr\"')), ''), '0') AS DECIMAL(10,2)) +
    CAST(COALESCE(NULLIF(JSON_UNQUOTE(JSON_EXTRACT(quickie_rates, '$.\"30_min\"')), ''), '0') AS DECIMAL(10,2)) +
    CAST(COALESCE(NULLIF(JSON_UNQUOTE(JSON_EXTRACT(quickie_rates, '$.\"90_min\"')), ''), '0') AS DECIMAL(10,2)) +
    CAST(COALESCE(NULLIF(JSON_UNQUOTE(JSON_EXTRACT(quickie_rates, '$.\"overnight\"')), ''), '0') AS DECIMAL(10,2))
) / 7 {$direction}
");
                    } elseif ($column === 'rating') {
                        $query->orderBy('reviews_received_avg_rating', $direction);
                    } else {
                        $query->orderBy($column, $direction);
                    }
                }
            } else {
                // Default order
                $query->orderByDesc('id');
            }


            return $query->paginate($perPage);
        } catch (\Exception $e) {
            Log::error("Error in UserRepository.getByWherenew(): " . $e->getMessage());
            return response()->json(['status' => '0', 'message' => __('message.statusZero')]);
        }
    }

    public function createWishlist($create)
    {
        try {

            return $this->wishlist->create($create);
        } catch (\Exception $e) {
            Log::error("Error in " . __CLASS__ . "::" . __FUNCTION__ . ": " . $e->getMessage());
            return response()->json(['status' => 0, 'message' => 'Failed to wishlist submit from repository.']);
        }
    }

    public function deleteWishlist($where)
    {
        try {

            return $this->wishlist->where($where)->delete();
        } catch (Exception $e) {
            Log::error("Error in " . __CLASS__ . "::" . __FUNCTION__ . ": " . $e->getMessage());
            return response()->json(['status' => 0, 'message' => 'Failed to wishlist delete from repository.']);
        }
    }
    public function getOnewishlist($byWhere)
    {
        try {
            return $this->wishlist->select('*')->where($byWhere)->first();
        } catch (\Exception $e) {
            Log::error("Error in UserRepository.getOnewishlist(): " . $e->getMessage());
            throw $e;
        }
    }
    public function getByWherewishlist($bywhere)
    {
        try {
            return $this->wishlist->with('user', 'favouriteUser')->where($bywhere)->orderBy('id', 'asc')->get();
        } catch (\Exception $e) {
            Log::error("Error in ArtistPrintRepository.getByWhere(): " . $e->getMessage());
            throw $e;
        }
    }
    public function getByWheretransaction($bywhere)
    {
        try {
            return $this->transactionmodel->with('user', 'plan')->where($bywhere)->orderBy('id', 'asc')->get();
        } catch (\Exception $e) {
            Log::error("Error in ArtistPrintRepository.getByWheretransaction(): " . $e->getMessage());
            throw $e;
        }
    }
    public function logView($viewedId, $viewerId = null, $viewedType = 'user', $ip = null)
    {
        try {
            if (!$ip) {
                $ip = request()->ip();
            }

            // ❌ Don't log if viewer is same as viewed
            if ($viewerId && $viewerId == $viewedId) {
                return;
            }

            // ✅ Check if view already exists within the last hour
            $alreadyViewedQuery = $this->Viewmodel
                ->where('viewed_id', $viewedId)
                ->where('viewed_type', $viewedType)
                ->where('created_at', '>=', now()->subHour());

            if ($viewerId) {
                // Logged-in user: check by viewer_id
                $alreadyViewedQuery->where('viewer_id', $viewerId);
            } else {
                // Guest user: check by IP (no viewer_id)
                $alreadyViewedQuery->whereNull('viewer_id')->where('ip_address', $ip);
            }

            if ($alreadyViewedQuery->exists()) {
                return null; // Don't log duplicate
            }

            // ✅ Create the view log
            return $this->Viewmodel->create([
                'viewer_id' => $viewerId,
                'viewed_id' => $viewedId,
                'viewed_type' => $viewedType,
                'ip_address' => $ip,
            ]);
        } catch (\Exception $e) {
            Log::error("Error in UserRepository.logView(): " . $e->getMessage());
            throw $e;
        }
    }



    // public function deleteContactUs($byWhere)
    // {
    //     try {
    //         return $this->contactmodel->where($byWhere)->delete();
    //     } catch (\Exception $e) {
    //         Log::error("Error in UserRepository.deleteContactUs(): " . $e->getMessage());
    //         return response()->json(['status' => '0', 'message' => __('message.statusZero')]);
    //     }
    // }

    public function searchModels(array $where, array $select = ['users.*'], array $whereInUsers = [], $keywords = null) {
        try {
            
            $currentSlot = getCurrentSlot();
            $cityId = $this->cityRepository->getSingleRecordWhere(['name' => $keywords]);
            $query = $this->model->select($select)->with([
                'country',
                'plan',
                'gender',
                'nationality',
                'state',
                'city',
                'countries',
                'ethnicity',
                'bodyType',
                'haircolor',
                'hairLength',
                'hairType',
                'eyeColor',
                'reviewsReceived',
                'reviewsGiven',
                'videos',
                'images',
                
            ]);
            $shownToday = collect();
            $today = now()->toDateString();
            if(isset($cityId["id"])) {
                $shownToday = $this->userDailyShow->where('city_id', $cityId["id"])
                    ->where('show_date', $today)
                    ->where('slot_number', "=", $currentSlot)
                    ->pluck('user_id');
            }
            //if record exist in current slot
            if($shownToday->isNotEmpty()) {
                return $query->whereIn('users.id', $shownToday)->distinct('users.id')->inRandomOrder();
            }
            //if record not exist in current slot
            if(isset($cityId["id"])) {
            $shownToday = $this->userDailyShow->where('city_id', $cityId["id"])
                    ->where('show_date', $today)
                    ->where('slot_number', "!=", $currentSlot)
                    ->pluck('user_id');
            }
            
            if(!empty($where)) {
                $query->join("feature_devils", "users.id", "feature_devils.user_id", )
                ->where($where);

                if(!empty($whereInUsers)) {
                    $query->whereIn('users.id', $whereInUsers);
                }

                if(isset($keywords)) {
                    $parts = explode("+", $keywords);
                    if(!empty($parts)) {
                        $query->leftJoin("cities", "users.city_id", "cities.id")->leftJoin("countries", "users.country_id", "countries.id");
                         $query->where(function($q) use($parts) {
                             foreach ($parts as $key => $value) {
                                $q->orWhere('users.name', 'like', "%{$value}%")
                                ->orWhere('countries.name', 'like', "%{$value}%")
                                ->orWhere('cities.name', 'like', "%{$value}%");
                             }
                         });
                    }
                }
                
                $current_date = now()->format('Y-m-d');
                if(!isset($where["plan_start_date"]) && !isset($where["plan_end_date"])) {
                    $query->where([
                        ['users.plan_start_date', '<=', $current_date],
                        ['users.plan_end_date', '>=', $current_date]
                    ]);                    
                }

            }
            
            if($shownToday->isNotEmpty()) {
                $query->whereNotIn('users.id', $shownToday);
            }
            $query->distinct('users.id')->limit(6)->inRandomOrder();
            $newUsers = $query->get();
            // Save records in tracking table
            if(isset($newUsers) && !empty($newUsers) ) {

                foreach ($newUsers as $user) {
                    $this->userDailyShow->updateOrInsert(
                        [
                            'user_id' => $user->id,
                            'show_date' => $today,
                            'slot_number' => $currentSlot,
                        ],
                        [
                            'city_id' => $user->city_id ?? 0,
                            'updated_at' => now(),
                        ]
                    ); 
                }
            }
            return $query;
        } catch (\Exception $exception) {
            Log::error("Error in " . __CLASS__ . "::" . __FUNCTION__ . ": " . $exception->getMessage());
        }
    }

    public function getFeaturedModels(array $where, $keywords = null) {
        try {
            $query = $this->model->select('users.*')->with([
                'reviewsReceived',  'images'    
            ])
            ->join('feature_devils', 'users.id', '=', 'feature_devils.user_id')
            ->leftJoin('countries', 'users.country_id', '=', 'countries.id')
            ->leftJoin('states', 'users.state_id', '=', 'states.id')
            ->leftJoin('cities', 'users.city_id', '=', 'cities.id')
            ->where($where);
            if(isset($keywords)) {
                $keywords = str_replace("+", " ", $keywords);
                $query->where(function($q) use ($keywords) {
                    $q->where('countries.name', 'like', "%{$keywords}%")
                    ->orWhere('states.name', 'like', "%{$keywords}%")
                    ->orWhere('cities.name', 'like', "%{$keywords}%");
                });
            }
            return $query->inRandomOrder()->limit(12)->get()->unique('id')->take(6)->values();
        } catch (\Throwable $exception) {
            Log::error("Error in " . __CLASS__ . "::" . __FUNCTION__ . ": " . $exception->getMessage());
            return collect();
        }        
    }

    public function devilForYou(array $where, $keywords = null, $current_date = null) {
        try {
            if (!$current_date) {
                $current_date = now()->format('Y-m-d');
            }
            $query = $this->model->select('users.*')->with('images')
            ->leftJoin('feature_devils', 'users.id', '=', 'feature_devils.user_id')
            ->leftJoin('countries', 'users.country_id', '=', 'countries.id')
            ->leftJoin('states', 'users.state_id', '=', 'states.id')
            ->leftJoin('cities', 'users.city_id', '=', 'cities.id')
            ->where($where);
            $query->where(function ($q) use ($current_date) {
                $q->whereNull('feature_devils.date')
                ->orWhere('feature_devils.date', '!=', $current_date);
            });
            if(isset($keywords)) {
                $keywords = str_replace("+", " ", $keywords);
                $query->where(function($q) use ($keywords) {
                    $q->where('countries.name', 'like', "%{$keywords}%")
                    ->orWhere('states.name', 'like', "%{$keywords}%")
                    ->orWhere('cities.name', 'like', "%{$keywords}%");
                });
            }
            return $query->inRandomOrder()->limit(12)->get()->unique('id')->take(6)->values();
        } catch (\Throwable $exception) {
            Log::error("Error in " . __CLASS__ . "::" . __FUNCTION__ . ": " . $exception->getMessage());
            return collect();
        }
        
    }

    public function top3User(array $where, array $select = ['users.*'], $keywords = null, $limit = 3, $userType = "weekly") {
        try {        
            $currentWeek = Carbon::now()->format('o-W');
            $current_date = now()->format('Y-m-d');

            $query = $this->model->select($select)->with([
                'country',
                'plan',
                'state',
                'city',
                'countries',
                'reviewsReceived',
                'videos',
                'images',
                'is_featured'                
            ]);

            
            if(!empty($where)) {
                $query->where($where);
            }
            
            if(isset($keywords)) {
                
                $parts = str_replace("+", " ", $keywords);
                if(!empty($parts)) {                    
                    $query->join('cities', 'users.city_id', '=', 'cities.id')->where(function($q) use($parts) {
                            $q->where('cities.name', 'like', "%{$parts}%");
                        });
                }
            }
            $existingUsers = clone $query;
            //FreshSins only 
            if($userType == "FreshSins") {
                return $existingUsers->leftJoin('feature_devils', 'users.id', '=', 'feature_devils.user_id')
                            ->whereNotIn('users.id', function($subquery) use ($current_date) {
                            $subquery->select('user_id')
                                    ->from('feature_devils')
                                    ->where('date', $current_date);
                        })->inRandomOrder()->limit($limit * 3)->get()->unique('id')->take($limit)->values();
            }
            $existingUsers = $existingUsers->where('users.week_assigned', $currentWeek)->inRandomOrder()->limit($limit * 3)->get()->unique('id')->take($limit)->values();
            
            // Check if current week already has assigned users
            if ($existingUsers->count() > 0) {
                return $existingUsers;
            }
            $newUsers = clone $query;
            $weekly_users = $newUsers->leftJoin('feature_devils', 'users.id', '=', 'feature_devils.user_id')
                            ->whereNotIn('users.id', function($subquery) use ($current_date) {
                            $subquery->select('user_id')
                                    ->from('feature_devils')
                                    ->where('date', $current_date);
                        })->inRandomOrder()->limit($limit * 3)->get()->unique('id')->take($limit)->values();

            foreach ($weekly_users as $user) {
                $this->model->where('id', $user->id)
                    ->update(['week_assigned' => $currentWeek]);
            }
            return $weekly_users;
        } catch (\Throwable $exception) {
            Log::error("Error in " . __CLASS__ . "::" . __FUNCTION__ . ": " . $exception->getMessage());
            return collect();
        } 
    }

    public function UpdatePhoto(array $allData, array $data)
    {
        try {
            return $this->uploadedPhotomodel->where($allData)->update($data);
        } catch (\Exception $e) {
            Log::error("Error in UserRepository.UpdatePhoto(): " . $e->getMessage());
            return false;

        }
    }
}
