<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Http\Requests\UpdateProfile;
use App\Http\Requests\ChangePasswordRequest;
use App\Services\Admin\AuthServices;
use App\Repository\Eloquent\OccupationRepository;
use Validator;

class OccupationController extends Controller
{
    protected $OccupationRepository;
    public function __construct(OccupationRepository $OccupationRepository)
    {
        $this->OccupationRepository = $OccupationRepository;
    }

    public function index()
    {
        try {
            $data = $this->OccupationRepository->getAll();
            return view('admin.occupation', compact('data'));
        } catch (\Exception $e) {
            Log::error('Error in OccupationController/index :' . $e->getMessage() . 'in line' . $e->getLine());
            return response()->json(['status' => '0', 'message' => __('message.statusZero')]);
        }
    }

    public function storeOccupation(Request $request)
    {
      
        try {
            foreach ($request->occupations as $item) {
                $this->OccupationRepository->update(
                    ['id' => $item['id']],
                    ['name' => $item['name']]
                );
            }
    
            return response()->json(['status' => 1, 'message' => __('message.statusTwo', ['parameter' => 'Occupations'])]);
        } catch (\Exception $e) {
            Log::error("Error in OccupationController.storeOccupation(): " . $e->getMessage());
            return response()->json(['status' => 0, 'message' => __('message.statusZero')]);
        }
    }

}