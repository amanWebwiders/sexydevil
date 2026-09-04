<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NewsAndStory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class HotStoryController extends Controller
{
    /**
     * Display a listing of all Hot Stories with filters & moderation controls.
     */
    public function index(Request $request)
    {
        try {
            $query = NewsAndStory::with(['user', 'likes', 'comments'])->latest('id');

            // Search by caption/title or creator name/email
            if ($request->filled('search')) {
                $search = trim($request->search);
                $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                      ->orWhere('text', 'like', "%{$search}%")
                      ->orWhereHas('user', function ($uq) use ($search) {
                          $uq->where('name', 'like', "%{$search}%")
                             ->orWhere('email', 'like', "%{$search}%")
                             ->orWhere('nickname', 'like', "%{$search}%");
                      });
                });
            }

            // Filter by media type
            if ($request->filled('media_type')) {
                if ($request->media_type === 'video') {
                    $query->where(function ($q) {
                        $q->whereNotNull('videos')
                          ->orWhere('images', 'like', '%.mp4%')
                          ->orWhere('images', 'like', '%.webm%')
                          ->orWhere('images', 'like', '%.mov%');
                    });
                } elseif ($request->media_type === 'image') {
                    $query->where(function ($q) {
                        $q->whereNull('videos')
                          ->where('images', 'not like', '%.mp4%')
                          ->where('images', 'not like', '%.webm%')
                          ->where('images', 'not like', '%.mov%');
                    });
                }
            }

            // Stats metrics
            $totalStories = NewsAndStory::count();
            $videoStories = NewsAndStory::where(function ($q) {
                $q->whereNotNull('videos')
                  ->orWhere('images', 'like', '%.mp4%')
                  ->orWhere('images', 'like', '%.webm%')
                  ->orWhere('images', 'like', '%.mov%');
            })->count();
            $imageStories = max(0, $totalStories - $videoStories);
            $activeCreators = NewsAndStory::distinct('user_id')->count('user_id');

            $stories = $query->paginate(15)->withQueryString();

            return view('admin.hot-stories.index', compact(
                'stories',
                'totalStories',
                'videoStories',
                'imageStories',
                'activeCreators'
            ));
        } catch (\Exception $e) {
            Log::error("Error in HotStoryController::index(): " . $e->getMessage());
            return redirect()->back()->with('error', 'Unable to load Hot Stories.');
        }
    }

    /**
     * Delete a single Hot Story and its physical media assets.
     */
    public function destroy($id)
    {
        try {
            $story = NewsAndStory::find($id);

            if (!$story) {
                return response()->json([
                    'status' => false,
                    'message' => 'Story not found or already deleted.'
                ], 404);
            }

            DB::beginTransaction();

            // 1. Delete physical files
            $this->deleteStoryMedia($story);

            // 2. Delete related likes and comments
            if (method_exists($story, 'likes')) {
                $story->likes()->delete();
            }
            if (method_exists($story, 'comments')) {
                $story->comments()->delete();
            }

            // 3. Delete story record
            $story->delete();

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Hot Story deleted successfully and removed from all feeds.'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Error deleting story #{$id}: " . $e->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'Failed to delete story: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Bulk delete multiple Hot Stories.
     */
    public function bulkDelete(Request $request)
    {
        try {
            $ids = $request->input('ids', []);
            if (empty($ids) || !is_array($ids)) {
                return response()->json([
                    'status' => false,
                    'message' => 'No stories selected for deletion.'
                ], 400);
            }

            DB::beginTransaction();

            $stories = NewsAndStory::whereIn('id', $ids)->get();
            $deletedCount = 0;

            foreach ($stories as $story) {
                $this->deleteStoryMedia($story);
                if (method_exists($story, 'likes')) {
                    $story->likes()->delete();
                }
                if (method_exists($story, 'comments')) {
                    $story->comments()->delete();
                }
                $story->delete();
                $deletedCount++;
            }

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => "Successfully deleted {$deletedCount} stories."
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Error in HotStoryController::bulkDelete(): " . $e->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'Failed to bulk delete stories.'
            ], 500);
        }
    }

    /**
     * Helper to safely remove physical media files from disk.
     */
    private function deleteStoryMedia(NewsAndStory $story)
    {
        $filesToDelete = [];

        // Single or array paths for images
        if (!empty($story->images)) {
            if (is_array($story->images)) {
                $filesToDelete = array_merge($filesToDelete, $story->images);
            } elseif (is_string($story->images)) {
                $decoded = json_decode($story->images, true);
                if (is_array($decoded)) {
                    $filesToDelete = array_merge($filesToDelete, $decoded);
                } else {
                    $filesToDelete[] = $story->images;
                }
            }
        }

        // Single or array paths for videos
        if (!empty($story->videos)) {
            if (is_array($story->videos)) {
                $filesToDelete = array_merge($filesToDelete, $story->videos);
            } elseif (is_string($story->videos)) {
                $decoded = json_decode($story->videos, true);
                if (is_array($decoded)) {
                    $filesToDelete = array_merge($filesToDelete, $decoded);
                } else {
                    $filesToDelete[] = $story->videos;
                }
            }
        }

        // Thumbnail
        if (!empty($story->thumbnail) && !str_contains($story->thumbnail, 'escort_logo')) {
            $filesToDelete[] = $story->thumbnail;
        }

        foreach (array_unique($filesToDelete) as $path) {
            if (empty($path)) continue;
            try {
                if (Storage::disk('public')->exists($path)) {
                    Storage::disk('public')->delete($path);
                }
                $publicPath = public_path('storage/' . $path);
                if (File::exists($publicPath)) {
                    File::delete($publicPath);
                }
            } catch (\Exception $e) {
                Log::warning("Could not delete file {$path}: " . $e->getMessage());
            }
        }
    }
}
