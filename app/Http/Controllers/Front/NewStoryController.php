<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoryRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Pion\Laravel\ChunkUpload\Handler\HandlerFactory;
use Pion\Laravel\ChunkUpload\Receiver\FileReceiver;
use App\Services\Front\NewStoriesServices;
use Illuminate\Support\Facades\Log;
use App\Repository\Eloquent\UserRepository;
use App\Repository\Eloquent\{AdminRepository, PlanRepository, NewsandstoryRepository, CountryRepository, LocationSeoContentRepository};
use App\Http\Requests\FrontEnd\{
    UserRequest,
    LoginRequest,
    ContactRequest,
    UserChangePasswordRequest,
    UserForgotPasswordRequest,
    UserResetPasswordRequest
};
use Validator;
use App\Models\{EscortServiceCategory, UserEscortService};
use Illuminate\Support\Facades\Auth;
use App\Services\Front\UserServices;
class NewStoryController extends Controller
{
    protected $NewStoriesServices, $userServices;
    protected $userRepository;
    protected $PlanRepository;
    protected $AdminRepository, $NewsandstoryRepository, $countryRepository, $locationSeoContentRepository;
    private $dataObject;
    public function __construct(
        NewsandstoryRepository $NewsandstoryRepository,
        AdminRepository $AdminRepository,
        NewStoriesServices $NewStoriesServices,
        UserRepository $userRepository,
        PlanRepository $PlanRepository,
        UserServices $userServices,
        CountryRepository $countryRepository,
        LocationSeoContentRepository $locationSeoContentRepository
    ) {
        $this->NewStoriesServices = $NewStoriesServices;
        $this->userRepository = $userRepository;
        $this->AdminRepository = $AdminRepository;
        $this->PlanRepository = $PlanRepository;
        $this->locationSeoContentRepository = $locationSeoContentRepository;
        $this->NewsandstoryRepository = $NewsandstoryRepository;
        $this->userServices = $userServices;
        $this->countryRepository = $countryRepository;
    }

    public function index(Request $request)
    {
        try {
            $user = auth()->user();
            if($user->type != 2){
                return redirect()->route('user.profile');
            }
            $result = $this->NewStoriesServices->getMyStories($request);
            //dd($result);
            if ($result["is_view"] === false) {
                $data = $result["list"];
                return view('front.news-story', compact('data'));
            } else {
                return ["status" => $result["status"], "list" => $result["list"]];
                //$result["status"] == 200 ? $result["list"]:"";
            }
        } catch (\Exception $e) {
            Log::error("Error in NewStoryController.index(): " . $e->getMessage());
            return response()->json(['status' => 0, 'message' => __('message.statusZero'), 'data' => $this->dataObject, 'error' => $this->dataObject], 500);
        }
    }


    public function newsStoriesSave(StoryRequest $request)
    {
        try {
            return $this->NewStoriesServices->insert($request);
        } catch (\Exception $e) {
            Log::error("Error in HomeController.Register(): " . $e->getMessage());
            return response()->json(['status' => 0, 'message' => __('message.statusZero'), 'data' => $this->dataObject, 'error' => $this->dataObject], 500);
        }
    }

    public function chunkUpload(Request $request)
    {
        try {
            $receiver = new FileReceiver('file', $request, HandlerFactory::classFromRequest($request));
            //if ($request->hasFile('file')) {
            $file = $request->file('file');
            $extension = $file->extension();
            $mimeType = $file->getMimeType();
            // } 

            if ($receiver->isUploaded() && in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp', 'mp4', 'ogg', 'webm', 'avi']) && (str_starts_with($mimeType, 'image/') || str_starts_with($mimeType, 'video/'))) {
                $save = $receiver->receive();

                if ($save->isFinished()) {
                    $file = $save->getFile(); // Instance of Illuminate\Http\UploadedFile or Symfony\Component\HttpFoundation\File\File

                    $isVideo = str_starts_with($file->getMimeType(), 'video/');
                    $folder = $isVideo ? 'uploads/news/videos' : 'uploads/news/images';
                    // Video size validation (5MB)
                    if ($isVideo && $file->getSize() > 5 * 1024 * 1024) {
                        return response()->json([
                            'status' => 0,
                            'message' => 'Video exceeds 5MB limit.'
                        ]);
                    }

                    $filename = uniqid() . '_' . $file->getClientOriginalName();
                    $path = $file->storeAs($folder, $filename, 'public');

                    return response()->json([
                        'status' => 1,
                        'path' => $path //config('app.img_url') . $folder . '/' . $filename
                    ]);
                }
            }
            $handler = $receiver->handler();
            return response()->json([
                'status' => 0,
                'message' => 'Uploading...',
                'done' => $handler->getPercentageDone()
            ]);
        } catch (\Exception $e) {
            \Log::error("Chunk Upload Error: " . $e->getMessage());
            return response()->json([
                'status' => 0,
                'message' => 'Upload failed. Try again.',
                'error' => $e->getMessage()
            ]);
        }
    }

