<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\BlogCategoryRequest;
use App\Services\Admin\BlogCategoryServices;
use Illuminate\Support\Facades\Log;

class BlogCategoryController extends Controller
{
    protected $blogCategoryServices;

    public function __construct(BlogCategoryServices $blogCategoryServices)
    {
        $this->blogCategoryServices = $blogCategoryServices;
    }

    /**
     * Display a listing of blog categories.
     */
    public function index(Request $request)
    {
        try {
            $blogCategories = $this->blogCategoryServices->list($request->only(['search', 'status']));

            return view('admin.blogs.categories', compact('blogCategories'));
        } catch (\Exception $e) {
            Log::error("Error in BlogCategoryController::index: " . $e->getMessage());
            return redirect()->back()->with('error', 'Unable to fetch blog categories.');
        }
    }

    /**
     * Store a newly created blog category in storage.
     */
    public function store(BlogCategoryRequest $request)
    {
        try {
            $this->blogCategoryServices->create($request->validated());

            return $this->respond($request, 'Blog category created successfully!');
        } catch (\Exception $e) {
            Log::error("Error in BlogCategoryController::store: " . $e->getMessage());
            return $this->respondError($request, 'Failed to create blog category.');
        }
    }

    /**
     * Return JSON data of single category for edit modal.
     */
    public function edit($id)
    {
        $category = $this->blogCategoryServices->find((int) $id);

        if (!$category) {
            return response()->json(['status' => 0, 'message' => 'Blog category not found.'], 404);
        }

        return response()->json(['status' => 1, 'data' => $category]);
    }

    /**
     * Update the specified blog category in storage.
     */
    public function update(BlogCategoryRequest $request, $id)
    {
        try {
            $this->blogCategoryServices->update((int) $id, $request->validated());

            return $this->respond($request, 'Blog category updated successfully!');
        } catch (\Exception $e) {
            Log::error("Error in BlogCategoryController::update: " . $e->getMessage());
            return $this->respondError($request, 'Failed to update blog category.');
        }
    }

    /**
     * Remove the specified blog category from storage.
     */
    public function destroy(Request $request, $id)
    {
        try {
            $this->blogCategoryServices->delete((int) $id);

            return $this->respond($request, 'Blog category deleted successfully!');
        } catch (\Exception $e) {
            Log::error("Error in BlogCategoryController::destroy: " . $e->getMessage());
            return $this->respondError($request, 'Failed to delete blog category.');
        }
    }

    /**
     * Toggle active/inactive status.
     */
    public function toggleStatus($id)
    {
        try {
            $category = $this->blogCategoryServices->toggleStatus((int) $id);

            return response()->json([
                'status' => 1,
                'message' => 'Status updated to ' . ($category->status == 1 ? 'Active' : 'Inactive') . '!',
                'new_status' => $category->status,
            ]);
        } catch (\Exception $e) {
            Log::error("Error in BlogCategoryController::toggleStatus: " . $e->getMessage());
            return response()->json(['status' => 0, 'message' => 'Failed to update status.'], 500);
        }
    }

    private function respond(Request $request, string $message)
    {
        if ($request->ajax()) {
            return response()->json(['status' => 1, 'message' => $message]);
        }

        return redirect()->route('admin.blog-categories.index')->with('success', $message);
    }

    private function respondError(Request $request, string $message)
    {
        if ($request->ajax()) {
            return response()->json(['status' => 0, 'message' => $message], 500);
        }

        return redirect()->back()->with('error', $message)->withInput();
    }
}
