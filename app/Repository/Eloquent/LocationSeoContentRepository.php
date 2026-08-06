<?php

namespace App\Repository\Eloquent;

use App\Models\LocationSeoContent;
use Illuminate\Support\Facades\Log;

class LocationSeoContentRepository {
    protected $model;

    public function __construct(LocationSeoContent $model) {
        $this->model = $model;
    }

    public function createOrUpdate(array $where, array $data) {
        try {
            return $this->model->updateOrCreate($where, $data);
        } catch (\Exception $exception) {
            Log::error("Error in " . __CLASS__ . "::" . __FUNCTION__ . ": " . $exception->getMessage());
            return false;
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