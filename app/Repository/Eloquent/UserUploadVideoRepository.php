<?php
namespace App\Repository\Eloquent;
use App\Models\Video;
use Illuminate\Support\Facades\Log; 
use Illuminate\Support\Facades\DB;
class UserUploadVideoRepository {
    
    protected  $uploadedVideomodel;
    public function __construct(Video $uploadedVideomodel) {
        $this->uploadedVideomodel = $uploadedVideomodel;
    }

    public function getDataWhere(array $where = []) {
        try {
          $query = $this->uploadedVideomodel->select('users.name', 'users.email', 'videos.*');
          if(!empty($where)) {
              $query->where($where);
          }
          return $query->join('users', 'videos.user_id', "users.id")->orderBy('videos.id', 'desc')->get()->toArray();
        } catch (\Exception $exception) {
            Log::error("Error in " . __CLASS__ . "::" . __FUNCTION__ . ": " . $exception->getMessage());
            return [];
        }
    }

    public function updateRecord(array $where, array $data) {
        try {
          return $this->uploadedVideomodel->where($where)->update($data);
        } catch (\Exception $exception) {
            Log::error("Error in " . __CLASS__ . "::" . __FUNCTION__ . ": " . $exception->getMessage());
            return false;
        }
    }

    public function getUserData(array $where) {
        try {
          return $this->uploadedVideomodel->select('users.name', 'videos.*', 'users.email')->where($where)
          ->join('users', 'videos.user_id', "users.id")->first();
        } catch (\Exception $exception) {
            Log::error("Error in " . __CLASS__ . "::" . __FUNCTION__ . ": " . $exception->getMessage());
            return false;
        }
    }
}