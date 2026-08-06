<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Http\Requests\UpdateProfile;
use App\Http\Requests\ChangePasswordRequest;
use App\Services\Admin\AuthServices;
use App\Repository\Eloquent\UserRepository;
use Validator;
use App\Repository\Eloquent\AdminRepository;
use App\Repository\Eloquent\OccupationRepository;

class DashboardController extends Controller
{
    protected $authServices;
     protected $userRepository;
     protected $AdminRepository,$OccupationRepository;
    public function __construct(AdminRepository $AdminRepository,OccupationRepository $OccupationRepository,AuthServices $authServices, UserRepository $userRepository)
    {
        $this->authServices = $authServices;
        $this->userRepository = $userRepository;
        $this->AdminRepository = $AdminRepository;
        $this->OccupationRepository = $OccupationRepository;
    }
    public function index()
    {
        try {
            return view('admin.dashboard');
        } catch (\Exception $e) {
            log::error('Error in DashboardController/index :' . $e->getMessage() . 'in line' . $e->getLine());
            return response()->json(['status' => 0, 'message' => __('message.statusZero'), 'data' => [], 'error' => []], 500);
        }
    }
    public function myProfile()
    {
        try {
            return view('admin.auth.profile');
        } catch (\Exception $e) {
            log::error('Error in DashboardController/my_profile :' . $e->getMessage() . 'in line' . $e->getLine());
            return response()->json(['status' => 0, 'message' => __('message.statusZero'), 'data' => [], 'error' => []], 500);
        }
    }
    public function editProfile()
    {
        try {
            $occupations = $this->OccupationRepository->getAll();
            $countryCodes = $this->AdminRepository->getCountryCode();
            return view('admin.auth.update_profile',compact('occupations','countryCodes'));
        } catch (\Exception $e) {
            log::error('Error in DashboardController/editProfile :' . $e->getMessage() . 'in line' . $e->getLine());
            return response()->json(['status' => 0, 'message' => __('message.statusZero'), 'data' => [], 'error' => []], 500);
        }
    }
    public function updateProfile(UpdateProfile $request)
    {
        try {
            $run = $this->authServices->updateAdminProfile($request);
            if ($run) {
                return response()->json(['status' => 1, 'message' => __('message.statusTwo', ['parameter' => 'Profile']), 'data' => [], 'error' => []], 200);
            } else {
                return response()->json(['status' => 0, 'message' => __('message.statusZero'), 'data' => [], 'error' => []], 500);
            }
        } catch (\Exception $e) {
            log::error('Error in DashboardController/update_profile :' . $e->getMessage() . 'in line' . $e->getLine());
            return response()->json(['status' => 0, 'message' => __('message.statusZero'), 'data' => [], 'error' => []], 500);
        }
    }
    
    public function adminPassword(){
         try {
            return view('admin.auth.change_password');
        } catch (\Exception $e) {
            log::error('Error in DashboardController/adminPassword :' . $e->getMessage() . 'in line' . $e->getLine());
            return response()->json(['status' => 0, 'message' => __('message.statusZero'), 'data' => [], 'error' => []], 500);
        }
    }
    public function changePassword(ChangePasswordRequest $request)
    {
        try {
            $data = $request->all();
            // dd($data);
            $run = $this->authServices->changePassword($data);
            if ($run) {
                return response()->json(['status' => 1, 'message' => __('message.statusTwo', ['parameter' => 'Password']), 'data' => [], 'error' => []], 200);
            } else {
                return response()->json(['status' => 0, 'message' => __('message.password_not_match'), 'data' => [], 'error' => []], 500);
            }
        } catch (\Exception $e) {
            log::error('Error in DashboardController/updateChangePassword :' . $e->getMessage() . 'in line' . $e->getLine());
            return response()->json(['status' => 0, 'message' => __('message.statusZero'), 'data' => [], 'error' => []], 500);
        }
    }
    
    public function getContactUs(){
        $contactus = $this->userRepository->getAllContactUs();
        return view('admin.contactus.contactus_list', compact('contactus'));
    }
    
    public function getContactUsDetail($id){
        $bywhere = ['id' => $id];
        $contactus = $this->userRepository->getContactUsOne($bywhere);
        // dd($contactus);
        return view('admin.contactus.contact_us_detail', compact('contactus'));
    }
    
    public function deleteContactUs($id){
        
        $where = ['id' => $id];
        $run = $this->userRepository->delete($where);
        if ($run) {
            return response()->json([
                'status' => 200,
                'message' => 'Record deleted Successfully !',
                'data' => [],
                'success' => true,
            ]);
        } else {
            return response()->json([
                'status' => 403,
                'message' => 'Something went wrong!',
                'data' => [],
                'success' => false,
            ]);
        }
    }
    
    
    public function contactList()
    {

        try {
            $contactus = $this->userRepository->getAllContactUs();
        
            return view('admin.contactus_list',compact('contactus'));
        } catch (\Exception $e) {

            log::error('Error in AuthController/contactList :' . $e->getMessage() . 'in line' . $e->getLine());

            return response()->json(['status' => 0, 'message' => __('message.statusZero'), 'data' => $this->dataObject, 'error' => $this->dataObject], 500);
        }
    }
 
    public function updateStatus(Request $request,$id)
    {

        try {
           
            $data['status'] = $request->status;
            $update = $this->userRepository->updateContactUs(['id'=>$id],$data);
            
            if($update){
                return response()->json(['success' => true]);
            }
            
        } catch (\Exception $e) {

            log::error('Error in AuthController/updateStatus :' . $e->getMessage() . 'in line' . $e->getLine());

            return response()->json(['status' => 0, 'message' => __('message.statusZero'), 'data' => $this->dataObject, 'error' => $this->dataObject], 500);
        }
    }
 
    
}
