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
        $metaContent = [
            "title" => "Escort Agencies & Independent Listings | Global Directory",
            "description" => "Browse escort agencies and independent profiles worldwide. Discover listings across UK, Colombia & Germany with 24/7 escort service access."
        ];
        return view('front.agencies', compact('agencies', 'locationSeoContent', 'metaContent'));
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

          
            return view('front.agency-detail', compact('agency', 'teams'));
        } catch (\Exception $e) {
            \Log::error("Error in AgencyController.detail(): " . $e->getMessage());

            return redirect()->route('admin.agency-list')->with('error', 'Something went wrong.');
        }
    }
}
