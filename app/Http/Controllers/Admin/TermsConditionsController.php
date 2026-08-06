<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Repository\Eloquent\{TermsConditionsRepository, ContactSettingRepository, StateRepository, CountryRepository, CityRepository};
use App\Services\Admin\ContentSettingsServices;

class TermsConditionsController extends Controller {
    
    protected $termsConditionsRepository, $contactSettingRepository, $contentSettingsServices, $countryRepository, $stateRepository, $cityRepository;

    public function __construct(TermsConditionsRepository $termsConditionsRepository,
    ContactSettingRepository $contactSettingRepository, ContentSettingsServices $contentSettingsServices, CountryRepository $countryRepository, StateRepository $stateRepository, CityRepository $cityRepository) {
        $this->termsConditionsRepository = $termsConditionsRepository;
        $this->contactSettingRepository = $contactSettingRepository;
        $this->contentSettingsServices  = $contentSettingsServices;
        $this->countryRepository = $countryRepository;
        $this->stateRepository = $stateRepository;
        $this->cityRepository = $cityRepository;
    }
    public function adminTerms() {
        try {
        $terms = $this->termsConditionsRepository->getSingleDataWhere(["id" => 1]);
        return view('admin.terms-conditions', compact('terms'));
        } catch (\Exception $exception) {
            Log::error("Error in " . __CLASS__ . "::" . __FUNCTION__ . ": " . $exception->getMessage());
            return redirect()->back()->with('error', 'Something went wrong.');            
        }
    }

    public function adminPrivacy() {
        try {
        $terms = $this->termsConditionsRepository->getSingleDataWhere(["id" => 2]);
        return view('admin.terms-conditions', compact('terms'));
        } catch (\Exception $exception) {
            Log::error("Error in " . __CLASS__ . "::" . __FUNCTION__ . ": " . $exception->getMessage());
            return redirect()->back()->with('error', 'Something went wrong.');
            
        }
    }
    

    public function adminTermsUpdate(Request $request) {
        try {
           $run = $this->termsConditionsRepository->updateContentWhere(["id" => $request->id], ["content" => $request->content]);
           if($run) {
               return redirect()->back()->with('success', 'Data updated successfully !!');
           }
        } catch (\Exception $exception) {
            Log::error("Error in " . __CLASS__ . "::" . __FUNCTION__ . ": " . $exception->getMessage());
        }
        return redirect()->back()->with('error', 'Something went wrong.')->withInput();
    }

    public function contactPageContent() {
        try {
            $content = $this->contactSettingRepository->getSingleDataWhere(["id" => 1]);
            return view('admin.contact-page-content', compact('content'));
        } catch (\Exception $exception) {
            Log::error("Error in " . __CLASS__ . "::" . __FUNCTION__ . ": " . $exception->getMessage());
            return redirect()->back()->with('error', 'Something went wrong.');            
        }
    }

    public function contactPageContentUpdate(Request $request) {
        try {
            $this->contentSettingsServices->updateContent($request->all());
        } catch (\Exception $exception) {
            Log::error("Error in " . __CLASS__ . "::" . __FUNCTION__ . ": " . $exception->getMessage());
            return redirect()->back()->with('error', 'Something went wrong.');            
        }
        return redirect()->back()->with('success', 'Data updated successfully !!');
    }   
    
    public function locationSeoContent() {
        try {
            $countries = $this->countryRepository->getAllRecordWhere();
            return view('admin.location-seo-content', compact('countries'));
        } catch (\Exception $exception) {
            Log::error("Error in " . __CLASS__ . "::" . __FUNCTION__ . ": " . $exception->getMessage());
            return redirect()->back()->with('error', 'Something went wrong.');            
        }
    }

    public function loadStates(Request $request) {
        try {
            $states = $this->stateRepository->getAllWhere(["country_id" => $request->country_id], ["id", "name"]);
            return response()->json($states);
        } catch (\Exception $exception) {
            Log::error("Error in " . __CLASS__ . "::" . __FUNCTION__ . ": " . $exception->getMessage());
            return response()->json([]);
        }
    }

    public function loadCities(Request $request) {
        try {
            $cities = $this->cityRepository->getAllWhere(["state_id" => $request->state_id], ["id", "name"]);
            return response()->json($cities);
        } catch (\Exception $exception) {
            Log::error("Error in " . __CLASS__ . "::" . __FUNCTION__ . ": " . $exception->getMessage());
            return response()->json([]);
        }
    }

    public function locationSeoContentStore(Request $request) {
        try {
            return $this->contentSettingsServices->updateLocationSeoContent($request->all());
        } catch (\Exception $exception) {
            Log::error("Error in " . __CLASS__ . "::" . __FUNCTION__ . ": " . $exception->getMessage());
            return ['status' => 400, "message" => __('message.something_went_wrong')];
         }
    }

    public function getLocationSeoContent(Request $request) {
        try {
            $content = $this->contentSettingsServices->getLocationSeoContent($request->all());
            return ['status' => $content['status'], "data" => $content];
        } catch (\Exception $exception) {
            Log::error("Error in " . __CLASS__ . "::" . __FUNCTION__ . ": " . $exception->getMessage());
            return ['status' => 400, "message" => __('message.something_went_wrong')];
         }
     }
}
