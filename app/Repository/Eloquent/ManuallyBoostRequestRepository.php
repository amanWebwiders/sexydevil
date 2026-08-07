<?php
namespace App\Repository\Eloquent;
use Exception;
use App\Models\{ManuallyBoostRequestModel, BoostUserProfilesModel, User};
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
class ManuallyBoostRequestRepository extends BaseRepository 
{
    protected $model, $cache;
    protected $boostUserProfilesModel, $userModel;
    public function __construct(ManuallyBoostRequestModel $model, BoostUserProfilesModel $boostUserProfilesModel, User $userModel)
    {
        $this->model = $model;
        $this->boostUserProfilesModel = $boostUserProfilesModel;
        $this->userModel = $userModel;
        parent::__construct($model);
    }
    
    public function createRecord($data)
    {
        try {
            return $this->model->create($data);            
        } catch (Exception $e) {
            Log::error("Error in " . __CLASS__ . "::" . __FUNCTION__ . ": " . $e->getMessage());
            return false;
        }
    }

    public function getAllData(array $conditions)
    {
        try {
            $query = $this->model->where($conditions);
            return $query->orderByDesc('id')->get();
        } catch (Exception $e) {
            Log::error("Error in " . __CLASS__ . "::" . __FUNCTION__ . ": " . $e->getMessage());
            return null;
        }
    }

    public function getAllDataInArray(array $conditions = [], array $columns = ['manually_boost_requests.*', 'users.name', 'users.email'])    {
        try {
            $query = $this->model->select($columns);
            if(!empty($conditions)) {
                $query->where($conditions);
            }            
            return $query->leftJoin('users', 'manually_boost_requests.user_id', '=', 'users.id')->orderByDesc('manually_boost_requests.id')->get()->toArray();
        } catch (Exception $e) {
            Log::error("Error in " . __CLASS__ . "::" . __FUNCTION__ . ": " . $e->getMessage());
            return null;
        }
    }

    public function updateRecord(array $conditions, array $data)
    {
        try {
            return $this->model->where($conditions)->update($data);            
        } catch (Exception $e) {
            Log::error("Error in " . __CLASS__ . "::" . __FUNCTION__ . ": " . $e->getMessage());
            return false;
        }
    }

    public function getSingleData(array $conditions, array $columns)
    {
        try {
            return $this->model->where($conditions)->first($columns);            
        } catch (Exception $e) {
            Log::error("Error in " . __CLASS__ . "::" . __FUNCTION__ . ": " . $e->getMessage());
            return false;
        }
    }

    public function createBoostProfiles(array $data)
    {
        try {
            return $this->boostUserProfilesModel->create($data);            
        } catch (Exception $e) {
            Log::error("Error in " . __CLASS__ . "::" . __FUNCTION__ . ": " . $e->getMessage());
            return false;
        }        
    }

    public function getSingleBoostProfiles(array $data)
    {
        try {
            return $this->boostUserProfilesModel->where($data)->first();            
        } catch (Exception $e) {
            Log::error("Error in " . __CLASS__ . "::" . __FUNCTION__ . ": " . $e->getMessage());
            return false;
        }        
    }

    public function getAllBoostedProfiles(array $conditions, $selectColumns = ['users.*'], $keywords = null) {
        try {
            $current_time = Carbon::now();
            $query = $this->userModel->select($selectColumns)->with([
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
            ])
            ->where(function ($query) use ($conditions) {

                // Define fields that should use LIKE
                $likeFields = ['name', 'slogan', 'description', 'nationality'];


                if (isset($conditions['category_id']) || isset($conditions['sub_category_id'])) {
                    $query->whereHas('escortServices', function ($q) use ($conditions) {
                        if (isset($conditions['category_id'][1])) {
                            $q->whereIn('category_id', $conditions['category_id'][1]);
                        }
                        if (isset($conditions['sub_category_id'][1])) {
                            $q->whereIn('service_id', $conditions['sub_category_id'][1]);
                        }
                    });

                    // Remove from main loop to avoid re-processing
                    unset($conditions['category_id'], $conditions['sub_category_id']);
                }
                foreach ($conditions as $column => $condition) {
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
            $query->join('boost_user_profiles', 'users.id', '=', 'boost_user_profiles.user_id')->where('boost_user_profiles.boosted_from', '<=', $current_time)->where('boost_user_profiles.boosted_to', '>=', $current_time);
            if(isset($keywords)) {
                $parts = explode("+", $keywords);
                if(!empty($parts)) {
                    
                    $query->leftJoin("cities", "users.city_id", "cities.id")
                        ->leftJoin("countries", "users.country_id", "countries.id")
                        ->leftJoin("states", "users.state_id", "states.id");
                         $query->where(function($q) use($parts, $conditions) {
                             foreach ($parts as $key => $value) {
                                 if(!isset($conditions["users.country_id"])) {
                                    $q->orWhere('users.name', 'like', "%{$value}%")
                                    ->orWhere('countries.name', 'like', "%{$value}%")
                                    ->orWhere('states.name', 'like', "%{$value}%")
                                    ->orWhere('cities.name', 'like', "%{$value}%");
                                } 
                             }
                         }); 
                }
            }

            return $query->orderByDesc('id')->get();            
        } catch (Exception $e) {
            Log::error("Error in " . __CLASS__ . "::" . __FUNCTION__ . ": " . $e->getMessage());
            return null;
        }
        
    }


}