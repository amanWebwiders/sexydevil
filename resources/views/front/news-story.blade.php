@extends('front.layout.layout')

@section('content')
<style>
    .sidebar {
        top: 0;
    }
    .preview-thumb {
        position: relative;
        width: 100px;
        height: 100px;
        margin-right: 10px;
        margin-bottom: 10px;
        overflow: hidden;
        border: 1px solid #ccc;
        border-radius: 6px;
    }

    .preview-thumb img,
    .preview-thumb video {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .preview-thumb .remove {
        position: absolute;
        top: 2px;
        right: 4px;
        color: red;
        cursor: pointer;
        background: white;
        border-radius: 50%;
        font-size: 16px;
        font-weight: bold;
        padding: 0 4px;
    }

    .more-text {
        display: none;
    }

    .newsstorypost {
        max-width: 600px !important;
    }

    #quicklinks:has(.newsstorypost) {
        justify-content: center !important;
    }

    .heading {
        font-size: 30px;
    }
    /* From Uiverse.io by mobinkakei */ 
#wifi-loader {
  --background: #62abff;
  --back-color: #c3c8de;
  --text-color: #414856;
  width: 64px;
  height: 64px;
  border-radius: 50px;
  position: relative;
  display: flex;
  justify-content: center;
  align-items: center;
  margin-bottom: 50px;
}

#wifi-loader svg {
  position: absolute;
  display: flex;
  justify-content: center;
  align-items: center;
}

#wifi-loader svg circle {
  position: absolute;
  fill: none;
  stroke-width: 6px;
  stroke-linecap: round;
  stroke-linejoin: round;
  transform: rotate(-100deg);
  transform-origin: center;
}

#wifi-loader svg circle.back {
  stroke: var(--back-color);
}

#wifi-loader svg circle.front {
  stroke: var(--primary-color);
}

#wifi-loader svg.circle-outer {
  height: 86px;
  width: 86px;
}

#wifi-loader svg.circle-outer circle {
  stroke-dasharray: 62.75 188.25;
}

#wifi-loader svg.circle-outer circle.back {
  animation: circle-outer135 1.8s ease infinite 0.3s;
}

#wifi-loader svg.circle-outer circle.front {
  animation: circle-outer135 1.8s ease infinite 0.15s;
}

#wifi-loader svg.circle-middle {
  height: 60px;
  width: 60px;
}

#wifi-loader svg.circle-middle circle {
  stroke-dasharray: 42.5 127.5;
}

#wifi-loader svg.circle-middle circle.back {
  animation: circle-middle6123 1.8s ease infinite 0.25s;
}

#wifi-loader svg.circle-middle circle.front {
  animation: circle-middle6123 1.8s ease infinite 0.1s;
}

#wifi-loader svg.circle-inner {
  height: 34px;
  width: 34px;
}

#wifi-loader svg.circle-inner circle {
  stroke-dasharray: 22 66;
}

#wifi-loader svg.circle-inner circle.back {
  animation: circle-inner162 1.8s ease infinite 0.2s;
}

#wifi-loader svg.circle-inner circle.front {
  animation: circle-inner162 1.8s ease infinite 0.05s;
}

#wifi-loader .text {
  position: absolute;
  bottom: -40px;
  display: flex;
  justify-content: center;
  align-items: center;
  text-transform: lowercase;
  font-weight: 500;
  font-size: 14px;
  letter-spacing: 0.2px;
}

#wifi-loader .text::before, #wifi-loader .text::after {
  content: attr(data-text);
}

#wifi-loader .text::before {
  color: var(--text-color);
}

#wifi-loader .text::after {
  color: var(--front-color);
  animation: text-animation76 3.6s ease infinite;
  position: absolute;
  left: 0;
}

@keyframes circle-outer135 {
  0% {
    stroke-dashoffset: 25;
  }

  25% {
    stroke-dashoffset: 0;
  }

  65% {
    stroke-dashoffset: 301;
  }

  80% {
    stroke-dashoffset: 276;
  }

  100% {
    stroke-dashoffset: 276;
  }
}

@keyframes circle-middle6123 {
  0% {
    stroke-dashoffset: 17;
  }

  25% {
    stroke-dashoffset: 0;
  }

  65% {
    stroke-dashoffset: 204;
  }

  80% {
    stroke-dashoffset: 187;
  }

  100% {
    stroke-dashoffset: 187;
  }
}

