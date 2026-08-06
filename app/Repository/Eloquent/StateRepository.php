<?php
namespace App\Repository\Eloquent;
use App\Models\{State};
use Illuminate\Support\Facades\Log;

class StateRepository  {
    protected $model;

    public function __construct(State $model) {
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

    public function getAll(array $where = [], array $select = ['*'], $limit = null) {
        try {
            $query = $this->model->select($select);
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
            return $this->model->select($select)->where($where)->first();
        } catch (\Exception $exception) {
            Log::error("Error in " . __CLASS__ . "::" . __FUNCTION__ . ": " . $exception->getMessage());
            return false;
        }
    }
}