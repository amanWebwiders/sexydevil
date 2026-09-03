<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Faq;
use Illuminate\Support\Facades\Log;

class FaqController extends Controller
{
    /**
     * Display a listing of FAQs.
     */
    public function index(Request $request)
    {
        try {
            $query = Faq::query();

            if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('question', 'like', "%{$search}%")
                      ->orWhere('answer', 'like', "%{$search}%")
                      ->orWhere('category', 'like', "%{$search}%");
                });
            }

            if ($request->filled('category')) {
                $query->where('category', $request->category);
            }

            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }

            $faqs = $query->orderBy('order', 'asc')->orderBy('id', 'desc')->paginate(15);
            $faqCategories = Faq::select('category')->distinct()->pluck('category')->filter()->values();

            return view('admin.faq.index', compact('faqs', 'faqCategories'));
        } catch (\Exception $e) {
            Log::error("Error in FaqController::index: " . $e->getMessage());
            return redirect()->back()->with('error', 'Unable to fetch FAQs.');
        }
    }

    /**
     * Store a newly created FAQ in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'question' => 'required|string',
            'answer' => 'required|string',
            'category' => 'nullable|string|max:100',
            'order' => 'nullable|integer',
            'status' => 'nullable|in:0,1',
        ]);

        try {
            Faq::create([
                'question' => $validated['question'],
                'answer' => $validated['answer'],
                'category' => $validated['category'] ?? 'For Advertisers',
                'order' => $validated['order'] ?? 0,
                'status' => isset($validated['status']) ? (int)$validated['status'] : 1,
            ]);

            if ($request->ajax()) {
                return response()->json(['status' => 1, 'message' => 'FAQ created successfully!']);
            }

            return redirect()->route('admin.faqs.index')->with('success', 'FAQ created successfully!');
        } catch (\Exception $e) {
            Log::error("Error in FaqController::store: " . $e->getMessage());
            if ($request->ajax()) {
                return response()->json(['status' => 0, 'message' => 'Failed to create FAQ.'], 500);
            }
            return redirect()->back()->with('error', 'Failed to create FAQ.')->withInput();
        }
    }

    /**
     * Return JSON data of single FAQ for edit modal.
     */
    public function edit($id)
    {
        try {
            $faq = Faq::findOrFail($id);
            return response()->json(['status' => 1, 'data' => $faq]);
        } catch (\Exception $e) {
            return response()->json(['status' => 0, 'message' => 'FAQ not found.'], 404);
        }
    }

    /**
     * Update the specified FAQ in storage.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'question' => 'required|string',
            'answer' => 'required|string',
            'category' => 'nullable|string|max:100',
            'order' => 'nullable|integer',
            'status' => 'nullable|in:0,1',
        ]);

        try {
            $faq = Faq::findOrFail($id);
            $faq->update([
                'question' => $validated['question'],
                'answer' => $validated['answer'],
                'category' => $validated['category'] ?? $faq->category,
                'order' => $validated['order'] ?? $faq->order,
                'status' => isset($validated['status']) ? (int)$validated['status'] : $faq->status,
            ]);

            if ($request->ajax()) {
                return response()->json(['status' => 1, 'message' => 'FAQ updated successfully!']);
            }

            return redirect()->route('admin.faqs.index')->with('success', 'FAQ updated successfully!');
        } catch (\Exception $e) {
            Log::error("Error in FaqController::update: " . $e->getMessage());
            if ($request->ajax()) {
                return response()->json(['status' => 0, 'message' => 'Failed to update FAQ.'], 500);
            }
            return redirect()->back()->with('error', 'Failed to update FAQ.')->withInput();
        }
    }

    /**
     * Remove the specified FAQ from storage.
     */
    public function destroy(Request $request, $id)
    {
        try {
            $faq = Faq::findOrFail($id);
            $faq->delete();

            if ($request->ajax()) {
                return response()->json(['status' => 1, 'message' => 'FAQ deleted successfully!']);
            }

            return redirect()->route('admin.faqs.index')->with('success', 'FAQ deleted successfully!');
        } catch (\Exception $e) {
            Log::error("Error in FaqController::destroy: " . $e->getMessage());
            if ($request->ajax()) {
                return response()->json(['status' => 0, 'message' => 'Failed to delete FAQ.'], 500);
            }
            return redirect()->back()->with('error', 'Failed to delete FAQ.');
        }
    }

    /**
     * Toggle active/inactive status.
     */
    public function toggleStatus(Request $request, $id)
    {
        try {
            $faq = Faq::findOrFail($id);
            $faq->status = $faq->status == 1 ? 0 : 1;
            $faq->save();

            return response()->json([
                'status' => 1,
                'message' => 'Status updated to ' . ($faq->status == 1 ? 'Active' : 'Inactive') . '!',
                'new_status' => $faq->status,
            ]);
        } catch (\Exception $e) {
            return response()->json(['status' => 0, 'message' => 'Failed to update status.'], 500);
        }
    }
}
