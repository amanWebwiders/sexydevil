<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repository\Eloquent\{PlanRepository};
use App\Repository\Eloquent\AdminRepository;
use Illuminate\Support\Facades\Log;
use Exception;
use Illuminate\Support\Facades\Redis;
use App\Http\Requests\Admin\PlanRequest;
use App\Services\Admin\PlanServices;
use Illuminate\Support\Facades\File;

class PlanController extends Controller
{
    
    protected $PlanRepository;
    protected $PlanServices, $adminRepository;

    public function __construct(PlanRepository $PlanRepository,
    PlanServices $PlanServices,
    AdminRepository $adminRepository)
    {
        $this->PlanRepository = $PlanRepository;
        $this->PlanServices = $PlanServices;
        $this->adminRepository = $adminRepository;
    }

    public function get()
    {
        $data = $this->PlanRepository->getAll();
        $admin = $this->adminRepository->getOne(["id" => 1]);
        return view('admin.plan', compact('data', 'admin'));
    }


    public function add(PlanRequest $request)
    {
        try {            
            return $this->PlanServices->create($request);        
        } catch (Exception $e) {
            Log::error("PlanController : add()" . $e->getLine() . " " . $e->getMessage());
            return redirect()->route('admin.dashboard')->withErrors(['error' => __('message.something_went_wrong')]);
        }
    }

    public function show($id)
    {
        try {
           
            $success = $this->PlanRepository->getOne(['id' => $id]);
            
            if ($success) {
                return response()->json(['status' => true, 'data' => $success, 'message' => __('message.statusFour', ['parameter' => __('message.plan')])]);
            } else {
                return response()->json(['status' => false], 500);
            }
        } catch (Exception $e) {
            Log::error("PlanController : show()" . $e->getLine() . " " . $e->getMessage());
            return redirect()->route('admin.dashboard')->withErrors(['error' => __('message.something_went_wrong')]);
        }
    }

    public function update(PlanRequest $request)
    {
        // dd($request);      
        try {
            return $this->PlanServices->update($request);
        } catch (Exception $e) {
            Log::error("PlanController : update()" . $e->getLine() . " " . $e->getMessage());
            return redirect()->route('admin.dashboard')->withErrors(['error' => __('message.something_went_wrong')]);
        }
    }

    public function delete(Request $request, $id)
    {
        try {

            $success = $this->PlanRepository->delete(['id' => $id]);
            if ($success) {
                return response()->json(['status' => true, 'message' => __('message.statusThree', ['parameter' =>  __('message.plan')])]);
            } else {
                return response()->json(['status' => false], 500);
            }
        } catch (Exception $e) {
            Log::error("PlanController : delete()" . $e->getLine() . " " . $e->getMessage());
            return redirect()->route('admin.dashboard')->withErrors(['error' => __('message.something_went_wrong')]);
        }
    }

    public function priceHideShow(Request $request) {
        try {
            
            $run = $this->adminRepository->updateadminProfile(["id" => 1], ["is_show_price" => $request->is_checked == "true" ? 1:2]);
            return response()->json(["status" => $run ? 200:400, "message" => $run ? __('message.common_success'):__('message.something_went_wrong') ]);

        } catch (Exception $e) {
            Log::error("PlanController : priceHideShow()" . $e->getLine() . " " . $e->getMessage());
            return response()->json(["status" => 400, "message" => __('message.something_went_wrong')]);
        }
    }


}