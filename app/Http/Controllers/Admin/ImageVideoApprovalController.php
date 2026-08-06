<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Services\Admin\UserServices;
use Yajra\DataTables\Facades\DataTables;

class ImageVideoApprovalController extends Controller {

    protected $userServices;
    public function __construct(UserServices $userServices) { 
        $this->userServices = $userServices;
    }
    public function ImageApproval(Request $request) {
        try {
            $data = $this->userServices->getUploadedImages($request);
            $result = $data["data"]; 
            //dd($result);
            if ($request->ajax()) {
                return DataTables::of($result)
                    ->addIndexColumn() // adds index (Sr. No.)
                    ->addColumn('action', function($row){
                        return ($row["is_approved"] == 0) ? '<a href="javascript:void(0)" class="btn btn-sm btn-success approveImage" data-id="'.$row["id"].'">Approve</a>
                                <a href="javascript:void(0)" class="btn btn-sm btn-danger rejectImage" data-id="'.$row["id"].'" data-image="'.config('app.img_url').$row["orignal_file_path"].'">Reject</a>':"";
                    })
                    ->addColumn('status', function($row){
                        return ($row["is_approved"] == 0) ? "<label class='badge badge-info'>Pending</label>": ($row["is_approved"] == 1 ? "<label class='badge badge-success'>Approved</label>":"<label class='badge badge-danger'>Rejected</label>");
                    })
                    ->addColumn('image', function($row){
                        return '<img src="'.config('app.img_url').$row["orignal_file_path"].'"  width="100" />';
                    })
                    ->rawColumns(['action', 'status', 'image'])
                    ->make(true);
            }
        
         return view('admin.image-approval');
        } catch (\Exception $exception) {
            Log::error("Error in " . __CLASS__ . "::" . __FUNCTION__ . ": " . $exception->getMessage());
            return redirect()->back()->with('error', 'Something went wrong!');
        }
    }

    public function ImageApprovalAction(Request $request){
        try {
            $data = $this->userServices->updatedUploadedImages($request);
            return response()->json(["status" => $data["status"], "message" => $data["msg"]]);

        } catch (\Exception $exception) {
            Log::error("Error in " . __CLASS__ . "::" . __FUNCTION__ . ": " . $exception->getMessage());
            return response()->json(["status" => 400, "message" => __('message.statusZero')]);
            //return redirect()->back()->with('error', 'Something went wrong!');
        }
    }

    public function VideoApproval(Request $request) {
        try {
            $data = $this->userServices->getUploadedVideos($request);
            $result = $data["data"];
            //dd($result);
            if ($request->ajax()) {
            return DataTables::of($result)
                ->addIndexColumn() // adds index (Sr. No.)
                ->addColumn('action', function($row){
                    $parts = explode('.', $row["file_path"]);
                    $extension = end($parts);
                    $file_convert = '';
                    if(in_array($extension, ['mov'])) {
                        //$file_convert = '<a href="'.$row["file_path"].'" class="btn btn-sm btn-primary convertVideo" data-id="'.$row["id"].'">Convert</a>';
                    }
                    return ($row["is_approved"] == 0) ? '<a href="javascript:void(0)" class="btn btn-sm btn-success approveImage" data-id="'.$row["id"].'">Approve</a>
                            <a href="javascript:void(0)" class="btn btn-sm btn-danger rejectImage" data-id="'.$row["id"].'" data-image="'.config('app.img_url').$row["file_path"].'">Reject</a>
                            '.$file_convert:"";
                })
                ->addColumn('status', function($row){
                    return ($row["is_approved"] == 0) ? "<label class='badge badge-info'>Pending</label>": ($row["is_approved"] == 1 ? "<label class='badge badge-success'>Approved</label>":"<label class='badge badge-danger'>Rejected</label>");
                })
                ->addColumn('image', function($row){
                    return '<video width="320" height="240" controls><source src="'.config('app.img_url').$row["file_path"].'" type="video/ogg"></video>';
                })
                ->rawColumns(['action', 'status', 'image'])
                ->make(true);
        }
        
         return view('admin.video-approval');
        } catch (\Exception $exception) {
            Log::error("Error in " . __CLASS__ . "::" . __FUNCTION__ . ": " . $exception->getMessage());
            return redirect()->back()->with('error', 'Something went wrong!');
        }
    }

    public function VideoApprovalAction(Request $request){
        try {
            $data = $this->userServices->updatedUploadedVideos($request);
            return response()->json(["status" => $data["status"], "message" => $data["msg"]]);

        } catch (\Exception $exception) {
            Log::error("Error in " . __CLASS__ . "::" . __FUNCTION__ . ": " . $exception->getMessage());
            return response()->json(["status" => 400, "message" => __('message.statusZero')]);
            //return redirect()->back()->with('error', 'Something went wrong!');
        }
    }

    public function VideoConvert(Request $request) {
        try {
            $data = $this->userServices->convertVideo($request->all());
            return response()->json(["status" => $data["status"], "message" => $data["msg"]]);
        } catch (\Exception $exception) {
            Log::error("Error in " . __CLASS__ . "::" . __FUNCTION__ . ": " . $exception->getMessage());
            return response()->json(["status" => 400, "message" => __('message.statusZero')]);
        }
        
    }
}
