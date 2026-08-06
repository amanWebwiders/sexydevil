<?php

namespace App\Services\Admin;

use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Repository\Eloquent\AgencyRepository;
use Exception;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use App\Traits\ImageUploadTrait;
use Illuminate\Support\Facades\Storage;


class AgencyServices
{

    use ImageUploadTrait;
    protected $AgencyRepository;
    private $dataObject;
    public function __construct(AgencyRepository $AgencyRepository)
    {

        $this->AgencyRepository = $AgencyRepository;
        $this->dataObject = new \stdClass();
    }


    public function create($request)
    {
        try {
            $data = [
                'name'       => $request->name,
                'headline'   => $request->headline,
                'short_desc' => $request->short_desc,
                'long_desc'  => $request->long_desc,
                'email'      => $request->email,
                'phone'      => $request->phone,
                'facebook'   => $request->facebook,
                'instagram'  => $request->instagram,
                'linkedin'   => $request->linkedin,
                'telegram'   => $request->telegram,
                'address'    => $request->address,
                'website'    => $request->website,
            ];

            // Handle main photo upload
            if ($request->hasFile('photo')) {
                $image = $request->file('photo');
                $data['photo'] = $this->uploadImage($image, 'agencies');
            }

            $agency = $this->AgencyRepository->create($data);

            /** ------------------------------------
             *  Handle multiple PHOTOS upload
             * ------------------------------------ */
            if ($request->hasFile('photos')) {
                foreach ($request->file('photos') as $file) {
                    if ($file->isValid()) {
                        $this->AgencyRepository->createagencymodel([
                            'agency_id' => $agency->id,
                            'type'      => 'image',
                            'file_path' => $this->uploadImage($file, 'agency_media'),
                        ]);
                    }
                }
            }

            /** ------------------------------------
             *  Handle multiple VIDEOS upload
             * ------------------------------------ */
            if ($request->hasFile('videos')) {
                foreach ($request->file('videos') as $file) {
                    if ($file->isValid()) {
                        $this->AgencyRepository->createagencymodel([
                            'agency_id' => $agency->id,
                            'type'      => 'video',
                            'file_path' => $this->uploadImage($file, 'agency_media'),
                        ]);
                    }
                }
            }

            /** ------------------------------------
             *  Handle Team Members
             * ------------------------------------ */
            if ($request->has('team')) {
                foreach ($request->team as $member) {
                    if (!empty($member['name'])) {
                        $teamdata = [
                            'agency_id'   => $agency->id,
                            'name'        => $member['name'] ?? null,
                            'age'         => $member['age'] ?? null,
                            'gender'      => $member['gender'] ?? null,
                            'description' => $member['description'] ?? null,
                        ];

                        if (isset($member['photo']) && $member['photo'] instanceof \Illuminate\Http\UploadedFile) {
                            $teamdata['photo'] = $this->uploadImage($member['photo'], 'team');
                        }

                        $this->AgencyRepository->createagencyteam($teamdata);
                    }
                }
            }

            return response()->json([
                'message' => __('message.statusOne', ['parameter' => 'Agency']),
                'data'    => $agency,
                'status'  => 1
            ], 201);
        } catch (\Exception $e) {
            \Log::error("Error in AgencyService.create(): " . $e->getMessage());

            return response()->json([
                'message' => 'Something went wrong while creating Agency',
                'status'  => 0
            ], 500);
        }
    }



    public function updateAgency($id, $request)
    {
        try {
            $agency = $this->AgencyRepository->getOne(['id' => $id]);

            if (!$agency) {
                throw new \Exception("Agency not found!");
            }

            $data = $request->except(['_token', '_method', 'photo', 'photos', 'videos', 'team']);

            /** ------------------------------------
             *  Handle main photo upload
             * ------------------------------------ */
            if ($request->hasFile('photo')) {
                if ($agency->photo && Storage::disk('public')->exists($agency->photo)) {
                    Storage::disk('public')->delete($agency->photo);
                }
                $data['photo'] = $this->uploadImage($request->file('photo'), 'agencies');
            }

            /** ------------------------------------
             *  Update Agency
             * ------------------------------------ */
            $this->AgencyRepository->update(['id' => $agency->id], $data);

            /** ------------------------------------
             *  Handle new Photos
             * ------------------------------------ */
            if ($request->hasFile('photos')) {
                foreach ($request->file('photos') as $file) {
                    if ($file->isValid()) {
                        $this->AgencyRepository->createagencymodel([
                            'agency_id' => $agency->id,
                            'type'      => 'image',
                            'file_path' => $this->uploadImage($file, 'agency_media'),
                        ]);
                    }
                }
            }

            /** ------------------------------------
             *  Handle new Videos
             * ------------------------------------ */
            if ($request->hasFile('videos')) {
                foreach ($request->file('videos') as $file) {
                    if ($file->isValid()) {
                        $this->AgencyRepository->createagencymodel([
                            'agency_id' => $agency->id,
                            'type'      => 'video',
                            'file_path' => $this->uploadImage($file, 'agency_media'),
                        ]);
                    }
                }
            }

            /** ------------------------------------
             *  Handle Teams (remove old & insert new)
             * ------------------------------------ */
            /** ------------------------------------
             *  Handle Teams (update or insert)
             * ------------------------------------ */
            if ($request->has('team')) {
                $teamIds = [];

                foreach ($request->team as $member) {
                    if (!empty($member['name'])) {
                        if (!empty($member['id'])) {
                            // Update existing team
                            $team = $agency->teams()->find($member['id']);

                            if ($team) {
                                $team->name        = $member['name'];
                                $team->age         = $member['age'] ?? null;
                                $team->gender      = $member['gender'] ?? null;
                                $team->description = $member['description'] ?? null;

                                // Only replace photo if new one uploaded
                                if (isset($member['photo']) && $member['photo'] instanceof \Illuminate\Http\UploadedFile) {
                                    if ($team->photo && Storage::disk('public')->exists($team->photo)) {
                                        Storage::disk('public')->delete($team->photo);
                                    }
                                    $team->photo = $this->uploadImage($member['photo'], 'team');
                                }

                                $team->save();
                                $teamIds[] = $team->id;
                            }
                        } else {
                            // Create new team member
                            $teamdata = [
                                'agency_id'   => $agency->id,
                                'name'        => $member['name'],
                                'age'         => $member['age'] ?? null,
                                'gender'      => $member['gender'] ?? null,
                                'description' => $member['description'] ?? null,
                            ];

                            if (isset($member['photo']) && $member['photo'] instanceof \Illuminate\Http\UploadedFile) {
                                $teamdata['photo'] = $this->uploadImage($member['photo'], 'team');
                            }

                            $newTeam = $this->AgencyRepository->createagencyteam($teamdata);
                            $teamIds[] = $newTeam->id;
                        }
                    }
                }

                // Delete removed members (those not submitted anymore)
                $agency->teams()->whereNotIn('id', $teamIds)->delete();
            }


            return response()->json([
                'message' => __('message.statusTwo', ['parameter' => 'Agency']),
                'data'    => $data,
                'status'  => 1
            ], 201);
        } catch (\Exception $e) {
            \Log::error("Error in AgencyService.updateAgency(): " . $e->getMessage());

            return response()->json([
                'message' => 'Something went wrong while updating Agency',
                'status'  => 0
            ], 500);
        }
    }
}