    public function destroy(Request $request)
    {
        try {
            return $this->NewStoriesServices->deleteMyStory($request->all());
        } catch (\Exception $e) {
            Log::error("Chunk Upload Error: " . $e->getMessage());
            return response()->json([
                'status' => 400,
                'message' => 'Upload failed. Try again.',
                'error' => $e->getMessage()
            ]);
        }
    }

    public function commentstore(Request $request)
    {
        try {
            $request->validate([
                'news_and_story_id' => 'required|exists:news_and_stories,id',
                'comment' => 'required|string|max:1000',
            ]);

            return $this->NewStoriesServices->commentstore($request);
        } catch (\Exception $e) {
            Log::error("Error in NewStoryController.index(): " . $e->getMessage());
            return response()->json(['status' => 0, 'message' => __('message.statusZero'), 'data' => $this->dataObject, 'error' => $this->dataObject], 500);
        }
    }


    public function toggleLike(Request $request)
    {
        try {

            return $this->NewStoriesServices->likestore($request);
        } catch (\Exception $e) {
            Log::error("Error in NewStoryController.index(): " . $e->getMessage());
            return response()->json(['status' => 0, 'message' => __('message.statusZero'), 'data' => $this->dataObject, 'error' => $this->dataObject], 500);
        }
    }

    public function like(Request $request, $id)
    {

        $comment = $this->NewsandstoryRepository->getOneComment(['id' => $id]);
        $user = Auth::guard('web')->user();


        $like = $comment->likes()->where('user_id', $user->id)->first();

        if ($like) {
            $like->delete();
        } else {
            $comment->likes()->create(['user_id' => $user->id]);
        }

        return response()->json(['likes' => $comment->likes()->count()]);
    }

    public function reply(Request $request, $id)
    {

        $request->validate(['comment' => 'required|string']);
        $user = Auth::guard('web')->user();
        $userData = $this->userRepository->getOne(['id' => $user->id]);

        $reply = $this->NewsandstoryRepository->createComment([
            'user_id' => $user->id,
            'news_and_story_id' => $request->story_id,
            'comment' => $request->comment,
            'parent_id' => $id,
        ]);
        return response()->json([
            'comment' => $reply->comment,
            'user_name' => $userData->nickname,
            'profile_image' => config('app.img_url').$userData->profile_image,
        ]);
    }


    public function reels(Request $request, $city = null)
    {
        try {
            $city = $locationSeoCity = isset($city) && $city != "home" ? $city : null;
            $allUsersData = $this->userServices->getUsersByCurrentCityCountry($request, $city);
            //dd($allUsersData);
            $data = []; //$this->NewsandstoryRepository->getByWhere([], ['RAND()']);
            // dd($data);

            $page = $allUsersData["page"];
            $allUsers = $allUsersData["records"];
            $records_from = $allUsersData["records_from"];
            $locationSeoContent = $this->userServices->getLocationSeoContent($locationSeoCity, "Hot Stories");        
            if ($request->ajax()) {
                return ["status" => isset($allUsers) && !empty($allUsers) ? 200 : 400, "list" => view('front.component.reelsAjax', compact('allUsers'))->render(), "page" => $page, "records_from" => $records_from, 'content' => $locationSeoContent['data']->content ?? null];
            }
            $country = $this->countryRepository->getAllRecordWhere([], ['id', 'name']);
            return view('front.reels', compact('data', 'allUsers', 'country', 'page', 'records_from', 'locationSeoContent'));
        } catch (\Exception $e) {
            Log::error("Error in HomeController.reels(): " . $e->getMessage() . " line" . $e->getLine());
            return response()->json(['status' => 0, 'message' => __('message.statusZero'), 'data' => $this->dataObject, 'error' => $this->dataObject], 500);
        }
    }

    public function reelSearch(Request $request)
    {

        try {
            session()->put('SeoType', 'worldwide');
            $locationSeoCity = (int)null;
            if ($request->filled('country_id')) {
                session()->put('SeoType', 'country');
                $locationSeoCity = (int)$request->country_id;
            }
            if ($request->filled('state_id')) {
                session()->put('SeoType', 'state');
                $locationSeoCity = (int)$request->state_id;
            }
            if ($request->filled('city')) {
                session()->put('SeoType', 'city');
                $locationSeoCity = (int)$request->city;
            }
            
            $locationSeoContent = $this->userServices->getLocationSeoContent($locationSeoCity, "Hot Stories");        
            //dd($locationSeoContent);

           $reels = $this->userServices->reelSearch($request->all());
            return response()->json(['status' => $reels["status"], 'data' => $reels["list"], 'page' => $reels["page"], 'content' => $locationSeoContent["data"]->content ?? null]);
        } catch (\Exception $e) {
            Log::error("Error in HomeController.reelSearch(): " . $e->getMessage());
            return response()->json(['status' => 400, 'message' => __('message.statusZero'), 'data' => "", 'error' => $this->dataObject, 'content' => null], 500);
        }
    }
}
