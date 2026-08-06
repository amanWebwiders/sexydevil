<?php
namespace App\Repository\Eloquent;
use App\Models\{FeatureDevil};
use Illuminate\Support\Facades\Log;
class FeatureDevilRepository {
    protected $model;
    public function __construct(FeatureDevil $model) {
        $this->model = $model;
    }
    public function getAllRecordWhere(array $where = [], array $select = ['*']) {
        try {
            $query = $this->model->select($select);
            if(!empty($where)) {
                $query->where($where);
            }
            return $query->get();
        } catch (\Exception $exception) {
                Log::error("Error in " . __CLASS__ . "::" . __FUNCTION__ . ": " . $exception->getMessage());
        }
    }
    public function create(array $data) {
        try {
            return $this->model->insert($data);
        } catch (\Exception $exception) {
            Log::error("Error in " . __CLASS__ . "::" . __FUNCTION__ . ": " . $exception->getMessage());
        }
    }
    public function getAllRecordByDate(array $where = [], array $select = ['feature_devils.*', 'users.name', 'users.email'], array $whereInUsers) {
        try {
                $query = $this->model->select($select);
            if(!empty($where)) {
                    $query->join("users", "feature_devils.user_id", "users.id");
                if(isset($where["country"])) {
                        $query->where("users.country_id", $where["country"]);
                }
                if(isset($where["state"])) {
                        $query->where("users.state_id", $where["state"]);
                }
                if(isset($where["city"])) {
                        $query->where("users.city_id", $where["city"]);
                }
                if(isset($where["start_date"]) && isset($where["end_date"])) {
                        $query->whereBetween('feature_devils.date', [$where["start_date"], $where["end_date"]]);
                }
                if(!empty($whereInUsers)) {
                        $query->whereIn('users.id', $whereInUsers);
                }
                
                $current_date = now()->format('Y-m-d');
                $query->where([
                        ['users.plan_start_date', '<=', $current_date],
                    ['users.plan_end_date', '>=', $current_date]
                ]);
            }
            return $query->get();
        } catch (\Exception $exception) {
                Log::error("Error in " . __CLASS__ . "::" . __FUNCTION__ . ": " . $exception->getMessage());
        }
    }
}