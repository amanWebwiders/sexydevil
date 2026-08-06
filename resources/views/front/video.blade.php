@extends('front.layout.layout')

@section('content')


<style>
    button.swal2-confirm.swal2-styled {
    background: #C72E2E;
}


div#video-preview-container {
    flex-direction: row;
}


div#video-preview-container .remove-video {
       position: absolute;
      right: -5px;
    top: -8px;
    font-size: 20px;
       background: var(--primary-color) !important;
       color: #fff !important;
    height: 20px;
    width: 20px;
    display: flex
;
    justify-content: center;
    align-items: center;
    border-radius: 100%;
}

div#video-preview-container div {
  
    margin-right: 10px;
}



button.swal2-confirm.swal2-styled:hover {
background: #c72e2e !important;
}

button.swal2-cancel.swal2-styled:hover {
     background-color: #2b78c1 !important;
}
button.swal2-cancel.swal2-styled {
    background: #3085d6;
}
    .uploaded-videos{
        margin-right: 10px;
    }
    .sidebar {
        top: 0px;
    }

    .select2-container {
        width: 100% !important;
    }

    .ds select {
        height: 45px;
        line-height: 45px;
    }

    .avatar-upload {
        position: relative;
        max-width: 205px;
        margin: 50px auto;
    }

    .avatar-upload .avatar-edit {
        position: absolute !important;
        right: 0;
        z-index: 1;
        top: 0;
        width: 100%;
        height: 100%;
    }

    .avatar-upload .avatar-edit input {
        opacity: 0;
        height: 100%;
        width: 100%;
    }

    .avatar-upload .avatar-edit input+label {
        display: inline-block;
        width: 34px;
        height: 34px;
        margin-bottom: 0;
        border-radius: 100%;
        background: #FFFFFF;
        border: 1px solid transparent;
        box-shadow: 0px 2px 4px 0px rgba(0, 0, 0, 0.12);
        cursor: pointer;
        font-weight: normal;
        transition: all 0.2s ease-in-out;
    }

    .avatar-upload .avatar-edit input+label:hover {
        background: #f1f1f1;
        border-color: #d6d6d6;
    }

    .avatar-upload .avatar-edit input+label:after {
        content: "\f040";
        font-family: 'FontAwesome';
        color: #757575;
        position: absolute;
        top: 10px;
        left: 0;
        right: 0;
        text-align: center;
        margin: auto;
    }

    .avatar-upload .avatar-preview {
        width: 192px;
        height: 192px;
        position: relative;
        border-radius: 100%;
        border: 6px solid #F8F8F8;
        box-shadow: 0px 2px 4px 0px rgba(0, 0, 0, 0.1);
    }

    .avatar-upload .avatar-preview>div {
        width: 100%;
        height: 100%;
        border-radius: 100%;
        background-size: cover;
        background-repeat: no-repeat;
        background-position: center;
    }



    .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
        left: auto !important;
        right: -3px;
    }

    span.select2-selection.select2-selection--multiple {
        min-height: 45px;
    }

    span.select2-selection.select2-selection--multiple.select2-selection--clearable {
        min-height: 45px;
        height: 100%;
        max-height: 100%;
        overflow: auto;
    }
    span.remove-video-existing {
        position: absolute;
      right: -5px;
    top: -5px;
    font-size: 20px;
       background: var(--primary-color) !important;
       color: #fff !important;
    height: 20px;
    width: 20px;
    display: flex
;
    justify-content: center;
    align-items: center;
    border-radius: 100%;
}
     input[type="file"] {
  transition: border-color .25s ease-in-out;
  &::file-selector-button{
  padding: 5px 10px;
  border-width: 0;
  border-radius: 2em;
  background: var(--primary-color);
  color: hsl(210 40% 90%);
  transition: all .25s ease-in-out;
  cursor: pointer;
  margin-right: 1em;
  }
 
}
</style>
<section class="main-area">
    <div class="container-fluid">
        <div class="row model_detail">
            @include('front.component.quicklink')
              <div class="d-flex d-lg-none justify-content-between col-12 px-0 mt-2 mb-4">
                <a class="open-offcanvas" data-target="#offcanvas1">Quick links <i class="fa fa-external-link" aria-hidden="true" class="canvas-icon"></i>
                </a>
                <!-- <a class="open-offcanvas" data-target="#offcanvas2">Filters <i class="fa fa-filter" aria-hidden="true" class="canvas-icon"></i></a> -->
            </div>

            <div class="offcanvas offcanvas_left" id="offcanvas1">
                <button type="button" class="close close-offcanvas" id="closeOffcanvas" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                @include('front.component.quicklink')
            </div>


            <div class="col-md-12 col-lg-10">
                <section class="ds s-pt-70 s-pb-50 s-pb-sm-50 s-py-lg-100 s-py-xl-150 c-gutter-60 content-area">
                    <div class="p-5">
                        <div class="row">
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-12">
                                        <!-- tabs start -->
                                        <div class="container-fluid">
                                            <h2 class="mb-4 text-left">Add Video</h2>
                                            <p>Only videos up to 5 MB in size and in MP4, WebM, AVI, or OGG format are accepted. <a href="{{ $globalData->video_convert_url }}" target="_blank">Click here</a> to converter video and ensure your file meets the requirements. If you are experiencing any issues, please contact our support team for assistance.</p>
                                            @include('front.component.plan_notification')
                                            <form method="POST" id="VideoUploadForm" enctype="multipart/form-data">
                                                @csrf

                                                <!-- Video File Input -->
                                                <input type="file" name="videos[]" id="videoInput" accept="video/*" multiple>
                                                <span class="text-danger" id="videoError"></span>

                                                <!-- Preview Container (optional if you want to show selected filenames) -->
                                                <div class="form-group mt-3 d-flex flex-wrap gap-2" id="video-preview-container"></div>

                                                <input type="hidden" name="removed_videos" id="removedVideos">

                                                <!-- Submit Button -->
                                                <button type="submit" class="btn btn-maincolor mt-3 mt-3" id="uploadVideoBtn" disabled>Upload Videos</button>
                                            </form>


                                            <hr>

                                            <h4>Uploaded Videos</h4>
                                            <div id="existing-videos" class="d-flex flex-wrap gap-2">
                                                @if ($uploadedVideos->isNotEmpty())
                                                @foreach ($uploadedVideos as $video)
                                                <div class="position-relative d-inline-block me-2 mb-2 uploaded-videos" data-video-id="{{ $video->id }}">
                                                    @if($video->is_approved == 0)
                                                        <div class="watermark-text" >Pending</div>
                                                    @elseif($video->is_approved == 2)
                                                        <div class="watermark-text" >Rejected</div>
                                                    @endif
                                                    <a href="{{ config('app.img_url'). $video->file_path }}" class="glightbox" data-type="video">
                                                        <video width="110" height="110" class="border rounded">
                                                            <source src="{{ config('app.img_url'). $video->file_path }}" type="video/mp4">
                                                        </video>
                                                    </a>
                                                    <span class="remove-video-existing text-danger bg-white px-1" data-id="{{ $video->id }}" style="cursor: pointer;">&times;</span>
                                                </div>
                                                @endforeach
                                                @else
                                                <p class="text-muted">No Video is uploaded.</p>
                                                @endif
                                            </div>


                                            <input type="hidden" name="removed_videos" id="removedVideos">

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>


        </div>
    </div>
