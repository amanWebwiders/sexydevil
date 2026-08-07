<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Front\UserServices;
use Illuminate\Support\Facades\Log;
use App\Repository\Eloquent\UserRepository;
use App\Repository\Eloquent\AgencyRepository;
use App\Http\Requests\FrontEnd\{
    UserRequest,
    LoginRequest,
    ContactRequest,
    UserChangePasswordRequest,
    UserForgotPasswordRequest,
    UserResetPasswordRequest
};
use Validator;
use App\Services\Admin\AgencyServices;
use Illuminate\Support\Facades\Auth;

class AgencyController extends Controller
{
    protected $AgencyRepository, $userServices;
    protected $AgencyServices;

    public function __construct(AgencyRepository $AgencyRepository, AgencyServices $AgencyServices, UserServices $userServices)
    {
        $this->AgencyRepository = $AgencyRepository;
        $this->userServices = $userServices;
        $this->AgencyServices = $AgencyServices;
    }
    public function index(Request $request, $city = null)
    {
        $locationSeoContent = $this->userServices->getLocationSeoContent($city, "Agencies");        
        //dd($locationSeoContent);
        $agencies = $this->AgencyRepository->getAllPaginated(10);;
        // dd($agencies);
        return view('front.agencies', compact('agencies', 'locationSeoContent'));
    }
    public function detail($id)
    {
        try {
            $agency = $this->AgencyRepository->getOne(['id' => $id]);
            $teams = $this->AgencyRepository->getByWhereteam(
                ['agency_id' => $id], // filter
                [],                   // no specific orderBy
                8,                    // limit
                true                  // random
            );

            $locationSeoContent = $this->userServices->getLocationSeoContent($agency->city_id ?? null, "Agency Profile");
            $pageTitle = $agency->name ?? 'Agency Profile';
            $seoOgImage = !empty($agency->agency_logo) ? config('app.img_url') . $agency->agency_logo : null;
            return view('front.agency-detail', compact('agency', 'teams', 'locationSeoContent', 'pageTitle', 'seoOgImage'));
        } catch (\Exception $e) {
            \Log::error("Error in AgencyController.detail(): " . $e->getMessage());

            return redirect()->route('admin.agency-list')->with('error', 'Something went wrong.');
        }
    }
}
