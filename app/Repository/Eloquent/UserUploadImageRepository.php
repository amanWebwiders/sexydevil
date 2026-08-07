<?php

namespace App\Repository\Eloquent;
use App\Models\UploadedPhoto;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class UserUploadImageRepository {
    
    protected  $uploadedPhotomodel;
    public function __construct(UploadedPhoto $uploadedPhotomodel) {
        $this->uploadedPhotomodel = $uploadedPhotomodel;
    }

    public function getDataWhere(array $where = []) {
        try {
          $query = $this->uploadedPhotomodel->select('users.name', 'users.email', 'uploaded_photos.*');
          if(!empty($where)) {
              $query->where($where);
          }
          return $query->join('users', 'uploaded_photos.user_id', "users.id")->orderBy('uploaded_photos.id', 'desc')->get()->toArray();
        } catch (\Exception $exception) {
            Log::error("Error in " . __CLASS__ . "::" . __FUNCTION__ . ": " . $exception->getMessage());
            return [];
        }
    }

    public function updateRecord(array $where, array $data) {
        try {
          return $this->uploadedPhotomodel->where($where)->update($data);
        } catch (\Exception $exception) {
            Log::error("Error in " . __CLASS__ . "::" . __FUNCTION__ . ": " . $exception->getMessage());
            return false;
        }
    }

    public function getUserData(array $where) {
        try {
          return $this->uploadedPhotomodel->select('users.name', 'uploaded_photos.*', 'users.email')->where($where)
          ->join('users', 'uploaded_photos.user_id', "users.id")->first();
        } catch (\Exception $exception) {
            Log::error("Error in " . __CLASS__ . "::" . __FUNCTION__ . ": " . $exception->getMessage());
            return false;
        }
    }
}