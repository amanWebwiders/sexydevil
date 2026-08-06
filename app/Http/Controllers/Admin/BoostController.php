<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Repository\Eloquent\{CountryRepository, StateRepository, CityRepository, UserRepository};
use App\Services\Admin\UserServices;
use Yajra\DataTables\Facades\DataTables;
class BoostController extends Controller
{
    protected $countryRepository, $stateRepository, $cityRepository, $userRepository, $userServices;

    public function __construct(CountryRepository $countryRepository,
    StateRepository $stateRepository, CityRepository $cityRepository, UserRepository $userRepository,
    UserServices $userServices) {
        $this->countryRepository = $countryRepository;
        $this->stateRepository = $stateRepository;
        $this->cityRepository = $cityRepository;
        $this->userRepository = $userRepository;
        $this->userServices = $userServices;
    }
    public function index() {
        try {
            $my_country = $this->countryRepository->getCountryWithUserCount();
            // dd($my_country);
            $state = collect();
           
            $db_city = collect();
           
            $current_date = now()->format('Y-m-d');

            $where = ["type" => 2, ['users.plan_start_date', '<=', $current_date], ['users.plan_end_date', '>=', $current_date]];
            if(isset($my_country[0]->id)) {
                $where["country_id"] = $my_country[0]->id;
            }
       
            $users = $this->userRepository->getAllWhere($where, ["id", "name", "email"]);
            return view('admin.boost-user-list', compact('my_country', 'state', 'db_city', 'users'));
        } catch (\Exception $e) {
            Log::error('Error in BoostController/index :' . $e->getMessage() . 'in line' . $e->getLine());
            return redirect()->route('admin.dashboard')->withErrors(['error' => __('message.something_went_wrong')]);
        }
    }

    public function fetchModels(Request $request) {
        try {
            $users = $this->userServices->fetchExistFeatureDevils($request->all());
            return response()->json(["status" => $users["status"], "record" => $users["data"]]);
        } catch (\Exception $e) {
            Log::error('Error in BoostController/fetchModels :' . $e->getMessage() . 'in line' . $e->getLine());
        }
    }

    public function addFeatureDevil(Request $request) {
        try {
            return $this->userServices->createFeatureDevils($request->all());
        } catch (\Exception $e) {
            Log::error('Error in BoostController/addFeatureDevil :' . $e->getMessage() . 'in line' . $e->getLine());
        }
    }

    public function fetchFeatureDevils (Request $request) {
        try {
            //dd($request->all());
            $result = $this->userServices->fetchFeatureDevils($request->all());
            return isset($request->name) ? $result["results"]:$result["data_json"];
        } catch (\Exception $e) {
            Log::error('Error in BoostController/fetchFeatureDevils :' . $e->getMessage() . 'in line' . $e->getLine());
        }
    }

    public function manuallyBoostRequest (Request $request) {
        try {
            $result = $this->userServices->manuallyBoostRequestStoreService($request->all());

            if ($request->ajax()) {
                return DataTables::of($result["data"])
                    ->addIndexColumn() // adds index (Sr. No.)
                    ->addColumn('action', function($row){
                        return ($row["status"] == 0) ? '<a href="javascript:void(0)" class="btn btn-sm btn-success approveImage" data-id="'.$row["id"].'" data-userid="'.$row["user_id"].'">Approve</a>
                                <a href="javascript:void(0)" class="btn btn-sm btn-danger approveImage" data-id="'.$row["id"].'" data-userid="'.$row["user_id"].'" >Reject</a>':"";
                    })
                    ->addColumn('status', function($row){
                        return ($row["status"] == 0) ? "<label class='badge badge-info'>Pending</label>": ($row["status"] == 1 ? "<label class='badge badge-success'>Approved</label>":"<label class='badge badge-danger'>Rejected</label>");
                    })
                    ->addColumn('request_at', function($row){
                        return date('d M, Y', strtotime($row["created_at"]));
                    })

                    ->rawColumns(['action', 'status'])
                    ->make(true);
            }
         return view('admin.manually-boost-request', compact('result'));
            
        } catch (\Exception $e) {
            Log::error('Error in BoostController/manuallyBoostRequest :' . $e->getMessage() . 'in line' . $e->getLine());
            return response()->json(["status" => 400]);
        }
    }

    public function manuallyBoostRequestAction (Request $request) {
        try {
            $data = $this->userServices->manuallyBoostRequestActionService($request->all());
            return response()->json(["status" => $data["status"], "message" => $data["msg"]]);
        } catch (\Exception $e) {
            Log::error('Error in BoostController/manuallyBoostRequestAction :' . $e->getMessage() . 'in line' . $e->getLine());
            return response()->json(["status" => 400, "message" => __('message.statusZero')]);
        }
    }
}
