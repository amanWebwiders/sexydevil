<?php

namespace App\Http\Controllers\Front;

use Exception;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Front\UserServices;
use Illuminate\Support\Facades\Log;
use App\Repository\Eloquent\UserRepository;
use App\Repository\Eloquent\{AdminRepository, GenderRepository, CommonRepository, StateRepository, CityRepository};
use App\Http\Requests\FrontEnd\{
    UpdateProfile
};
use Illuminate\Support\Facades\Auth;
use App\Models\State;
use App\Models\City;
use App\Models\Country;
use App\Models\EscortServiceCategory;
use App\Models\{UserEscortService, EscortService};
use Validator;
use App\Traits\ImageUploadTrait;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class DashboardController extends Controller
{
    use ImageUploadTrait;
    protected $userServices;
    protected $userRepository, $GenderRepository, $CommonRepository, $stateRepository;
    protected $AdminRepository,$cityRepository;
    private $dataObject;


    public function __construct(CommonRepository $CommonRepository, GenderRepository $GenderRepository, AdminRepository $AdminRepository, UserServices $userServices, UserRepository $userRepository, StateRepository $stateRepository, CityRepository $cityRepository)
    {
        $this->userServices = $userServices;
        $this->userRepository = $userRepository;
        $this->AdminRepository = $AdminRepository;
        $this->GenderRepository = $GenderRepository;
        $this->CommonRepository = $CommonRepository;
        $this->stateRepository = $stateRepository;
        $this->cityRepository = $cityRepository;
    }

    public function index() {}

    public function profile()
    {
        try {
            $user = Auth::guard('web')->user();
            if (!$user) {
                return redirect()->route('user-login');
            }
            $countries = Country::orderBy('name')->get();

            $countryCodes = $this->AdminRepository->getCountryCode();
            $gender = $this->GenderRepository->getAll();
            $ethnicity = $this->CommonRepository->setModel(new \App\Models\Ethnicity())->getAll();
            $nationality = $this->CommonRepository->setModel(new \App\Models\Nationality())->getAll();
            $language = $this->CommonRepository->setModel(new \App\Models\Language())->getAll();
            $state = collect();
            $city = collect();
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
            $categories = EscortServiceCategory::with('services.selections')->get();

            $selectedServices = UserEscortService::where('user_id', $user->id)
                ->whereNull('selection_id')
                ->pluck('service_id')
                ->toArray();

            $selectedSelections = UserEscortService::where('user_id', $user->id)
                ->whereNotNull('selection_id')
                ->pluck('selection_id')
                ->toArray();

            return view('front.edit_profile', compact('categories', 'selectedServices', 'selectedSelections', 'nationality', 'countryCodes', 'countries', 'gender', 'ethnicity', 'language', 'state', 'city', 'bodyType', 'hairColor', 'hairLength', 'hairType', 'eyeColor', 'tattoo', 'pubicHair', 'oralkissing', 'analRelatedOption', 'cumBodyPlay', 'manualFingering', 'groupSpecialExperience', 'massageSensualTouch', 'fetishBdsm', 'mediaVirtualOption', 'experience'));
        } catch (\Throwable $e) {
            Log::error("DashboardController:profile() line " . $e->getLine() . ": " . $e->getMessage());
            return redirect()->route('home')->withErrors(['error' => __('message.statusZero')]);
        }
    }
    public function getStates($country_id)
    {
        // If ?with_users=1 is present, use repository (for filter dropdown)
        if (request()->has('with_users') && request()->input('with_users')) {
            $states = $this->stateRepository->getAllRecordWhere(['country_id' => $country_id]);
            return response()->json($states);
        } else {
            $states = State::where('country_id', $country_id)->orderBy('name')->get();
            return response()->json($states);
        }
    }
    public function getSubCategory($category_id)
    {

        $subcategory = EscortService::where('category_id', $category_id)->get();
        return response()->json($subcategory);
    }


    public function getCities($state_id)
    {
        if (request()->has('with_users') && request()->input('with_users')) {
            $cities = $this->cityRepository->getAllRecordWhere(['state_id' => $state_id]);

            return response()->json($cities);
        } else {
            $cities = City::where('state_id', $state_id)->orderBy('name')->get();
            return response()->json($cities);
        }
    }

    public function getCitiesCountry($country_id)
    {
        $cities = City::where('country_id', $country_id)->orderBy('name')->get();
        return response()->json($cities);
    }


    public function getCurrency($countryId)
    {
        $country = Country::find($countryId);

        return response()->json([
            'currency' => $country ?? ''
        ]);
    }
    public function Password()
    {
        try {

            return view('front.change_password');
        } catch (Exception $e) {
            Log::error("HomeController:profile()" . $e->getLine() . " " . $e->getMessage());
            return response()->json(['status' => 0, 'message' => __('message.statusZero')]);
        }
    }
    public function updateProfile(UpdateProfile $request)
    {
        try {
            return $this->userServices->updateProfile($request);
        } catch (\Exception $e) {
            log::error('Error in DashboardController/update_profile :' . $e->getMessage() . 'in line' . $e->getLine());
            return response()->json(['status' => 0, 'message' => __('message.statusZero'), 'data' => [], 'error' => []], 500);
        }
    }

    public function Photo()
    {
        try {
            $user = Auth::guard('web')->user();
            $uploadedPhotos = $this->userRepository->getByWhereuploadedPhoto(['user_id' => $user->id], ["sequence" => "ASC"]);
            return view('front.photo', compact('uploadedPhotos'));
        } catch (Exception $e) {
            Log::error("DashboardController:Photo()" . $e->getLine() . " " . $e->getMessage());
            return response()->json(['status' => 0, 'message' => __('message.statusZero')]);
        }
    }
    public function Video()
    {
        try {
            $user = Auth::guard('web')->user();
            if($user->type != 2){
                return redirect()->route('user.profile');
            }
            $uploadedVideos = $this->userRepository->getByWhereuploadedVideo(['user_id' => $user->id]);
            return view('front.video', compact('uploadedVideos'));
        } catch (Exception $e) {
            Log::error("DashboardController:Photo()" . $e->getLine() . " " . $e->getMessage());
            return response()->json(['status' => 0, 'message' => __('message.statusZero')]);
        }
    }
    public function Availabilities()
    {
        try {
            $user = Auth::guard('web')->user();
            if($user->type != 2){
                return redirect()->route('user.profile');
            }
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

            return view('front.availabilities', compact('availabilityByDay', 'user'));
        } catch (Exception $e) {
            Log::error("DashboardController:Availabilities()" . $e->getLine() . " " . $e->getMessage());
            return response()->json(['status' => 0, 'message' => __('message.statusZero')]);
        }
    }




    public function Rate()
    {
        try {
            $user = Auth::guard('web')->user();
            if($user->type != 2){
                return redirect()->route('user.profile');
            }
            $countries = Country::select('currency')->distinct()->pluck('currency');
            // dd($availabilityByDay);
            return view('front.rate', compact('user', 'countries'));
        } catch (Exception $e) {
            Log::error("DashboardController:Availabilities()" . $e->getLine() . " " . $e->getMessage());
            return response()->json(['status' => 0, 'message' => __('message.statusZero')]);
        }
    }
    public function saveRate(Request $request)
    {
        // dd($request);
        $user = auth()->user();



        $user->quickie_enabled = $request->input('quickie_enabled');
        //$user->quickie_currency = $request->input('quickie_currency') ?? null; // Set to null if not provided
        $user->quickie_rates = $request->input('quickie_rates') ?? null;
        $user->quickie_price = $request->input('quickie_price') ?? null;
        $user->quickie_overnight_hours = $request->input('quickie_overnight_hours') ?? null; // Store the overnight duration
        $user->payment_method = json_encode($request->input('payment_method')) ?? null;

        // Save online status (0 or 1)

        // Save the user data
        $user->save();




        return response()->json(['message' => 'Rates saved successfully']);
    }
    public function uploadVideo(Request $request)
    {
        try {
            $user = Auth::guard('web')->user();
            $request->validate([
                'videos.*' => 'required|file|mimetypes:video/mp4,video/webm,video/ogg,video/avi|max:5120', // 5120 KB = 5 MB
            ]);

            $run = false;
            foreach ($request->file('videos') as $video) {
                $path = $this->uploadImage($video, 'user_videos');;

                $run = $this->userRepository->createVideo([
                    'user_id' => $user->id,
                    'file_path' => $path,
                ]);
            }

            if ($run) {
                $body = 'Hello Admin,';
                $name = $user->name;
                $body .= '<p>' . $name . ' upload a video. Please take necessary action !!</p>';

                // dd($body);

                $mailData = [
                    'subject' => 'Image Verification ' . now()->format('Y-m-d H:i:s'),
                    'email' => 'admin@sexydevilescorts.com',
                    'body' => $body,
                ];

                $run3 =  Mail::to('admin@sexydevilescorts.com')->send(new \App\Mail\DemoMail($mailData));
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

        $availability = $request->input('availability');
        $user = auth()->user();

        $user->availability_main = $request->input('availability_main');
        $user->walkin_type = $request->input('walkin_type') ? json_encode($request->input('walkin_type')) : null;
        $user->is_online = $request->input('is_online', 0);
        $user->save();

        // Delete old availability records
        $this->userRepository->deleteAvailability(['user_id' => $user->id]);

        if ($availability && is_array($availability)) {
            foreach ($availability as $day => $slots) {
                foreach ($slots as $slot) {
                    $isAllDay = isset($slot['all_day']) && $slot['all_day'];

                    $startTime = $isAllDay ? null : Carbon::createFromFormat('h:i A', $slot['start'])->format('H:i:s');
                    $endTime   = $isAllDay ? null : Carbon::createFromFormat('h:i A', $slot['end'])->format('H:i:s');

                    $this->userRepository->createAvailability([
                        'user_id'    => $user->id,
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


    public function uploadPhoto(Request $request)
    {
        $request->validate([
            'images.*' => 'required|image|mimes:jpeg,png,jpg,webp,gif|max:20480'
        ]);
        $run = false;
        foreach ($request->file('images') as $image) {
            $path = $this->uploadWatermarkImage($image, 'images');

            $run = $this->userRepository->createPhoto([
                'user_id' => auth()->id(),
                'file_path' => $path["watermarked"] ?? 'profile_image/default-profile.png',
                'orignal_file_path' => $path["orignal"] ?? 'profile_image/default-profile.png',
            ]);
        }

        if ($run) {
            $body = 'Hello Admin,';
            $name = auth()->user()->name;
            $body .= '<p>' . $name . ' upload a image. Please take necessary action !!</p>';

            // dd($body);

            $mailData = [
                'subject' => 'Image Verification ' . now()->format('Y-m-d H:i:s'),
                'email' => 'admin@sexydevilescorts.com',
                'body' => $body,
            ];

            $run3 =  Mail::to('admin@sexydevilescorts.com')->send(new \App\Mail\DemoMail($mailData));
        }

        return response()->json(['message' => 'Photos uploaded successfully.']);
    }

    public function delete(Request $request)
    {
        $request->validate([
            'image_id' => 'required|exists:uploaded_photos,id'
        ]);

        $photo = $this->userRepository->getOnePhoto(['id' => $request->image_id]);
        // Optional: delete file from storage
        if ($photo && Storage::disk('public')->exists($photo->file_path)) {
            Storage::disk('public')->delete($photo->file_path);
            Storage::disk('public')->delete($photo->orignal_file_path);
        }
        $photo->delete();

        return response()->json(['success' => true]);
    }

    public function updatePhotoOrder(Request $request){
        try { 
            //dd($request->all());
            foreach ($request->sequence as $photoOrder) {
                $photo = $this->userRepository->UpdatePhoto(['id' => $photoOrder['id']], ['sequence' => $photoOrder['sequence']]);                 
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Invalid input data.', 'errors' => $e->getMessage()], 422);
        }
        return response()->json(['message' => 'Photo order updated successfully.']);
        
    }

    public function hideShowImage(Request $request){
        try { 
            //dd($request->all());
            $photo = $this->userRepository->UpdatePhoto(['id' => $request->photo_id], ['hide_show' => $request->btnText == "Hide Image" ? 2 : 1]);                 
        } catch (\Exception $e) {
            return response()->json(['message' => 'Invalid input data.', 'errors' => $e->getMessage()], 422);
        }
        return response()->json(['message' => 'Photo visibility updated successfully.']);
        
    }
    public function markAsProfile(Request $request){
        try { 
            //dd($request->all());
            // First, unset the current profile picture

            // Then, set the new profile picture
            $photo = $this->userRepository->getOnePhoto(
                ['id' => $request->photo_id, "user_id" => auth()->id()]
            );         
            if(isset($photo)){
                $user = $this->userRepository->update(["id" => auth()->id()], ["profile_image" => $photo->orignal_file_path]);
            } else {
                return response()->json(['status' => 0, 'message' => __('message.statusZero')]);            
            }       
        } catch (\Exception $e) {
            return response()->json(['status' => 0, 'message' => 'Invalid input data.', 'errors' => $e->getMessage()]);
        }
        return response()->json(['status' => 1, 'message' => 'Profile picture updated successfully.']);
        
    }
}
