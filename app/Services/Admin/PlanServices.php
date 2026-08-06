<?php

namespace App\Services\Admin;

use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Repository\Eloquent\PlanRepository;
use Exception;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class PlanServices
{


    protected $PlanRepository;
    private $dataObject;
    public function __construct(PlanRepository $PlanRepository)
    {

        $this->PlanRepository = $PlanRepository;
        $this->dataObject = new \stdClass();
    }


    public function create($request)
    {
        try {
           
            
            $data = [
                'title' => $request->title,
                'tag' => $request->tag,
                'description' => $request->description,
                'cost' => $request->cost,
                'days' => $request->days,
                'saving' => $request->saving,
                'heading'=> $request->heading,
                'visibility' => $request->visibility
            ];    
            $success = $this->PlanRepository->create($data);
               
            // Optionally save $planResponse->id in your DB
            return response()->json([
                'message' => __('message.statusOne', ['parameter' => __('message.plan')]),
                'data' => $data,
                'status' => 1
            ], 201);                                   
    
        } catch (Exception $e) {
            Log::error("PlanServices : create()" . $e->getLine() . " " . $e->getMessage());
            return response()->json(['message' => __('message.some_thing_went_wrong')], 500);
        }
    }
    



    // public function update($request)
    // {
    //     try {
    //         $data = [
    //             'title' => $request->title,
    //             'description' => $request->description,
    //             'cost' => $request->cost,
    //             'days' => $request->days,
    //             'saving'=>$request->saving
    //         ];
    //         $success = $this->PlanRepository->update(['id' => $request->id], $data);
    //         if ($success) {
    //             return response()->json(['message' => __('message.statusTwo', ['parameter' =>  __('message.plan')]), 'data' => $data, 'status' => 1, 'error' => $this->dataObject], 201);
    //         } else {
    //             return response()->json(['message' => __('message.some_thing_went_wrong'),  'status' => 0, 'error' => $this->dataObject], 400);
    //         }
    //     } catch (Exception $e) {
    //         Log::error("PlanServices : create()" . $e->getLine() . " " . $e->getMessage());
    //         return redirect()->route('admin.dashboard')->withErrors(['error' => __('message.some_thing_went_wrong')]);
    //     }
    // }
    public function update($request)
    {
        try {
            // Step 1: Fetch old PayPal plan ID
            $existingPlan = $this->PlanRepository->getOne(['id'=>$request->id]);
            if (!$existingPlan) {
                return response()->json(['message' => 'Plan not found.', 'status' => 0], 404);
            }
    
           
            // Step 5: Update local database
            $data = [
                'title' => $request->title,
                'tag' => $request->tag,
                'description' => $request->description,
                'cost' => $request->cost,
                'days' => $request->days,
                'heading'=> $request->heading,
                'visibility' => $request->visibility
            ];
    
            $success = $this->PlanRepository->update(['id' => $request->id], $data);
    
            if ($success) {
                return response()->json([
                    'message' => __('message.statusTwo', ['parameter' => __('message.plan')]),
                    'data' => $data,
                    'status' => 1
                ], 201);
            } else {
                return response()->json(['message' => __('message.some_thing_went_wrong'), 'status' => 0], 400);
            }
    
        } catch (Exception $e) {
            Log::error("PlanServices : update()" . $e->getLine() . " " . $e->getMessage());
            return response()->json(['message' => __('message.some_thing_went_wrong')], 500);
        }
    }
    
    
}