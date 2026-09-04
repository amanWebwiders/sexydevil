<?php

namespace App\Services\Front;

use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Log;
use App\Repository\Eloquent\{UserRepository, CountryRepository, CityRepository, ManuallyBoostRequestRepository, LocationSeoContentRepository};
use App\Repository\Eloquent\AdminRepository;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Mail;

use Illuminate\Support\Str;
use Validator;
use App\Traits\ImageUploadTrait;

class UserServices
{
    use ImageUploadTrait;
    protected $userRepository, $cityRepository, $countryRepository, $manuallyBoostRequestRepository, $locationSeoContentRepository;
    protected $AdminRepository;
    private $dataObject;

    public function __construct(AdminRepository $AdminRepository,
    UserRepository $userRepository,
    CityRepository $cityRepository,
    CountryRepository $countryRepository,
    ManuallyBoostRequestRepository $manuallyBoostRequestRepository,
    LocationSeoContentRepository $locationSeoContentRepository
    )
    {
        $this->dataObject = new \stdClass();
        $this->userRepository = $userRepository;
        $this->AdminRepository = $AdminRepository;
        $this->cityRepository = $cityRepository;
        $this->countryRepository = $countryRepository;
        $this->manuallyBoostRequestRepository = $manuallyBoostRequestRepository;
        $this->locationSeoContentRepository = $locationSeoContentRepository;
    }

    public function saveContactUsData($request)
    {
        try {

            $data['full_name'] = $request['full_name'];
            $data['city'] = $request['city'];
            $data['email'] = $request['email'];
            $data['phone'] = $request['phone'];
            $data['message'] = $request['message'];

            return  $this->userRepository->saveContactUsData($data);
        } catch (\Exception $e) {
            Log::error("Error in UserServices.saveContactUsData(): " . $e->getMessage());
            return response()->json(['status' => 0, 'message' => __('message.statusZero'), 'data' => $this->dataObject, 'error' => $this->dataObject], 500);
        }
    }

