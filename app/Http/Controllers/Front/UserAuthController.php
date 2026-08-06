<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Front\UserServices;
use Illuminate\Support\Facades\Log;
use App\Repository\Eloquent\UserRepository;
use App\Repository\Eloquent\AdminRepository;
use App\Repository\Eloquent\PlanRepository;
use App\Http\Requests\FrontEnd\{
    UserRequest,
    LoginRequest,
    ContactRequest,
    UserChangePasswordRequest,
    UserForgotPasswordRequest,
    UserResetPasswordRequest
};
use Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

use Illuminate\Support\Facades\Mail;

class UserAuthController extends Controller
{
    protected $userServices;
    protected $userRepository;
    protected $PlanRepository;
    protected $AdminRepository;
    private $dataObject;
    public function __construct(PlanRepository $PlanRepository, AdminRepository $AdminRepository, UserServices $userServices, UserRepository $userRepository)
    {
        $this->userServices = $userServices;
        $this->userRepository = $userRepository;
        $this->AdminRepository = $AdminRepository;
        $this->PlanRepository = $PlanRepository;
    }

    public function userEmailVerify()
    {

        return view('front.email-verification');
    }

    public function choose()
    {
        return view('front.choose');
    }

    public function emailVerification()

    {

        try {
            $user = auth()->user();

            if (is_null($user->email_verified_at)) {
                return view('front.verify-email', compact('user'));
            } else {
                return redirect()->route('user-email-verify');
            }
        } catch (Exception $e) {

            Log::error('Error in UserAuthController/registerStep2 :' . $e->getMessage() . 'in line' . $e->getLine());

            return redirect()->route('user.login')->withErrors(['error' => __('message.statusZero')]);
        }
    }

    public function resendVerification()
    {

        $user = auth()->user();

        if (!$user) {
            return response()->json(['status' => 0, 'message' => 'User not found.'], 404);
        }

        if ($user->email_verified_at) {
            return response()->json(['status' => 0, 'message' => 'Email is already verified']);
        }

        // Send verification email
        $randomToken = Str::random(40);

        $update['remember_token'] = $randomToken;

        $run2 = $this->userRepository->update(['email' => $user->email], $update);

        if ($run2) {

            $userdata = $this->userRepository->getOne(['email' => $user->email]);



            $verificationUrl = route('user.user-email-verification', ['token' => $userdata['remember_token']]);
            // dd($verificationUrl);
            $body = 'Hello ' . $userdata->name . ',';

            $body .= '<p>Thanks for signing up to ' . env("APP_NAME") . '.</p>Please confirm your email address by clicking on this link:</p>';

            $body .= '<p><a href="' . $verificationUrl . '" target="_blank" style="font-size: 15px; font-family: Helvetica, Arial, sans-serif; color: #902F7E; text-decoration: none;  text-decoration: none; padding: 6px 15px; border-radius: 2px; border: 1px solid #902f7e; display: inline-block;">Verify email</a></p>';

            // dd($body);

            $mailData = [
                'subject' => 'Verify Email',
                'email' => $userdata->email,
                'body' => $body,
            ];

            //$run2 =  Mail::to('shivania.webwiders@gmail.com')->send(new \App\Mail\DemoMail($mailData));
            $run3 =  Mail::to($user->email)->send(new \App\Mail\DemoMail($mailData));
        }

        return response()->json(['status' => 1, 'message' => 'Verification email resent successfully!']);
    }

    public function userEmailVerification($token)
    {
        try {
            $message = '';
            $verifyData = $this->userRepository->getOne(['remember_token' => $token]);
            Auth::logout();
            if ($verifyData) {
                // Check if the token has already been used (cleared)
                if (empty($verifyData->remember_token)) {
                    $message = "Your verification link has already been used, please request a new one.";
                } else {
                    // Check if the token is still valid (you can define a validity period here)
                    $tokenIssuedAt = $verifyData->updated_at; // Assuming the token is updated when issued
                    $validDuration = 60 * 60 * 24; // 24 hours (you can change this duration)

                    if (strtotime($tokenIssuedAt) + $validDuration < time()) {
                        // Token has expired
                        $message = "Your verification link has expired, please request a new one.";
                    } else {
                        // Proceed with email verification
                        $verifyData->email_verified_at = now();
                        $verifyData->remember_token = ''; // Clear the token after successful verification
                        if ($verifyData->update()) {
                            Auth::guard('web')->login($verifyData);
                            $message = "Email verified successfully";
                        } else {
                            $message = "Your email is not verified, try again.";
                        }
                    }
                }
            } else {
                // Token not found or invalid
                $message = "Your verification link is invalid or expired, please request a new one.";
            }
            return view('front.email-verification', compact('message'));
        } catch (\Exception $e) {
            Log::error("Error in HomeController.userEmailVerification(): " . $e->getMessage() . $e->getLine());
            return response()->json(['status' => 0, 'message' => 'Something went wrong, please try again later.']);
        }
    }

