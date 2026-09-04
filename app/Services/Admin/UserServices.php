<?php

namespace App\Services\Admin;

use Illuminate\Support\Facades\Log;
use App\Repository\Eloquent\AdminRepository;
use App\Repository\Eloquent\{OccupationRepository, FeatureDevilRepository, UserUploadImageRepository, UserUploadVideoRepository, ManuallyBoostRequestRepository};
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
// use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Mail;
use Illuminate\Support\Facades\File;
use App\Traits\ImageUploadTrait;
use App\Repository\Eloquent\{UserRepository, PlanRepository};
use Carbon\Carbon;

class UserServices
{
    use ImageUploadTrait;
    protected $AdminRepository, $manuallyBoostRequestRepository;
    private $dataObject;
    protected $OccupationRepository, $userUploadVideoRepository;
    protected $userRepository, $planRepository, $featureDevilRepository, $userUploadImageRepository;

    public function __construct(
        UserRepository $userRepository, 
        OccupationRepository $OccupationRepository, 
        AdminRepository $AdminRepository, 
        PlanRepository $planRepository,
        FeatureDevilRepository $featureDevilRepository, 
        UserUploadImageRepository $userUploadImageRepository,
        UserUploadVideoRepository $userUploadVideoRepository,
        ManuallyBoostRequestRepository $manuallyBoostRequestRepository
        )
    {
        $this->dataObject = new \stdClass();
        $this->AdminRepository = $AdminRepository;
        $this->OccupationRepository = $OccupationRepository;
        $this->userRepository = $userRepository;
        $this->planRepository = $planRepository;
        $this->featureDevilRepository = $featureDevilRepository;
        $this->userUploadImageRepository = $userUploadImageRepository;
        $this->userUploadVideoRepository = $userUploadVideoRepository;
        $this->manuallyBoostRequestRepository = $manuallyBoostRequestRepository;
    }

