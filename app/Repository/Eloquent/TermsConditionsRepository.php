<?php
namespace App\Repository\Eloquent;

use App\Models\TermsCondition;
use Illuminate\Support\Facades\Log;

class TermsConditionsRepository {
    protected $termsCondition;    
    public function __construct(TermsCondition $termsCondition) {
        $this->termsCondition = $termsCondition;
    }

    public function getSingleDataWhere($bywhere) {
        try { 
            return $this->termsCondition->where($bywhere)->first();
        } catch (\Exception $exception) {
            Log::error("Error in " . __CLASS__ . "::" . __FUNCTION__ . ": " . $exception->getMessage());
        }
    }

    public function updateContentWhere($bywhere, $data) {
        try { 
            return $this->termsCondition->where($bywhere)->update($data);
        } catch (\Exception $exception) {
            Log::error("Error in " . __CLASS__ . "::" . __FUNCTION__ . ": " . $exception->getMessage());
        }
    }

    public function getAllData(array $where = []) {
        try { 
            $query = $this->termsCondition->select('*');
            if(!empty($where)) {
                $query->where($where);
            }
            return $query->get();
        } catch (\Exception $exception) {
            Log::error("Error in " . __CLASS__ . "::" . __FUNCTION__ . ": " . $exception->getMessage());
        }
    }
}