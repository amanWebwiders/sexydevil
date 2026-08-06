<?php

namespace App\Services\Front;

use Exception;
use Illuminate\Support\Facades\Log;
use App\Repository\Eloquent\NewsandstoryRepository;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Mail;

use Illuminate\Support\Str;
use Validator;
use App\Traits\ImageUploadTrait;

class NewStoriesServices
{
    use ImageUploadTrait;
    protected $newsandstoryRepository;
    private $dataObject;

    public function __construct(NewsandstoryRepository $newsandstoryRepository)
    {
        $this->dataObject = new \stdClass();
        $this->newsandstoryRepository = $newsandstoryRepository;
    }

    public function insert($request)
    {
        try {
            // dd($request);
            $user = Auth::guard('web')->user();

            $data['text'] = $request['text'];
            $data['title'] = $request['title'];
            $data['user_id'] = $user->id;
            if(isset($request['validity'])) {
                $data['validity'] = now()->addHours(24);
            }
            // These come from the frontend as JSON arrays of uploaded paths
            $data['images'] = $request->filled('uploaded_media') ? $request->input('uploaded_media') : json_encode([]);
            $data['thumbnail'] = 'uploads/news/images/escort_logo1.png';
            if ($request->hasFile('thumbnail')) {
                $thumbnail = $request->file('thumbnail');
                // Get extension safely
                $extension = $thumbnail->getClientOriginalExtension();

                // Optional: Double-check extension manually (extra safety)
                $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp'];
                if (in_array(strtolower($extension), $allowedExtensions)) {
                    $path = 'uploads/news/images';
                    $filename = time() . '_' . uniqid() . '.' . $extension;
                    // Store file
                    $path = $thumbnail->storeAs($path, $filename, 'public');
                    $data['thumbnail'] = $path;
                }
            }
            //dd($data);
            // $data['videos'] = $request->filled('uploaded_videos') ? $request->input('uploaded_videos') : json_encode([]);
            $success = $this->newsandstoryRepository->create($data);
            if ($success) {
                return response()->json(['status' => 200, 'message' => 'News/Story added successfully!']);
            }
        } catch (Exception $e) {
            Log::error("Error in NewStoriesServices.insert(): " . $e->getMessage());
            return response()->json([
                'status' => 400,
                'message' => __('message.statusZero'),
                'error' => $e->getMessage()
            ], 500);
        }
    }


    public function commentstore($request)
    {
        try {

            $user = Auth::guard('web')->user();

            $data['news_and_story_id'] = $request->news_and_story_id;
            $data['user_id'] = $user->id;
            $data['parent_id'] = $request->parent_id;
            // These come from the frontend as JSON arrays of uploaded paths
            $data['comment'] = $request->comment;

            $success = $this->newsandstoryRepository->createComment($data);
            if ($success) {
                return response()->json(['status' => '1', 'message' => 'success']);
            }
        } catch (Exception $e) {
            Log::error("Error in NewStoriesServices.insert(): " . $e->getMessage());
            return response()->json([
                'status' => 0,
                'message' => __('message.statusZero'),
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function likestore($request)
    {
        try {
            $user = Auth::guard('web')->user();
            $like = $this->newsandstoryRepository->getOneLike(['user_id' => $user->id, 'news_and_story_id' => $request->news_and_story_id]);

            if ($like) {
                $this->newsandstoryRepository->deleteLike(['user_id' => $user->id, 'news_and_story_id' => $request->news_and_story_id]);
                return response()->json(['status' => 'unliked']);
            } else {
                $data['news_and_story_id'] = $request->news_and_story_id;
                $data['user_id'] = $user->id;
                $success = $this->newsandstoryRepository->createLike($data);
                if ($success) {
                    return response()->json(['status' => 'liked']);
                }
            }
        } catch (Exception $e) {
            Log::error("Error in NewStoriesServices.insert(): " . $e->getMessage());
            return response()->json([
                'status' => 0,
                'message' => __('message.statusZero'),
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function deleteMyStory(array $inputs) {
        try {
            $user = Auth::guard('web')->user();
            $news = $this->newsandstoryRepository->getOne(['id' => $inputs["id"], "user_id" => $user->id ]);
            if ($news->image_path && Storage::disk('public')->exists($news->image_path)) {
                Storage::disk('public')->delete($news->image_path);
            }

            // Delete video if exists
            if ($news->video_path && Storage::disk('public')->exists($news->video_path)) {
                Storage::disk('public')->delete($news->video_path);
            }
            $success = $this->newsandstoryRepository->delete(['id' => $inputs["id"], "user_id" => $user->id]);
            
            return ['status' => $success ? 200:400, 'message' => $success ? 'News deleted successfully':__('message.something_went_wrong')];
        } catch (Exception $exception) {
            Log::error("Error in " . __CLASS__ . "::" . __FUNCTION__ . ": " . $exception->getMessage());
            return ['status' => 400, 'message' => __('message.something_went_wrong')];
        }
    }

    public function getMyStories($inputs) {
        try {
            $user = auth()->user();
            $data = $this->newsandstoryRepository->getUserStoriesWhere(['user_id' => $user->id]);
            //dd($data->get()->toArray());
            //dd($inputs->query('page'));
            if($inputs->query('page')) {
                $data = $data->paginate(2,);
                $view = false;
                //dd($data->isNotEmpty());
                if($data->isNotEmpty()) {
                    $view = view('front.component.myHotStories', compact('data'))->render();
                }
                return ['status' => $view === false ? 400:200, "is_view" => true, "list" => $view];
            }
            return ['status' => 200, "is_view" => false, "list" => $data->paginate(2)];
        } catch (Exception $exception) {
            Log::error("Error in " . __CLASS__ . "::" . __FUNCTION__ . ": " . $exception->getMessage());
            return ['status' => 400, 'list' => [] ];
        }
    }
}