    public function createUser($request)
    {
        try {


            $create = [
                'name' => $request->name,
                'phone' => $request->phone,
                'type' => 1,
                'email' => $request->email,
                'country_code_id' => $request->country_code_id,
                'description' => $request->description,
                'fee' => $request->fee,
                'gst' => $request->gst,
                'total' => $request->total,
                'occupation_id' => $request->occupation_id,
                'location' => $request->location,
                'password' => Hash::make($request->password),
            ];
            if ($request->hasFile('profile_image')) {
                $image = $request->file('profile_image');

                // Generate a unique file name for the image and store it
                $imagePath = $this->uploadImage($image, 'profile_image');  // Save to 'artists' folder in the public disk
                // Add the image path to the data
                $create['image'] = $imagePath;
            }
            $occupationname =  $this->OccupationRepository->getOne(['id' => $request->occupation_id]);
            // dd($create);
            $data = $this->AdminRepository->create($create);

            if ($data) {

                $appName = config('app.name');
                $loginUrl = route('admin.login'); // or route to your login page
                $mailBody  = '<p>Hello ' . ($request->name) . ',</p>';
                $mailBody .= '<p>This mail is to inform you that your account in ' . $appName . ' has been added as a ' . $occupationname->name . '.</p>';
                $mailBody .= '<p><strong>Login Details:</strong><br>';
                $mailBody .= 'Link: <a href="' . $loginUrl . '">' . $loginUrl . '</a><br>';
                $mailBody .= 'Username: ' . ($request->email) . '<br>';
                $mailBody .= 'Password: <strong>' . $request->password . '</strong></p>';
                $mailBody .= '<p>Thanks,<br>' . ($appName) . '</p>';

                $mailData = [
                    'subject' => 'Your ' . $appName . ' Account Details',
                    'email'   => $request->email,
                    'body'    => $mailBody,
                ];

                // 6) Send the email
                try {
                    Mail::to($request->email)
                        ->send(new \App\Mail\DemoMail($mailData));
                } catch (\Exception $e) {
                    Log::error('Failed to send New-User email: ' . $e->getMessage());
                    // you might still return success but note that mail failed
                    return response()->json([
                        'status'  => 1,
                        'message' => __('message.statusOne', ['parameter' => 'User']) . ' (but email failed to send.)'
                    ]);
                }


                return response()->json(['status' => 1, 'message' => __('message.statusOne', ['parameter' => 'User'])]);
            }
        } catch (\Exception $e) {
            Log::error("Error in " . __CLASS__ . "::" . __FUNCTION__ . ": " . $e->getMessage());
            return response()->json(['status' => 0, 'message' => 'Failed to create user.']);
        }
    }
    public function updateUser($request)
    {
        try {

            // dd($request);
          
            if ($request->name) {
                $create['name'] = $request->name;
            }
            if ($request->phone_code) {
                $create['phone_code'] = $request->phone_code;
            }
            if ($request->phone) {
                $create['phone'] = $request->phone;
            }
            if ($request->email) {
                $create['email'] = $request->email;
            }
            if ($request->type) {
                $create['type'] = $request->type;
            }
            if ($request->filled('password')) {
                $create['password'] = Hash::make($request->password);
            }
            if ($request->hasFile('profile_image')) {
                $image = $request->file('profile_image');

                // Generate a unique file name for the image and store it
                $imagePath = $this->uploadImage($image, 'profile_image');  // Save to 'artists' folder in the public disk
                // Add the image path to the data
                $create['profile_image'] = $imagePath;
            }

            if ($request->type == 2) {
                if ($request->displayed_age) {
                    $create['displayed_age'] = $request->displayed_age;
                }
                if ($request->nickname) {
                    $create['nickname'] = $request->nickname;
                }
                if ($request->slogan) {
                    $create['slogan'] = $request->slogan;
                }
                if ($request->nationality) {
                    $create['nationality'] = $request->nationality;
                }
                if ($request->rates) {
                    $create['rates'] = $request->rates;
                }
                if ($request->contact_method) {
                    $create['contact_method'] = $request->contact_method;
                }
                if ($request->description) {
                    $create['description'] = $request->description;
                }
                if ($request->gender_id) {
                    $create['gender_id'] = $request->gender_id;
                }
                if ($request->country_id) {
                    $create['country_id'] = $request->country_id;
                }
                if ($request->dob) {
                    try {
                        $rawDob = trim($request->dob);
                        if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $rawDob)) {
                            $create['dob'] = $rawDob;
                        } elseif (preg_match('/^(\d{1,2})\/(\d{1,2})\/(\d{4})$/', $rawDob, $m)) {
                            $p1 = (int)$m[1];
                            $p2 = (int)$m[2];
                            $y = (int)$m[3];
                            if ($p2 > 12) {
                                $create['dob'] = sprintf('%04d-%02d-%02d', $y, $p1, $p2);
                            } else {
                                $create['dob'] = sprintf('%04d-%02d-%02d', $y, $p2, $p1);
                            }
                        } else {
                            $create['dob'] = date('Y-m-d', strtotime($rawDob));
                        }
                    } catch (\Exception $e) {
                        Log::warning("Admin UserServices could not parse DOB '{$request->dob}': " . $e->getMessage());
                    }
                }
                if ($request->sex_location) {
                    $create['sex_location'] = $request->sex_location;
                }
                if ($request->blocked_countries) {
                    $create['blocked_countries'] = json_encode($request->blocked_countries);
                }
                if ($request->languages) {
                    $create['languages'] = json_encode($request->languages);
                }
                if ($request->sexual_orientation) {
                    $create['sexual_orientation'] = $request->sexual_orientation;
                }
                if ($request->body_type_id) {
                    $create['body_type_id'] = $request->body_type_id;
                }
                if ($request->contact_methods) {
                    $create['contact_methods'] = $request->contact_methods;
                }
                if ($request->ethnicity_id) {
                    $create['ethnicity_id'] = $request->ethnicity_id;
                }
                
                if ($request->state_id) {
                    $create['state_id'] = $request->state_id;
                }
                if ($request->city_id) {
                    $create['city_id'] = $request->city_id;
                }
                if ($request->breast_size) {
                    $create['breast_size'] = $request->breast_size;
                }
                if ($request->incall_outcall) {
                    $create['incall_outcall'] = $request->incall_outcall;
                }
                if ($request->social_contact_method) {
                    $create['social_contact_method'] = $request->social_contact_method;
                }
                if ($request->contact_detail) {
                    $create['contact_detail'] = $request->contact_detail;
                }
                if ($request->height_cm) {
                    $create['height_cm'] = $request->height_cm;
                }
                if ($request->weight_kg) {
                    $create['weight_kg'] = $request->weight_kg;
                }
                if ($request->shoe_size) {
                    $create['shoe_size'] = $request->shoe_size;
                }
                if ($request->tattoo) {
                    $create['tattoo'] = $request->tattoo;
                }
                if ($request->piercing) {
                    $create['piercing'] = $request->piercing;
                }
                if ($request->smoking) {
                    $create['smoking'] = $request->smoking;
                }
                if ($request->oral_kissing_id) {
                    $create['oral_kissing_id'] = $request->oral_kissing_id;
                }
                if ($request->anal_related_option_id) {
                    $create['anal_related_option_id'] = $request->anal_related_option_id;
                }
                if ($request->cum_body_play_id) {
                    $create['cum_body_play_id'] = $request->cum_body_play_id;
                }
                if ($request->manual_fingering_id) {
                    $create['manual_fingering_id'] = $request->manual_fingering_id;
                }
                if ($request->massage_sensual_touch_id) {
                    $create['massage_sensual_touch_id'] = $request->massage_sensual_touch_id;
                }
                if ($request->fetish_bdsm_id) {
                    $create['fetish_bdsm_id'] = $request->fetish_bdsm_id;
                }
                if ($request->group_special_experience_id) {
                    $create['group_special_experience_id'] = $request->group_special_experience_id;
                }
                if ($request->media_virtual_option_id) {
                    $create['media_virtual_option_id'] = $request->media_virtual_option_id;
                }
                if ($request->experience_id) {
                    $create['experience_id'] = $request->experience_id;
                }
                if ($request->service_notes) {
                    $create['service_notes'] = $request->service_notes;
                }
                if ($request->hair_length_id) {
                    $create['hair_length_id'] = $request->hair_length_id;
                }
                if ($request->hair_type_id) {
                    $create['hair_type_id'] = $request->hair_type_id;
                }
                if ($request->hair_color_id) {
                    $create['hair_color_id'] = $request->hair_color_id;
                }
                if ($request->eye_color_id) {
                    $create['eye_color_id'] = $request->eye_color_id;
                }
                if ($request->tattoo_id) {
                    $create['tattoo_id'] = $request->tattoo_id;
                }
                if ($request->pubic_hair_id) {
                    $create['pubic_hair_id'] = $request->pubic_hair_id;
                }
                if ($request->onlyfans_link) {
                    $create['onlyfans_link'] = $request->onlyfans_link;
                }
                if ($request->instagram_link) {
                    $create['instagram_link'] = $request->instagram_link;
                }
                if ($request->telegram_link) {
                    $create['telegram_link'] = $request->telegram_link;
                }
                if ($request->tiktok_link) {
                    $create['tiktok_link'] = $request->tiktok_link;
                }
                // If media files are uploaded
                if ($request->hasFile('media')) {
                    $image = $request->file('media');

                    // Generate a unique file name for the image and store it
                    $imagePath = $this->uploadImage($image, 'media');  // Save to 'artists' folder in the public disk
                    // Add the image path to the data
                    $create['verify_age_document'] = $imagePath;
                    // foreach ($request->file('media') as $file) {
                    //     // Handle each media file upload here as needed
                    //     // (e.g., move to storage, save path to DB later)
                    // }
                }
                if ($request->hasFile('document_image')) {
                    $image = $request->file('document_image');

                    // Generate a unique file name for the image and store it
                    $imagePath = $this->uploadImage($image, 'document_image');  // Save to 'artists' folder in the public disk
                    // Add the image path to the data
                    $create['document_image'] = $imagePath;
                    // foreach ($request->file('media') as $file) {
                    //     // Handle each media file upload here as needed
                    //     // (e.g., move to storage, save path to DB later)
                    // }
                }
                if ($request->hasFile('holding_document_image')) {
                    $image = $request->file('holding_document_image');

                    // Generate a unique file name for the image and store it
                    $imagePath = $this->uploadImage($image, 'holding_document_image');  // Save to 'artists' folder in the public disk
                    // Add the image path to the data
                    $create['holding_document_image'] = $imagePath;
                    // foreach ($request->file('media') as $file) {
                    //     // Handle each media file upload here as needed
                    //     // (e.g., move to storage, save path to DB later)
                    // }
                }
                if ($request->hasFile('identity_photos')) {
                    $photoPaths = [];

                    foreach ($request->file('identity_photos') as $photo) {
                        // Reuse your existing image upload logic
                        $path = $this->uploadImage($photo, 'identity_photos'); // Save to 'identity_photos' folder in public disk
                        $photoPaths[] = $path;
                    }

                    // Save paths as JSON string
                    $create['identity_photos'] = json_encode($photoPaths);
                }
            }
            // dd($create);

            

