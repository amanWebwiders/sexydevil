<?php

namespace App\Repository\Eloquent;

use App\Models\Admin;
use Illuminate\Contracts\Cache\Repository as Cache;
use Illuminate\Support\Facades\Log;
use App\Models\CountryCode;

class AdminRepository extends BaseRepository{

    protected $model;
    protected $cache;
    protected $countrycodemodel;

    public function __construct(Admin $model,CountryCode $countrycodemodel, Cache $cache){
        $this->model = $model;
        $this->countrycodemodel = $countrycodemodel;
        parent::__construct($model, $cache);
    }
    public function getCountryCode(){
        try {
            return $this->countrycodemodel->orderBy('country', 'asc')->get();
        } catch(\Exception $e){
            Log::error("Error in AdminRepository.getCountryCode(): " . $e->getMessage());
            return response()->json(['status' => '0', 'message' => __('message.statusZero')]);
        }
    }
    public function updateadminProfile($byWhere, $allData){
        try {
            return $this->model->where($byWhere)->update($allData);
        } catch(\Exception $e){
            Log::error("Error in AdminRepository.updateadminProfile(): " . $e->getMessage());
            return response()->json(['status' => '0', 'message' => __('message.statusZero')]);
        }
    }
    public function updatePassword($byWhere, $adminPassword){
        try {
            return $this->model->where($byWhere)->update(['password' => $adminPassword['password']]);
        } catch(\Exception $e){
            Log::error("Error in AdminRepository.updatePassword(): " . $e->getMessage());
            return response()->json(['status' => '0', 'message' => __('message.statusZero')]);
        }
    }
    public function getAdminData($byWhere){
        try {
            return $this->model->where($byWhere)->first();
        } catch(\Exception $e){
            Log::error("Error in AdminRepository.getAdminData(): " . $e->getMessage());
            return response()->json(['status' => '0', 'message' => __('message.statusZero')]);
        }
    }
    public function create($allData)
    {
        try {
            return $this->model->create($allData);
        } catch (\Exception $e) {
            Log::error("Error in AdminRepository.create(): " . $e->getMessage());
            throw $e;
        }
    }

    public function update($byWhere, $update)
    {
        try {
            return $this->model->where($byWhere)->update($update);
        } catch (\Exception $e) {
            Log::error("Error in AdminRepository.update(): " . $e->getMessage());
            throw $e;
        }
    }

    public function getOne($byWhere)
    {
        try {
            return $this->model->select('*')->where($byWhere)->first();
           
        } catch (\Exception $e) {
            Log::error("Error in AdminRepository.getOne(): " . $e->getMessage());
            throw $e;
        }
    }


    public function getAll()
    {
        try {
            return $this->model->orderBy('id', 'desc')->get();
        } catch (\Exception $e) {
            Log::error("Error in AdminRepository.getAll(): " . $e->getMessage());
            return response()->json(['status' => '0', 'message' => __('message.statusZero')]);
        }
    }

    public function delete($byWhere)
    {
        try {
            return $this->model->where($byWhere)->delete();
        } catch (\Exception $e) {
            Log::error("Error in AdminRepository.delete(): " . $e->getMessage());
            return response()->json(['status' => '0', 'message' => __('message.statusZero')]);
        }
    }

    public function getByWhere($byWhere, $orderBy = ['id' => 'desc'])
    {
        try {
            $query = $this->model->with('occupation')->where(function ($query) use ($byWhere) {

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
            Log::error("Error in AdminRepository.getUsersByWhere(): " . $e->getMessage());
            return response()->json(['status' => '0', 'message' => __('message.statusZero')]);
        }
    }
}
