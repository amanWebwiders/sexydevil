@extends('front.layout.layout')

@section('content')


    <style>
        .uploaded-images {
            width: 85px;
            height: 85px;
        }

        .uploaded-images img {
            height: 100%;
            width: 100%;
            object-fit: contain;
        }

        span.remove-existing {
            position: absolute;
            right: -5px;
            top: -5px;
            font-size: 20px;
            background: var(--primary-color);
            height: 20px;
            width: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 100%;
        }

        #image-preview-container {
            flex-direction: row !important;
        }

        div#image-preview-container div {
            height: 85px !important;
            width: 85px !important;
            margin-right: 10px;
        }

        div#image-preview-container div img {
            height: 100% !important;
            width: 100% !important;
            object-fit: cover;
        }

        div#image-preview-container .remove-preview {
            position: absolute;
            right: -5px;
            top: -8px;
            font-size: 20px;
            background: var(--primary-color) !important;
            height: 20px;
            width: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 100%;
            color: #fff !important;
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

        input[type="file"] {
            transition: border-color .25s ease-in-out;

            &::file-selector-button {
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

        .lb-outerContainer {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        div#lightbox {
            z-index: 99999 !important;
        }

        @media screen and (max-width:767px) {
            .uploaded-images {
                width: 72px;
                height: 72px;
            }

        }

        /* Photo blade Desige log in */

        .uploaded-images {
            height: 350px;
        }

        .options-btn {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 12px;
            padding:8px 0px 0px;
            gap:6px
        }

        .options-btn a{
            text-decoration:none;
            padding: 1px 10px;
            background-color:#BC1212;
            border-radius:4px;
        }

        .options-btn a.new-nav-btn{
            width:100%;
            text-align:center;
        }

        .c-gutter-60 .row, div.row.c-gutter-60{
            margin-inline: -15px !important;
        }

        .profile-upload-card{
            margin-bottom: 2rem;
        }

        .profile-upload-card img{
            height: 350px;
            width: 100%;
            object-fit: contain;
        }

        @media (max-width: 767px){

            .profile-upload-card img {
                height: 200px;
            }

        }
    </style>
    <section class="main-area">
        <div class="container-fluid">
            <div class="row model_detail">
                @include('front.component.quicklink')
                <div class="d-flex d-lg-none justify-content-between col-12 px-0 mt-2 mb-4">
                    <a class="open-offcanvas" data-target="#offcanvas1">Quick links <i class="fa fa-external-link"
                            aria-hidden="true" class="canvas-icon"></i>
                    </a>
                    <!-- <a class="open-offcanvas" data-target="#offcanvas2">Filters <i class="fa fa-filter" aria-hidden="true" class="canvas-icon"></i></a> -->
                </div>

                <div class="offcanvas offcanvas_left" id="offcanvas1">
                    <button type="button" class="close close-offcanvas" id="closeOffcanvas" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    @include('front.component.quicklink')
                </div>


                <div class="col-md-12 col-lg-10 px-0 px-md-2">
                    <section class="ds s-pt-70 s-pb-50 s-pb-sm-50 s-py-lg-100 s-py-xl-150 c-gutter-60 content-area">                   
                                                <!-- tabs start -->
                                            
                                                <h1 class="mb-4 text-left">Add Photos</h1>
                                                @include('front.component.plan_notification')
                                                <form method="POST" id="EditProfile" enctype="multipart/form-data">
                                                    @csrf
                                                    <input type="file" name="images[]" id="image" accept="image/*" multiple
                                                        class="choose_photo">
                                                    <span class="text-danger" id="imageError"></span>

                                                    <div class="form-group mt-3 d-flex flex-wrap gap-2 "
                                                        id="image-preview-container"></div>

                                                    <input type="hidden" name="removed_images" id="removedImages">
                                                    <button type="submit" class="btn btn-maincolor mt-3" id="uploadBtn"
                                                        disabled>Upload Photos</button>
                                                </form>


                                                <hr>

                                                <h2>Uploaded Images</h2>
                                                <div id="existing-photos" class="row">
                                                    @if ($uploadedPhotos->isNotEmpty())
                                                        @foreach ($uploadedPhotos as $photo)
                                                            <div class="position-relative profile-upload-card col-6 col-lg-3 col-md-4"
                                                                data-photo-id="{{ $photo->id }}">
                                                                @if($photo->is_approved == 0)
                                                                    <div class="watermark-text">Pending</div>
                                                                @elseif($photo->is_approved == 2)
                                                                    <div class="watermark-text">Rejected</div>
                                                                @endif
                                                                <a href="{{ config('app.img_url') . $photo->orignal_file_path }}"
                                                                    data-lightbox="gallery">

                                                                    <img src="{{ config('app.img_url') . $photo->orignal_file_path }}"
                                                                        width="100" class="border rounded ">
                                                                </a>
                                                                <div class="options-btn flex-column flex-lg-row">
                                                                    @if ($photo->is_approved == 1)
                                                                        <a href="javascript:void(0)" class="mark-profile w-100 text-center new-opt-btn">Mark as Profile</a>
                                                                        <a href="javascript:void(0)" class="lock-img new-opt-btn w-100 text-center HideShowImage">{{ $photo->hide_show == 1 ? "Hide" : "Show" }} Image</a>                                                                    
                                                                    @endif
                                                                </div>
                                                                <div class="options-btn">
                                                                    @if ($photo->is_approved == 1)
                                                                    <a href="javascript:void(0)" class="new-nav-btn leftShift"><i class="fa-solid fa-arrow-left"></i></a>
                                                                    @endif
                                                                    <a href="javascript:void(0)" class="new-nav-btn remove-existing"  data-id="{{ $photo->id }}"><i class="fa-solid fa-trash-can"></i></a>
                                                                    @if ($photo->is_approved == 1)
                                                                    <a href="javascript:void(0)" class="new-nav-btn rightShift"><i class="fa-solid fa-arrow-right"></i></a>
                                                                    @endif
                                                                </div>

                                                                <!-- <span class="remove-existing" data-id="{{ $photo->id }}"
                                                                    style="cursor: pointer;">&times;</span> -->
                                                            </div>
                                                        @endforeach
                                                    @else
                                                        <p class="text-muted">No Images uploaded.</p>
                                                    @endif
                                                </div>
                                                <input type="hidden" name="removed_images" id="removedImages">                                           
                    </section>
                </div>


            </div>
        </div>
    </section>

@endsection
@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/lightbox2@2.11.3/dist/css/lightbox.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/lightbox2@2.11.3/dist/js/lightbox.min.js"></script>

    <script>
        let removedImageIds = [];

        $(document).on('click', '.remove-existing', function () {
            const id = $(this).data('id');

            Swal.fire({
                title: "Are you sure?",
                text: "Do you really want to delete this image?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    // Send AJAX request to update database
                    $.ajax({
                        url: "{{ route('user.photo.delete') }}",
                        type: "POST",
                        data: {
                            _token: '{{ csrf_token() }}',
                            image_id: id
                        },
                        success: function (response) {
                            // Track removed ID and update hidden input
                            removedImageIds.push(id);
                            $('#removedImages').val(removedImageIds.join(','));

                            // Remove from UI
                            $(`[data-photo-id="${id}"]`).remove();

                            // Show fallback message if no photos left
                            if ($('#existing-photos').find('[data-photo-id]').length === 0) {
                                $('#existing-photos').html('<p class="text-muted">No photo is uploaded.</p>');
                            }

                            Swal.fire(
                                'Deleted!',
                                'Image deleted successfully.',
                                'success'
                            );
                        },
                        error: function (xhr) {
                            Swal.fire(
                                'Error!',
                                'Failed to delete image. Please try again.',
                                'error'
                            );
                        }
                    });
                }
            });
        });


        let previewImages = []; // Holds all selected files
        let imageIndex = 0; // Unique index for each image

        $('#image').on('change', function (e) {
            const files = e.target.files;

            if (files.length > 0) {
                $('#uploadBtn').prop('disabled', false);
            }

            Array.from(files).forEach((file) => {
                previewImages.push(file);

                const reader = new FileReader();
                const currentIndex = imageIndex; // Capture index before it increments

                reader.onload = function (e) {
                    const preview = $(`
                    <div class="position-relative d-inline-block me-2 mb-2" data-index="${currentIndex}">
                        <img src="${e.target.result}" width="100" class="border rounded">
                        <span class="position-absolute top-0 end-0 text-danger bg-white px-1 remove-preview" data-index="${currentIndex}" style="cursor: pointer;">&times;</span>
                    </div>
                `);
                    $('#image-preview-container').append(preview);
                };
                reader.readAsDataURL(file);
                imageIndex++; // Increment after assigning
            });

            // Reset input to allow same file re-selection again if needed
            $('#image').val('');
        });

        // Remove selected image
        $(document).on('click', '.remove-preview', function () {
            const index = $(this).data('index');

            // Mark the div for this image index and remove it from array
            previewImages[index] = null; // Mark as null to keep indices aligned
            $(this).parent().remove();

            // Disable button if no valid image remains
            if (!previewImages.some(file => file !== null)) {
                $('#uploadBtn').prop('disabled', true);
            }
        });


        $('#EditProfile').on('submit', function (e) {
            e.preventDefault();

            const formData = new FormData();
            previewImages.forEach((file) => {
                if (file !== null) {
                    formData.append('images[]', file);
                }
            });
            formData.append('_token', '{{ csrf_token() }}');

            $.ajax({
                url: "{{ route('user.photos.upload') }}",
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                beforeSend: function () {
                    $('#uploadBtn').prop('disabled', true).text('Uploading...');
                },
                success: function (response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Photos uploaded successfully!',
                        confirmButtonColor: '#3085d6'
                    }).then(() => {
                        location.reload();
                    });
                },
                error: function (xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Upload Failed',
                        text: 'Failed to upload photos. Please try again.',
                        confirmButtonColor: '#d33'
                    });

                    $('#uploadBtn').prop('disabled', false).text('Upload Photos');
                }
            });
        });

    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const toggleBtn = document.querySelector(".dropdown-toggle-icon");
            const menu = document.querySelector(".custom-dropdown-menu");

            toggleBtn.addEventListener("click", function (e) {
                e.stopPropagation();
                menu.classList.toggle("show-menu");
            });

            // close when clicking outside
            document.addEventListener("click", function () {
                menu.classList.remove("show-menu");
            });
        });
        $(document).on('click', '.leftShift', function () {
            let block = $(this).closest('.profile-upload-card');
            let prev = block.prev('.profile-upload-card');

            if (prev.length) {
                prev.before(block);
                updateSequence();
            }
        });

        $(document).on('click', '.rightShift', function () {
            let block = $(this).closest('.profile-upload-card');
            let next = block.next('.profile-upload-card');

            if (next.length) {
                next.after(block);
                updateSequence();
            }
        });
        function updateSequence() {
            let sequence = [];

            $('.profile-upload-card').each(function (index) {
                let id = $(this).data('photo-id');
                sequence.push({
                    id: id,
                    sequence: index + 1
                });
            });

            // AJAX call to Laravel
            $.ajax({
                url: "{{ route('user.photos.updateOrder') }}",
                method: "POST",
                data: {
                    sequence: sequence,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function (res) {
                    console.log("Order updated");
                }
            });
        }
        $(document).on("click", ".HideShowImage", function () {
            let thissss = $(this);
            let block = thissss.closest('.profile-upload-card');
            let photoId = block.data('photo-id');
            let btnText = thissss.text().trim();
            $.ajax({
                url: "{{ route('user.photo.hideShowImage') }}",
                method: "POST",
                data: {
                    photo_id: photoId,
                    btnText: btnText,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function (res) {
                    thissss.text(btnText == "Hide Image" ? "Show Image" : "Hide Image");
                    toastr.success('Photo marked as ' + (btnText == "Hide Image" ? "Show Image" : "Hide Image") + '.');                    
                }
            });
        });
        $(document).on("click", ".mark-profile", function () {
            let thissss = $(this);
            let block = thissss.closest('.profile-upload-card');
            let photoId = block.data('photo-id');
            $.ajax({
                url: "{{ route('user.photo.markAsProfile') }}",
                method: "POST",
                data: {
                    photo_id: photoId,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function (res) {
                    toastr.success(res.message);                    
                    if(res.status == 1){ 
                        location.reload();
                    }
                }
            });
        });
    </script>
@endpush