    public function logout()

    {

        try {
            $logout = Auth::logout();
            return redirect()->route('user-login');
        } catch (Exception $e) {
            Log::error("UserAuthController:do_login()" . $e->getLine() . " " . $e->getMessage());
            return response()->json(['status' => 0, 'message' => __('message.statusZero')]);
        }
    }

    public function purchasePlan(Request $request)
    {

        $user = auth()->user();
        $plan = $this->PlanRepository->getOne(['id' => $request->plan_id]);

        // Insert transaction
        $this->userRepository->createtransaction([
            'user_id' => $user->id,
            'plan_id' => $plan->id,
            'amount' => $plan->cost,
            'type' => 'membership-purchase',
            'payment_method' => 'manual',
            'transaction_id' => 'TXN' . strtoupper(uniqid()),
            'status' => 'success',
        ]);

        // Update user plan
        $user->update([
            'plan_id' => $plan->id,
            'plan_start_date' => now(),
            'plan_end_date' => now()->addDays($plan->duration_days ?? $plan->days),
        ]);

        // Redirect based on user type
        $redirect = $user->type == 1 ? route('home') : route('user.waiting');

        return response()->json([
            'status' => 1,
            'message' => 'Plan purchased successfully!',
            'redirect' => $redirect,
        ]);
    }
    public function wishlistSubmit(Request $request)
    {
        try {

            return $this->userServices->wishlistService($request);
        } catch (\Exception $e) {
            Log::error("Error in " . __CLASS__ . "::" . __FUNCTION__ . ": " . $e->getMessage());
            return response()->json(['status' => 0, 'message' => 'Failed to wishlist submit from controller.']);
        }
    }

    public function favouriteList()

    {

        try {
            $user = auth()->user();
            $data = $this->userRepository->getByWherewishlist(['user_id' => $user->id]);

            return view('front.favourite-list', compact('data'));
        } catch (Exception $e) {
            Log::error("UserAuthController:do_login()" . $e->getLine() . " " . $e->getMessage());
            return response()->json(['status' => 0, 'message' => __('message.statusZero')]);
        }
    }

    public function removeAllFavourites(Request $request)
    {
        try {
            $user = Auth::guard('web')->user();
            if (!$user) {
                return response()->json(['status' => 0, 'message' => 'You need to be logged in.']);
            }

            $data = $this->userRepository->deleteWishlist(['user_id'=>$user->id]);
            if($data){
            return response()->json(['status' => 1, 'message' => 'All favourites removed successfully.']);

            }
        } catch (\Exception $e) {
            Log::error('Remove All Favourites Error: ' . $e->getMessage());
            return response()->json(['status' => 0, 'message' => 'Something went wrong.']);
        }
    }


    
    public function ajaxBoostActivate(Request $request)
    {
        try {
            return $this->userServices->updateBoost($request);
            }
        catch (\Exception $e) {
            Log::error('Remove All Favourites Error: ' . $e->getMessage());
            return response()->json(['status' => 0, 'message' => 'Something went wrong.']);
        }
    }

    public function manuallyBoost()   {
        try {
            $user = auth()->user();
            if($user->type != 2){
                return redirect()->route('user.profile');
            }
            $manuallyBoostData = $this->userServices->getManuallyBoostData($user->id);
            $BoostData = $this->userServices->checkAlreadyActiveBoost();
            return view('front.manually-boost', compact('manuallyBoostData', 'BoostData'));
        } catch (\Exception $exception) {
            Log::error("Error in " . __CLASS__ . "::" . __FUNCTION__ . ": " . $exception->getMessage());
            return redirect()->back()->withErrors(['error' => __('message.statusZero')]);
        }
    }

    public function manuallyBoostRequestStore(Request $request)
    {
        try {
            $result = $this->userServices->manuallyBoostRequestStoreService($request->all());
            if ($result['status'] == 200) {
                return redirect()->back()->with('success', __('message.boostRequestSuccess'));
            } else {
                return redirect()->back()->withErrors(['error' => __('message.statusZero')])->withInput();
            }
        } catch (\Exception $e) {
            Log::error("Error in " . __CLASS__ . "::" . __FUNCTION__ . ": " . $e->getMessage());
            return redirect()->back()->withErrors(['error' => __('message.statusZero')]);
        }
    }

    public function manuallyBoostProcess(Request $request)
    {
        try {
            $result = $this->userServices->manuallyBoostProcessService($request->all());
            //dd($result);
            if ($result['status'] == 200) {
                return redirect()->back()->with('success', $result['message']);
            } else {
                return redirect()->back()->with('error', $result['message']);
            }
        } catch (\Exception $e) {
            Log::error("Error in " . __CLASS__ . "::" . __FUNCTION__ . ": " . $e->getMessage());
            return redirect()->back()->withErrors(['error' => __('message.statusZero')]);
        }
    }
    
}