</section>

@endsection
@push('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css" />
<script src="https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js"></script>
<script>
    const lightbox = GLightbox({
        selector: '.glightbox'
    });
    let removedVideoIds = [];

    $(document).on('click', '.remove-video-existing', function() {
        const id = $(this).data('id');

        Swal.fire({
            title: 'Delete this video?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                // Show loading state
                Swal.fire({
                    title: 'Deleting...',
                    text: 'Please wait',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                // AJAX call to delete from DB
                $.ajax({
                    url: "{{ route('user.video.delete') }}",
                    type: "POST",
                    data: {
                        _token: '{{ csrf_token() }}',
                        video_id: id
                    },
                    success: function(response) {
                        removedVideoIds.push(id);
                        $('#removedVideos').val(removedVideoIds.join(','));

                        $(`[data-video-id="${id}"]`).remove();

                        if ($('#existing-videos').find('[data-video-id]').length === 0) {
                            $('#existing-videos').html('<p class="text-muted">No Video is uploaded.</p>');
                        }

                        Swal.fire({
                            icon: 'success',
                            title: 'Deleted!',
                            text: 'Video has been removed.',
                            timer: 1500,
                            showConfirmButton: false
                        });

                        // Optional: refresh UI after delay
                        setTimeout(() => location.reload(), 1500);
                    },
                    error: function() {
                        Swal.fire('Error!', 'Failed to delete video. Please try again.', 'error');
                    }
                });
            }
        });
    });

    let previewVideos = [];
    let videoIndex = 0;

    // Enable preview and track selected videos
    $('#videoInput').on('change', function(e) {
        const files = e.target.files;
        let isValid = true;
        let valid_format = true;

        Array.from(files).forEach((file) => {
            if (file.size > 5 * 1024 * 1024) {
                isValid = false;
            }
        });

        Array.from(files).forEach((file) => {
            if (!['video/mp4', 'video/webm', 'video/ogg', 'video/avi'].includes(file.type)) {
                valid_format = false;
            }
        });

        if (!isValid) {
            $('#videoError').text('Each video must be 5MB or smaller.');
            $('#uploadVideoBtn').prop('disabled', true);
            this.value = '';
            return;
        }

        if (!valid_format) {
            $('#videoError').text('Each video must be in MP4, WebM, AVI, or OGG format.');
            $('#uploadVideoBtn').prop('disabled', true);
            this.value = '';
            return;
        }

        $('#videoError').text('');
        $('#uploadVideoBtn').prop('disabled', false);

        Array.from(files).forEach((file) => {
            const currentIndex = videoIndex;
            previewVideos.push(file);

            const reader = new FileReader();
            reader.onload = function(event) {
                const videoPreview = $(`
                <div class="position-relative d-inline-block me-2 mb-2" data-index="${currentIndex}">
                    <video width="110" height="110" controls class="border rounded">
                        <source src="${event.target.result}" type="${file.type}">
                        Your browser does not support the video tag.
                    </video>
                    <span class="position-absolute top-0 end-0 text-danger bg-white px-1 remove-video" data-index="${currentIndex}" style="cursor:pointer;">&times;</span>
                </div>
            `);
                $('#video-preview-container').append(videoPreview);
            };
            reader.readAsDataURL(file);

            videoIndex++;
        });

        $('#videoInput').val('');
    });


    // Remove selected video
    $(document).on('click', '.remove-video', function() {
        const index = $(this).data('index');
        previewVideos[index] = null;
        $(this).parent().remove();

        if (!previewVideos.some(file => file !== null)) {
            $('#uploadVideoBtn').prop('disabled', true);
        }
    });


    // Submit via AJAX
    $('#VideoUploadForm').on('submit', function(e) {
        e.preventDefault();

        const formData = new FormData();
        previewVideos.forEach(file => {
            if (file !== null) {
                formData.append('videos[]', file);
            }
        });
        formData.append('_token', '{{ csrf_token() }}');

        $.ajax({
            url: "{{ route('user.videos.upload') }}", // <-- Ensure this route exists
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            beforeSend: function() {
                $('#uploadVideoBtn').prop('disabled', true).text('Uploading...');
            },
            success: function(response) {
                Swal.fire('Success', response.message, 'success');
                location.reload();
            },
            error: function() {
                Swal.fire('Error', 'Failed to upload videos.', 'error');
                $('#uploadVideoBtn').prop('disabled', false).text('Upload Videos');
            }
        });
    });
</script>

@endpush