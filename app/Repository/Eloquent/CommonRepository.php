<?php



namespace App\Repository\Eloquent;

use Illuminate\Contracts\Cache\Repository as Cache;
use Illuminate\Support\Facades\Log;

class CommonRepository
{
    protected $model;
    protected $cache;

    public function __construct(Cache $cache)
    {
        $this->cache = $cache;
    }

    public function setModel($model)
    {
        if (is_string($model)) {
            $modelClass = "App\\Models\\$model";
            if (!class_exists($modelClass)) {
                throw new \Exception("Model $modelClass does not exist.");
            }
            $model = new $modelClass;
        }

        $this->model = $model;
        return $this;
    }
    public function create($allData)

    {

        try {

            return $this->model->create($allData);
        } catch (\Exception $e) {

            Log::error("Error in CommonRepository.create(): " . $e->getMessage());

            throw $e;
        }
    }

    public function update($byWhere, $update)

    {

        try {

            return $this->model->where($byWhere)->update($update);
        } catch (\Exception $e) {

            Log::error("Error in CommonRepository.update(): " . $e->getMessage());

            throw $e;
        }
    }



    public function getOne($byWhere)

    {

        try {

            $data = $this->model->select('*')->where($byWhere)->first();

            return $data;
        } catch (\Exception $e) {

            Log::error("Error in CommonRepository.getOne(): " . $e->getMessage());

            throw $e;
        }
    }





    public function getAll()

    {

        try {

            return $this->model->orderBy('name','asc')->get();
        } catch (\Exception $e) {

            Log::error("Error in CommonRepository.getAll(): " . $e->getMessage());

            throw $e;
        }
    }



    public function delete($byWhere)

    {

        try {

            return $this->model->where($byWhere)->delete();
        } catch (\Exception $e) {

            Log::error("Error in CommonRepository.delete(): " . $e->getMessage());

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

            Log::error("Error in CommonRepository.getByWhere(): " . $e->getMessage());

            return response()->json(['status' => '0', 'message' => __('message.statusZero')]);
        }
    }
}
