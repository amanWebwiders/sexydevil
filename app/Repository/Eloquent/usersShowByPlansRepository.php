<?php
namespace App\Repository\Eloquent;

use App\Models\userVisibilityLog;
use Illuminate\Support\Facades\Log;

class usersShowByPlansRepository {
    protected $userDailyShow;
    public function __construct(userVisibilityLog $userDailyShow){
        $this->userDailyShow = $userDailyShow;
    }

    public function create($allData) {
        try {
            return $this->userDailyShow->create($allData);
        } catch (\Exception $e) {
            Log::error("Error in usersShowByPlansRepository.create(): " . $e->getMessage());
            return false;
        }
    }
}
