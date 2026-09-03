<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Http\Requests\{UserRequest, UpdateUserRequest};
use App\Services\Admin\UserServices;
use App\Repository\Eloquent\{AdminRepository, UserRepository, CommonRepository, OccupationRepository, PlanRepository};
use Illuminate\Support\Facades\Mail;
use App\Mail\{AcceptbyAdminMail, RejectbyAdminMail};
use App\Models\{User, EscortServiceCategory, UserEscortService, Country};
use App\Traits\ImageUploadTrait;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use Validator;
use Carbon\Carbon;

class UserController extends Controller
{
    use ImageUploadTrait;
    protected $AdminRepository, $UserServices, $userRepository, $CommonRepository, $PlanRepository;
    private $dataObject;
    protected $OccupationRepository;
    public function __construct(CommonRepository $CommonRepository, 
    AdminRepository $AdminRepository, 
    OccupationRepository $OccupationRepository, 
    UserServices $UserServices, 
    UserRepository $userRepository,
    PlanRepository $PlanRepository)
    {
        $this->dataObject = new \stdClass();
        $this->AdminRepository = $AdminRepository;
        $this->OccupationRepository = $OccupationRepository;
        $this->userRepository = $userRepository;
        $this->UserServices = $UserServices;
        $this->CommonRepository = $CommonRepository;
        $this->PlanRepository = $PlanRepository;
    }

    public function index()
    {

        try {
            $countryCodes = $this->AdminRepository->getCountryCode();
            $data = $this->userRepository->getByWhere(['type' => 1]);
            return view('admin.user', compact('data', 'countryCodes'));
        } catch (\Exception $e) {
            Log::error('Error in UserController/index :' . $e->getMessage() . 'in line' . $e->getLine());
            return response()->json(['status' => '0', 'message' => __('message.statusZero')]);
        }
    }
    public function advertiseList()
    {

        try {
            $countryCodes = $this->AdminRepository->getCountryCode();
            $data = $this->userRepository->getByWhere(['type' => 2, 'admin_status' => 'pending']);
            return view('admin.advertiseList', compact('data', 'countryCodes'));
        } catch (\Exception $e) {
            Log::error('Error in UserController/advertiseList :' . $e->getMessage() . 'in line' . $e->getLine());
            return response()->json(['status' => '0', 'message' => __('message.statusZero')]);
        }
    }
    public function advertiseapproveList()
    {

        try {
            $countryCodes = $this->AdminRepository->getCountryCode();
            $data = $this->userRepository->getByWhere(['type' => 2, 'admin_status' => 'approved']);
            return view('admin.advertise-approvelist', compact('data', 'countryCodes'));
        } catch (\Exception $e) {
            Log::error('Error in UserController/advertiseList :' . $e->getMessage() . 'in line' . $e->getLine());
            return response()->json(['status' => '0', 'message' => __('message.statusZero')]);
        }
    }


    public function clientList()
    {

        try {

            $data = $this->userRepository->getAll();
            // dd($data);
            return view('admin.client', compact('data'));
        } catch (\Exception $e) {
            Log::error('Error in UserController/index :' . $e->getMessage() . 'in line' . $e->getLine());
            return response()->json(['status' => '0', 'message' => __('message.statusZero')]);
        }
    }


