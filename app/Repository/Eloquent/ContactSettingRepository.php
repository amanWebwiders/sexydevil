<?php
namespace App\Repository\Eloquent;

use App\Models\ContactSetting;
use Illuminate\Support\Facades\Log;

class ContactSettingRepository {
    protected $contactSetting;
    public function __construct(ContactSetting $contactSetting) {
        $this->contactSetting = $contactSetting;
    }

    public function getSingleDataWhere($bywhere) {
        try { 
            return $this->contactSetting->where($bywhere)->first();
        } catch (\Exception $exception) {
            Log::error("Error in " . __CLASS__ . "::" . __FUNCTION__ . ": " . $exception->getMessage());
        }
    }

    public function updateDataWhere($bywhere, $data) {
        try { 
            return $this->contactSetting->where($bywhere)->update($data);
        } catch (\Exception $exception) {
            Log::error("Error in " . __CLASS__ . "::" . __FUNCTION__ . ": " . $exception->getMessage());
        }
    }
}