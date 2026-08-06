<?php
namespace App\Services\Admin;

use App\Repository\Eloquent\{ContactSettingRepository, LocationSeoContentRepository, CountryRepository, StateRepository, CityRepository};
use Illuminate\Support\Facades\Log;

class ContentSettingsServices {
    protected $contactSettingRepository;
    protected $locationSeoContentRepository;
    protected $countryRepository, $stateRepository, $cityRepository;

    public function __construct(
    ContactSettingRepository $contactSettingRepository, LocationSeoContentRepository $locationSeoContentRepository, CountryRepository $countryRepository, StateRepository $stateRepository, CityRepository $cityRepository) {
        $this->contactSettingRepository = $contactSettingRepository;
        $this->locationSeoContentRepository = $locationSeoContentRepository;
        $this->countryRepository = $countryRepository;
        $this->stateRepository = $stateRepository;
        $this->cityRepository = $cityRepository;
    }

    public function updateContent($inputs) {
        try { 
            $update = [
                "phone_no" => $inputs["phone_no"] ?? 0,
                "alter_phone_no" => $inputs["alter_phone_no"] ?? 0,
                "email" => $inputs["email"] ?? 0,
                "address" => $inputs["address"] ?? "-",
                "telegram_active" => $inputs["telegram_active"] ?? 2,
                "telegram" => $inputs["telegram"] ?? null,
                "facebook_active" => $inputs["facebook_active"] ?? 2,
                "facebook" => $inputs["facebook"] ?? null,
                "instagram_active" => $inputs["instagram_active"] ?? 2,
                "intagram" => $inputs["intagram"] ?? null,
                "whatsApp_no" => $inputs["whatsApp_no"] ?? null,
                "video_convert_url" => $inputs["video_convert_url"] ?? null
            ];
            return $this->contactSettingRepository->updateDataWhere(["id" => 1], $update);
        } catch (\Exception $exception) {
            Log::error("Error in " . __CLASS__ . "::" . __FUNCTION__ . ": " . $exception->getMessage());
        }
    }

    public function updateLocationSeoContent($inputs) {
        try {
            $where = [
                "country_id" => $inputs["country"] == "worldwide" ? 0 : $inputs["country"],
                "state_id" => $inputs["state"] ?? null,
                "city_id" => $inputs["city"] ?? null,
                "title" => $inputs["title"]
            ];
            $country = $this->countryRepository->getSingleRecordWhere(["id" => $inputs["country"] ?? 0]);
            $state = $this->stateRepository->getSingleRecordWhere(["id" => $inputs["state"] ?? null]);
            $city = null;
            if(isset($inputs["city"]) && $inputs["city"] != null) {
                $where["city_id"] = $inputs["city"];
                $city = $this->cityRepository->getSingleRecordWhere(["id" => $inputs["city"] ?? null]);
            }
            $data = [
                "country" => $inputs["country"] == "worldwide" ? 'worldwide' : $country["name"],
                "state" => $state["name"] ?? null,
                "city" => $city["name"] ?? null,
                "content" => $inputs["content"] ?? null
            ];
            $run = $this->locationSeoContentRepository->createOrUpdate($where, $data);
            return ["status" => $run ? 200 : 400, "message" => $run ? __('message.common_success') : __('message.something_went_wrong')];
        } catch (\Exception $exception) {
            Log::error("Error in " . __CLASS__ . "::" . __FUNCTION__ . ": " . $exception->getMessage());
            return ['status' => 400, "message" => __('message.something_went_wrong')];
        }
    }

    public function getLocationSeoContent($inputs) {
        try {

            if(isset($inputs["country"]) && $inputs["country"] == "worldwide") {                
                $where = [ "country" => $inputs["country"] ];
            } else {
                $where = [ "country_id" => $inputs["country"] ];
            }
            $where["state_id"] = null;
            $where["city_id"] = null;
            if(isset($inputs["state"]) && $inputs["state"] != null) {
                $where["state_id"] = $inputs["state"];
            }
            if(isset($inputs["city"]) && $inputs["city"] != null) {
                $where["city_id"] = $inputs["city"];
            }
            $where["title"] = $inputs["title"];
            $run = $this->locationSeoContentRepository->getSingleRecordWhere($where);
            return ["status" => $run ? 200 : 400, "message" => $run ];
        } catch (\Exception $exception) {
            Log::error("Error in " . __CLASS__ . "::" . __FUNCTION__ . ": " . $exception->getMessage());
            return ['status' => 400, "message" => __('message.something_went_wrong')];
        }
    }
}    