    public function store(UserRequest $request)
    {
        try {
            return $this->UserServices->createUser($request);
        } catch (\Exception $e) {
            Log::error('Error in UserController/index :' . $e->getMessage() . 'in line' . $e->getLine());
            return response()->json(['status' => '0', 'message' => __('message.statusZero')]);
        }
    }
    public function show($id)
    {
        try {

            $user = $this->userRepository->getOne(['id' => $id]);
            $plans = $this->PlanRepository->getAll();

            if ($user) {
                $uploadedPhotos = $this->userRepository->getByWhereuploadedPhoto(['user_id' => $user->id]);
                $uploadedVideos = $this->userRepository->getByWhereuploadedVideo(['user_id' => $user->id]);
                $availabilities = $this->userRepository->getByWhereuserAvailability(['user_id' => $user->id]);
                $language = $this->CommonRepository->setModel(new \App\Models\Language())->getAll();
                $countryCodes = $this->AdminRepository->getCountryCode();
                $categories = EscortServiceCategory::with('services.selections')->get();
                $selectedServices = UserEscortService::where('user_id', $user->id)
                    ->whereNull('selection_id')
                    ->pluck('service_id')
                    ->toArray();

                $selectedSelections = UserEscortService::where('user_id', $user->id)
                    ->whereNotNull('selection_id')
                    ->pluck('selection_id')
                    ->toArray();

                return view('admin.user-detail', compact('user', 'selectedServices', 'selectedSelections', 'categories', 'uploadedPhotos', 'uploadedVideos', 'availabilities', 'countryCodes', 'language', 'plans'));
            } else {
                return response()->json(['status' => 0], 500);
            }
        } catch (Exception $e) {
            Log::error("UserController : show()" . $e->getLine() . " " . $e->getMessage());
            return redirect()->route('admin.dashboard')->withErrors(['error' => __('message.something_went_wrong')]);
        }
    }
    public function showDetail($id)
    {
        try {

            $user = $this->userRepository->getOne(['id' => $id]);
            $nationality = $this->CommonRepository->setModel(new \App\Models\Nationality())->getAll();
            $uploadedPhotos = $this->userRepository->getByWhereuploadedPhoto(['user_id' => $user->id]);
            $uploadedVideos = $this->userRepository->getByWhereuploadedVideo(['user_id' => $user->id]);
            // $availabilities = $this->userRepository->getByWhereuserAvailability(['user_id' => $user->id]);
            $language = $this->CommonRepository->setModel(new \App\Models\Language())->getAll();
            $countryCodes = $this->AdminRepository->getCountryCode();
            $categories = EscortServiceCategory::with('services.selections')->get();
            $selectedServices = UserEscortService::where('user_id', $user->id)
                ->whereNull('selection_id')
                ->pluck('service_id')
                ->toArray();

            $selectedSelections = UserEscortService::where('user_id', $user->id)
                ->whereNotNull('selection_id')
                ->pluck('selection_id')
                ->toArray();
            $countries = Country::all();
            $ethnicity = $this->CommonRepository->setModel(new \App\Models\Ethnicity())->getAll();
            $bodyType = $this->CommonRepository->setModel(new \App\Models\BodyType())->getAll();
            $hairColor = $this->CommonRepository->setModel(new \App\Models\HairColor())->getAll();
            $hairLength = $this->CommonRepository->setModel(new \App\Models\HairLength())->getAll();
            $hairType = $this->CommonRepository->setModel(new \App\Models\HairType())->getAll();
            $eyeColor = $this->CommonRepository->setModel(new \App\Models\EyeColor())->getAll();
            $tattoo = $this->CommonRepository->setModel(new \App\Models\Tattoo())->getAll();
            $pubicHair = $this->CommonRepository->setModel(new \App\Models\PubicHair())->getAll();
            $oralkissing = $this->CommonRepository->setModel(new \App\Models\OralKissing())->getAll();
            $analRelatedOption = $this->CommonRepository->setModel(new \App\Models\AnalRelatedOption())->getAll();
            $cumBodyPlay = $this->CommonRepository->setModel(new \App\Models\CumBodyPlay())->getAll();
            $manualFingering = $this->CommonRepository->setModel(new \App\Models\ManualFingering())->getAll();
            $groupSpecialExperience = $this->CommonRepository->setModel(new \App\Models\GroupSpecialExperience())->getAll();
            $massageSensualTouch = $this->CommonRepository->setModel(new \App\Models\MassageSensualTouch())->getAll();
            $fetishBdsm = $this->CommonRepository->setModel(new \App\Models\FetishBdsm())->getAll();
            $mediaVirtualOption = $this->CommonRepository->setModel(new \App\Models\MediaVirtualOption())->getAll();
            $experience = $this->CommonRepository->setModel(new \App\Models\Experience())->getAll();
            $plans = $this->PlanRepository->getAll();
            $availabilities = $this->userRepository->getByWhereuserAvailability(['user_id' => $user->id]);

            if (!$availabilities) {
                $availabilities = [];
            } elseif (!is_iterable($availabilities)) {
                $availabilities = [$availabilities];
            }

            $availabilityByDay = [];

            foreach ($availabilities as $avail) {
                if (!is_object($avail)) continue; // skip non-object

                $day = strtolower($avail->day);

                // Check for 'all_day' flag (assuming it exists in your DB)
                if (isset($avail->all_day) && $avail->all_day) {
                    $availabilityByDay[$day] = [
                        'start' => null,
                        'end' => null,
                        'all_day' => true,
                    ];
                } else {
                    $availabilityByDay[$day] = [
                        'start' => substr($avail->start_time, 0, 5),
                        'end' => substr($avail->end_time, 0, 5),
                        'all_day' => false,
                    ];
                }
            }
            $currency = Country::select('currency')->distinct()->pluck('currency');
            if ($user) {
                return view('admin.edit-user', compact(
                    'currency',
                    'availabilityByDay',
                    'experience',
                    'mediaVirtualOption',
                    'fetishBdsm',
                    'massageSensualTouch',
                    'hairLength',
                    'groupSpecialExperience',
                    'manualFingering',
                    'cumBodyPlay',
                    'analRelatedOption',
                    'hairType',
                    'eyeColor',
                    'tattoo',
                    'pubicHair',
                    'oralkissing',
                    'hairColor',
                    'bodyType',
                    'ethnicity',
                    'countries',
                    'user',
                    'uploadedPhotos',
                    'uploadedVideos',
                    'availabilities',
                    'nationality',
                    'language',
                    'countryCodes',
                    'categories',
                    'selectedServices',
                    'selectedSelections',
                    'plans'
                ));
                // return response()->json(['status' => true, 'data' => $user, 'message' => __('message.statusFour', ['parameter' => 'User'])]);
            } else {
                return response()->json(['status' => false], 500);
            }
        } catch (\Exception $e) {
            Log::error("UserController : show()" . $e->getLine() . " " . $e->getMessage());
            return redirect()->route('admin.dashboard')->withErrors(['error' => __('message.something_went_wrong')]);
        }
    }

