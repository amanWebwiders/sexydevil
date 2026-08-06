@extends('admin.layout.layout')
@section('content')

<style>
    input.pe-2 {
        margin-right: 5px;
        position: relative;
        top: 2px;
    }
</style>

<div id="content" class="app-content">

    <div class="d-lg-flex align-items-end mb-4">
        <h3 class="page-header mb-lg-0">
            Add Agency
        </h3>
    </div>

    <div class="card p-4">
        <!-- <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Profile</button>
            </li>
        </ul> -->
        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active form-container" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab" tabindex="0">
                <!-- <h3 class="mt-2 mb-4">Update Your Profile</h3> -->
                <form id="agencyForm" method="POST"
                    action="{{ isset($agency) 
                  ? route('admin.agencies.update', $agency->id) 
                  : route('admin.agencies.store') }}"
                    enctype="multipart/form-data">
                    @csrf
                    @if(isset($agency))
                    @method('PUT')
                    @endif

                    <div class="row">
                        {{-- Agency Name --}}
                        <div class="col-md-12 mb-4">
                            <label class="form-label">Agency Name</label>
                            <input type="text" class="form-control" name="name" value="{{ old('name', $agency->name ?? '') }}">
                        </div>

                        {{-- Headline --}}
                        <div class="col-md-12 mb-4">
                            <label class="form-label">Headline</label>
                            <input type="text" class="form-control" name="headline" value="{{ old('headline', $agency->headline ?? '') }}">
                        </div>

                        {{-- Short Description --}}
                        <div class="col-md-12 mb-4">
                            <label class="form-label">Short Description</label>
                            <textarea class="form-control" name="short_desc" rows="2">{{ old('short_desc', $agency->short_desc ?? '') }}</textarea>
                        </div>

                        {{-- Long Description --}}
                        <div class="col-md-12 mb-4">
                            <label class="form-label">Long Description</label>
                            <textarea class="form-control" name="long_desc" rows="4">{{ old('long_desc', $agency->long_desc ?? '') }}</textarea>
                        </div>

                        {{-- Contact Details --}}
                        <div class="col-md-6 mb-4">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" name="email" value="{{ old('email', $agency->email ?? '') }}">
                        </div>

                        <div class="col-md-6 mb-4">
                            <label class="form-label">Phone</label>
                            <input type="text" class="form-control" name="phone" value="{{ old('phone', $agency->phone ?? '') }}">
                        </div>

                        <div class="col-md-6 mb-4">
                            <label class="form-label">Facebook</label>
                            <input type="text" class="form-control" name="facebook"
                                value="{{ old('facebook', $agency->facebook ?? '') }}" placeholder="https://facebook.com/...">
                        </div>

                        <div class="col-md-6 mb-4">
                            <label class="form-label">Instagram</label>
                            <input type="text" class="form-control" name="instagram"
                                value="{{ old('instagram', $agency->instagram ?? '') }}" placeholder="https://instagram.com/...">
                        </div>

                        <div class="col-md-6 mb-4">
                            <label class="form-label">LinkedIn</label>
                            <input type="text" class="form-control" name="linkedin"
                                value="{{ old('linkedin', $agency->linkedin ?? '') }}" placeholder="https://linkedin.com/...">
                        </div>

                        <div class="col-md-6 mb-4">
                            <label class="form-label">Telegram</label>
                            <input type="text" class="form-control" name="telegram"
                                value="{{ old('telegram', $agency->telegram ?? '') }}" placeholder="https://t.me/...">
                        </div>


                        {{-- Address --}}
                        <div class="col-md-12 mb-4">
                            <label class="form-label">Full Address</label>
                            <input type="text" class="form-control" name="address" value="{{ old('address', $agency->address ?? '') }}">
                        </div>

                        {{-- Website --}}
                        <div class="col-md-12 mb-4">
                            <label class="form-label">Website (Optional)</label>
                            <input type="url" class="form-control" name="website" value="{{ old('website', $agency->website ?? '') }}">
                        </div>

                        {{-- Agency Photo --}}
                        <div class="col-md-12 mb-4">
                            <label class="form-label">Agency Photo</label>
                            <input type="file" class="form-control" name="photo" accept="image/*">
                            @if(isset($agency) && $agency->photo)
                            <img class="mt-3 rounded" src="{{ asset('storage/'.$agency->photo) }}" style="max-width:120px; max-height:120px;">
                            @endif
                        </div>

                        {{-- Agency Media (Multiple Images/Videos) --}}
                        <div class="col-md-12 mb-4">
                            <label class="form-label">Upload Photos</label>
                            <input type="file" class="form-control" id="photoInput" name="photos[]" multiple accept="image/*">
                            <div id="photoPreview" class="mt-3 d-flex flex-wrap"></div>
                        </div>
                        @if(isset($agency) && $agency->media)
                        {{-- Existing Photos --}}
                        @if($agency->media->where('type','image')->count())
                        <div class="col-md-12 mt-3">
                            <label class="form-label">Existing Photos</label>
                            <div class="d-flex flex-wrap">
                                @foreach($agency->media->where('type','image') as $media)
                                <div class="position-relative m-2">
                                    <img src="{{ asset('storage/'.$media->file_path) }}" class="rounded" style="max-width:100px; max-height:100px;">
                                    <span class="remove-existing btn btn-sm btn-danger position-absolute top-0 end-0" data-id="{{ $media->id }}">×</span>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endif
                        @endif

                        <div class="col-md-12 mb-4">
                            <label class="form-label">Upload Videos</label>
                            <input type="file" class="form-control" id="videoInput" name="videos[]" multiple accept="video/*">
                            <div id="videoPreview" class="mt-3 d-flex flex-wrap"></div>
                        </div>

                        {{-- Existing Media --}}
                        @if(isset($agency) && $agency->media)


                        {{-- Existing Videos --}}
                        @if($agency->media->where('type','video')->count())
                        <div class="col-md-12 mt-3">
                            <label class="form-label">Existing Videos</label>
                            <div class="d-flex flex-wrap">
                                @foreach($agency->media->where('type','video') as $media)
                                <div class="position-relative m-2">
                                    <video src="{{ asset('storage/'.$media->file_path) }}" style="max-width:120px; max-height:100px;" controls></video>
                                    <span class="remove-existing btn btn-sm btn-danger position-absolute top-0 end-0" data-id="{{ $media->id }}">×</span>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endif
                        @endif



                        {{-- Team Members --}}
                        <div class="col-md-12 mb-4">
                            <label class="form-label">Team Members</label>
                            <div id="team-members">
                                @if(isset($agency) && $agency->teams->count())
                                @foreach($agency->teams as $team)
                                
                                <input type="hidden" name="team[{{ $loop->index }}][id]" value="{{ $team->id }}">

                                <div class="team-member row mb-2">
                                    <div class="col-md-3">
                                        <input type="file" name="team[{{ $loop->index }}][photo]" class="form-control" accept="image/*">
                                        @if($team->photo)
                                        <img src="{{ asset('storage/'.$team->photo) }}" style="max-width:80px;" class="mt-2 rounded">
                                        @endif
                                    </div>
                                    <div class="col-md-3">
                                        <input type="text" name="team[{{ $loop->index }}][name]" class="form-control" placeholder="Name" value="{{ $team->name }}">
                                    </div>
                                    <div class="col-md-2">
                                        <input type="number" name="team[{{ $loop->index }}][age]" class="form-control" placeholder="Age" value="{{ $team->age }}">
                                    </div>
                                    <div class="col-md-2">
                                        <select name="team[{{ $loop->index }}][gender]" class="form-control">
                                            <option value="male" {{ $team->gender == 'male' ? 'selected' : '' }}>Male</option>
                                            <option value="female" {{ $team->gender == 'female' ? 'selected' : '' }}>Female</option>
                                            <option value="other" {{ $team->gender == 'other' ? 'selected' : '' }}>Other</option>
                                        </select>
                                    </div>
                                    <div class="col-md-12 mt-2">
                                        <textarea name="team[{{ $loop->index }}][description]" class="form-control" rows="2" placeholder="Description">{{ $team->description }}</textarea>
                                    </div>
                                </div>
                                @endforeach
                                @else
                                <div class="team-member row mb-2">
                                    <div class="col-md-3">
                                        <input type="file" name="team[0][photo]" class="form-control" accept="image/*">
                                    </div>
                                    <div class="col-md-3">
                                        <input type="text" name="team[0][name]" class="form-control" placeholder="Name">
                                    </div>
                                    <div class="col-md-2">
                                        <input type="number" name="team[0][age]" class="form-control" placeholder="Age">
                                    </div>
                                    <div class="col-md-2">
                                        <select name="team[0][gender]" class="form-control">
                                            <option value="">Select Gender</option>
                                            <option value="male">Male</option>
                                            <option value="female">Female</option>
                                            <option value="other">Other</option>
                                        </select>
                                    </div>
                                    <div class="col-md-12 mt-2">
                                        <textarea name="team[0][description]" class="form-control" rows="2" placeholder="Description"></textarea>
                                    </div>
                                </div>
                                @endif
                            </div>
                            <button type="button" class="btn btn-sm btn-secondary mt-2" id="add-team-member">+ Add More</button>
                        </div>

                    </div>

                    <div class="text-end">
                        <button type="submit" id="saveAgencyBtn" class="btn btn-primary mt-3">Save Agency</button>
                    </div>
                </form>

            </div>

        </div>



    </div>

    @endsection
    @push('js')
    <script>
        $(document).ready(function() {
            let selectedPhotos = [];
            let selectedVideos = [];

            /** -------------------------------
             *  Handle Photo Upload + Preview
             * ------------------------------- */
            $("#photoInput").on("change", function(e) {
                let files = Array.from(e.target.files);

                // Add new photos
                files.forEach((file) => {
                    if (file.type.startsWith("image/")) {
                        selectedPhotos.push(file);
                    }
                });

                // Rebuild photo preview
                $("#photoPreview").html("");
                selectedPhotos.forEach((file, index) => {
                    let fileUrl = URL.createObjectURL(file);
                    let previewElement = `
                <div class="position-relative m-2">
                    <img src="${fileUrl}" class="rounded" style="max-width:100px; max-height:100px;">
                    <span class="remove-photo btn btn-sm btn-danger position-absolute top-0 end-0" data-index="${index}">×</span>
                </div>`;
                    $("#photoPreview").append(previewElement);
                });

                updateFileList("#photoInput", selectedPhotos);
            });

            // Remove selected photo
            $(document).on("click", ".remove-photo", function() {
                let index = $(this).data("index");
                selectedPhotos.splice(index, 1);

                // Rebuild
                $("#photoPreview").html("");
                selectedPhotos.forEach((file, newIndex) => {
                    let fileUrl = URL.createObjectURL(file);
                    let previewElement = `
                <div class="position-relative m-2">
                    <img src="${fileUrl}" class="rounded" style="max-width:100px; max-height:100px;">
                    <span class="remove-photo btn btn-sm btn-danger position-absolute top-0 end-0" data-index="${newIndex}">×</span>
                </div>`;
                    $("#photoPreview").append(previewElement);
                });

                updateFileList("#photoInput", selectedPhotos);
            });

            /** -------------------------------
             *  Handle Video Upload + Preview
             * ------------------------------- */
            $("#videoInput").on("change", function(e) {
                let files = Array.from(e.target.files);

                // Add new videos
                files.forEach((file) => {
                    if (file.type.startsWith("video/")) {
                        selectedVideos.push(file);
                    }
                });

                // Rebuild video preview
                $("#videoPreview").html("");
                selectedVideos.forEach((file, index) => {
                    let fileUrl = URL.createObjectURL(file);
                    let previewElement = `
                <div class="position-relative m-2">
                    <video src="${fileUrl}" style="max-width:120px; max-height:100px;" controls></video>
                    <span class="remove-video btn btn-sm btn-danger position-absolute top-0 end-0" data-index="${index}">×</span>
                </div>`;
                    $("#videoPreview").append(previewElement);
                });

                updateFileList("#videoInput", selectedVideos);
            });

            // Remove selected video
            $(document).on("click", ".remove-video", function() {
                let index = $(this).data("index");
                selectedVideos.splice(index, 1);

                // Rebuild
                $("#videoPreview").html("");
                selectedVideos.forEach((file, newIndex) => {
                    let fileUrl = URL.createObjectURL(file);
                    let previewElement = `
                <div class="position-relative m-2">
                    <video src="${fileUrl}" style="max-width:120px; max-height:100px;" controls></video>
                    <span class="remove-video btn btn-sm btn-danger position-absolute top-0 end-0" data-index="${newIndex}">×</span>
                </div>`;
                    $("#videoPreview").append(previewElement);
                });

                updateFileList("#videoInput", selectedVideos);
            });

            /** -------------------------------
             *  Remove Existing Media (AJAX)
             * ------------------------------- */
            $(document).on("click", ".remove-existing", function() {
                let mediaId = $(this).data("id");
                let $el = $(this).parent();

                $.ajax({
                    url: "{{ route('admin.agencies.media.delete', '') }}/" + mediaId,
                    type: "DELETE",
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(res) {
                        if (res.status == 1) {
                            $el.remove();
                            Swal.fire('Deleted!', res.message, 'success');
                        } else {
                            Swal.fire('Error!', res.message, 'error');
                        }
                    },
                    error: function() {
                        Swal.fire('Error!', 'Something went wrong.', 'error');
                    }
                });
            });

            /** -------------------------------
             *  Helper: Update FileList
             * ------------------------------- */
            function updateFileList(inputSelector, filesArray) {
                let dataTransfer = new DataTransfer();
                filesArray.forEach(file => dataTransfer.items.add(file));
                $(inputSelector)[0].files = dataTransfer.files;
            }
        });



        $(document).ready(function() {

            $(document).on('submit', '#agencyForm', function(e) {
                e.preventDefault();

                let form = this;
                let formData = new FormData(form);
                console.log(formData);
                let $btn = $('#saveAgencyBtn');

                $.ajax({
                    url: $(form).attr('action'), // Use the form's action
                    type: 'POST', // always POST
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    beforeSend: function() {
                        $btn.prop('disabled', true).text('Saving...');
                        $('.text-danger').remove(); // remove old errors
                    },
                    success: function(res) {
                        $btn.prop('disabled', false).text('Save Agency');

                        if (res.status == 1) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: res.message
                            }).then(() => {
                                window.location.href = "{{ route('admin.agencies.index') }}";
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: res.message
                            });
                        }
                    },
                    error: function(xhr) {
                        $btn.prop('disabled', false).text('Save Agency');

                        if (xhr.responseJSON && xhr.responseJSON.errors) {
                            $.each(xhr.responseJSON.errors, function(field, messages) {
                                    let inputName = dotToBracket(field);

                                    console.log("Looking for:", inputName);

                                    let $input = $("[name='" + inputName + "']");
                                    if ($input.length) {
                                        $input.after("<div class='text-danger'>" + messages[0] + "</div>");
                                    } else {
                                        console.warn("No input found for:", inputName);
                                    }
                                });

                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: xhr.responseJSON?.message || 'Something went wrong.'
                            });
                        }
                    }


                });
            });

        });
