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
            $countryId = (isset($inputs["country"]) && $inputs["country"] == "worldwide") ? 0 : ($inputs["country"] ?? 0);
            $stateId = !empty($inputs["state"]) ? $inputs["state"] : null;
            $cityId = !empty($inputs["city"]) ? $inputs["city"] : null;
            $title = $inputs["title"] ?? null;

            $where = [
                "country_id" => $countryId,
                "state_id" => $stateId,
                "city_id" => $cityId,
                "title" => $title
            ];

            $country = $this->countryRepository->getSingleRecordWhere(["id" => $countryId]);
            $state = $stateId ? $this->stateRepository->getSingleRecordWhere(["id" => $stateId]) : null;
            $city = $cityId ? $this->cityRepository->getSingleRecordWhere(["id" => $cityId]) : null;

            $data = [
                "country_id" => $countryId,
                "state_id" => $stateId,
                "city_id" => $cityId,
                "country" => ($inputs["country"] ?? '') == "worldwide" ? 'worldwide' : ($country["name"] ?? 'worldwide'),
                "state" => $state["name"] ?? null,
                "city" => $city["name"] ?? null,
                "content" => $inputs["content"] ?? "",
                "title" => $title,
                "meta_title" => $inputs["meta_title"] ?? null,
                "meta_description" => $inputs["meta_description"] ?? null,
                "image_alt_text" => $inputs["image_alt_text"] ?? null,
                "meta_keywords" => $inputs["meta_keywords"] ?? null,
                "seo_url_slug" => $inputs["seo_url_slug"] ?? null,
                "canonical_url" => $inputs["canonical_url"] ?? null,
                "robots_setting" => $inputs["robots_setting"] ?? null,
                "og_title" => $inputs["og_title"] ?? null,
                "og_description" => $inputs["og_description"] ?? null,
                "twitter_title" => $inputs["twitter_title"] ?? null,
                "twitter_description" => $inputs["twitter_description"] ?? null,
            ];

            if (isset($inputs['og_image']) && $inputs['og_image'] instanceof \Illuminate\Http\UploadedFile) {
                $file = $inputs['og_image'];
                $filename = time() . '_og.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/seo'), $filename);
                $data['og_image'] = 'uploads/seo/' . $filename;
            }

            if (isset($inputs['twitter_image']) && $inputs['twitter_image'] instanceof \Illuminate\Http\UploadedFile) {
                $file = $inputs['twitter_image'];
                $filename = time() . '_tw.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/seo'), $filename);
                $data['twitter_image'] = 'uploads/seo/' . $filename;
            }

            $run = $this->locationSeoContentRepository->createOrUpdate($where, $data);
            return ["status" => $run ? 200 : 400, "message" => $run ? __('message.common_success') : __('message.something_went_wrong')];
        } catch (\Exception $exception) {
            Log::error("Error in " . __CLASS__ . "::" . __FUNCTION__ . ": " . $exception->getMessage());
            return ['status' => 400, "message" => __('message.something_went_wrong')];
        }
    }

    public function getLocationSeoContent($inputs) {
        try {
            $countryId = (isset($inputs["country"]) && $inputs["country"] == "worldwide") ? 0 : ($inputs["country"] ?? 0);
            $stateId = !empty($inputs["state"]) ? $inputs["state"] : null;
            $cityId = !empty($inputs["city"]) ? $inputs["city"] : null;
            $title = $inputs["title"] ?? null;

            $where = [
                "state_id" => $stateId,
                "city_id" => $cityId,
                "title" => $title
            ];

            if (isset($inputs["country"]) && $inputs["country"] == "worldwide") {
                $run = $this->locationSeoContentRepository->getSingleRecordWhere(array_merge($where, ["country" => "worldwide"]));
                if (!$run) {
                    $run = $this->locationSeoContentRepository->getSingleRecordWhere(array_merge($where, ["country_id" => 0]));
                }
            } else {
                $run = $this->locationSeoContentRepository->getSingleRecordWhere(array_merge($where, ["country_id" => $countryId]));
            }

            return ["status" => $run ? 200 : 400, "message" => $run ];
        } catch (\Exception $exception) {
            Log::error("Error in " . __CLASS__ . "::" . __FUNCTION__ . ": " . $exception->getMessage());
            return ['status' => 400, "message" => __('message.something_went_wrong')];
        }
    }
}
