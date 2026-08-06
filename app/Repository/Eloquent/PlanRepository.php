<?php



namespace App\Repository\Eloquent;



use App\Models\Plan;
use Illuminate\Contracts\Cache\Repository as Cache;

use Illuminate\Support\Facades\Log;
// use App\Models\NotificationModel;

use DB;



class PlanRepository extends BaseRepository

{
    protected $model;

    protected $cache;
    public function __construct(

        Plan $model,
     

        Cache $cache,


    ) {

        $this->model = $model;
     
        parent::__construct($model, $cache);
    }

    public function create($allData)

    {

        try {

            return $this->model->create($allData);
        } catch (\Exception $e) {

            Log::error("Error in PlanRepository.create(): " . $e->getMessage());

            throw $e;
        }
    }

    public function update($byWhere, $update)

    {

        try {

            return $this->model->where($byWhere)->update($update);
        } catch (\Exception $e) {

            Log::error("Error in PlanRepository.update(): " . $e->getMessage());

            throw $e;
        }
    }



    public function getOne($byWhere) {
        try {
            return $this->model->select('*')->where($byWhere)->first();
        } catch (\Exception $e) {
            Log::error("Error in PlanRepository.getOne(): " . $e->getMessage());
            throw $e;
        }
    }





    public function getAll()

    {

        try {

            return $this->model->orderBy('days', 'asc')->get();
        } catch (\Exception $e) {

            Log::error("Error in PlanRepository.getAll(): " . $e->getMessage());

            throw $e;
        }
    }



    public function delete($byWhere)

    {

        try {

            return $this->model->where($byWhere)->delete();

        } catch (\Exception $e) {

            Log::error("Error in PlanRepository.delete(): " . $e->getMessage());

            throw $e;
        }
    }





    public function getByWhere($byWhere, $orderBy = ['id' => 'desc'])

    {

        try {

            $query = $this->model->where(function ($query) use ($byWhere) {



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

            Log::error("Error in PlanRepository.getByWhere(): " . $e->getMessage());

            return response()->json(['status' => '0', 'message' => __('message.statusZero')]);
        }
    }


    
}
