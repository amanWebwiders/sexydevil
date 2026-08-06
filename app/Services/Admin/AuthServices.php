<?php
namespace App\Services\Admin;
use Illuminate\Support\Facades\Log;
use App\Repository\Eloquent\AdminRepository;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
// use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Mail;
use App\Traits\ImageUploadTrait;

class AuthServices{
    use ImageUploadTrait;
    protected $adminRepository;
    private $dataObject;
    
    public function __construct(AdminRepository $adminRepository){
        $this->dataObject = new \stdClass();
        $this->adminRepository = $adminRepository;
    }

    public function updateAdminProfile($request){
        try {
          
            $data['name'] = $request['name'];
            $data['email'] = $request['email'];
 $data['boost_days'] = $request['boost_days'];
            $data['boost_cost'] = $request['boost_cost'];

            $data['name'] = $request['name'];
            $data['phone'] = $request['phone'];
            $data['country_code_id'] = $request['country_code_id'];
            $data['description'] = $request['description'];
            $data['fee'] = $request['fee'];
            // $data['gst'] = $request['gst'];
            // $data['total'] = $request['total'];
            $data['location'] = $request['location'];
            // if ($request->hasFile('file_image')) {
            //     $image = $request->file('file_image');
            //     $name = time() . "." . $image->getClientOriginalExtension();
            //     $imageData=$image->storeAs('admin_profile_images', $name, 'public');
            //     $data['image'] = $imageData;
            // }
            if ($request->hasFile('file_image')) {
                $image = $request->file('file_image');

                // Generate a unique file name for the image and store it
                $imagePath = $this->uploadImage($image, 'profile_image');  // Save to 'artists' folder in the public disk
                // Add the image path to the data
                $data['image'] = $imagePath;
            }
            // dd($data);
            $id = Auth::guard('admin')->user()->id;
            return  $this->adminRepository->updateadminProfile(['id' => $id], $data);
        } catch(\Exception $e){
            Log::error("Error in AuthServices.updateAdminProfile(): " . $e->getMessage());
            return response()->json(['status' => 0, 'message' => __('message.statusZero'), 'data' => $this->dataObject,'error'=>$this->dataObject], 500);
        }
    }

    public function changePassword($request){
        try {
            $user = Auth::guard('admin')->user();
            if (Hash::check($request['old_password'], $user->password)) {
                $data = [
                    'password' =>Hash::make( $request['password'])
                ];
                $id = $user->id;
                return  $this->adminRepository->updatePassword(['id'=>$id],$data);
            }
        } catch(\Exception $e){
            Log::error("Error in AuthServices.changePassword(): " . $e->getMessage());
            return response()->json(['status' => 0, 'message' => __('message.statusZero'), 'data' => $this->dataObject,'error'=>$this->dataObject], 500);
        }
    }
    public function sendPassword($request){
        try {
            $adminData  = $this->adminRepository->getAdminData(['email'=>$request['email']]);
            if ($adminData) {
               
                $randomPassword = mt_rand(100000, 999999);
                $update['password'] = Hash::make($randomPassword);
                $this->adminRepository->updateadminProfile(['id' => $adminData->id], $update);
                $email = $adminData->email;
                // dd($randomPassword); 
                $body = 'Hello ' . $adminData->name;
                $body .= '<p>This is an automated message. If you did not recently initiate the Forgot Password process, please disregard this email.</p>';
                $body .= '<p>Your new temporary password for logging in is  <b>' .  $randomPassword . '</b> Please do not share the password.</p>';

                $mailData = [
                    'subject' => 'Forgot password',
                    'email' => $email,
                    'body' => $body,
                ];
               
                try {
                    
                   $run= Mail::to($email)->send(new \App\Mail\DemoMail($mailData));
                    // dd($run);
                    return response()->json([
                        'status' => '1',
                        'message' => 'Please check your registered email. We have sent you a temporary password.',
                    ]);
                } catch (\Exception $e) {
                    Log::error('Mail send failed: ' . $e->getMessage());
                    return response()->json([
                        'status' => '0',
                        'message' => 'Something went wrong. Unable to send email.',
                    ]);
                }
            } else {
                return response()->json(['status' => '0', 'message' => 'This Email does not exits !']);
             }
        } catch (\Exception $e) {
            log::error('Error in AuthServices/sendPassword :' . $e->getMessage() . 'in line' . $e->getLine());
            return response()->json(['status' => '0', 'message' => 'Something went wrong.']);
        }
    }

}