@keyframes circle-inner162 {
  0% {
    stroke-dashoffset: 9;
  }

  25% {
    stroke-dashoffset: 0;
  }

  65% {
    stroke-dashoffset: 106;
  }

  80% {
    stroke-dashoffset: 97;
  }

  100% {
    stroke-dashoffset: 97;
  }
}

@keyframes text-animation76 {
  0% {
    clip-path: inset(0 100% 0 0);
  }

  50% {
    clip-path: inset(0);
  }

  100% {
    clip-path: inset(0 0 0 100%);
  }
}
 
</style>
<section class="main-area">
    <div class="container-fluid">
        <div class="row" id="quicklinks">
            @include('front.component.quicklink')

            <!-- for mobile  -->

            <div class="d-flex d-lg-none justify-content-between col-12 px-0 mt-2 mb-4">
                <a class="open-offcanvas" data-target="#offcanvas1">Quick links <i class="fa fa-external-link" aria-hidden="true" class="canvas-icon"></i>
                </a>
                <a class="open-offcanvas" data-target="#offcanvas2">Filters <i class="fa fa-filter" aria-hidden="true" class="canvas-icon"></i></a>
            </div>

            <div class="offcanvas offcanvas_left" id="offcanvas1">
                <button type="button" class="close close-offcanvas" id="closeOffcanvas" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                @include('front.component.quicklink')
            </div>


            <div class="offcanvas-backdrop" id="offcanvasBackdrop"></div>

            <!-- for mobile end  -->

            <div class="col-lg-10 newsstorypost">



                <section class="ds s-pt-70 s-pb-50 s-pb-sm-50 s-py-lg-100 s-py-xl-150 c-gutter-60 content-area">
                    <div class="p-5 mx-lg-0 mx-md-0 mx-2 setavailabilty-main">
                        <div class="row justify-content-center">
                            <div class="d-md-flex justify-content-between w-100 px-md-3  mb-3">
                                <h1 class="heading mb-0">News Stories</h1>

                                <div>
                                    <button class="btn " data-toggle="modal" data-target="#addNewsModal">
                                        Add News & Stories
                                    </button>
                                </div>




                            </div>
                            <div class="w-100" style=" height: 1100px; overflow: auto; " id="userHotStories">
                                @forelse($data as $story)
                                <div class="post-card">
                                    <div class="post-header">
                                        <div class="profile-pic">
                                            <img src="{{ config('app.img_url'). $story->user->profile_image }}" alt="Profile">
                                        </div>
                                        <div class="user-info">
                                            <h4 class="user-name">{{$story->user->nickname}}</h4>
                                            <p class="post-time">{{ $story->created_at->format('F j, Y \a\t g:i A') }} <i class="fas fa-globe-americas"></i></p>
                                        </div>
                                        <a href="#" class="delete-news ms-auto" data-id="{{ $story->id }}"><i class="fa-solid fa-x"></i></a>

                                    </div>
                                    @php

                                    @endphp
                                    <div class="post-content">
                                        @php
                                        $storyId = $story->id;
                                        $text = strip_tags($story->text);
                                        $words = explode(' ', $text);
                                        $preview = implode(' ', array_slice($words, 0, 20));
                                        $hasMore = count($words) > 20;
                                        @endphp
                                        <h6 class="user-name ml-3">{{$story->title}}</h6>
                                        <p>
                                            {!! $preview !!}
                                            @if ($hasMore)
                                            <span id="dots-{{ $storyId }}">...</span>
                                            <span id="more-{{ $storyId }}" class="more-text">{{ implode(' ', array_slice($words, 20)) }}</span>
                                            @endif
                                        </p>

                                        @if ($hasMore)
                                        <button id="btn-{{ $storyId }}" onclick="toggleText({{ $storyId }})">Read more</button>
                                        @endif
                                        <div class="post-images one-image">

                                            @php
                                            $ext = strtolower(pathinfo($story->images, PATHINFO_EXTENSION));
                                            $isVideo = in_array($ext, ['mp4', 'ogg', 'webm', 'avi']);
                                            @endphp
                                            @if($isVideo)
                                            <video controls class="post-image"
                                                 loop playsinline poster="{{ url('storage/app/public/' . $story->thumbnail) }}">
                                                  <source src="{{ url('storage/app/public/' . $story->images) }}">
                                            </video>
                                            @else
                                            <img src="{{ url('storage/app/public/' . $story->images) }}"
                                                alt="Post media"
                                                class="post-image {{ asset('storage/' . $story->images) }}">
                                            @endif


                                        </div>
                                    </div>

                                    <div class="post-footer">
                                        <div class="reaction-bar">
                                            <div><i class="fas fa-thumbs-up"></i> {{$story->likes->count()}}</div>
                                            <div>{{$story->comments->count()}} comments</div>
                                        </div>
                                        <div class="action-bar">
                                            <div class="action-button">
                                                <i class="far fa-thumbs-up"></i> Like
                                            </div>
                                            <div class="action-button">
                                                <i class="far fa-comment"></i> Comment
                                            </div>
                                        </div>
                                    </div>

                                    <div class="comment-section">
                                        <div class="comment-count">{{$story->comments->count()}} comments</div>

                                        @if ($story->comments->isEmpty())
                                        <div class="no-comments">No comments yet</div>
                                        @else
                                        @foreach ($story->comments as $comment)
                                        <div class="comment">
                                            <div class="comment-pic">
                                                <img src="{{ $comment->user->profile_picture ?? 'https://randomuser.me/api/portraits/lego/1.jpg' }}" alt="Profile">
                                            </div>
                                            <div class="comment-content">
                                                <div class="comment-author">{{ $comment->user->name }}</div>
                                                <div class="comment-text">{{ $comment->comment }}</div>
                                                <div class="comment-actions">
                                                    <span class="comment-action">Like</span>
                                                    <span class="comment-action">Reply</span>
                                                    <span class="comment-action">{{ $comment->created_at->diffForHumans() }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                        @endif

                                        <!-- <div class="add-comment">
                                            <div class="comment-pic">
                                                <img src="https://randomuser.me/api/portraits/women/28.jpg" alt="Profile">
                                            </div>
                                            <input type="text" class="comment-input" placeholder="Write a comment...">
                                        </div> -->
                                    </div>
                                </div>
                                @empty
                                <div class="no-news text-center py-5">
                                    <h4>No news available</h4>
                                </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </section>





            </div>
        </div>
    </div>
</section>

<!-- Lightbox HTML -->
<div class="lightbox" id="lightbox" style="display: none;">
    <div class="lightbox-content">
        <span class="lightbox-close" id="lightboxClose">&times;</span>

        <!-- Image element -->
        <img class="lightbox-image" id="lightboxImage" src="" alt="" style="max-width: 100%; max-height: 100%; display: none;">

        <!-- Video element -->
        <video class="lightbox-video" id="lightboxVideo" controls style="max-width: 100%; max-height: 100%; display: none;">
            Your browser does not support the video tag.
        </video>

        <div class="lightbox-nav">
            <span class="lightbox-prev" id="lightboxPrev">&#10094;</span>
            <span class="lightbox-next" id="lightboxNext">&#10095;</span>
        </div>
        <div class="image-counter" id="imageCounter"></div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="addNewsModal" tabindex="-1" role="dialog" aria-labelledby="addNewsModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form id="newsStoriesForm" method="POST" enctype="multipart/form-data">

            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addNewsModalLabel">Add News & Stories</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <!-- Text Field -->
                    <div class="form-group">
                        <label for="text">Heading <span class="text-danger">*</span></label>
                        <input type="text" name="title" maxlength="10" id="title"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="text">Description <span class="text-danger">*</span></label>
                        <textarea name="text" id="textEditor"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="fileType">File Type<span class="text-danger">*</span></label>
                        <select id="fileType" name="fileType" required >
                            <option value="image" selected >Image</option>
                            <option value="video">Video</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="image">Upload Image<span class="text-danger">*</span></label>
                        <input type="file" name="image" id="media" accept="image/*" required>
                        <small class="form-text text-muted">Only one image allowed.</small>
                    </div>
                    <div class="form-group d-none">
                        <label for="thumbnail">Thumbnail <span class="text-danger">*</span></label>
                        <input type="file" name="thumbnail" id="thumbnail" accept="image/jpeg, image/png, image/webp">
                        <small class="form-text text-muted">Thumbnail for video.</small>
                    </div>
                    <div class="form-group">
                        <input class="TFHours hidden" name="validity" value="on" type="checkbox" id="TFHours" title="Show for 24 Hours">
                        <label for="TFHours">Show for 24 Hours</label>
                    </div> 
                    <div id="mediaPreview" class="d-flex flex-wrap mt-2 mediaPreview"></div>

                    <div id="uploadProgressContainer" class="mt-3"></div>

                    <!-- Images Upload -->
                    <!-- <div class="form-group">
                        <label for="images">Upload Media(Image or Video)</label>
                        <input type="file" name="image" id="images" class="form-control" accept="image/*" required>
                        <small class="form-text text-muted">You can select images.</small>

                        <div id="imagePreview" class="d-flex flex-wrap mt-2"></div>
                    </div> -->

                    <!-- Videos Upload -->
                    <!-- <div class="form-group">
                        <label for="videos">Videos (optional)</label>
                        <input type="file" name="videos" id="videos" class="form-control" accept="video/*">
                        <small class="form-text text-muted">You can select videos.</small>

                        <div id="videoPreview" class="d-flex flex-wrap mt-2"></div>
                    </div>
                    <div id="uploadProgressContainer" class="mt-3"></div> -->
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-success" id="submitbtn">Submit</button>
                    <button type="button" class="btn" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </form>
    </div>
</div>



@endsection
@push('js')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/css/lightbox.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/js/lightbox.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.isotope/3.0.6/isotope.pkgd.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/browser-image-compression@2.0.2/dist/browser-image-compression.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.8.2/tinymce.min.js" referrerpolicy="origin"></script>

<script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>
<script>
    function toggleText(id) {
        var dots = document.getElementById("dots-" + id);
        var more = document.getElementById("more-" + id);
        var btn = document.getElementById("btn-" + id);

        if (dots.style.display === "none") {
            dots.style.display = "inline";
            btn.innerText = "Read more";
            more.style.display = "none";
        } else {
            dots.style.display = "none";
            btn.innerText = "Read less";
            more.style.display = "inline";
        }
    }
    document.addEventListener('DOMContentLoaded', function() {
        const mediaElements = document.querySelectorAll('.post-images .post-image, .post-images .post-video');
        const moreCountOverlay = document.querySelector('.more-count');
        const lightbox = document.getElementById('lightbox');
        const lightboxImage = document.getElementById('lightboxImage');
        const lightboxVideo = document.getElementById('lightboxVideo');
        const lightboxClose = document.getElementById('lightboxClose');
        const lightboxPrev = document.getElementById('lightboxPrev');
        const lightboxNext = document.getElementById('lightboxNext');
        const imageCounter = document.getElementById('imageCounter');

        // Collect all media info (src + type)
        const allMedia = Array.from(mediaElements).map(el => {
            const tag = el.tagName.toLowerCase();
            return {
                src: el.src || el.getAttribute('data-src'), // for <video> with data-src
                type: tag === 'img' ? 'image' : 'video'
            };
        });

        let currentIndex = 0;

        function showMedia(index) {
            const media = allMedia[index];

            if (media.type === 'image') {
                lightboxImage.src = media.src;
                lightboxImage.style.display = 'block';
                lightboxVideo.pause();
                lightboxVideo.style.display = 'none';
            } else if (media.type === 'video') {
                lightboxVideo.src = media.src;
                lightboxVideo.style.display = 'block';
                lightboxImage.style.display = 'none';
            }

            imageCounter.textContent = `${index + 1} of ${allMedia.length}`;
            lightbox.style.display = 'flex';
            document.body.style.overflow = 'hidden';
            currentIndex = index;
        }

        function closeLightbox() {
            lightbox.style.display = 'none';
            document.body.style.overflow = '';
            lightboxVideo.pause();
        }

        function navigateMedia(direction) {
            currentIndex += direction;
            if (currentIndex < 0) {
                currentIndex = allMedia.length - 1;
            } else if (currentIndex >= allMedia.length) {
                currentIndex = 0;
            }
            showMedia(currentIndex);
        }

        mediaElements.forEach((el, index) => {
            el.addEventListener('click', function(e) {
                e.stopPropagation();
                showMedia(index);
            });
        });

        if (moreCountOverlay) {
            moreCountOverlay.addEventListener('click', function(e) {
                e.stopPropagation();
                const hiddenMedia = Array.from(mediaElements).filter(el =>
                    window.getComputedStyle(el).display === 'none'
                );
                if (hiddenMedia.length > 0) {
                    const firstHiddenIndex = Array.from(mediaElements).indexOf(hiddenMedia[0]);
                    showMedia(firstHiddenIndex);
                }
            });
        }

        lightboxClose.addEventListener('click', closeLightbox);
        lightboxPrev.addEventListener('click', function(e) {
            e.stopPropagation();
            navigateMedia(-1);
        });
        lightboxNext.addEventListener('click', function(e) {
            e.stopPropagation();
            navigateMedia(1);
        });

        lightbox.addEventListener('click', function(e) {
            if (e.target === this) {
                closeLightbox();
            }
        });

        document.addEventListener('keydown', function(e) {
            if (lightbox.style.display === 'flex') {
                if (e.key === 'Escape') {
                    closeLightbox();
                } else if (e.key === 'ArrowLeft') {
                    navigateMedia(-1);
                } else if (e.key === 'ArrowRight') {
                    navigateMedia(1);
                }
            }
        });
    });
</script>

<script>
    $(document).ready(function() {
        tinymce.init({
            selector: '#textEditor',
            height: 300,
            menubar: false,
            plugins: 'emoticons lists link code',
            toolbar: 'undo redo | bold italic underline | emoticons | bullist numlist | code',
            toolbar_location: 'top',
            branding: false,
            content_style: 'body { font-family:Arial,sans-serif; font-size:14px }'
        });
        // let uploadedImagePaths = [];
        // let uploadedVideoPaths = [];

        // $('#images').on('change', function(e) {
        //     const file = e.target.files[0];
        //     console.log(file);
        //     if (file) {
        //         $('#imagePreview').html('');
        //         uploadedImagePaths = [];
        //         compressAndUploadImage(file);
        //     }
        //     // const files = Array.from(e.target.files);
        //     // files.forEach(file => compressAndUploadImage(file));
        // });

        // $('#videos').on('change', function(e) {
        //     const file = e.target.files[0];
        //     console.log(file);
        //     if (file) {
        //         $('#videoPreview').html('');
        //         uploadedVideoPaths = [];
        //         uploadFile(file, 'videos');
        //     }
        //     // const files = Array.from(e.target.files);
        //     // files.forEach(file => uploadFile(file, 'videos'));
        // });

        let uploadedMediaPath = '';

        $('#media').on('change', function(e) {
            const file = e.target.files[0];
            if (!file) return;

            $('.mediaPreview').html('');
            uploadedMediaPath = '';

            const fileType = file.type;

            if (fileType.startsWith('image/')) {
                compressAndUploadImage(file);
            } else if (fileType.startsWith('video/')) {
                if (!['video/mp4', 'video/webm', 'video/ogg', 'video/avi'].includes(fileType)) {
                    toastr.warning("Unsupported video format. Please upload MP4, WebM, OGG, or AVI files.");
                    return false;
                } else if (file.size > 5 * 1024 * 1024) {
                    toastr.warning("Video exceeds 5MB limit.");
                    return false;
                } else {
                    uploadFile(file, 'video');
                }
                //console.log('Selected video file:', fileType);
            } else {
                alert('Only image or video files are allowed.');
            }
        });

        async function compressAndUploadImage(file) {
            try {
                const options = {
                    maxSizeMB: 1,
                    maxWidthOrHeight: 1024,
                    useWebWorker: true
                };
                const compressedFile = await imageCompression(file, options);
                const originalMB = (file.size / 1024 / 1024).toFixed(2);
                const compressedMB = (compressedFile.size / 1024 / 1024).toFixed(2);
                console.log(`Compressed ${file.name}: ${originalMB} MB → ${compressedMB} MB`);

                uploadFile(compressedFile, 'images', file.name, `${originalMB} → ${compressedMB}`);
            } catch (error) {
                alert('Image compression failed.');
            }
        }
        const assetBase = "{{ config('app.img_url') }}";

        function uploadFile(file, type, originalName = null, sizeInfo = '') {
            const formData = new FormData();
            formData.append('file', file);

            const progressId = `progress_${Math.random().toString(36).substr(2, 9)}`;
            $('#uploadProgressContainer').html('').append(`
            <div class="mb-2">
                <strong>${originalName || file.name}</strong> (${sizeInfo || (file.size / 1024 / 1024).toFixed(2)} MB)
                <div class="progress">
                    <div class="progress-bar" id="${progressId}" role="progressbar" style="width: 0%">0%</div>
                </div>
            </div>
        `);

            $.ajax({
                url: '{{ route("chunk.upload") }}',
                method: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                xhr: function() {
                    const xhr = new window.XMLHttpRequest();
                    xhr.upload.addEventListener("progress", function(evt) {
                        if (evt.lengthComputable) {
                            const percent = Math.round((evt.loaded / evt.total) * 100);
                            $(`#${progressId}`).css('width', `${percent}%`).text(`${percent}%`);
                        }
                    }, false);
                    return xhr;
                },
                beforeSend: function() {
                    $('#submitbtn').prop('disabled', true).text('processing ...');
                },
                success: function(res) {
                    console.log('Uploaded file path:', res.path);
                    console.log('Full preview URL:', `${assetBase}/${res.path}`);
                    if (res.status === 1 && res.path) {
                        uploadedMediaPath = res.path;
                        if (type === 'images') {
                            renderImagePreview(res.path);
                        } else {
                            renderVideoPreview(res.path);
                        }
                    } else if (res.message) {
                        alert(res.message);
                    }
                },
                error: function() {
                    alert('Upload failed.');
                },
                complete: function() {
                    $('#submitbtn').prop('disabled', false).text('Submit');
                }
            });
        }

        // function renderImagePreview(path) {
        //     const fullUrl = `{{ asset('storage') }}/${path}`;
        //     $('#imagePreview').append(`
        //     <div class="preview-thumb m-1">
        //         <img src="${fullUrl}" class="img-thumbnail" style="max-width: 120px;">
        //     </div>
        // `);
        // }

        // function renderVideoPreview(path) {
        //     const fullUrl = `{{ asset('storage') }}/${path}`;
        //     $('#videoPreview').append(`
        //     <div class="preview-thumb m-1">
        //         <video src="${fullUrl}" class="img-thumbnail" style="max-width: 150px;" autoplay muted loop></video>
        //     </div>
        // `);
        // }
        function renderImagePreview(path) {
            const fullUrl = `${assetBase}/${path}`;
            $('.mediaPreview').html(`
        <div class="preview-thumb m-1">
            <img src="${fullUrl}" class="img-thumbnail" style="max-width: 120px; border-radius: 5px;">
        </div>
    `);
        }

        function renderVideoPreview(path) {
            const fullUrl = `${assetBase}/${path}`;
            $('.mediaPreview').html(`
        <div class="preview-thumb m-1">
            <video src="${fullUrl}" class="img-thumbnail" style="max-width: 150px;" controls ></video>
        </div>
    `);
        }


        $('#newsStoriesForm').submit(function(e) {
            e.preventDefault();
            var text = tinymce.get('textEditor').getContent({
                format: 'text'
            }).trim();

            if (!text) {
                // if empty, block submission
                e.preventDefault();

                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Please enter some text before submitting.',
                });
                return false;
            }
            tinymce.triggerSave();
            let formData = new FormData(this);
            formData.delete('image');
            // formData.append('uploaded_images', JSON.stringify(uploadedImagePaths));
            // formData.append('uploaded_videos', JSON.stringify(uploadedVideoPaths));
            formData.append('uploaded_media', uploadedMediaPath);

            $.ajax({
                url: "{{ route('user.newsStories.store') }}",
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                beforeSend: function() {
                    $('#submitbtn').prop('disabled', true).text('processing ...');
                },
                success: function(response) {
                    $('#addNewsModal').modal('hide');
                    $('#newsStoriesForm')[0].reset();
                    $('.mediaPreview, #uploadProgressContainer').html('');

                    // uploadedImagePaths = [];
                    // uploadedVideoPaths = [];
                    let uploadedMediaPath = '';

                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: response.message || 'News/Story added successfully!',
                        timer: 3000,
                        showConfirmButton: false
                    });
                    window.location.reload();
                },
                error: function(xhr) {
                    const errors = xhr.responseJSON?.errors || {};
                    const msg = Object.values(errors).flat().join('\n') || 'Something went wrong.';
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: msg
                    });
                },
                complete: function() {
                    $('#submitbtn').prop('disabled', false).text('Submit');
                }
            });
        });
    });
    $(document).on('click', '.delete-news', function(e) {
        e.preventDefault();

        if (!confirm("Are you sure you want to delete this post?")) return;

        const newsId = $(this).data('id');
        const postCard = $(this).closest('.post-card');

        $.ajax({
            url: "{{ route('user.news.destroy') }}",
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                id: newsId
            },
            dataType : 'json',
            success: function(response) {
                // Show Swal success
                if(response.status == 200) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Deleted!',
                        text: response.message || 'Post has been deleted.',
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        // Fade out and remove card after alert
                        postCard.fadeOut(300, function() {
                            $(this).remove();
                        });
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.message,
                    });
                }
            },
            error: function(xhr) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Unable to delete the post. Please try again.',
                });
                console.log(xhr.responseText);
            }
        });
    });

    const swiper = new Swiper('.swiper', {
        loop: true,
        autoplay: {
            delay: 3000,
        },
    });
    var $grid = $('.isotope-wrapper').isotope({
        itemSelector: '.col-sm-6',
        layoutMode: 'masonry'
    });

    // Filter on click
    $('.gallery-filters a').on('click', function(e) {
        e.preventDefault();
        var filterValue = $(this).attr('data-filter');
        $grid.isotope({
            filter: filterValue
        });

        // Active state toggle
        $('.gallery-filters a').removeClass('active selected');
        $(this).addClass('active selected');
    });

    function toggleHeart(button) {
        const icon = button.querySelector('i');

        // Toggle class and icon style
        button.classList.toggle('liked');
        if (icon.classList.contains('fa-regular')) {
            icon.classList.remove('fa-regular');
            icon.classList.add('fa-solid');
        } else {
            icon.classList.remove('fa-solid');
            icon.classList.add('fa-regular');
        }
    }

