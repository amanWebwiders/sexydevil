<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use App\Repository\Eloquent\AdminRepository;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Services\Admin\AuthServices;
use App\Http\Requests\ForgetPasswordRequest;
use Illuminate\Support\Facades\DB;
class AuthController extends Controller
{
    protected $adminRepository;
    protected $authServices;
    private $dataObject;
    
    public function __construct(
        AdminRepository $adminRepository,
        AuthServices $authServices,
    ){
        $this->dataObject = new \stdClass();
        $this->adminRepository =  $adminRepository;
        $this->authServices =  $authServices;
    }

    public function login(){
        try {
            // $users = DB::table('user')->get(); // Get all rows
            // dd('s');
            return view('admin.login');
        } catch (\Exception $e) {
            log::error('Error in AuthController/login :' . $e->getMessage() . 'in line' . $e->getLine());
            return response()->json(['status' => 0, 'message' => __('message.statusZero'), 'data' => $this->dataObject,'error'=>$this->dataObject], 500);
        }
    }
    public function doLogin(LoginRequest $request){
        // dd('done');
        try {
            $user = Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password]);
            if ($user) {
                // dd($user);
                return response()->json(['status' => 1, 'message' => __('message.statusLogin'), 'data' => $this->dataObject,'error'=>$this->dataObject], 200);
                
            } else {
                return response()->json(['status' => 0, 'message' => __('message.statusInvalid'), 'data' => $this->dataObject,'error'=>$this->dataObject], 500);
                
            }
        } catch (\Exception $e) {
            log::error('Error in AuthController/do_login :' . $e->getMessage() . 'in line' . $e->getLine());
            return response()->json(['status' => 0, 'message' => __('message.statusZero'), 'data' => [],'error'=>[]], 500);
        }
    }
    public function logout(Request $request)
    {
        try {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            $response = redirect()->route('admin.login')
            ->with(['logout_message' => '<div class="alert alert-success">Logout successfully.</div>']);
            return $response;
        } catch (\Exception $e) {
            log::error('Error in AuthController/logout :' . $e->getMessage() . 'in line' . $e->getLine());
            return response()->json(['status' => 0, 'message' => __('message.statusZero'), 'data' => $this->dataObject,'error'=>$this->dataObject], 500);
        }
    }
    public function forgotPassword(){
        try {
            return view('admin.auth.forgot_password');
        } catch (\Exception $e) {
            log::error('Error in AuthController/forgotPassword :' . $e->getMessage() . 'in line' . $e->getLine());
            return response()->json(['status' => 0, 'message' => __('message.statusZero'), 'data' => $this->dataObject,'error'=>$this->dataObject], 500);
        }
    }
    public function sendPassword(ForgetPasswordRequest $request){
        try {
           return $this->authServices->sendPassword($request);
        } catch (\Exception $e) {
            log::error('Error in AuthController/sendPassword :' . $e->getMessage() . 'in line' . $e->getLine());
            return response()->json(['status' => 0, 'message' => __('message.statusZero'), 'data' => $this->dataObject,'error'=>$this->dataObject], 500);
        }
    }

}