             if ($request->has('services') || $request->has('selections') || $request->has('selections_group')) {
                $this->userRepository->deleteEscortService(['user_id' => $request->id]);
            }
            if ($request->has('services')) {

                foreach ($request->input('services') as $serviceId => $value) {
                    $service = \App\Models\EscortService::with('category')->find($serviceId);
                    if ($service) {
                        $this->userRepository->createEscortService([
                            'user_id'     => $request->id,
                            'category_id' => $service->category_id,
                            'service_id'  => $serviceId,
                            'selection_id' => null
                        ]);
                    }
                }
            }
            if ($request->has('selections')) {

                foreach ($request->input('selections') as $selectionId => $checked) {
                    if ($checked) {
                        $selection =  $this->userRepository->getOneescortServiceSelection(['id' => $selectionId]);
                        if ($selection && $selection->service && $selection->service->category) {
                            $this->userRepository->createEscortService([
                                'user_id'     => $request->id,
                                'category_id' => $selection->service->category->id,
                                'service_id'  => $selection->service_id,
                                'selection_id' => $selectionId
                            ]);
                        }
                    }
                }
            }
            if ($request->has('selections_group')) {
                foreach ($request->input('selections_group') as $serviceId => $selectionId) {
                    $selection = $this->userRepository->getOneescortServiceSelection(['id' => $selectionId]);
                    if ($selection && $selection->service && $selection->service->category) {
                        $this->userRepository->createEscortService([
                            'user_id'     => $request->id,
                            'category_id' => $selection->service->category->id,
                            'service_id'  => $selection->service_id,
                            'selection_id' => $selectionId
                        ]);
                    }
                }
            }
            $data = $this->userRepository->update(['id' => $request->id], $create);

