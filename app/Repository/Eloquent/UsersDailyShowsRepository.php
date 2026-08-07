<?php

namespace App\Repository\Eloquent;
use App\Models\UserDailyShow;
use Illuminate\Support\Facades\Log;

class UsersDailyShowsRepository {
    
    protected $userDailyShow;
    public function __construct(UserDailyShow $userDailyShow){
        $this->userDailyShow = $userDailyShow;
    }

    public function getRecords(array $where = [], array $select = ['*']) {
        try {
            $query = $this->userDailyShow->select($select);
            if(!empty($where)) {
               $query->where(); 
            }
            return $query->get()->toArray();
        } catch (\Exception $exception) {
            Log::error("Error in " . __CLASS__ . "::" . __FUNCTION__ . ": " . $exception->getMessage());
        }
    }
}
