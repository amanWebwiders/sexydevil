<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BlogRequest;
use App\Models\Admin;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Services\Admin\BlogServices;
use App\Services\Front\BlogServices as FrontBlogServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class BlogPostController extends Controller
{
    protected $blogServices;

    public function __construct(BlogServices $blogServices)
    {
        $this->blogServices = $blogServices;
    }

    /**
     * Blog Management listing. AJAX requests receive only the table partial.
     */
    public function index(Request $request)
    {
        $filters = $request->only(['search', 'status', 'category', 'country_id', 'state_id', 'city_id', 'date_from', 'date_to']);
        $blogs = $this->blogServices->list($filters);
        $statusCounts = $this->blogServices->statusCounts();

        if ($request->ajax()) {
            return response()->json([
                'status' => 1,
                'html' => view('admin.blogs.posts._table', compact('blogs'))->render(),
                'counts' => $statusCounts,
            ]);
        }

        // "categories" / "countries" are taken by a global view composer, hence the prefixed names.
        $blogCategories = BlogCategory::orderBy('name')->get(['id', 'name']);

        return view('admin.blogs.posts.index', compact('blogs', 'statusCounts', 'blogCategories'));
    }

    public function create()
    {
        return $this->editor(new Blog([
            'status' => Blog::STATUS_DRAFT,
            'featured_media_type' => 'image',
            'robots_index' => 'index',
            'robots_follow' => 'follow',
            'author_id' => $this->adminId(),
        ]));
    }

    public function store(BlogRequest $request)
    {
        try {
            $blog = $this->blogServices->create($request->validated(), $this->adminId());

            return $this->savedResponse($blog, 'Article created successfully!');
        } catch (\Exception $e) {
            Log::error("Error in BlogPostController::store: " . $e->getMessage());
            return response()->json(['status' => 0, 'message' => 'Failed to save the article.'], 500);
        }
    }

    public function edit($id)
    {
        $blog = $this->blogServices->find((int) $id);

        if (!$blog) {
            return redirect()->route('admin.blog-posts.index')->with('error', 'Article not found.');
        }

        return $this->editor($blog);
    }

    public function update(BlogRequest $request, $id)
    {
        $blog = $this->blogServices->find((int) $id);

        if (!$blog) {
            return response()->json(['status' => 0, 'message' => 'Article not found. It may have been deleted.'], 404);
        }

        try {
            $blog = $this->blogServices->update($blog, $request->validated(), $this->adminId());

            return $this->savedResponse($blog, 'Article saved successfully!');
        } catch (\Exception $e) {
            Log::error("Error in BlogPostController::update: " . $e->getMessage());
            return response()->json(['status' => 0, 'message' => 'Failed to save the article.'], 500);
        }
    }

    public function destroy($id)
    {
        $blog = $this->blogServices->find((int) $id);

        if (!$blog) {
            return response()->json(['status' => 0, 'message' => 'Article not found.'], 404);
        }

        try {
            $this->blogServices->delete($blog);

            return response()->json(['status' => 1, 'message' => 'Article deleted successfully!']);
        } catch (\Exception $e) {
            Log::error("Error in BlogPostController::destroy: " . $e->getMessage());
            return response()->json(['status' => 0, 'message' => 'Failed to delete the article.'], 500);
        }
    }

    public function duplicate($id)
    {
        $blog = $this->blogServices->find((int) $id);

        if (!$blog) {
            return response()->json(['status' => 0, 'message' => 'Article not found.'], 404);
        }

        try {
            $copy = $this->blogServices->duplicate($blog, $this->adminId());

            return response()->json([
                'status' => 1,
                'message' => 'Article duplicated as a draft.',
                'edit_url' => route('admin.blog-posts.edit', $copy->id),
            ]);
        } catch (\Exception $e) {
            Log::error("Error in BlogPostController::duplicate: " . $e->getMessage());
            return response()->json(['status' => 0, 'message' => 'Failed to duplicate the article.'], 500);
        }
    }

    /**
     * Preview of the saved article, whatever its status. Only reachable behind adminauth.
     */
    public function preview($id)
    {
        $blog = $this->blogServices->find((int) $id);
        abort_if(!$blog, 404);

        $blog->load(['author', 'country', 'state', 'city']);

        return $this->renderPreview($blog);
    }

    /**
     * Preview of unsaved editor input; nothing is persisted.
     */
    public function previewDraft(BlogRequest $request)
    {
        $blog = $request->input('id') ? $this->blogServices->find((int) $request->input('id')) : null;

        return $this->renderPreview($this->blogServices->previewModel($request->validated(), $blog, $this->adminId()));
    }

    /**
     * Upload a featured image / video or an image inserted in the article body.
     */
    public function uploadMedia(Request $request)
    {
        $request->validate([
            'type' => ['required', 'in:image,video'],
            'file' => $request->input('type') === 'video'
                ? ['required', 'file', 'mimetypes:video/mp4,video/webm,video/ogg,video/quicktime', 'max:51200']
                : ['required', 'file', 'image', 'mimes:jpg,jpeg,png,gif,webp', 'max:5120'],
        ], [
            'file.max' => $request->input('type') === 'video' ? 'Videos may not be larger than 50 MB.' : 'Images may not be larger than 5 MB.',
        ]);

        try {
            $media = $this->blogServices->uploadMedia($request->file('file'), $request->input('type'));

            // "location" is the key TinyMCE expects from an image upload handler.
            return response()->json(['status' => 1, 'location' => $media['url']] + $media);
        } catch (\Exception $e) {
            Log::error("Error in BlogPostController::uploadMedia: " . $e->getMessage());
            return response()->json(['status' => 0, 'message' => 'Upload failed. Please try again.'], 500);
        }
    }

    public function mediaLibrary(Request $request)
    {
        return response()->json(['status' => 1] + $this->blogServices->mediaLibrary(max(1, (int) $request->input('page', 1))));
    }

    private function editor(Blog $blog)
    {
        $blogCategories = BlogCategory::orderBy('name')->get(['id', 'name', 'status']);
        $authors = Admin::orderBy('name')->get(['id', 'name']);

        return view('admin.blogs.posts.editor', compact('blog', 'blogCategories', 'authors'));
    }

    private function renderPreview(Blog $blog)
    {
        $data = ['blog' => $blog] + app(FrontBlogServices::class)->articleViewData($blog, true);

        return response()
            ->view('front.blog_article', $data)
            ->header('X-Robots-Tag', 'noindex, nofollow');
    }

    private function savedResponse(Blog $blog, string $message)
    {
        return response()->json([
            'status' => 1,
            'message' => $message,
            'data' => [
                'id' => $blog->id,
                'slug' => $blog->slug,
                'status' => $blog->status,
                'effective_status' => $blog->effective_status,
                'published_at' => optional($blog->published_at)->format('Y-m-d\TH:i'),
                'updated_at' => $blog->updated_at->toIso8601String(),
                'edit_url' => route('admin.blog-posts.edit', $blog->id),
                'update_url' => route('admin.blog-posts.update', $blog->id),
                'preview_url' => route('admin.blog-posts.preview', $blog->id),
                'public_url' => route('blog.show', $blog->slug),
            ],
        ]);
    }

    private function adminId(): int
    {
        return (int) Auth::guard('admin')->id();
    }
}