            if ($data) {
                return response()->json(['status' => 1, 'message' => __('message.statusTwo', ['parameter' => 'User'])]);
            }
        } catch (Exception $e) {
            Log::error("Error in " . __CLASS__ . "::" . __FUNCTION__ . ": " . $e->getMessage());
            return response()->json(['status' => 0, 'message' => 'Failed to create user.']);
        }
    }

    public function assignPlanToUser($inputs) {
        try {
            $plan = $this->planRepository->getOne([ 'id' => $inputs["plan_id"] ]);

            // Insert transaction
           $creat_plan = $this->userRepository->createtransaction([
                'user_id' => $inputs["user_id"],
                'plan_id' => $plan->id,
                'amount' => $plan->cost,
                'type' => 'membership-purchase',
                'payment_method' => 'manual',
                'transaction_id' => 'TXN' . strtoupper(uniqid()),
                'status' => 'success',
            ]);

            // Update user plan
            if($creat_plan) {
                $create = [
                    'plan_id' => $plan->id,
                    'plan_start_date' => now(),
                    'plan_end_date' => now()->addDays($plan->duration_days ?? $plan->days),
                ];
               $run = $this->userRepository->update([ 'id' => $inputs["user_id"] ], $create);

               $userdata = $this->userRepository->getSingleUser([ 'id' => $inputs["user_id"] ], ['users.name', 'users.email']);


                $body = 'Hello ' . $userdata->name . ',';
                $body .= '<p>We’re excited to let you know that your plan has been activated successful. 🎉</p>';
                $body .= '<h3 style="margin-top: 20px; color: #2563eb;">Plan Details</h3>';
                $body .= ' <table width="100%" cellpadding="8" cellspacing="0" border="0" style="border: 1px solid #e5e7eb; border-radius: 5px;">
                    <tr>
                        <td><strong>Plan Name:</strong></td>
                        <td>'.$plan["title"].'</td>
                    </tr>                    
                    <tr>
                        <td><strong>Purchase Date:</strong></td>
                        <td>'.$create["plan_start_date"].'</td>
                    </tr>
                    <tr>
                        <td><strong>Validity:</strong></td>
                        <td>'.$create["plan_end_date"].'</td>
                    </tr>
                </table>';
                $body .= '<p>Please login your account and enjoy !!</p>';
                $body .= '<p><a href="' . route('user-login') . '" target="_blank" style="font-size: 15px; font-family: Helvetica, Arial, sans-serif; color: #902F7E; text-decoration: none;  text-decoration: none; padding: 6px 15px; border-radius: 2px; border: 1px solid #902f7e; display: inline-block;">Login</a></p>';

                $mailData = [
                    'subject' => 'Plan Confirmation !!',
                    'email' => $userdata->email,
                    'body' => $body,
                ];
                //$run2 =  Mail::to('shivania.webwiders@gmail.com')->send(new \App\Mail\DemoMail($mailData));
                $run3 =  Mail::to($userdata->email)->send(new \App\Mail\DemoMail($mailData));
            
               return $run ? ['status' => 200, 'message' => 'Plan activated successfully.']:['status' => 400, 'message' => 'Failed to assign plan to user.'];
            } else {
                return ['status' => 400, 'message' => 'Failed to assign plan to user.'];
            }
            //code...
        } catch (\Exception $e) {
            Log::error("Error in " . __CLASS__ . "::" . __FUNCTION__ . ": " . $e->getMessage());
            return ['status' => 400, 'message' => 'Failed to assign plan to user.'];
        }
    }

    public function createFeatureDevils ($inputs) {
        try {
            $submit_date = Carbon::createFromFormat('d-m-Y', $inputs["date"])->format('Y-m-d');
            
            if(isset($inputs["city_id"]) && !empty($inputs["city_id"])) {
               $alreadyModels = $this->featureDevilRepository->getAllRecordWhere(["city_id" => $inputs["city_id"], 'date' => $submit_date ]);
               $max_models = env('MAX_MODELS', 20);
                $newModels = count($inputs["users"]);
               if($alreadyModels->count() >= $max_models) {
                    return ['status' => 400, 'message' => __('message.already_20')];
               } else if (($alreadyModels->count() + $newModels) > $max_models) {
                    return ['status' => 400, 'message' => __('message.already_remain', ['count' => $alreadyModels->count(), 'remain' => ($max_models - $alreadyModels->count()) ] ) ];
               }
            }
            $insert = [];
            foreach ($inputs["users"] as $key => $value) {
                $insert[] = [
                    "user_id" => $value,
                    "city_id" => $inputs["city_id"] ?? 0,
                    "date" => $submit_date,
                    "created_at" => now()->format('Y-m-d H:i:s'),
                    "updated_at" => now()->format('Y-m-d H:i:s'),
                ];
            }
           $run = $this->featureDevilRepository->create($insert);
           return ["status" => $run ? 200:400];
        } catch (\Exception $e) {
            Log::error("Error in " . __CLASS__ . "::" . __FUNCTION__ . ": " . $e->getMessage());
            return ['status' => 400, 'message' => 'Failed to assign plan to user.'];
        }
    }

    public function fetchFeatureDevils(array $inputs) {
        try {
            $data = [
                "country" => $inputs["country"] ?? null,
                "state" => $inputs["state"] ?? null,
                "city" => $inputs["city"] ?? null,
                "start_date" => $inputs["start"] > 0 ? $inputs["start"]:null,
                "end_date" => $inputs["end"] > 0 ? $inputs["end"]:null
            ];
            $whereInUsers = [];
            if(isset($inputs["advertiser"]) && is_array($inputs["advertiser"]) && !empty($inputs["advertiser"])){
                $whereInUsers = $inputs["advertiser"];
            }
            $myResult = $this->featureDevilRepository->getAllRecordByDate($data, ['feature_devils.*', 'users.name', 'users.email'], $whereInUsers);
            $counts = collect($myResult)
                ->groupBy('date') // group by date
                ->map(fn($items) => $items->count()); // count records in each group


            //dd($counts->count());
            $result = [];
            if($counts->count() > 0) {
                foreach ($counts as $key => $value) {
                   $result[] = ["title" => $value." Advertiser", "start" => $key."T00:00:00", "end" =>  $key."T23:59:00"];
                }
            }
           return ["status" => !empty($result) ? 200:400, "data_count" => count($result), "data_json" => json_encode($result), "results" => $myResult];
        } catch (\Exception $e) {
            Log::error("Error in " . __CLASS__ . "::" . __FUNCTION__ . ": " . $e->getMessage());
            return ['status' => 400, 'message' => 'Failed to assign plan to user.'];
        }
    }
    public function fetchExistFeatureDevils(array $inputs) {
        try {
            $current_date = now()->format('Y-m-d');

            $where = ["type" => 2, ['users.plan_start_date', '<=', $current_date], ['users.plan_end_date', '>=', $current_date]];
            if(isset($inputs["country"])) {
                $where["country_id"] = $inputs["country"];
            }

            if(isset($inputs["state"])) {
                $where["state_id"] =  $inputs["state"];
            }

            if(isset($inputs["city"])) {
                $where["city_id"] = $inputs["city"];
            } 

            $submit_date = Carbon::createFromFormat('Y-m-d H:i:s', $inputs["start"])->format('Y-m-d');
            $alreadyModels = [];
            if(isset($inputs["city"]) && !empty($inputs["city"])) {
               $alreadyModels = $this->featureDevilRepository->getAllRecordWhere(["city_id" => $inputs["city"], 'date' => $submit_date ], ['user_id']);
               $alreadyModels = $alreadyModels->isNotEmpty() ? $alreadyModels->toArray() : [];
            }
            //dd($alreadyModels);
            $users = $this->userRepository->getAllWhere($where, ["id", "name", "email"], $alreadyModels);
            return ['status' => $users ? 200:400, 'data' => $users];

        } catch (\Exception $e) {
            Log::error("Error in " . __CLASS__ . "::" . __FUNCTION__ . ": " . $e->getMessage().": " . $e->getLine());
            return ['status' => 400, 'data' => [] ];
        }
    }

    public function getUploadedImages($inputs)  {
        try {
            if(isset($inputs->is_approved) && !empty($inputs->is_approved)) {
                $where = ["is_approved" => $inputs->is_approved];            
                $run = $this->userUploadImageRepository->getDataWhere($where);
            } else {
                $run = $this->userUploadImageRepository->getDataWhere();
            }
            
            return ['status' => $run ? 200:400, 'data' => $run ];
        } catch (\Exception $e) {
            Log::error("Error in " . __CLASS__ . "::" . __FUNCTION__ . ": " . $e->getMessage().": " . $e->getLine());
            return ['status' => 400, 'data' => [] ];
        }
    }

    public function updatedUploadedImages($inputs)  {
        try {
            $where = ["id" => $inputs->id];
            $update = [];
            if (isset($inputs->is_approved)) {
                $update["is_approved"] = $inputs->is_approved;
            }
            if (isset($inputs->custom_alt_text)) {
                $update["custom_alt_text"] = $inputs->custom_alt_text;
            }
            $run = $this->userUploadImageRepository->updateRecord($where, $update);

           if(isset($run)) {
                $user = $this->userUploadImageRepository->getUserData(['uploaded_photos.id' => $inputs->id ]);
                $body = 'Hello '.$user->name.',';
                if($inputs->is_approved == 2) {
                    $body .= '<p>We regret to inform you that your uploaded image has rejected.</p>';
                    $body .= '<p>Reason : '.$inputs->reason.'.</p>';
                    $subject = 'Image Rejected '. now()->format('Y-m-d H:i:s');
                } else {
                    $body .= '<p>Your uploaded image has been approved successfully !!</p>';
                    $subject = 'Image Approved '. now()->format('Y-m-d H:i:s');
                }

                // dd($body);

                $mailData = [
                    'subject' => $subject,
                    'email' => $user->email, //'ameen.webwiders@gmail.com',
                    'body' => $body,
                ];

                $run3 =  Mail::to($user->email)->send(new \App\Mail\DemoMail($mailData));
            }
            return ['status' => $run ? 200:400, "msg" => $run ?  __('message.success_msg'): __('message.statusZero')];
        } catch (\Exception $e) {
            Log::error("Error in " . __CLASS__ . "::" . __FUNCTION__ . ": " . $e->getMessage().": " . $e->getLine());
            return ['status' => 400 , "message" => __('message.statusZero')];
        }
    }

    public function getUploadedVideos($inputs)  {
        try {
            if(isset($inputs->is_approved) && !empty($inputs->is_approved)) {
                $where = ["is_approved" => $inputs->is_approved];            
                $run = $this->userUploadVideoRepository->getDataWhere($where);
            } else {
                $run = $this->userUploadVideoRepository->getDataWhere();
            }
            
            return ['status' => $run ? 200:400, 'data' => $run ];
        } catch (\Exception $e) {
            Log::error("Error in " . __CLASS__ . "::" . __FUNCTION__ . ": " . $e->getMessage().": " . $e->getLine());
            return ['status' => 400, 'data' => [] ];
        }
    }

    public function updatedUploadedVideos($inputs)  {
        try {
            $where = ["id" => $inputs->id];
            $update = ["is_approved" => $inputs->is_approved];
           $run = $this->userUploadVideoRepository->updateRecord($where, $update);

           if(isset($run)) {
                $user = $this->userUploadVideoRepository->getUserData(['videos.id' => $inputs->id ]);
                $body = 'Hello '.$user->name.',';
                if($inputs->is_approved == 2) {
                    $body .= '<p>We regret to inform you that your uploaded video has rejected.</p>';
                    $body .= '<p>Reason : '.$inputs->reason.'.</p>';
                    $subject = 'Video Rejected '. now()->format('Y-m-d H:i:s');
                } else {
                    $body .= '<p>Your uploaded video has been approved successfully !!</p>';
                    $subject = 'Video Approved '. now()->format('Y-m-d H:i:s');
                }

                $mailData = [
                    'subject' => $subject,
                    'email' => $user->email, //'
                    'body' => $body,
                ]; 
                $run3 =  Mail::to($user->email)->send(new \App\Mail\DemoMail($mailData));
            }
            return ['status' => $run ? 200:400, "msg" => $run ?  __('message.success_msg'): __('message.statusZero')];
        } catch (\Exception $e) {
            Log::error("Error in " . __CLASS__ . "::" . __FUNCTION__ . ": " . $e->getMessage().": " . $e->getLine());
            return ['status' => 400 , "message" => __('message.statusZero')];
        }
    }

    public function manuallyBoostRequestStoreService($inputs) {
        try { 
           $run = $this->manuallyBoostRequestRepository->getAllDataInArray();
           return ['status' => $run ? 200:400, "data" => $run ];
        } catch (\Exception $e) {
            Log::error("Error in " . __CLASS__ . "::" . __FUNCTION__ . ": " . $e->getMessage().": " . $e->getLine());
            return ['status' => 400 , "data" => [] ];
        }
    }

    public function manuallyBoostRequestActionService($inputs) {
        try { 
            $where = ["id" => $inputs["id"] ];
            $update = ["status" => $inputs["is_approved"]];
           $run = $this->manuallyBoostRequestRepository->updateRecord($where, $update);
           if($run && $inputs["is_approved"] == 1) {
               $boost_data = $this->manuallyBoostRequestRepository->getSingleData($where, ['ups_quantity']);
               $where1  = ["id" => $inputs["user_id"] ];
               $user_data = $this->userRepository->getSingleUser($where1, ['alloted_ups']);
               $alloted_ups = $user_data->alloted_ups + $boost_data->ups_quantity;
               $this->userRepository->update($where1, ["alloted_ups" => $alloted_ups]);
            }
            $msg = $inputs["is_approved"] == 1 ? __('message.common_success') : __('message.user_rejected');
           return ['status' => $run ? 200:400, "msg" => $run ? $msg : __('message.statusZero') ];
        } catch (\Exception $e) {
            Log::error("Error in " . __CLASS__ . "::" . __FUNCTION__ . ": " . $e->getMessage().": " . $e->getLine());
            return ['status' => 400 , "msg" => __('message.statusZero') ];
        }
    }

    public function convertVideo($request) {
        try {
            
        /* dump([
            'video_url' => $request["video_url"],
            'final_path' => storage_path('app/public/' . $request["video_url"]),
            'exists' => file_exists(storage_path('app/public/' . $request["video_url"])),
        ]); */

            $outputPath = 'user_videos/' . uniqid() . '.mp4';

            $ffmpeg = \FFMpeg\FFMpeg::create([
            'ffmpeg.binaries'  => 'C:\xampp\mysql\bin\ffmpeg\bin\ffmpeg.exe',
            'ffprobe.binaries' => 'C:\xampp\mysql\bin\ffmpeg\bin\ffprobe.exe',
            'timeout'          => 3600,
            'ffmpeg.threads'   => 12,
        ]);
            $video = $ffmpeg->open(storage_path('app/public/' . $request["video_url"]));
            $format = new \FFMpeg\Format\Video\X264('aac', 'libx264');
            $run = $video->save($format, storage_path('app/public/' . $outputPath));
            $convert = false;
            if(file_exists(storage_path('app/public/' . $outputPath))) {
                unlink(storage_path('app/public/' . $request["video_url"]));
                $this->userUploadVideoRepository->updateRecord(["id" => $request["id"]], ["file_path" => $outputPath]);
                $convert = true;
            }
            return [
                'status' => $convert ? 200 : 400,
                "msg" => $convert ? __('message.common_success') : __('message.statusZero'),
                'path' => $convert ? $outputPath : "",
                 'convert' => $convert
            ];
        } catch (\Exception $e) {
            Log::error("Error in " . __CLASS__ . "::" . __FUNCTION__ . ": " . $e->getMessage() . ": " . $e->getLine());
            return ['status' => 400, "msg" => __('message.statusZero')];
        }
    }

}