    public function register($request)
    {
        try {
            $create = [
                'name' => $request->name,
                'nickname' => $request->name,
                'phone_code' => $request->phone_code,
                'phone' => $request->phone,
                'email' => $request->email,
                'type' => $request->type,
                'password' => Hash::make($request->password),
                'profile_image' => 'profile_image/default-profile.png',
                'plan_id' => null,
                'unique_user_id' => generateUniqueUserCode(),
            ];

            if ($request->type == 2) {
                $create['slogan'] = $request->slogan;
                $create['rates'] = $request->rates ?? 0;
                $create['contact_method'] = $request->contact_method;
                $create['description'] = $request->description;
                $create['contact_details'] = $request->contact_details;

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
                                // m/d/Y
                                $create['dob'] = sprintf('%04d-%02d-%02d', $y, $p1, $p2);
                            } else {
                                // d/m/Y (standard flatpickr)
                                $create['dob'] = sprintf('%04d-%02d-%02d', $y, $p2, $p1);
                            }
                        } else {
                            $create['dob'] = date('Y-m-d', strtotime($rawDob));
                        }
                    } catch (\Exception $e) {
                        Log::warning("UserServices::register() could not parse DOB '{$request->dob}': " . $e->getMessage());
                    }
                }
                $create['country_id'] = $request->country_id;

                $allowedExtensions = ["jpg", "jpeg", "png", "gif", "webp"];

                // If media files are uploaded
                if ($request->hasFile('media')) {
                    $image = $request->file('media');
                    $extension = strtolower($image->getClientOriginalExtension());
                    if (in_array($extension, $allowedExtensions)) {
                        $imagePath = $this->uploadImage($image, 'media');
                        $create['verify_age_document'] = $imagePath;
                    }
                }
                if ($request->hasFile('document_image')) {
                    $image = $request->file('document_image');
                    $extension = strtolower($image->getClientOriginalExtension());
                    if (in_array($extension, $allowedExtensions)) {
                        $imagePath = $this->uploadImage($image, 'document_image');
                        $create['document_image'] = $imagePath;
                    }
                }
                if ($request->hasFile('holding_document_image')) {
                    $image = $request->file('holding_document_image');
                    $extension = strtolower($image->getClientOriginalExtension());
                    if (in_array($extension, $allowedExtensions)) {
                        $imagePath = $this->uploadImage($image, 'holding_document_image');
                        $create['holding_document_image'] = $imagePath;
                    }
                }
                if ($request->hasFile('identity_photos')) {
                    $photoPaths = [];

                    foreach ($request->file('identity_photos') as $photo) {
                        $extension = strtolower($photo->getClientOriginalExtension());
                        if (in_array($extension, $allowedExtensions)) {
                            $path = $this->uploadImage($photo, 'identity_photos');
                            $photoPaths[] = $path;
                        }
                    }
                    // Save paths as JSON string
                    $create['identity_photos'] = json_encode($photoPaths);
                }
            }
            // dd($create);
            $data = $this->userRepository->create($create);
            Auth::guard('web')->login($data);
            if ($data) {

                $randomToken = Str::random(40);
                $update['remember_token'] = $randomToken;

                $run2 = $this->userRepository->update(['email' => $request->email], $update);

                $userdata = $this->userRepository->getOne(['email' => $request->email]);
                $verificationUrl = route('user.user-email-verification', ['token' => $userdata['remember_token']]);
                // dd($verificationUrl);
                $body = 'Hello ' . $data->name . ',';

                $body .= '<p>Thanks for signing up to ' . env("APP_NAME") . '.</p>Please confirm your email address by clicking on this link:</p>';

                $body .= '<p><a href="' . $verificationUrl . '" target="_blank" style="font-size: 15px; font-family: Helvetica, Arial, sans-serif; color: #902F7E; text-decoration: none;  text-decoration: none; padding: 6px 15px; border-radius: 2px; border: 1px solid #902f7e; display: inline-block;">Verify email</a></p>';
                // dd($body);

                $mailData = [
                    'subject' => 'Verify Email',
                    'email' => $data->email,
                    'body' => $body,
                ];

                //$run2 =  Mail::to('shivania.webwiders@gmail.com')->send(new \App\Mail\DemoMail($mailData));
                try {
                    Mail::to($request->email)->send(new \App\Mail\DemoMail($mailData));
                } catch (\Exception $e) {
                    Log::error("Failed to send email to {$request->email}: " . $e->getMessage(), [
                        'class' => __CLASS__,
                        'function' => __FUNCTION__,
                        'line' => __LINE__,
                    ]);
                }
                return response()->json(['status' => 1, 'message' => __('message.singup_success')]);
            }
        } catch (\Exception $e) {
            Log::error("Error in " . __CLASS__ . "::" . __FUNCTION__ . ": " . $e->getMessage());
            return response()->json(['status' => 0, 'message' => __('message.statusZero')]);
        }
    }

    public function sendPassword($request)
    {
        try {
            $userData  = $this->userRepository->getOne(['email' => $request['email']]);
            if ($userData) {

                $randomPassword = mt_rand(100000, 999999);
                $update['password'] = Hash::make($randomPassword);
                $this->userRepository->update(['id' => $userData->id], $update);
                $email = $userData->email;
                // dd($randomPassword);
                $body = 'Hello ' . $userData->name;
                $body .= '<p>This is an automated message. If you did not recently initiate the Forgot Password process, please disregard this email.</p>';
                $body .= '<p>Your new temporary password for logging in is  <b>' .  $randomPassword . '</b> Please do not share the password.</p>';

                $mailData = [
                    'subject' => 'Forgot password',
                    'email' => $email,
                    'body' => $body,
                ];

                try {
                    Mail::to($email)->send(new \App\Mail\DemoMail($mailData));
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
            log::error('Error in UserServices/sendPassword :' . $e->getMessage() . 'in line' . $e->getLine());
            return response()->json(['status' => '0', 'message' => 'Something went wrong.']);
        }
    }

    public function changePassword($request)
    {
        try {

            $user = Auth::guard('web')->user();

            if (Hash::check($request['current_password'], $user->password)) {
                $data = [
                    'password' => Hash::make($request['password'])
                ];
                $id = $user->id;
                // dd($id);
                return  $this->userRepository->update(['id' => $id], $data);
            }
        } catch (\Exception $e) {
            Log::error("Error in UserServices.changePassword(): " . $e->getMessage());
            return response()->json(['status' => 0, 'message' => __('message.statusZero'), 'data' => $this->dataObject, 'error' => $this->dataObject], 500);
        }
    }


    public function updateProfile($request)
    {
        // dd($request);
        try {
            $user = Auth::guard('web')->user();
            //$data['name'] = $request['name'];
            $data['phone'] = $request['phone'];
            $data['phone_code'] = $request['phone_code'];
            $data['email'] = $request['email'];

            if ($request->hasFile('file_image')) {
                $image = $request->file('file_image');

                // Generate a unique file name for the image and store it
                $imagePath = $this->uploadImage($image, 'profile_image');  // Save to 'artists' folder in the public disk
                // Add the image path to the data
                $data['profile_image'] = $imagePath;
            }
            $data['nickname'] = $request->nickname;

            if ($request->type == 2) {

                $data['displayed_age'] = $request->displayed_age;
                $data['slogan'] = $request->slogan;
                $data['nationality'] = $request->nationality;
                $data['rates'] = $request->rates ?? 0;
                $data['contact_method'] = $request->contact_method;
                $data['description'] = $request->description;
                $data['gender_id'] = $request->gender_id;
                //$data['country_id'] = $request->country_id;

                $data['sex_location'] = $request->sex_location;
                $data['blocked_countries'] = $request->blocked_countries; // Should be json_encoded if stored as JSON
                $data['languages'] = $request->languages; // Should be json_encoded if stored as JSON
                $data['sexual_orientation'] = $request->sexual_orientation;
                $data['body_type_id'] = $request->body_type_id;
                $data['contact_methods'] = $request->contact_methods;

                $data['ethnicity_id'] = $request->ethnicity_id;
                $data['state_id'] = $request->state_id;
                $data['city_id'] = $request->city_id;
                $data['breast_size'] = $request->breast_size;
                $data['incall_outcall'] = $request->incall_outcall;
                $data['social_contact_method'] = $request->social_contact_method;
                $data['contact_detail'] = $request->contact_detail;
                $data['height_cm'] = $request->height_cm;
                $data['weight_kg'] = $request->weight_kg;
                $data['shoe_size'] = $request->shoe_size;
                $data['tattoo'] = $request->tattoo;
                $data['piercing'] = $request->piercing;
                $data['smoking'] = $request->smoking;
                $data['oral_kissing_id'] = $request->oral_kissing_id;
                $data['anal_related_option_id'] = $request->anal_related_option_id;
                $data['cum_body_play_id'] = $request->cum_body_play_id;
                $data['manual_fingering_id'] = $request->manual_fingering_id;
                $data['massage_sensual_touch_id'] = $request->massage_sensual_touch_id;
                $data['fetish_bdsm_id'] = $request->fetish_bdsm_id;
                $data['group_special_experience_id'] = $request->group_special_experience_id;
                $data['media_virtual_option_id'] = $request->media_virtual_option_id;
                $data['experience_id'] = $request->experience_id;
                $data['service_notes'] = $request->service_notes;

                $data['hair_length_id'] = $request->hair_length_id;
                $data['hair_type_id'] = $request->hair_type_id;
                $data['hair_color_id'] = $request->hair_color_id;
                $data['eye_color_id'] = $request->eye_color_id;
                $data['tattoo_id'] = $request->tattoo_id;
                $data['pubic_hair_id'] = $request->pubic_hair_id;

                $data['onlyfans_link'] = $request->onlyfans_link;
                $data['instagram_link'] = $request->instagram_link;
                $data['telegram_link'] = $request->telegram_link;
                $data['tiktok_link'] = $request->tiktok_link;
                // dd($data);
                // If media files are uploaded
                if ($request->hasFile('media')) {
                    $image = $request->file('media');

                    // Generate a unique file name for the image and store it
                    $imagePath = $this->uploadImage($image, 'media');  // Save to 'artists' folder in the public disk
                    // Add the image path to the data
                    $data['verify_age_document'] = $imagePath;
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
                    $data['document_image'] = $imagePath;
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
                    $data['holding_document_image'] = $imagePath;
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
                    $data['identity_photos'] = json_encode($photoPaths);
                }
            }
            // dd($data);
            $id = $user->id;
            if ($request->has('services') || $request->has('selections') || $request->has('selections_group')) {
                $this->userRepository->deleteEscortService(['user_id' => $id]);
            }
            if ($request->has('services')) {

                foreach ($request->input('services') as $serviceId => $value) {
                    $service = \App\Models\EscortService::with('category')->find($serviceId);
                    if ($service) {
                        $this->userRepository->createEscortService([
                            'user_id'     => $id,
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
                                'user_id'     => $id,
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
                            'user_id'     => $id,
                            'category_id' => $selection->service->category->id,
                            'service_id'  => $selection->service_id,
                            'selection_id' => $selectionId
                        ]);
                    }
                }
            }
            $run = $this->userRepository->update(['id' => $id], $data);
            // dd($run);
            if ($run) {
                return response()->json(['status' => 1, 'message' => __('message.statusTwo', ['parameter' => 'Profile']), 'data' => [], 'error' => []], 200);
            } else {
                return response()->json(['status' => 0, 'message' => __('message.statusZero'), 'data' => [], 'error' => []], 500);
            }
        } catch (\Exception $e) {
            Log::error("Error in UserServices.updateProfile(): " . $e->getMessage());
            return response()->json(['status' => 0, 'message' => __('message.statusZero'), 'data' => $this->dataObject, 'error' => $this->dataObject], 500);
        }
    }

    public function wishlistService($request)
    {
        try {

            $user = Auth::guard('web')->user();
            if ($user) {

                $where = [
                    'favourite_user_id' => $request->favourite_user_id,
                    'user_id' => $request->user_id,
                ];

                $wishlist = $this->userRepository->getOnewishlist($where);

                if ($wishlist) {
                    $data = $this->userRepository->deleteWishlist($where);

                    if ($data) {
                        return response()->json(['status' => 1, 'message' => 'User has been removed from your Favourite List!']);
                    }
                } else {
                    $create = [
                        'favourite_user_id' => $request->favourite_user_id,
                        'user_id' => $request->user_id,
                    ];

                    $data = $this->userRepository->createWishlist($create);

                    if ($data) {
                        return response()->json(['status' => 1, 'message' => 'User has been added in your Favourite List!']);
                    }
                }
            } else {
                    $userId = $request->favourite_user_id;

                    // Get existing favorite list
                    $favorites = json_decode($request->cookie('favorites', '[]'), true);

                    // Ensure array
                    $favorites = array_map('intval', $favorites);

                    if (!in_array($userId, $favorites)) {
                        $favorites[] = (int) $userId;
                        $message = 'User has been added in your Favourite List!';
                    } else {
                        $favorites = array_filter($favorites, fn ($id) => $id !== (int)$userId);
                        $favorites = array_values($favorites); // 🔥 FIX
                        $message = 'User has been removed from your Favourite List!';
                    }
                    //dump($favorites);
                    // Store back in cookie (valid for 30 days)
                    return response()->json([
                        'status' => 1,
                        'message' => $message
                    ])->cookie('favorites', json_encode($favorites), 60 * 24 * 30);
            }
            return response()->json([
                'status' => 0,
                'message' => 'You need to be logged in.',
                'redirect' => route('user-login') // Or your named login route
            ]);
        } catch (Exception $e) {
            Log::error("Error in " . __CLASS__ . "::" . __FUNCTION__ . ": " . $e->getMessage());
            return response()->json(['status' => 0, 'message' => 'Failed to Favourite from service.']);
        }
    }

    public function updateBoost($request)
    {
        try {

            $user = Auth::guard('web')->user();
            if ($user) {
                $admin = $this->AdminRepository->getOne(['id' => 1]);
                $boostDays = $admin->boost_days ?? 3;
                $boostCost = $admin->boost_cost ?? 30;

                $boostStart = \Carbon\Carbon::now();
                $boostEnd = $boostStart->copy()->addDays($boostDays);
                $user->update([
                    'is_boosted' => 1,
                    'boost_start_date' => $boostStart,
                    'boost_end_date' => $boostEnd,
                ]);

                $this->userRepository->createtransaction([
                    'user_id' => $user->id,
                    'amount' => $boostCost,
                    'type' => 'boost',
                    'payment_method' => 'manual',
                    'transaction_id' => 'TXN' . strtoupper(uniqid()),
                    'status' => 'success',
                ]);


                return response()->json([
                    'message' => 'Boost successful',
                    'boost_end_date' => $boostEnd->format('d M Y')
                ]);
            }
            return response()->json([
                'status' => 0,
                'message' => 'You need to be logged in.',
                'redirect' => route('user-login') // Or your named login route
            ]);
        } catch (Exception $e) {
            Log::error("Error in " . __CLASS__ . "::" . __FUNCTION__ . ": " . $e->getMessage());
            return response()->json(['status' => 0, 'message' => 'Failed to Favourite from service.']);
        }
    }

    public function getUsersByCurrentCityCountry($request, $city = null) {
        try {

            $currentLoc = currentCityContry();
            if(isset($city) && !empty($city)) {
                $currentLoc["city"] = $city;
                $currentLoc["country"] = $city;
            }

            $cityId = $this->cityRepository->getSingleRecordWhere(['name' => $currentLoc["city"] ]);
            $countryId = $this->countryRepository->getSingleRecordWhere(['name' => $currentLoc["country"] ]);

            $myCity = $cityId->id ?? 1;
            $myCountryId = $countryId->id ?? 1;
            $current_date = now()->format('Y-m-d');
            $user = Auth::guard('web')->user();
            $user_id = $user->id ?? 0;
            $where = [
                'users.type' => 2,
                'user_status' => 0,
                'admin_status' => 'approved',
                ['plan_start_date', '<=', $current_date],
                ['plan_end_date', '>=', $current_date],
                ['users.id', '!=', $user_id]
            ];

            $page = (int)($request->page ?? 1);
            //from current city
            $records_from = $request->records_from ?? "city";
            $users = $this->userRepository->usersByMyCurrentLocation(array_merge($where, [['city_id', '=', $myCity]]), $page);
            if(isset($users) && $users->isNotEmpty()) {
                $records_from = "city";
                $page = $page+1;
            } else if($records_from == 'city') {
               $page = isset($request->records_from) && $request->records_from == 'country' ? $page:1;
                $records_from = "country";
            }
            //from current county
            if($users->isEmpty() && $records_from == 'country') {
                $users = $this->userRepository->usersByMyCurrentLocation(
                    array_merge($where, [
                                ['city_id', '!=', $myCity],
                                ['country_id', '=', $myCountryId],
                            ]), $page
                );
            }
            //dd($users->count());
            if(isset($users) && $users->count() > 1 && $records_from == 'country') {
                $records_from = "country";
                $page = $page+1;
            } else if($records_from == 'country') {
                $page = isset($request->records_from) && $request->records_from == 'globally' ? $page:1;
                $records_from = "globally";
            }
            //dd($records_from);
            //globally
            if($users->isEmpty() && $records_from == "globally") {
                $users = $this->userRepository->usersByMyCurrentLocation(
                        array_merge($where, [
                                ['city_id', '!=', $myCity],
                                ['country_id', '!=', $myCountryId],
                        ]), $page
                );
            }
            //dd($users);
            if(isset($users) && $users->count() > 1 && $records_from == "globally") {
                $page = $page+1;
            } else if($records_from == 'globally') {
                $page = isset($request->records_from) && $request->records_from == 'world' ? $page:1;
                $records_from = "world";
            }
            //dd($page);
            if($users->isEmpty() && $records_from == "world"){
                $users = $this->userRepository->usersByMyCurrentLocation(
                        $where, $page
                );
                $page = $page+1;
            }

            if($users->isEmpty() && $records_from == "world"){
                $users = $this->userRepository->usersByMyCurrentLocation(
                        $where, $page
                );
                $page = $users->isEmpty() ? 1 : $page+1;
            }
            return [ "records" => $users->items() ?? [], "records_from" => $records_from, "page" => $page ];
        } catch (Exception $e) {
            Log::error("Error in " . __CLASS__ . "::" . __FUNCTION__ . ": " . $e->getMessage());
        }
    }

    public function reelSearch($inputs)  {
        try {
            $where = [
                'users.type' => 2,
                'users.user_status' => 0,
                'users.admin_status' => 'approved'
            ];
            if(isset($inputs["country_id"]) && !empty($inputs["country_id"])) {
                $where['country_id'] = $inputs["country_id"];
            }

            if(isset($inputs["state_id"]) && !empty($inputs["state_id"])) {
                $where['state_id'] = $inputs["state_id"];
            }

            if(isset($inputs["city"]) && !empty($inputs["city"])) {
                $where['city_id'] = $inputs["city"];
            }
            $page = (int)$inputs["page"];
            $allUsers = $this->userRepository->usersByMyCurrentLocation($where, $page);
            if($allUsers->isEmpty()) {
                //dd(123);
                $allUsers = $this->userRepository->usersByMyCurrentLocation($where, 1);
                $page = 1;
            }
            //dd($allUsers);
            $page = $page + 1;
            return ["status" => $allUsers->isNotEmpty() ? 200:400, "list" => view('front.component.reelsAjax', compact('allUsers'))->render(), "page" => $page];
        } catch (Exception $e) {
            Log::error("Error in " . __CLASS__ . "::" . __FUNCTION__ . ": " . $e->getMessage());
            return ["status" => 400, "list" => ""];
        }
    }

    public function manuallyBoostRequestStoreService ($data) {
        try {
           $run = $this->manuallyBoostRequestRepository->createRecord([
                'user_id' => Auth::guard('web')->user()->id,
                'ups_quantity' => $data['ups_quantity']
            ]);
            return ["status" => $run ? 200 : 400];
        } catch (Exception $e) {
            Log::error("Error in " . __CLASS__ . "::" . __FUNCTION__ . ": " . $e->getMessage());
            return ["status" => 400, "list" => ""];
        }
    }
    public function getManuallyBoostData($userId) {
        try {
            return $this->manuallyBoostRequestRepository->getAllData(['user_id' => $userId]);
          } catch (Exception $e) {
            Log::error("Error in " . __CLASS__ . "::" . __FUNCTION__ . ": " . $e->getMessage());
            return null;
          }
    }

    public function manuallyBoostProcessService($data) {
        try {
            $user = Auth::guard('web')->user();
            //dd($user);
            $current_time = Carbon::now(config('app.timezone'));
            $check = $this->checkAlreadyActiveBoost();
            if($check["status"] == 200) {
                return ["status" => 400, "message" => __('message.already_boost')];
            } else {
                if(auth()->user()->alloted_ups > 0) {
                    $data = [
                        'user_id' => $user->id,
                        'ups_quantity' => 1,
                        'boosted_from' => $current_time->copy()->format('Y-m-d H:i:s'),
                        'boosted_to' => $current_time->copy()->addMinutes(15)->format('Y-m-d H:i:s'),
                    ];
                    $run = $this->manuallyBoostRequestRepository->createBoostProfiles($data);
                    $user->update([
                        'alloted_ups' => $user->alloted_ups - 1
                    ]);
                    return ["status" => $run ? 200 : 400, "message" => $run ? __('message.boost_success') : __('message.something_went_wrong')];
                }
                return ["status" => 400, "message" => __('message.no_ups_available')];
            }
        } catch (Exception $e) {
            Log::error("Error in " . __CLASS__ . "::" . __FUNCTION__ . ": " . $e->getMessage());
            return ["status" => 400, "list" => ""];
        }
    }

    public function checkAlreadyActiveBoost() {
        try {
           $user = Auth::guard('web')->user();
           $current_time = Carbon::now(config('app.timezone'));
            $where = [
                'user_id' => $user->id,
                ['boosted_from', '<=', $current_time->copy()->format('Y-m-d H:i:s')],
                ['boosted_to', '>=', $current_time->copy()->format('Y-m-d H:i:s')]
            ];
            $check = $this->manuallyBoostRequestRepository->getSingleBoostProfiles($where);
            return [ "status" => $check ? 200 : 400, "data" => $check ];
        } catch (Exception $e) {
            Log::error("Error in " . __CLASS__ . "::" . __FUNCTION__ . ": " . $e->getMessage());
            return [ "status" => 400 ];
        }
    }

    public function getLocationSeoContent($city, $pageType) {
        try {
            $run = null;

            if (!empty($city) && $city !== 'home') {
                // 1. Try City match (by name or ID)
                if (is_numeric($city)) {
                    $run = $this->locationSeoContentRepository->getSingleRecordWhere([
                        'city_id' => (int)$city,
                        'title' => $pageType
                    ]);
                } else {
                    $run = $this->locationSeoContentRepository->getSingleRecordWhere([
                        'city' => $city,
                        'title' => $pageType
                    ]);
                    if (!$run) {
                        $cityObj = \App\Models\City::where('name', $city)->first();
                        if ($cityObj) {
                            $run = $this->locationSeoContentRepository->getSingleRecordWhere([
                                'city_id' => $cityObj->id,
                                'title' => $pageType
                            ]);
                        }
                    }
                }

                // 2. Try State match if City match not found
                if (!$run) {
                    if (is_numeric($city)) {
                        $run = $this->locationSeoContentRepository->getSingleRecordWhere([
                            'state_id' => (int)$city,
                            'city_id' => null,
                            'title' => $pageType
                        ]);
                    } else {
                        $run = $this->locationSeoContentRepository->getSingleRecordWhere([
                            'state' => $city,
                            'city_id' => null,
                            'title' => $pageType
                        ]);
                        if (!$run) {
                            $stateObj = \App\Models\State::where('name', $city)->first();
                            if ($stateObj) {
                                $run = $this->locationSeoContentRepository->getSingleRecordWhere([
                                    'state_id' => $stateObj->id,
                                    'city_id' => null,
                                    'title' => $pageType
                                ]);
                            }
                        }
                    }
                }

                // 3. Try Country match if State match not found
                if (!$run) {
                    if (is_numeric($city)) {
                        $run = $this->locationSeoContentRepository->getSingleRecordWhere([
                            'country_id' => (int)$city,
                            'state_id' => null,
                            'city_id' => null,
                            'title' => $pageType
                        ]);
                    } else {
                        $run = $this->locationSeoContentRepository->getSingleRecordWhere([
                            'country' => $city,
                            'state_id' => null,
                            'city_id' => null,
                            'title' => $pageType
                        ]);
                        if (!$run) {
                            $countryObj = \App\Models\Country::where('name', $city)->first();
                            if ($countryObj) {
                                $run = $this->locationSeoContentRepository->getSingleRecordWhere([
                                    'country_id' => $countryObj->id,
                                    'state_id' => null,
                                    'city_id' => null,
                                    'title' => $pageType
                                ]);
                            }
                        }
                    }
                }
            }

            // 4. Fallback to Worldwide / Global Page SEO
            if (!$run) {
                $titles = [$pageType];
                if (in_array(strtolower($pageType), ['home', 'entry page'])) {
                    $titles = ['Home', 'Entry Page', 'home', 'entry page'];
                }

                $run = \App\Models\LocationSeoContent::whereIn('title', $titles)
                    ->where(function($q) {
                        $q->where('country', 'worldwide')
                          ->orWhere('country', 'Worldwide')
                          ->orWhere('country_id', 0)
                          ->orWhereNull('country_id');
                    })
                    ->where(function($q) {
                        $q->whereNull('city_id')->orWhere('city_id', 0)->orWhere('city_id', '');
                    })
                    ->where(function($q) {
                        $q->whereNull('state_id')->orWhere('state_id', 0)->orWhere('state_id', '');
                    })
                    ->first();
            }

            return [ "status" => $run ? 200 : 400, "data" => $run ];
        } catch (\Exception $e) {
            Log::error("Error in " . __CLASS__ . "::" . __FUNCTION__ . ": " . $e->getMessage());
            return [ "status" => 400 ];
        }
    }
}