var page = is_record = 2;

function loadMoreHotStories() {
     $.ajax({
        url: "{{ route('user.newsStories') }}?page="+page,
        type: 'get',
        dataType : 'json',
        beforeSend : function() {
            if(is_record == 2) {
                $("#userHotStories").append(`
                <div id="wifi-loader">
                    <svg class="circle-outer" viewBox="0 0 86 86">
                        <circle class="back" cx="43" cy="43" r="40"></circle>
                        <circle class="front" cx="43" cy="43" r="40"></circle>
                        <circle class="new" cx="43" cy="43" r="40"></circle>
                    </svg>
                    <svg class="circle-middle" viewBox="0 0 60 60">
                        <circle class="back" cx="30" cy="30" r="27"></circle>
                        <circle class="front" cx="30" cy="30" r="27"></circle>
                    </svg>
                    <svg class="circle-inner" viewBox="0 0 34 34">
                        <circle class="back" cx="17" cy="17" r="14"></circle>
                        <circle class="front" cx="17" cy="17" r="14"></circle>
                    </svg>
                    <div class="text" data-text="Searching"></div>
                </div>`);
            }
        },
        success: function(response) {
            $("#wifi-loader").remove();
            if(response.status == 200) {
                $("#userHotStories").append(response.list);
            } else {
                is_record = 1;
            }
        }
    });
}

$('#userHotStories').on('scroll', function () {
let $this = $(this);

// When scrolled to the bottom
if ($this.scrollTop() + $this.innerHeight() >= this.scrollHeight) {
    // Run your function here
    console.log('Reached bottom!', page);
    loadMoreHotStories(page); // example function
    page++;

}
});
$("#fileType").change(function() {
    var media = $("#media").closest('.form-group');
    if ($(this).val() === "video") {
        $("#thumbnail").prop('required', true).closest('.form-group').removeClass('d-none');
        $("#media").attr('accept', 'video/*');
        media.find('label').text('Upload Video');
        media.find('small').text('Only one video allowed. Max size: 5MB.');
    } else {
        $("#thumbnail").prop('required', false).closest('.form-group').addClass('d-none');
        $("#media").attr('accept', 'image/*');
        media.find('label').text('Upload Image');
        media.find('small').text('Only one image allowed.');
    }
});
</script>

<!-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script> -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

@endpush