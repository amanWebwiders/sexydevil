<?php
namespace App\Repository\Eloquent;
use App\Models\{Country};
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CountryRepository {
    protected $model;

    public function __construct(Country $model) {
        $this->model = $model;
    }

    public function getAllRecordWhere(array $where = [], array $select = ['*']) {
        try {
            $query = $this->model->select($select);
            if(!empty($where)) {
               $query->where($where);
            }
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
        }
    }

    public function getCountryWithUserCount(array $where = [])  {
        try {
            $countries = $this->model->whereHas('states.activeUsers')
                ->withCount('activeUsers')
                ->with([
                    'states' => function ($q) {
                        $q->whereHas('activeUsers')
                        ->withCount('activeUsers')
                        ->with([
                            'cities' => function ($q2) {
                                $q2->whereHas('activeUsers')
                                    ->withCount('activeUsers');
                            }
                        ]);
                    }
                ])
                ->orderBy('name')
                ->get();
            //dd($countries->toArray());
            $formatted = $countries->map(function ($country) {
               $flag = asset('images/flags/'.strtolower(emojiToCountryCode($country->emoji).'.svg'));

                return [
                    'id' => $country->id,   
                    'country' => $country->name,
                    'emoji' => $country->emoji,
                    'flag' => $flag,
                    'total_users' => $country->active_users_count,/* 
                    'cities' => $country->cities->map(function ($city) {
                        return [
                            'id' => $city->id,
                            'city' => $city->name,
                            'total_users' => $city->users_count,
                        ];
                    }), */
                    'states' => $country->states->map(function ($state) {
                        return [
                            'id' => $state->id,
                            'state' => $state->name,
                            'total_users' => $state->active_users_count,
                            'cities' => $state->cities->map(function ($city) {
                                return [
                                    'id' => $city->id,
                                    'city' => $city->name,
                                    'total_users' => $city->active_users_count,
                                ];
                            }),
                        ];
                    }),
                ];
            });

            return $formatted->toArray();

        } catch (\Exception $exception) {
            Log::error("Error in " . __CLASS__ . "::" . __FUNCTION__ . ": " . $exception->getMessage());
        }        
    }
}