function dotToBracket(field) {
    // team.0.name → team[0][name]
    return field.split('.').reduce((prev, curr, i) => {
        return i === 0 ? curr : prev + "[" + curr + "]";
    }, "");
}
        $(document).ready(function() {
            let teamIndex = {{isset($agency) ? $agency->teams->count() : 1}};

            // Add new team member
            $("#add-team-member").on("click", function() {
                let newMember = `
            <div class="team-member row mb-2 border p-2 rounded">
                <div class="col-md-3">
                    <input type="file" name="team[${teamIndex}][photo]" class="form-control" accept="image/*">
                </div>
                <div class="col-md-3">
                    <input type="text" name="team[${teamIndex}][name]" class="form-control" placeholder="Name">
                </div>
                <div class="col-md-2">
                    <input type="number" name="team[${teamIndex}][age]" class="form-control" placeholder="Age">
                </div>
                <div class="col-md-2">
                    <select name="team[${teamIndex}][gender]" class="form-control">
                        <option value="">Select Gender</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                        <option value="other">Other</option>
                    </select>
                </div>
                <div class="col-md-12 mt-2">
                    <textarea name="team[${teamIndex}][description]" class="form-control" rows="2" placeholder="Description"></textarea>
                </div>
                <div class="col-md-12 mt-2 text-end">
                    <button type="button" class="btn btn-danger btn-sm remove-team">Remove</button>
                </div>
            </div>`;

                $("#team-members").append(newMember);
                teamIndex++;
            });

            // Remove team member
            $(document).on("click", ".remove-team", function() {
                $(this).closest(".team-member").remove();
            });
        });
        
    </script>
    @endpush('js')