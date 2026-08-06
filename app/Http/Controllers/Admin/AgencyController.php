<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repository\Eloquent\AgencyRepository;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Exception;
use Illuminate\Support\Facades\Redis;
use App\Http\Requests\Admin\{AgencyRequest, UpdateAgencyRequest};
use App\Services\Admin\AgencyServices;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class AgencyController extends Controller
{

    protected $AgencyRepository;
    protected $AgencyServices;

    public function __construct(AgencyRepository $AgencyRepository, AgencyServices $AgencyServices)
    {
        $this->AgencyRepository = $AgencyRepository;
        $this->AgencyServices = $AgencyServices;
    }


    public function index()
    {
        $agencies = $this->AgencyRepository->getAll();
        return view('admin.agency-list', compact('agencies'));
    }


    public function create()
    {
        return view('admin.agency');
    }

    public function store(AgencyRequest $request)
    {
        // dd($request);
        return $this->AgencyServices->create($request);
    }

    public function edit($id)
    {
        try {
            // Fetch agency with relationships
            $agency = $this->AgencyRepository->getOne(['id' => $id]);

            if (!$agency) {
                return redirect()->route('admin.agency-list')->with('error', 'Agency not found!');
            }

            // Eager load relationships manually (since repository returns base model)
            $agency->load(['teams', 'media']);

            return view('admin.agency', compact('agency'));
        } catch (\Exception $e) {
            \Log::error("Error in AgencyController.edit(): " . $e->getMessage());

            return redirect()->route('admin.agency-list')->with('error', 'Something went wrong.');
        }
    }

    /**
     * Update the specified agency in storage.
     */
    public function update(UpdateAgencyRequest $request, $id)
    {
        try {

            return $this->AgencyServices->updateAgency($id, $request);
        } catch (\Exception $e) {
            \Log::error("Error updating agency: " . $e->getMessage());
            return redirect()
                ->route('admin.agencies.index')
                ->with('error', 'Something went wrong while updating the agency.');
        }
    }
    public function destroy(Request $request, $id)
    {
        try {
            // Delete photo

            $agency = $this->AgencyRepository->getOne(['id' => $id]);
            //  dd($agency);
            if ($agency->photo) {
                Storage::disk('public')->delete($agency->photo);
            }

            // Delete media
            foreach ($agency->media as $media) {
                Storage::disk('public')->delete($media->file_path);
                $media->delete();
            }

            // Delete teams
            foreach ($agency->teams as $team) {
                if ($team->photo) {
                    Storage::disk('public')->delete($team->photo);
                }
                $team->delete();
            }

            $agency->delete();

            return redirect()->route('admin.agencies.index')->with('success', 'Agency deleted successfully!');
        } catch (Exception $e) {
            Log::error("PlanController : delete()" . $e->getLine() . " " . $e->getMessage());
            return redirect()->route('admin.dashboard')->withErrors(['error' => __('message.something_went_wrong')]);
        }
    }

    public function show($id)
    {
        // fetch agency by ID (with relations if needed)
        $agency = $this->AgencyRepository->getOne(['id' => $id]);

        if (!$agency) {
            abort(404, 'Agency not found');
        }

        // load related data if needed
        $agency->load('teams', 'media');

        // return to blade view
       return view('admin.agency-view', compact('agency'));
    }

    public function deleteMedia(Request $request, $id)
    {
        try {

            $media = $this->AgencyRepository->getOneAgencyMedia(['id' => $id]);

            if (!$media) {
                return response()->json(['status' => 0, 'message' => 'Media not found'], 404);
            }

            // Delete file from storage
            if ($media->file_path && \Storage::disk('public')->exists($media->file_path)) {
                \Storage::disk('public')->delete($media->file_path);
            }

            // Delete from DB
            $media->delete();

            return response()->json(['status' => 1, 'message' => 'Media deleted successfully']);
            // $success = $this->AgencyRepository->delete(['id' => $id]);
            // if ($success) {
            //     return response()->json(['status' => 1, 'message' => __('message.statusThree', ['parameter' =>  'Media'])]);
            // } else {
            //     return response()->json(['status' => false], 500);
            // }
        } catch (Exception $e) {
            Log::error("PlanController : delete()" . $e->getLine() . " " . $e->getMessage());
            return redirect()->route('admin.dashboard')->withErrors(['error' => __('message.something_went_wrong')]);
        }
    }
}
