<?php



namespace App\Repository\Eloquent;



use App\Models\{Agency, AgencyTeam, AgencyMedia};
use Illuminate\Contracts\Cache\Repository as Cache;

use Illuminate\Support\Facades\Log;
// use App\Models\NotificationModel;

use DB;



class AgencyRepository extends BaseRepository

{
    protected $model, $agencymodel, $agencyteam;

    protected $cache;
    public function __construct(

        Agency $model,
        AgencyMedia $agencymodel,
        AgencyTeam $agencyteam,


        Cache $cache,


    ) {

        $this->model = $model;
        $this->agencymodel = $agencymodel;
        $this->agencyteam = $agencyteam;

        parent::__construct($model, $cache);
    }

    public function create($allData)

    {

        try {

            return $this->model->with('teams', 'media')->create($allData);
        } catch (\Exception $e) {

            Log::error("Error in AgencyRepository.create(): " . $e->getMessage());

            throw $e;
        }
    }
    public function createagencymodel($allData)

    {

        try {

            return $this->agencymodel->create($allData);
        } catch (\Exception $e) {

            Log::error("Error in AgencyRepository.createagencymodel(): " . $e->getMessage());

            throw $e;
        }
    }
    public function createagencyteam($allData)

    {

        try {

            return $this->agencyteam->create($allData);
        } catch (\Exception $e) {

            Log::error("Error in AgencyRepository.createagencyteam(): " . $e->getMessage());

            throw $e;
        }
    }

    public function update($byWhere, $update)

    {

        try {

            return $this->model->with('teams', 'media')->where($byWhere)->update($update);
        } catch (\Exception $e) {

            Log::error("Error in AgencyRepository.update(): " . $e->getMessage());

            throw $e;
        }
    }



    public function getOne($byWhere)

    {

        try {

            $data = $this->model->with('teams', 'media')->select('*')->where($byWhere)->first();

            return $data;
        } catch (\Exception $e) {

            Log::error("Error in AgencyRepository.getOne(): " . $e->getMessage());

            throw $e;
        }
    }
    public function getOneAgencyMedia($byWhere)

    {

        try {

            $data = $this->agencymodel->select('*')->where($byWhere)->first();

            return $data;
        } catch (\Exception $e) {

            Log::error("Error in AgencyRepository.getOneAgencyMedia(): " . $e->getMessage());

            throw $e;
        }
    }




    public function getAll()

    {

        try {

            return $this->model->with('teams', 'media')->orderBy('id', 'desc')->get();
        } catch (\Exception $e) {

            Log::error("Error in AgencyRepository.getAll(): " . $e->getMessage());

            throw $e;
        }
    }

    public function getAllPaginated($perPage = 10)
    {
        try {
            return $this->model
                ->with(['teams', 'media'])
                ->orderBy('id', 'desc')
                ->paginate($perPage);
        } catch (\Exception $e) {
            Log::error("Error in AgencyRepository.getAllPaginated(): " . $e->getMessage());
            throw $e;
        }
    }

    public function delete($byWhere)

    {

        try {

            return $this->model->where($byWhere)->delete();
        } catch (\Exception $e) {

            Log::error("Error in AgencyRepository.delete(): " . $e->getMessage());

            throw $e;
        }
    }





public function getByWhere($byWhere, $orderBy = ['id' => 'desc'], $limit = null, $random = false)
{
    try {
        $query = $this->model->with('teams', 'media')->where(function ($query) use ($byWhere) {
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

        // ✅ random order
        if ($random) {
            $query->inRandomOrder();
        } else {
            foreach ($orderBy as $column => $direction) {
                $query->orderBy($column, $direction);
            }
        }

        // ✅ apply limit only if given
        if (!empty($limit)) {
            return $query->limit($limit)->get();
        }

        return $query->get();

    } catch (\Exception $e) {
        Log::error("Error in AgencyRepository.getByWhere(): " . $e->getMessage());
        return collect(); // return empty collection
    }
}

public function getByWhereteam($byWhere, $orderBy = ['id' => 'desc'], $limit = null, $random = false)
{
    try {
        $query = $this->agencyteam->where(function ($query) use ($byWhere) {
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

        // ✅ random order
        if ($random) {
            $query->inRandomOrder();
        } else {
            foreach ($orderBy as $column => $direction) {
                $query->orderBy($column, $direction);
            }
        }

        // ✅ apply limit only if given
        if (!empty($limit)) {
            return $query->limit($limit)->get();
        }

        return $query->get();

    } catch (\Exception $e) {
        Log::error("Error in AgencyRepository.getByWhere(): " . $e->getMessage());
        return collect(); // return empty collection
    }
}
}