    public function planAssign(Request $request) {
        try {
            return $this->UserServices->assignPlanToUser($request->all());
        } catch (\Exception $e) {
            Log::error("UserController : planAssign()" . $e->getLine() . " " . $e->getMessage());
            return response()->json( ['status' => 400, 'message' => __('message.something_went_wrong') ]);
        }        
    }
    public function clientDetail($id)
    {
        try {

            $user = $this->userRepository->getOne(['id' => $id]);

            if ($user) {
                return view('admin.client-detail', compact('user'));
            } else {
                return response()->json(['status' => 0], 500);
            }
        } catch (Exception $e) {
            Log::error("UserController : show()" . $e->getLine() . " " . $e->getMessage());
            return redirect()->route('admin.dashboard')->withErrors(['error' => __('message.something_went_wrong')]);
        }
    }


    public function update(Request $request)
    {
        // dd($request);
        try {
            return $this->UserServices->updateUser($request);
        } catch (\Exception $e) {
            Log::error('Error in UserController/update :' . $e->getMessage() . 'in line' . $e->getLine());
            return response()->json(['status' => '0', 'message' => __('message.statusZero')]);
        }
    }
    public function delete(Request $request, $id)
    {
        try {
            $user = User::find($id);
            if (!$user) {
                return response()->json(['status' => false, 'message' => 'User not found.'], 404);
            }

            DB::transaction(function () use ($id, $user) {
                // 1. Delete physical files from disk
                if ($user->profile_image) {
                    $this->deletePhysicalFile($user->profile_image);
                }
                if ($user->document_image) {
                    $this->deletePhysicalFile($user->document_image);
                }
                if ($user->holding_document_image) {
                    $this->deletePhysicalFile($user->holding_document_image);
                }

                // Delete uploaded photos and their physical files
                $photos = DB::table('uploaded_photos')->where('user_id', $id)->get();
                foreach ($photos as $photo) {
                    if (!empty($photo->file_path)) {
                        $this->deletePhysicalFile($photo->file_path);
                    }
                }
                DB::table('uploaded_photos')->where('user_id', $id)->delete();

                // Delete uploaded videos and their physical files
                $videos = DB::table('videos')->where('user_id', $id)->get();
                foreach ($videos as $video) {
                    if (!empty($video->file_path)) {
                        $this->deletePhysicalFile($video->file_path);
                    }
                }
                DB::table('videos')->where('user_id', $id)->delete();

                // 2. Cascade delete all related database records
                DB::table('boost_user_profiles')->where('user_id', $id)->delete();
                DB::table('user_escort_services')->where('user_id', $id)->delete();
                DB::table('user_availabilities')->where('user_id', $id)->delete();
                DB::table('feature_devils')->where('user_id', $id)->delete();
                DB::table('manually_boost_requests')->where('user_id', $id)->delete();
                DB::table('user_daily_shows')->where('user_id', $id)->delete();
                DB::table('user_visibility_logs')->where('user_id', $id)->delete();
                DB::table('transactions')->where('user_id', $id)->delete();
                DB::table('reviews')->where('user_id', $id)->orWhere('reviewer_id', $id)->delete();
                DB::table('wishlists')->where('user_id', $id)->orWhere('favourite_user_id', $id)->delete();
                DB::table('views')->where('viewed_id', $id)->orWhere('viewer_id', $id)->delete();
                DB::table('comment_likes')->where('user_id', $id)->delete();
                DB::table('comments')->where('user_id', $id)->delete();
                DB::table('likes')->where('user_id', $id)->delete();
                DB::table('news_and_stories')->where('user_id', $id)->delete();

                if (\Illuminate\Support\Facades\Schema::hasTable('oauth_access_tokens')) {
                    DB::table('oauth_access_tokens')->where('user_id', $id)->delete();
                }

                // 3. Delete the user
                $user->delete();
            });

            return response()->json([
                'status' => true,
                'message' => 'Profile deleted successfully.'
            ]);
        } catch (\Exception $e) {
            Log::error("UserController : delete() on line " . $e->getLine() . " - " . $e->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'Failed to delete profile: ' . $e->getMessage()
            ], 500);
        }
    }

    private function deletePhysicalFile($filePath)
    {
        try {
            if (empty($filePath)) return;
            if (Storage::disk('public')->exists($filePath)) {
                Storage::disk('public')->delete($filePath);
            } elseif (Storage::exists($filePath)) {
                Storage::delete($filePath);
            } elseif (file_exists(public_path($filePath))) {
                @unlink(public_path($filePath));
            }
        } catch (\Throwable $e) {
            Log::warning("Could not delete physical file: {$filePath} - " . $e->getMessage());
        }
    }

    public function changePassword(Request $request, $id)
    {
        $request->validate([
            'password' => 'required|string|min:6',
        ]);

        try {
            $user = User::findOrFail($id);
            $user->password = Hash::make($request->password);
            $user->save();

            if ($request->boolean('send_email')) {
                try {
                    $appName = config('app.name');
                    $mailData = [
                        'subject' => 'Your ' . $appName . ' Account Password Has Been Updated',
                        'email' => $user->email,
                        'body' => '<p>Hello ' . e($user->name) . ',</p>' .
                                  '<p>Your password for <strong>' . $appName . '</strong> has been updated by the administrator.</p>' .
                                  '<p><strong>New Password:</strong> ' . e($request->password) . '</p>' .
                                  '<p>Thanks,<br>' . $appName . '</p>'
                    ];
                    Mail::to($user->email)->send(new \App\Mail\DemoMail($mailData));
                } catch (\Throwable $mailEx) {
                    Log::warning("changePassword Mail Error: " . $mailEx->getMessage());
                }
            }

            return response()->json([
                'status' => true,
                'message' => 'Password updated successfully for ' . $user->name . '.'
            ]);
        } catch (\Exception $e) {
            Log::error("UserController : changePassword() on line " . $e->getLine() . " - " . $e->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'Failed to update password.'
            ], 500);
        }
    }

    public function block($id)
    {
        try {
            $user = User::find($id);
            if (!$user) {
                return response()->json(['status' => false, 'message' => 'User not found.'], 404);
            }

            $user->user_status = 1;
            $user->save();

            try {
                $appName = config('app.name');
                $mailBody  = '<p>Hello ' . e($user->name) . ',</p>';
                $mailBody .= '<p>This is to inform you that your account in <strong>' . $appName . '</strong> has been <strong>blocked</strong>.</p>';
                $mailBody .= '<p>Please contact the administrator for more information.</p>';
                $mailBody .= '<p>Thanks,<br>' . $appName . '</p>';
                $mailData = [
                    'subject' => 'Your Account Has Been Blocked',
                    'email' => $user->email,
                    'body' => $mailBody,
                ];

                Mail::to($user->email)->send(new \App\Mail\DemoMail($mailData));
            } catch (\Throwable $mailEx) {
                Log::warning("UserController:block - Mail error: " . $mailEx->getMessage());
            }

            return response()->json(['status' => true, 'message' => __('message.user_blocked')]);
        } catch (\Exception $e) {
            Log::error("UserAdminController : block() " . $e->getLine() . " " . $e->getMessage());
            return response()->json(['status' => false, 'message' => __('message.something_went_wrong')], 500);
        }
    }

    public function unblock($id)
    {
        try {
            $user = User::find($id);
            if (!$user) {
                return response()->json(['status' => false, 'message' => 'User not found.'], 404);
            }

            $user->user_status = 0;
            $user->save();

            try {
                $appName = config('app.name');
                $mailBody = '<p>Hello ' . e($user->name) . ',</p>';
                $mailBody .= '<p>Your account in <strong>' . $appName . '</strong> has been <strong>unblocked</strong>. You can now access your account.</p>';
                $mailBody .= '<p>Thanks,<br>' . $appName . '</p>';

                $mailData = [
                    'subject' => 'Your Account Has Been Unblocked',
                    'email' => $user->email,
                    'body' => $mailBody,
                ];

                Mail::to($user->email)->send(new \App\Mail\DemoMail($mailData));
            } catch (\Throwable $mailEx) {
                Log::warning("UserController:unblock - Mail error: " . $mailEx->getMessage());
            }

            return response()->json(['status' => true, 'message' => __('message.user_unblocked')]);
        } catch (\Exception $e) {
            Log::error("UserAdminController : unblock() " . $e->getLine() . " " . $e->getMessage());
            return response()->json(['status' => false, 'message' => __('message.something_went_wrong')], 500);
        }
    }

    public function accept(Request $request, $id)
    {

        try {
            $value['admin_status'] = 'approved';

            try {
                $userDetails = $this->userRepository->getOne(['id' => $id]);
                // dd($userDetails);
                Mail::to($userDetails->email)->send(new AcceptbyAdminMail($userDetails));
            } catch (Exception $e) {
                Log::error("UserAdminController : mail() " . $e->getLine() . " " . $e->getMessage());
            }


            $success = $this->userRepository->update(['id' => $id], $value);
            if ($success) {
                return response()->json(['status' => true, 'message' => __('message.user_accepted')]);
            } else {
                return response()->json(['status' => false], 500);
            }
        } catch (Exception $e) {
            Log::error("UserAdminController : accept() " . $e->getLine() . " " . $e->getMessage());
            return response()->json(['status' => false, 'message' => __('message.something_went_wrong')], 500);
        }
    }
    public function reject(Request $request, $id)
    {

        try {
            try {
                $userDetails = $this->userRepository->getOne(['id' => $id]);
                $userDetails['message'] = $request->reason;
                Mail::to($userDetails->email)->send(new RejectbyAdminMail($userDetails));
            } catch (Exception $e) {
                Log::error("UserAdminController : mail() " . $e->getLine() . " " . $e->getMessage());
            }
            $success = $this->userRepository->delete(['id' => $id]);
            if ($success) {
                return response()->json(['status' => true, 'message' => __('message.user_rejected')]);
            } else {
                return response()->json(['status' => false], 500);
            }
        } catch (Exception $e) {
            Log::error("UserAdminController : reject() " . $e->getLine() . " " . $e->getMessage());
            return response()->json(['status' => false, 'message' => __('message.something_went_wrong')], 500);
        }
    }
    public function uploadPhoto(Request $request)
    {

        $request->validate([
            'images.*' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        foreach ($request->file('images') as $image) {
            $path = $this->uploadWatermarkImage($image, 'images');

            $run = $this->userRepository->createPhoto([
                'user_id' => $request->id,
                'file_path' => $path["watermarked"] ?? 'profile_image/default-profile.png',
                'orignal_file_path' => $path["orignal"] ?? 'profile_image/default-profile.png',
                'is_approved' => 1
            ]);        
        }


        return response()->json(['message' => 'Photos uploaded successfully.']);
    }

    public function deletePhoto(Request $request)
    {
        $request->validate([
            'image_id' => 'required|exists:uploaded_photos,id'
        ]);

        $photo = $this->userRepository->getOnePhoto(['id' => $request->image_id]);

        // Optional: delete file from storage
        if ($photo && \Storage::exists($photo->file_path)) {
            \Storage::delete($photo->file_path);
        }
        $photo->delete();

        return response()->json(['success' => true]);
    }

    public function uploadVideo(Request $request)
    {
        try {

            $request->validate([
                'videos.*' => 'required|max:5120', // 5120 KB = 5 MB
            ]);


            foreach ($request->file('videos') as $video) {
                $path = $this->uploadImage($video, 'user_videos');;

                $this->userRepository->createVideo([
                    'user_id' => $request->id,
                    'file_path' => $path,
                    'is_approved' => 1
                ]);
            }

            return response()->json(['message' => 'Video uploaded successfully.']);
        } catch (Exception $e) {
            Log::error("DashboardController:uploadVideo()" . $e->getLine() . " " . $e->getMessage());
            return response()->json(['status' => 0, 'message' => __('message.statusZero')]);
        }
    }
    public function deleteVideo(Request $request)
    {
        try {
            $video = $this->userRepository->getOneVideo(['id' => $request->video_id]);

            if ($video) {
                Storage::delete($video->file_path);
                $video->delete();
                return response()->json(['message' => 'Video deleted successfully.']);
            }

            return response()->json(['message' => 'Video not found.'], 404);
        } catch (Exception $e) {
            Log::error("DashboardController:deleteVideo()" . $e->getLine() . " " . $e->getMessage());
            return response()->json(['status' => 0, 'message' => __('message.statusZero')]);
        }
    }
    public function saveAvailability(Request $request)
    {
        // dd($request);
        $availability = $request->input('availability');
        // dd($availability);
        $user = $request->user_id;

        $data['availability_main'] = $request->input('availability_main');
        $data['walkin_type'] = $request->input('walkin_type') ? json_encode($request->input('walkin_type')) : null;

        // Save online status (0 or 1)
        $data['is_online'] = $request->input('is_online', 0);

        $this->userRepository->update(['id' => $request->user_id], $data);

        $this->userRepository->deleteAvailability(['user_id' => $request->user_id]);

        if ($request->has('availability')) {
            foreach ($request->availability as $day => $slots) {
                foreach ($slots as $slot) {
                    $isAllDay = isset($slot['all_day']) && $slot['all_day'];
                    $startTime = $isAllDay ? null : Carbon::createFromFormat('h:i A', $slot['start'])->format('H:i:s');
                    $endTime   = $isAllDay ? null : Carbon::createFromFormat('h:i A', $slot['end'])->format('H:i:s');
                    $this->userRepository->createAvailability([
                        'user_id'    => $request->user_id,
                        'day'        => $day,
                        'start_time' => $startTime,
                        'end_time'   => $endTime,
                        'all_day'    => $isAllDay ? 1 : 0,
                    ]);
                }
            }
        }

        return response()->json(['message' => 'Availability saved successfully']);
    }

    public function saveRate(Request $request)
    {
        // dd($request);
        $user = $request->user_id;



        $data['quickie_enabled'] = $request->input('quickie_enabled');
        $data['quickie_currency'] = $request->input('quickie_currency') ?? null; // Set to null if not provided
        $data['quickie_rates'] = $request->input('quickie_rates') ?? null;
        $data['quickie_price'] = $request->input('quickie_price') ?? null;
        $data['quickie_overnight_hours'] = $request->input('quickie_overnight_hours') ?? null; // Store the overnight duration
        $data['payment_method'] = json_encode($request->input('payment_method')) ?? null;

        // Save online status (0 or 1)

        // Save the user data
        $this->userRepository->update(['id' => $request->user_id], $data);




        return response()->json(['message' => 'Rates saved successfully']);
    }

    public function transactionHistory()
    {

        try {
            $data = $this->userRepository->getByWheretransaction(['type' => 'membership-purchase']);

            return view('admin.transaction-history', compact('data'));
        } catch (\Exception $e) {
            Log::error('Error in UserController/index :' . $e->getMessage() . 'in line' . $e->getLine());
            return response()->json(['status' => '0', 'message' => __('message.statusZero')]);
        }
    }

    public function boosttransactionHistory()
    {

        try {
            $data = $this->userRepository->getByWheretransaction(['type' => 'boost']);

            return view('admin.boost-transaction-history', compact('data'));
        } catch (\Exception $e) {
            Log::error('Error in UserController/index :' . $e->getMessage() . 'in line' . $e->getLine());
            return response()->json(['status' => '0', 'message' => __('message.statusZero')]);
        }
    }
}
