<?php
namespace App\Repository\Eloquent;
use App\Models\{City};
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CityRepository {
    protected $model;

    public function __construct(City $model) {
        $this->model = $model;
    }

    public function getAllRecordWhere(array $where = [], array $select = ['*'], $limit = null) {
        try {
            $query = $this->model->whereHas('users')->select($select);
            if(!empty($where)) {
               $query->where($where);
            }
            if(isset($limit)) {
                $query->limit($limit)->inRandomOrder();
            }
            $query->withCount('users')->orderBy('name');
            return $query->get();
        } catch (\Exception $exception) {
            Log::error("Error in " . __CLASS__ . "::" . __FUNCTION__ . ": " . $exception->getMessage());
        }
    }

    public function getSingleRecordWhere(array $where, array $select = ['*']) {
        try {
            $record = $this->model->select($select)->where($where)->first();
            if(isset($record) && !empty($record)) {
                return $record;
            } else {
                $query = $this->model->select($select);
                foreach ($where as $key => $value) {
                    $query->where(function($q) use($key, $value) {
                        $q->where($key, 'like', "%{$value}%");
                        $q->orWhere($key, 'like', "%{$value}%");
                    });
                }
               return $query->first();
            }
        } catch (\Exception $exception) {
            Log::error("Error in " . __CLASS__ . "::" . __FUNCTION__ . ": " . $exception->getMessage());
            return false;
        }
    }

    public function getCityWhereUserExist(array $where, array $select = ['cities.*'], $userType = "normal", $inputs = []) {
        try {
            $record = $this->model->select($select)->where($where);
            if($userType == "normal") {                
                $record->join('users', 'cities.id', '=', 'users.city_id');
            } else if($userType == "feature") {
                $record->join('feature_devils', 'cities.id', '=', 'feature_devils.city_id');
                if(isset($inputs['date'])) {
                    $record->where('feature_devils.date', $inputs['date']);
                }
            }
            $record = $record->first();
            if(isset($record) && !empty($record)) {
                return $record;
            } else {

                $query = $this->model->select($select);
                if($userType == "normal") {                
                    $query->join('users', 'cities.id', '=', 'users.city_id');
                } else if($userType == "feature") {
                    $query->join('feature_devils', 'cities.id', '=', 'feature_devils.city_id');
                    if(isset($inputs['date'])) {
                        $query->where('feature_devils.date', $inputs['date']);
                    }
                }
                $query->leftJoin('states', 'users.state_id', '=', 'states.id');
                $query->leftJoin('countries', 'users.country_id', '=', 'countries.id');
                foreach ($where as $key => $value) {
                    $query->where(function($q) use($key, $value) {
                        $q->where($key, 'like', "%{$value}%");
                        $q->orWhere($key, 'like', "%{$value}%");
                        $q->orWhere('states.name', 'like', "%{$value}%");
                        $q->orWhere('countries.name', 'like', "%{$value}%");
                    });
                }
               return $query->first();
            }
        } catch (\Exception $exception) {
            Log::error("Error in " . __CLASS__ . "::" . __FUNCTION__ . ": " . $exception->getMessage());
            return null;
        }
    }

    public function getUsersCount(array $where, $inputes = []) {
        try {
            $query = $this->model->select('cities.name',  DB::raw('COUNT(users.id) as total_users'))->where($where)->join('users', 'cities.id', '=', 'users.city_id');
            if(isset($inputes) && !empty($inputes)) {
                $parts = explode(" ", $inputes["city"]);
                if(!empty($parts)) {
                    foreach ($parts as $key => $value) {
                        $query->where(function($q) use($value) {
                            $q->orWhere('cities.name', 'like', "%{$value}%");
                        });
                    }
                }
                return $query->groupBy('cities.id', 'cities.name')->get();
            } else {
                return collect();
            }
        } catch (\Exception $exception) {
            Log::error("Error in " . __CLASS__ . "::" . __FUNCTION__ . ": " . $exception->getMessage(). ": " . $exception->getLine());
            return collect();
        }
    }
    public function getAllWhere(array $where = [], array $select = ['*']) {
        try {
            $query = $this->model->select($select);
            if(!empty($where)) {
               $query->where($where);
            }
            $query->orderBy('name');
            return $query->get();
        } catch (\Exception $exception) {
            Log::error("Error in " . __CLASS__ . "::" . __FUNCTION__ . ": " . $exception->getMessage());
        }
    }    

}