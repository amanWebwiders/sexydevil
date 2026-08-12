@extends('front.layout.layout')

@section('content')

<!-- Fancybox CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui/dist/fancybox.css" />




<style>
    .sidebar {
        top: 0px;
    }

    /* .swiper-wrapper {
        gap: 20px;
    } */

    .image_box,
    .image_box a img,
    .image_box a,
    .image_box a video {
        width: 100%;
        object-fit: cover;
        height: 250px;
    }

    .panel .rates th,
    .panel .rates td {
        color: white;
    }

    .profile-card {
        margin-top: 0px;
    }

    @media (max-width: 767px) {

        .panel,
        .col-md-9 {
            padding: 0px;
        }

        p {
            line-height: 1.3;
        }
    }

    .more-text {
        display: none;
    }

    .add-comment {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-top: 10px;
    }

    .comment-input {
        flex: 1;
        padding: 8px;
    }



    .like-button {
        cursor: pointer;
    }

    .like-button .text-primary {
        color: #007bff !important;
    }

    .newsactive {
        max-width: 600px !important;
        /* margin: auto; */
    }

    .newsactive .nav {
        gap: 8px;
    }

    .newsactive .nav-tabs .nav-item .nav-link {

        font-size: 10px;

        padding: 10px 9px;
    }

    .row.model_detail:has(.newsactive) {
        justify-content: center !important;
    }


    button#btn-8 {
        padding: 0px;
        background: transparent;
        color: maroon;
        letter-spacing: 0px;
        text-transform: capitalize;
        line-height: 1;
        margin-left: auto;
        display: block;
    }

    input.reply-input {
        border: 1px solid #f2f2f2 !important;
        margin-bottom: 5px;
    }

    input[type="submit"],
    button {
        letter-spacing: 1px;
        padding: 3px 20px;
        background-color: var(--primary-color) !important;
    }



    .comment-list>.comment {
        border-bottom: 1px solid #dbdbdb;
        padding-bottom: 20px;
    }

    .comment-list>.comment:last-child {
        border: none;
    }

    .ds input[type="text"].comment-input {
        border-radius: 5px !important;
    }

    .add-comment .btn {
        padding: 12px 20px;
        background: var(--primary-color) !important;
    }

    .post-content {
        margin: 0 -20px;
    }

    .post-content #btn-8,
    .post-content a,
    .post-content p {
        padding: 0 20px;
    }

    .rating-zero {
        margin-top: 25px !important;
        text-align: center;
    }

    button.carousel__button.is-prev,
    button.carousel__button.is-next {
        display: none;
    }

    @media (max-width: 767px) {
        div#maindetailui {
            padding: 0px;
        }
    }


    .detail-age-tabs{
        flex-direction: row;
    }


.exclusive-desc, .views-label{
    bottom: 60px;
}
.exclusive-label.exclusive-new{
    bottom: 90px;
}



    /* new css */
        .thumbnail-slider .swiper-slide {
        flex-shrink: 0;
        /* ✅ Prevent shrinking */
        opacity: 0.4;
        cursor: pointer;
        transition: opacity 0.3s ease;
    }

    .thumbnail-slider .swiper-slide img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 6px;
    }
.swiper-button-prev, .swiper-button-next {
    background: #ffffff61;
    width: 40px;
    height: 40px;
    /* font-size: 11px; */
    border-radius: 100%;
}
.swiper-button-next:after, .swiper-button-prev:after {
    font-size: 22px;
    color: #bc1212;
    font-weight: 900;
}
    /* .swiper-slide {
        width: auto !important;
    } */

    .main-slider {
        height: 500px;
        margin-bottom: 20px;
    }

    .main-slider .swiper-slide img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        /* border-radius: 8px; */
    }

    .main-slider .swiper-slide video {
        width: 100%;
        height: 500px !important;
        object-fit: cover;
    }

    .thumbnail-slider {
        height: 90px;
        overflow-x: auto;
    }

    .thumbnail-slider::-webkit-scrollbar {
        height: 12px;
        /* Set your desired scrollbar height */
    }

    .thumbnail-slider::-webkit-scrollbar-track {
        background: #f1f1f1;
        /* Optional: background of the track */
    }

    .thumbnail-slider::-webkit-scrollbar-thumb {
        background: #888;
        /* Scrollbar color */
        border-radius: 6px;
        /* Optional: round corners */
    }

    .thumbnail-slider::-webkit-scrollbar-thumb:hover {
        background: #555;
        /* Optional: hover effect */
    }


    .thumbnail-slider .swiper-slide {
        width: 60px;
        height: 60px;
        opacity: 0.4;
        cursor: pointer;
        transition: opacity 0.3s ease;
    }

    .thumbnail-slider .swiper-slide video {
        width: 60px !important;
        height: 60px !important;
        object-fit: cover;
        border-radius: 6px;
    }

    .thumbnail-slider .swiper-slide-thumb-active {
        opacity: 1;
    }

    .thumbnail-slider .swiper-slide img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 6px;
    }

    .popularity-label.hot-icon {
        position: absolute;
        bottom: 10px;
        left: 10px;
        z-index: 2;
        background: #00000073;
        padding: 5px;
        font-size: 12px;
        font-weight: bold;
        letter-spacing: 1px;
    }

    .all-model-details .exclusive-label.exclusive-new {
        position: absolute !important;
        left: 10px;
        bottom: 40px;
        z-index: 2;
    }
.video-wrapper {
    width: 100%;
    height: 100%;
}

.profile-media .video-wrapper video {
    width: 100%;
    height: 100%;
}

.play-btn {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    font-size: 60px;
    color: white;
    cursor: pointer;
    background: rgba(0,0,0,0.5);
    width: 80px;
    height: 80px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.card iframe {
    width: 100%;
    height: 100%;
    border: 0;
}

.custom-video {
    width: 100%;
    height: 400px;
    object-fit: cover;   /* Makes video cover area properly */
    display: block;
}

</style>




<section class="main-area">
    <div class="container-fluid">
        @php
            $breadcrumbs = [
                ['title' => $user->city ?? 'Escorts', 'url' => !empty($user->city) ? route('model.search', ['city' => Str::slug($user->city)]) : route('model.search')],
                ['title' => $user->listing_title ?? $user->nickname ?? $user->name ?? 'Profile', 'url' => '']
            ];
        @endphp
        @include('partials.breadcrumbs', ['breadcrumbs' => $breadcrumbs])
        @include('front.component.stories')
        <div class="row model_detail">
            <div class=" col-lg-8 mb-5">

                <div class="sidebar mb-0">
                    <div class="profile-image mb-0">
                        @php
                        $authUser = Auth::guard('web')->user();
                        @endphp
                        <div class="top-box all-model-details">
                            <button class="wishlistBtn heart-button" data-auth="{{ $authUser ? $authUser->id : '' }}"
                                data-id="{{ $user->id }}">
                                <i class="{{ in_array($user->id, $favorite_users) ? 'fa-solid fa-heart text-danger' : 'fa-regular fa-heart' }}"></i>
                            </button>
                            @php
                            $createdWithinTwoWeeks = $user->created_at >= now()->subDays(14);
                            @endphp
                            @if($createdWithinTwoWeeks)
                            <div class="exclusive-label exclusive-new">New</div>
                            @endif
                            @if($user->is_boosted && $user->boost_end_date >= now())
                            <div class="exclusive-label exclusive-vip mt-3">VIP</div>
                            @endif

                            <div class="corner-ribbon corner-ribbon-sm notranslate" translate="no">
                                <i class="fa-solid fa-fire"></i>

                                <span>{{$user->plan->tag}}</span>
                            </div>


                            @php
                            $views = getBoostedViews($user->viewsReceived->count(), $user->id);
                            @endphp

                            <div class="views-label"><!-- 
                                <i class="fa-solid fa-eye"></i>
                                {{ number_format($views['count']) }} {{ Str::plural('View', $views['count']) }} -->
                                @if($views['label'])
                                <span class="popularity-label hot-icon">{{ $views['label'] }}</span>
                                @endif
                            </div>


                            @php
                            $now = \Carbon\Carbon::now();
                            $nextAvailability = null;
                            if (!$user->is_online && !empty($user->availability)) {
                            for ($i = 0; $i < 7; $i++) {
                                $checkDay=strtolower($now->copy()->addDays($i)->format('l'));
                                if (!empty($user->availability[$checkDay])) {
                                $startTime = $user->availability[$checkDay]['start'] ?? null;
                                if ($startTime) {
                                $nextDate = $now->copy()->startOfDay()->addDays($i)->format('l, M j');
                                $nextAvailability = $nextDate . ' at ' . date('g:i A', strtotime($startTime));
                                break;
                                }
                                }
                                }
                                }
                                @endphp

                                @if ($user->is_online == 1)
                                <div class="exclusive-desc online-btn on">
                                    <i class="fa fa-circle text-success" title="Online"></i>
                                </div>
                                @else
                                <div class="exclusive-desc online-btn off">
                                    <i class="fa fa-circle" title="Offline"></i>
                                </div>
                                @endif
                                <div class="swiper main-slider">
                                    <div class="swiper-wrapper">

                                        {{-- 1️⃣ First slide: profile image --}}
                                        @if ($user->profile_image)
                                        <!-- <div class="swiper-slide">
                                            <a data-fancybox="gallery" href="{{ asset('storage/' . $user->profile_image) }}">
                                            <img src="{{ config('app.img_url'). $user->profile_image }}" alt="{{ $user->nickname }}">
                                            </a>
                                        </div> -->
                                        @else
                                        <div class="swiper-slide">
                                            <a data-fancybox="gallery" href="{{ asset('storage/profile_image/default-profile.png') }}">
                                            <img src="{{ asset('storage/profile_image/default-profile.png') }}" alt="Default profile">
                                            </a>
                                        </div>
                                        @endif

                                        {{-- 2️⃣ Other uploaded images --}}
                                        @foreach ($user->images as $image)
                                        @if($image->path !== $user->profile_image && $image->is_approved == 1)
                                            <div class="swiper-slide">
                                            <a data-fancybox="gallery" href="{{ config('app.img_url').$image->file_path }}">
                                                <img src="{{ config('app.img_url').$image->file_path }}" alt="{{ $image->alt_text }}">
                                            </a>
                                            </div>
                                        @endif
                                        @endforeach                                    
                                    </div>

                                    <div class="swiper-btns">
                                        <div class="swiper-button-prev"></div>
                                        <div class="swiper-button-next"></div>
                                    </div>
                                </div>





                                <!-- @if ($user->profile_image)
                                <img src="{{ asset('storage/' . $user->profile_image) }}" alt="Slide 1">
                                @else
                                <img src="{{ asset('storage/profile_image/default-profile.png') }}" alt="Slide 1">
                                @endif -->
                        </div>
                        <div class="swiper thumbnail-slider">
                            <div class="swiper-wrapper">

                                {{-- Profile image thumbnail --}}
                                @if ($user->profile_image)
                                <!-- <div class="swiper-slide">
                                    <img src="{{ config('app.img_url'). $user->profile_image }}" alt="{{ $user->nickname }}">
                                </div> -->
                                @else
                                <div class="swiper-slide">
                                    <img src="{{ asset('storage/profile_image/default-profile.png') }}" alt="Default profile">
                                </div>
                                @endif

                                {{-- Other images thumbnails --}}
                                @foreach ($user->images as $image)
                                    @if($image->file_path !== $user->profile_image && $image->is_approved == 1)
                                        <div class="swiper-slide">
                                            <img src="{{ config('app.img_url').$image->file_path }}" alt="{{ $image->alt_text }}">
                                        </div>
                                    @endif
                                @endforeach

                                {{-- Video thumbnails (optional: you could use a preview image instead of video directly) --}}
                               <!--  @if (!empty($user->videos))
                                    @foreach ($user->videos as $video)
                                        @if ($video->is_approved == 1)                                
                                        <div class="swiper-slide">
                                            <video preload="metadata" style="width:100%; height:auto;">
                                                <source src="{{ config('app.img_url'). $video->file_path }}" type="video/mp4">
                                            </video>
                                        </div>
                                        @endif
                                    @endforeach
                                @endif -->

                            </div>
                            <div class="swiper-scrollbar"></div>
                        </div>

                    </div>
                </div>

            </div>

            <div class="col-lg-4 mb-5">
<div class="sidebar mb-0 h-100">
                <div class="profile-card">
                    <div class="profile-info">
                        <div class="d-flex justify-content-between align-items-center">
                            <h1 class="name notranslate" translate="no">{{$user->nickname}}</h1>
                            @if ($user->is_online == 1)
                            <span class="available text-success">
                                <i class="fa fa-circle"></i> Available Now
                            </span>
                            @else
                            <span class="available text-danger">
                                <i class="fa fa-circle"></i> Offline
                            </span>
                            @endif
                        </div>
                        <p class="slogan notranslate" translate="no">{{$user->slogan}}</p>

                        <div class="details">

                            <p><strong>Location:</strong>{{ $user->city?->name ? $user->city->name . ', ' : '' }}
                    {{ $user->state?->name ? $user->state->name . ', ' : '' }}
                    {{ $user->countries?->name ?? '' }}</p>
                            @php
                            $selectedCategoryNames = [];

                            foreach ($categories as $category) {
                            $filteredServices = $category->services->filter(function ($service) use ($selectedServices, $selectedSelections) {
                            return in_array($service->id, $selectedServices) ||
                            $service->selections->pluck('id')->intersect($selectedSelections)->isNotEmpty();
                            });

                            if ($filteredServices->isNotEmpty()) {
                            $selectedCategoryNames[] = $category->name;
                            }
                            }

                            @endphp

                            @if (!empty($selectedCategoryNames))
                            <p><strong>Services:</strong>{{ implode(', ', $selectedCategoryNames) }}</p>
                            @endif
                            <p><strong>Rates:</strong>{{ format_price_dot(($user->quickie_rates['1_hr'] ?? '0')) }}{{$user->countries?->currency_symbol ?? '$'}}/hr, {{ format_price_dot(($user->quickie_rates['overnight'] ?? '0')) }}{{$user->countries?->currency_symbol ?? '$'}}/overnight</p>
                            <p><strong>Favourites:</strong>{{$user->wishlist()->count()}} <i class="fa-solid fa-heart"></i></p>

                        </div>
                        <div class="contact-buttons">
                            <a href="https://wa.me/{{ $user->phone_code }}{{ $user->phone }}?text=Hi%20I%20found%20your%20profile%20on%20the%20site" target="_blank" class="btn btn-success profileWhatsApp">
                                <i class="fa-brands fa-whatsapp"></i> Chat on WhatsApp
                            </a>

                        </div>
                        <div class="meta-info">
                            <p><i class="fa fa-arrow-circle-up"></i> Ad refreshed {{ $user->updated_at->diffForHumans() }}
                            </p>
                            <p><i class="fa-solid fa-calendar-days"></i> Active since {{ $user->created_at->format('F Y') }}</p>
                        </div>
                        <div class="reviews-section">
                            <h4>Reviews</h4>

                            @php
                            $reviews = $user->reviewsReceived;
                            $average = $reviews->avg('rating');
                            @endphp

                            @if($reviews->count())
                            <p><strong>Average Rating:</strong> {{ number_format($average, 1) }}/5 ({{ $reviews->count() }} reviews)</p>

                            @php $latestReview = $reviews->first(); @endphp
                            <p>
                                {!! str_repeat('⭐', $latestReview->rating) !!}
                                "{{ $latestReview->comment }}"
                                <br>
                                <small>
                                    by {{ UserData($latestReview->user_id, ['nickname'])->nickname ?? 'Anonymous' }} –
                                    {{ $latestReview->created_at->diffForHumans() }}
                                </small>
                            </p>
                            @else
                            <p>No reviews yet.</p>
                            @endif

                        </div>




                    </div>

                </div>
                </div>
            </div>

            <div class="col-md-12 col-lg-12" id="maindetailui">
                <section class="ds content-area">



                    <div class="row">
                        <div class="col-12">

                            <!-- tabs start -->
                            <ul class="nav nav-tabs detail-age-tabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link" id="tab04" data-toggle="tab" href="#tab04_pane" role="tab"
                                        aria-controls="tab04_pane" aria-expanded="true"
                                        onclick="document.querySelector('.col-lg-9').classList.remove('newsactive')">
                                        Overview
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link notranslate" translate="no" id="tab01" data-toggle="tab" href="#tab01_pane" role="tab"
                                        aria-controls="tab01_pane" aria-expanded="true"
                                        onclick="document.querySelector('.col-lg-9').classList.add('newsactive')">
                                        Feed
                                    </a>
                                </li>
                                <li class="nav-item d-none">
                                    <a class="nav-link" id="tab05" data-toggle="tab" href="#tab05_pane" role="tab"
                                        aria-controls="tab05_pane"
                                        onclick="document.querySelector('.col-lg-9').classList.remove('newsactive')">
                                        Photos
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="tab06" data-toggle="tab" href="#tab06_pane" role="tab"
                                        aria-controls="tab06_pane"
                                        onclick="document.querySelector('.col-lg-9').classList.remove('newsactive')">
                                        Rating
                                    </a>
                                </li>
                                <li class="nav-item d-none">
                                    <a class="nav-link" id="tab07" data-toggle="tab" href="#tab07_pane" role="tab"
                                        aria-controls="tab07_pane"
                                        onclick="document.querySelector('.col-lg-9').classList.remove('newsactive')">
                                        Videos
                                    </a>
                                </li>
                            </ul>

                            <div class="tab-content">
                                <div class="tab-pane fade" id="tab01_pane" role="tabpanel" aria-labelledby="tab01">
                                    <div class="">


                                        <!-- Post Card with 5 or more Images -->
                                        @forelse($newsstory as $story)
                                        <div class="post-card" data-story-id="{{ $story->id }}">
                                            <div class="post-header">
                                                <div class="profile-pic">
                                                    <img src="{{ config('app.img_url').  (isset($story->user->profile_image) && Storage::disk('public')->exists($story->user->profile_image) ? $story->user->profile_image:"profile_image/default-profile.png") }}" alt="Profile">
                                                </div>
                                                <div class="user-info">
                                                    <h4 class="user-name notranslate" translate="no">{{$story->user->nickname}}</h4>
                                                    <p class="post-time">{{ $story->created_at->format('F j, Y \a\t g:i A') }} <i class="fas fa-globe-americas"></i></p>
                                                </div>


                                            </div>

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
                                                <a href="#" id="btn-{{ $storyId }}" class="" onclick="toggleText({{ $storyId }})">Read more</a>
                                                @endif
                                                <div class="post-images one-image">

                                                    @php
                                                    $ext = strtolower(pathinfo($story->images, PATHINFO_EXTENSION));
                                                    $isVideo = in_array($ext, ['mp4', 'ogg', 'webm', 'avi']);
                                                    @endphp

                                                    @if($isVideo)
                                                    <div class="video-wrapper position-relative">
                                                        <video class="w-100 h-100" poster="{{ url('storage/app/public/' . $story->thumbnail) }}">
                                                            <source src="{{ config('app.img_url'). $story->images }}">
                                                        </video>
                                                        <!-- Play Icon -->
                                                        <div class="play-btn">
                                                            <i class="fa fa-play" ></i>
                                                        </div>
                                                    </div>
                                                    @else
                                                    <img src="{{ config('app.img_url'). $story->images }}"
                                                        alt="Post media"
                                                        class="post-image">
                                                    @endif


                                                </div>
                                            </div>

                                            <div class="post-footer">
                                                <div class="reaction-bar">
                                                    <div class="top-like-count top-like-count-{{ $story->id }}">
                                                        <i class="fas fa-thumbs-up"></i>
                                                        <span class="like-count"> {{ $story->likes->count() }}</span>
                                                    </div>
                                                    <div class="comment-count comment-count-top-{{ $story->id }}">
                                                        @php
                                                        $totalComments = $story->comments->count();
                                                        @endphp
                                                        <span class="comment-total">{{ $totalComments }}</span> {{ $totalComments <= 1 ? 'Comment' : 'Comments' }}
                                                    </div>
                                                </div>
                                                @php
                                                $userlogin = auth()->user();
                                                $userLiked = false;

                                                if ($userlogin) {
                                                $userLiked = $userlogin->likes->where('news_and_story_id', $story->id)->isNotEmpty();
                                                }
                                                @endphp
                                                <div class="action-bar">
                                                    <div class="action-button like-button {{ $userLiked ? 'liked' : '' }}"
                                                        data-story-id="{{ $story->id }}" data-id="{{ $user->id }}">

                                                        {{-- Icon: filled or outline --}}
                                                        <i class="{{ $userLiked ? 'fas' : 'far' }} fa-thumbs-up like-icon {{ $userLiked ? 'text-primary' : '' }}"></i>

                                                        <span class="like-text">I Like</span>
                                                        <span class="like-count d-none">{{ $story->likes->count() }}</span>
                                                    </div>

                                                    <div class="action-button">
                                                        <i class="far fa-comment"></i> Comment
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="comment-section" data-story-id="{{ $story->id }}">
                                                <div class="comment-count comment-count-bottom-{{ $story->id }}">
                                                    <span class="comment-total">{{ $story->comments->count() }}</span> {{ $totalComments <= 1 ? 'Comment' : 'Comments' }}
                                                </div>

                                                <div class="comment-list">
                                                    @if ($story->comments->isEmpty())
                                                    <div class="no-comments">No comments yet</div>
                                                    @else

                                                    @foreach ($story->comments->whereNull('parent_id') as $comment)
                                                    <div class="comment" data-comment-id="{{ $comment->id }}">
                                                        <div class="comment-pic">
                                                            <img src="{{ config('app.img_url').
                                                            (isset($comment->user->profile_image) && Storage::disk('public')->exists($comment->user->profile_image) ? $comment->user->profile_image : 'profile_image/default-profile.png') }}" alt="Profile">
                                                        </div>
                                                        <div class="comment-content">
                                                            <div class="comment-author notranslate" translate="no">{{ $comment->user->nickname }}</div>
                                                            <div class="comment-text">{{ $comment->comment }}</div>
                                                            <div class="comment-actions">
                                                                <span class="comment-like comment-action" data-id="{{ $comment->id }}" data-user-id="{{$user->id}}">
                                                                    👍 <span class="like-count">{{ $comment->likes->count() }}</span>
                                                                </span>
                                                                <span class="comment-reply-toggle comment-action">Reply</span>
                                                                <span class="comment-time comment-action">{{ $comment->created_at->diffForHumans() }}</span>
                                                            </div>
                                                            <div class="reply-section" style="display: none;">
                                                                <input type="text" class="reply-input" placeholder="Write a reply..." />
                                                                <button class="reply-send-btn" data-comment-id="{{ $comment->id }}" data-story-id="{{ $story->id }}" data-user-id="{{$user->id}}">Send</button>
                                                            </div>

                                                            {{-- Show Replies --}}
                                                            <div class="reply-list" data-comment-id="{{ $comment->id }}">
                                                                @foreach ($comment->replies as $reply)
                                                                <div class="comment reply" data-comment-id="{{ $reply->id }}">
                                                                    <div class="comment-pic">
                                                                        <img src="{{ config('app.img_url').
                                                                         (isset($reply->user->profile_image) && Storage::disk('public')->exists($reply->user->profile_image) ? $reply->user->profile_image : 'profile_image/default-profile.png') }}" alt="Profile">
                                                                    </div>
                                                                    <div class="comment-content">
                                                                        <div class="comment-author notranslate" translate="no">{{ $reply->user->nickname }}</div>
                                                                        <div class="comment-text">{{ $reply->comment }}</div>
                                                                        <div class="comment-actions">
                                                                            <span class="comment-reply-toggle comment-action">Reply</span>
                                                                            <span class="comment-time">{{ $reply->created_at->diffForHumans() }}</span>
                                                                        </div>

                                                                        {{-- Reply input for this reply --}}
                                                                        <div class="reply-section" style="display: none;">
                                                                            <input type="text" class="reply-input" placeholder="Write a reply..." />
                                                                            <button class="reply-send-btn"
                                                                                data-comment-id="{{ $reply->id }}"
                                                                                data-story-id="{{ $story->id }}"
                                                                                data-user-id="{{ $user->id }}">
                                                                                Send
                                                                            </button>
                                                                        </div>

                                                                        {{-- Recursive replies --}}
                                                                        <div class="reply-list" data-comment-id="{{ $reply->id }}">
                                                                            @include('partials.replies', ['comment' => $reply, 'story' => $story, 'user' => $user])
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                @endforeach

                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endforeach

                                                    @endif
                                                </div>


                                                @php
                                                $userlogin = auth()->user();

                                                $profileImg = $userlogin && isset($userlogin->profile_image) && Storage::disk('public')->exists($userlogin->profile_image) ? $userlogin->profile_image : null;

                                                $imgUrl = $profileImg
                                                ? config('app.img_url') . $profileImg
                                                : 'https://randomuser.me/api/portraits/lego/2.jpg';
                                                @endphp
                                                <div class="add-comment">
                                                    <div class="comment-pic">
                                                        <img src="{{ $imgUrl }}" alt="Profile">
                                                    </div>

                                                    <input
                                                        type="text"
                                                        class="comment-input"
                                                        placeholder="Write a comment..."
                                                        data-user-name="{{ $userlogin->nickname ?? '' }}" data-id="{{ $userlogin->id ?? ''}}"
                                                        data-profile="{{ $imgUrl }}">
                                                    <a href="" class="comment-send-btn btn btn-maincolor" disabled>Send</a>
                                                </div>

                                            </div>

                                        </div>
                                        @empty
                                        <div class="no-news  py-5">
                                            <h4>No news available</h4>
                                        </div>
                                        @endforelse




                                    </div>
                                </div>

                                <div class="tab-pane fade show active in" id="tab04_pane" role="tabpanel" aria-labelledby="tab04">
                                    <div class="media">
                                        <div class="media-body">
                                            <h5 class="notranslate" translate="no">{{$user->slogan}}</h5>
                                            <div class="description">
                                                <p class="sc-info">
                                                    <i class="fas fa-user"></i><span>{{ $user->displayed_age ?? \Carbon\Carbon::parse($user->dob)->age }} years</span>
                                                </p>
                                                <p class="sc-info">
                                                    <i class="fas fa-venus"></i>
                                                    <span>
                                                        {{$user->gender?->name}}
                                                    </span>
                                                </p>
                                                <p class="sc-info">
                                                    <i class="fas fa-map-marker-alt"></i><span> {{$user->countries?->name}}</span>
                                                </p>
                                            </div>
                                            <p class="notranslate" translate="no">
                                                {{$user->description}}
                                            </p>


                                            <div class="panel">
                                                <div class="location">
                                                    <h3>LOCATION</h3>
                                                    
                                                    <p>{{$user->countries?->name}}, {{ $user->state?->name ?? 'N/A' }}, {{$user->city?->name}}</p>
                                                </div>
                                                <div class="services">
                                                    <h3>Additional Details</h3>
                                                    <p><strong>Phone Number : </strong> +{{ $user->country->code }} {{ $user->phone }}
                                                    </p>
                                                    <p><strong>Ethnicity : </strong> {{ $user->ethnicity->name ?? '-'}}
                                                    </p>
                                                    <p><strong>Body Type  : </strong> {{ $user->bodyType->name ??'' }}
                                                    </p>
                                                    <p><strong>Service Location : </strong> {{ $user->incall_outcall == 1 ? 'In my place' : ($user->incall_outcall == 0 ? 'Hotel and private home visits' : ($user->incall_outcall == 2 ? 'Hotel and private home visits + In my place' : '')) }}
                                                    </p>
                                                    <p><strong>Type Of Service Provider : </strong> {{ $user->sex_location }}
                                                    </p>
                                                    <p><strong>Smoking : </strong> {{ ucfirst($user->smoking) ?? '-' }}
                                                    </p>
                                                    <p><strong>Pubic Hair : </strong> {{ $user->pubicHair->name ?? '-' }}
                                                    </p>
                                                    <p><strong>Nickname : </strong class="notranslate" translate="no">{{ $user->nickname }}</p>
                                                    @if($user->type == 2)
                                                    <p><strong>Nationality : </strong>{{ $user->nationality ?? '-' }}</p>
                                                    @endif
                                                    <p><strong>Height (cm) : </strong> {{ $user->height_cm ?? '-' }}
                                                    </p>
                                                    <p><strong>Weight (kg) : </strong> {{ $user->weight_kg ?? '-' }}
                                                    </p>
                                                    <p><strong>Sexual Orientation : </strong> {{ $user->sexual_orientation ?? '-' }}
                                                    </p>
                                                    <p><strong>Hair Color : </strong> {{ $user->haircolor->name ?? '-' }}
                                                    </p>
                                                    <p><strong>Hair Length : </strong> {{ $user->hairLength->name ?? '-' }}
                                                    </p>
                                                    <p><strong>Hair Type : </strong> {{ $user->hairType->name ?? '-' }}
                                                    </p>
                                                    <p><strong>Eye Color : </strong>{{ $user->eyeColor->name ?? '-' }}
                                                    </p>
                                                    <p><strong>Tattoos : </strong> {{ ucfirst($user->tattoo) ?? '-' }}
                                                    </p>
                                                    <p><strong>Piercings : </strong>{{ ucfirst($user->piercing) ?? '-' }}
                                                    </p>
                                                    <p><strong>Shoe Size : </strong>{{ $user->shoe_size ?? '-' }}
                                                    </p>
                                                    <p><strong>Breast Size : </strong>@php
                                                        $breastSizes = json_decode($user->breast_size ?? '[]', true);
                                                        @endphp

                                                        {{ !empty($breastSizes) ? implode(', ', $breastSizes) : '-' }}
                                                    </p>
                                                    <p><strong class="notranslate" translate="no">OnlyFans : </strong> @if (!empty($user->onlyfans_link))
                                                        <a href="{{ $user->onlyfans_link }}" target="_blank" rel="nofollow noopener">{{ $user->onlyfans_link }}</a>
                                                        @else
                                                        -
                                                        @endif
                                                    </p>
                                                    <p><strong>Instagram : </strong>@if (!empty($user->instagram_link))
                                                        <a href="{{ $user->instagram_link }}" target="_blank" rel="nofollow noopener">{{ $user->instagram_link }}</a>
                                                        @else
                                                        -
                                                        @endif
                                                    </p>
                                                    <p><strong class="notranslate" translate="no">Telegram : </strong>@if (!empty($user->telegram_link))
                                                        <a href="{{ $user->telegram_link }}" target="_blank" rel="nofollow noopener">{{ $user->telegram_link }}</a>
                                                        @else
                                                        -
                                                        @endif
                                                    </p>
                                                    <p><strong>TikTok : </strong>@if (!empty($user->tiktok_link))
                                                        <a href="{{ $user->tiktok_link }}" target="_blank" rel="nofollow noopener">{{ $user->tiktok_link }}</a>
                                                        @else
                                                        -
                                                        @endif
                                                    </p>
                                                </div>
                                                <div class="services">
                                                    <h3>Contact Methods : </h3>
                                                    @php
                                                    $contactMethods = json_decode($user->contact_methods ?? '{}', true);
                                                    @endphp

                                                    @if (!empty($contactMethods))
                                                    <ul class="list-unstyled mb-0">
                                                        @foreach($contactMethods as $method => $value)
                                                        @if(!empty($value))
                                                        <li><strong class="notranslate" translate="no">{{ $method }} : </strong> {{ $value }}</li>
                                                        @endif
                                                        @endforeach
                                                    </ul>
                                                    @else
                                                    <em>No contact methods provided.</em>
                                                    @endif

                                                </div>
                                                
                                                <div class="services">
                                                    <h3>SERVICES : </h3>
                                                    @foreach ($categories as $category)
                                                    @php
                                                    // Filter services that are selected or have selected selections
                                                    $filteredServices = $category->services->filter(function ($service) use ($selectedServices, $selectedSelections) {
                                                    return in_array($service->id, $selectedServices) ||
                                                    $service->selections->pluck('id')->intersect($selectedSelections)->isNotEmpty();
                                                    });

                                                    $entries = [];
                                                    foreach ($filteredServices as $service) {
                                                    // Add the service name
                                                    $entry = $service->name;

                                                    // If it has selected selections, append them
                                                    $selected = $service->selections->filter(function ($selection) use ($selectedSelections) {
                                                    return in_array($selection->id, $selectedSelections);
                                                    })->pluck('name')->toArray();

                                                    if (!empty($selected)) {
                                                    $entry .= ' (' . implode(', ', $selected) . ')';
                                                    }

                                                    $entries[] = $entry;
                                                    }
                                                    @endphp

                                                    @if (!empty($entries))
                                                    <p><strong>{{ $category->name }} : </strong> {{ implode(' / ', $entries) }}</p>
                                                    @endif
                                                    @endforeach

                                                </div>

                                                <div class="services">
                                                    <h3>Languages : </h3>
                                                    @php
                                                    $selectedLanguageIds = json_decode($user->languages ?? '[]', true);
                                                    $selectedLanguages = $language->whereIn('id', $selectedLanguageIds);
                                                    @endphp
                                                    @if ($selectedLanguages->isNotEmpty())
                                                    <ul class="list-unstyled mb-0">
                                                        @foreach($selectedLanguages as $lang)
                                                        <li>{{ $lang->name }}</li>
                                                        @endforeach
                                                    </ul>
                                                    @else
                                                    <em>No languages selected.</em>
                                                    @endif
                                                </div>
                                                <div class="rates">
                                                    <h3>RATES : </h3>
                                                    <div class="mb-3">
                                                        <strong>Offer Quickie Service:</strong>
                                                        <span>{{ $user->quickie_enabled ? 'Yes' : 'No' }}</span>
                                                    </div>

                                                    @if($user->quickie_enabled)
                                                    <!-- If Quickie Service is enabled, show the values -->
                                                    <div class="mb-3">
                                                        <strong>Price : </strong>
                                                        <span>{{ $user->quickie_price ?? 'N/A' }}</span>
                                                    </div>
                                                    @endif
                                                    <div class="mb-3">
                                                        <strong>Currency : </strong>
                                                        <span>{{$user->countries?->currency ?? 'NA'}}</span>
                                                    </div>
                                                    @php
                                                    $durations = [
                                                    '30_min' => '30 Minutes',
                                                    '1_hr' => '1 Hour',
                                                    '90_min' => '90 Minutes',
                                                    '2_hr' => '2 Hours',
                                                    '3_hr' => '3 Hours',
                                                    'overnight' => 'Overnight'
                                                    ];
                                                    @endphp

                                                    <table>
                                                        <thead>
                                                            <tr>
                                                                <th style="color: red;"><strong>Duration</strong></th>
                                                                <th style="color: red;"><strong>Price</strong></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($durations as $key => $label)
                                                            @php
                                                            $rate = $user->quickie_rates[$key] ?? 'N/A';
                                                            @endphp
                                                            <tr>
                                                                <td ><strong>{{ $label }}</strong></td>
                                                                <td>{{$user->countries?->currency ?? 'USD'}}
                                                                {{ format_price_dot($rate) }}</td>
                                                            </tr>
                                                            @endforeach

                                                            {{-- Show overnight hours if available --}}
                                                            @if (!empty($user->quickie_overnight_hours))
                                                            <tr>
                                                                <td><strong>Overnight Duration</strong></td>
                                                                <td>{{ $user->quickie_overnight_hours }} hours</td>
                                                            </tr>
                                                            @endif
                                                        </tbody>
                                                    </table>
                                                    @php
                                                    $methods = is_array($user->payment_method)
                                                    ? $user->payment_method
                                                    : json_decode($user->payment_method, true);
                                                    @endphp

                                                    <div class="mb-2">
                                                        <strong>Payment Method : </strong>
                                                        <span>
                                                            {{ !empty($methods) ? implode(', ', $methods) : 'N/A' }}
                                                        </span>
                                                    </div>
                                                </div>

                                                <div class="rates">
                                                    <h3>Availability : </h3>

                                                    {{-- General Availability Info --}}
                                                    <div class="mb-3">
                                                        <strong>Availability Mode : </strong>
                                                        <span>
                                                            {{ $user->availability_main === 'walk-in' 
                                                                            ? 'Available without appointment' 
                                                                            : 'Available with appointment (By appointment only)' }}
                                                        </span>
                                                    </div>

                                                    @if($user->availability_main === 'walk-in')
                                                    @php
                                                    $walkinTypes = is_array($user->walkin_type)
                                                    ? $user->walkin_type
                                                    : json_decode($user->walkin_type, true);
                                                    @endphp
                                                    <div class="mb-3">
                                                        <strong>Walk-in Options : </strong>
                                                        <span>
                                                            {{ !empty($walkinTypes) 
                                                                            ? implode(', ', array_map('ucwords', $walkinTypes)) 
                                                                            : 'N/A' }}
                                                        </span>
                                                    </div>
                                                    @endif



                                                    {{-- Weekly Schedule --}}
                                                    <table class="table table-bordered mt-3">
                                                        <thead>
                                                            <tr>
                                                                <th style="color: red;">Day</th>
                                                                <th style="color: red;">Start Time</th>
                                                                <th style="color: red;">End Time</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @forelse ($availabilities as $availability)
                                                            <tr>
                                                                <td>{{ ucfirst($availability->day) }}</td>
                                                                <td>{{ date('h:i A', strtotime($availability->start_time)) }}</td>
                                                                <td>{{ date('h:i A', strtotime($availability->end_time)) }}</td>
                                                            </tr>
                                                            @empty
                                                            <tr>
                                                                <td colspan="3" class="text-center">No availability set</td>
                                                            </tr>
                                                            @endforelse
                                                        </tbody>
                                                    </table>
                                                </div>


                                            </div>



                                        </div>
                                    </div>
                                </div>
                                
                                <div class="tab-pane fade" id="tab06_pane" role="tabpanel" aria-labelledby="tab06">
                                    <div class="media flex-column">
                                        @php
                                        $authUser = Auth::user();
                                        $isOwnProfile = $authUser && $authUser->id === $user->id;
                                        $reviews = $user->reviewsReceived;

                                        $total = $reviews->count();
                                        $averageScore = $reviews->avg('rating');
                                        $photoAccurate = $total > 0
                                        ? ($reviews->where('photo_accurate', 1)->count() / $total) * 100
                                        : 0;

                                        $agreementsFulfilled = $total > 0
                                        ? ($reviews->where('agreement_fulfilled', 1)->count() / $total) * 100
                                        : 0;

                                        $smoker = $total > 0
                                        ? ($reviews->where('is_smoker', 1)->count() / $total) * 100
                                        : 0;

                                        $mostCommonHygiene = $reviews->groupBy('hygiene')
                                        ->map(fn($items) => $items->count())
                                        ->sortDesc()
                                        ->keys()
                                        ->first();

                                        $mostCommonAmbience = $reviews->groupBy('ambience')
                                        ->map(fn($items) => $items->count())
                                        ->sortDesc()
                                        ->keys()
                                        ->first();

                                        @endphp
                                        @if (!$authUser)
                                        <!-- Not logged in: Show button, redirect to login -->
                                        <div class="text-right mb-3 pt-5">
                                            <a href="{{ route('user-login') }}" class="btn btn-maincolor">
                                                <i class="fas fa-star"></i> Give Rating
                                            </a>
                                        </div>
                                        @elseif (!$user->checkIsReviewed($authUser->id) && !$isOwnProfile)
                                        <!-- Logged in, not reviewed yet, and not own profile -->
                                        <div class="text-right mb-3 pt-5">
                                            <button class="btn btn-maincolor" data-toggle="modal" data-target="#giveRatingModal">
                                                <i class="fas fa-star"></i> Give Rating
                                            </button>
                                        </div>
                                        @endif


                                        @if ($user->reviewsReceived->isNotEmpty())
                                        {{-- Review Statistics --}}
                                        <div class="review-statistics">
                                            <p>Total score</p>
                                            <div>
                                                <div class="review-score">
                                                    <span>{{ number_format($averageScore, 1) }}</span>
                                                    <div>
                                                        <span class="score">
                                                            <div class="score-wrap">
                                                                <span class="stars-active" style="width: {{ min(100, ($averageScore / 5) * 100) }}%">
                                                                    @for($i = 0; $i < 5; $i++) <i class="fas fa-star" aria-hidden="true"></i> @endfor
                                                                </span>
                                                                <span class="stars-inactive">
                                                                    @for($i = 0; $i < 5; $i++) <i class="far fa-star" aria-hidden="true"></i> @endfor
                                                                </span>
                                                            </div>
                                                        </span>
                                                        <p>{{ $reviews->count() }} Reviews</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <p><b>{{ round($photoAccurate) }}%</b> think the photos are accurate</p>
                                            <p><b>{{ round($agreementsFulfilled) }}%</b> believe the agreements have been fulfilled</p>
                                            <p><b>{{ round($smoker) }}%</b> have indicated that advertiser is a smoker</p>
                                            <p>The average visitor gives <b>{{$mostCommonHygiene}} for hygiene</b></p>
                                            <p>The average visitor is <b>{{$mostCommonAmbience}} with the ambience</b></p>
                                        </div>
                                        @else

                                        <div class="no_review no-news ">
                                            <h3>No reviews have been posted yet.</h3>

                                        </div>
                                        @endif
                                    </div>
                                    
                                        {{-- Top Reviews --}}
                                    <div class="row d-flex flex-lg-row flex-column">
                                        @foreach ($reviews as $review)
                                        <div class="col-12 col-md-6 col-xl-4">
                                            <div class="top-reviews mt-5 " id="reviews-tab-top-reviews">
                                                <div>
                                                    <div class="review-info mb-4 d-flex flex-column">
                                                        <div class="d-flex justify-content-between align-items-center mb-3 w-100">
                                                        <div class="d-flex align-items-center">
                                                                <div class="review-member-profile"><i class="fa fa-user"></i></div>
                                                            <div class="reviewer_name_review_count_badge">
                                                                <p class="reviewer_name_review_count">
                                                                    <span>
                                                                        <b>
                                                                            <a href="{{ route('user.profile.show', ['id' => $review->user_id ]) }}" class="notranslate" translate="no">
                                                                                {{ UserData($review->user_id, ['nickname'])->nickname ?? 'Anonymous' }}
                                                                            </a>
                                                                        </b>
                                                                    </span>
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <div>
                                                                <div class="d-flex align-items-center">
                                                                    <p class="total-score m-0 mr-2">{{ number_format($review->rating, 1) }}</p>
                                                                    <span class="score">
                                                                        <div class="score-wrap">
                                                                            <span class="stars-active" style="width: {{ ($review->rating / 5) * 100 }}%">
                                                                                @for($i = 0; $i < 5; $i++) <i class="fas fa-star" aria-hidden="true"></i> @endfor
                                                                            </span>
                                                                            <span class="stars-inactive">
                                                                                @for($i = 0; $i < 5; $i++) <i class="far fa-star" aria-hidden="true"></i> @endfor
                                                                            </span>
                                                                        </div>
                                                                    </span>
                                                                </div>
                                                                <span class="review-date">
                                                                    <i class="fas fa-clock"></i>
                                                                    <span>{{ \Carbon\Carbon::parse($review->created_at)->format('d-m-Y') }}</span>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    

                                                        <div class="review-description show-more w-100">
                                                            <div class="review-body">
                                                                {!! nl2br(e($review->comment)) !!}
                                                            </div>

                                                            <div class="review-options">
                                                                <div>
                                                                    <p>Are the photos in the ad accurate?</p>
                                                                    <p>{{ $review->photo_accurate ? 'Yes' : 'No' }}</p>
                                                                </div>
                                                                <div>
                                                                    <p>Have the agreements been fulfilled?</p>
                                                                    <p>{{ $review->agreement_fulfilled ? 'Yes' : 'No' }}</p>
                                                                </div>
                                                                <div>
                                                                    <p>Is advertiser a smoker?</p>
                                                                    <p>{{ $review->is_smoker ? 'Yes' : 'No' }}</p>
                                                                </div>
                                                                <div>
                                                                    <p>Hygiene</p>
                                                                    <p>{{ ucfirst($review->hygiene) }}</p>
                                                                </div>
                                                                <div>
                                                                    <p>Ambience</p>
                                                                    <p>{{ ucfirst($review->ambience) }}</p>
                                                                </div>
                                                                @if ($review->service_rating)
                                                                <div>
                                                                    <p>{{ $review->service_name ?? 'Service' }}</p>
                                                                    <span class="score">
                                                                        <div class="score-wrap">
                                                                            <span class="stars-active" style="width: {{ ($review->service_rating / 5) * 100 }}%">
                                                                                @for($i = 0; $i < 5; $i++) <i class="fas fa-star" aria-hidden="true"></i> @endfor
                                                                            </span>
                                                                            <span class="stars-inactive">
                                                                                @for($i = 0; $i < 5; $i++) <i class="far fa-star" aria-hidden="true"></i> @endfor
                                                                            </span>
                                                                        </div>
                                                                    </span>
                                                                </div>
                                                                @endif
                                                            </div>

                                                            @if ($review->provider_reply)
                                                            <hr>
                                                            <div class="respond-review">
                                                                <div class="review-member-profile">
                                                                    <i class="fa fa-user"></i>
                                                                </div>
                                                                <div>
                                                                    <div class="review-info">
                                                                        <p><span class="notranslate" translate="no"><b>{{ $user->nickname }}</b></span></p>
                                                                        <div>
                                                                            <span class="review-date">
                                                                                <i class="fas fa-clock"></i>
                                                                                <span>{{ $review->provider_reply->created_at->diffForHumans() }}</span>
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="mt-1">
                                                                        {{ $review->provider_reply->comment }}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>


                                <!-- Videos Tab -->
                                <!-- NewTab -->
                                <div class="tab-pane fade" id="tab07_pane" role="tabpanel" aria-labelledby="tab07">
                                    <div class="media-body">
                                        <!-- <h5>New Tab</h5> -->
                                        <div class="container-fluid">
                                            <div class="row">                                                       
                                                <!-- Card 1 -->
                                                 @php
                                                    $videoShow = false;
                                                 @endphp
                                                @if (!empty($user->videos))
                                                    @foreach ($user->videos as $video)
                                                        @if ($video->is_approved == 1) 
                                                            @php
                                                                $videoShow = true;
                                                            @endphp
                                                            <div class="col-md-4 mb-4">
                                                                <div class="card shadow-sm">
                                                                    <div class="video-wrapper position-relative">
                                                                        <video class="custom-video w-100">
                                                                            <source src="{{ config('app.img_url'). $video->file_path }}" >
                                                                        </video>
                                                                        <!-- Play Icon -->
                                                                        <div class="play-btn">
                                                                            <i class="fa fa-play"></i>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                @endif                                            
                                            </div>
                                        </div>
                                    </div>
                            <!-- tabs end-->
                                </div>
                    </div>



                    <div class="fw-divider-space hidden-below-lg mt-20"></div>
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

<!-- Fancybox JS -->
<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui/dist/fancybox.umd.js"></script>

<div class="modal fade" id="reviewModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="reviewModalLabel">Place a Review</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">

                <!-- Agreements -->
                <h6>Agreements</h6>
                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                    <button class="btn btn-maincolor btn-outline-main option-btn" data-category="agreements">No</button>
                    <button class="btn btn-maincolor btn-outline-main option-btn" data-category="agreements">Yes</button>
                </div>

                <!-- Smoking -->
                <h6 class="mt-4">Smoking</h6>
                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                    <button class="btn btn-maincolor btn-outline-main option-btn" data-category="smoking">No</button>
                    <button class="btn btn-maincolor btn-outline-main option-btn" data-category="smoking">Yes</button>
                    <button class="btn btn-maincolor btn-outline-main option-btn" data-category="smoking">Unknown</button>
                </div>

                <!-- Photos -->
                <h6 class="mt-4">Photos</h6>
                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                    <button class="btn btn-maincolor btn-outline-main option-btn" data-category="photos">No</button>
                    <button class="btn btn-maincolor btn-outline-main option-btn" data-category="photos">Yes</button>
                </div>

                <!-- Ambience -->
                <h6 class="mt-4">Ambience</h6>
                <div class="btn-group btn-group-toggle d-flex flex-wrap" data-toggle="buttons">
                    <button class="btn btn-maincolor btn-outline-main flex-fill option-btn" data-category="ambience">Dissatisfied</button>
                    <button class="btn btn-maincolor btn-outline-main flex-fill option-btn" data-category="ambience">Moderate</button>
                    <button class="btn btn-maincolor btn-outline-main flex-fill option-btn" data-category="ambience">Satisfied</button>
                    <button class="btn btn-maincolor btn-outline-main flex-fill option-btn" data-category="ambience">Very satisfied</button>
                    <button class="btn btn-maincolor btn-outline-main flex-fill option-btn" data-category="ambience">Excellent</button>
                </div>

                <!-- Hygiene -->
                <h6 class="mt-4">Hygiene</h6>
                <div class="btn-group btn-group-toggle d-flex flex-wrap" data-toggle="buttons">
                    <button class="btn btn-maincolor btn-outline-main flex-fill option-btn" data-category="hygiene">Dissatisfied</button>
                    <button class="btn btn-maincolor btn-outline-main flex-fill option-btn" data-category="hygiene">Moderate</button>
                    <button class="btn btn-maincolor btn-outline-main flex-fill option-btn" data-category="hygiene">Satisfied</button>
                    <button class="btn btn-maincolor btn-outline-main flex-fill option-btn" data-category="hygiene">Very satisfied</button>
                    <button class="btn btn-maincolor btn-outline-main flex-fill option-btn" data-category="hygiene">Excellent</button>
                </div>

                <!-- Experience Textarea -->
                <h6 class="mt-4">How was your experience? (min. 50 characters)</h6>
                <div class="form-group">
                    <textarea id="experienceText" class="form-control" rows="4" maxlength="1200" placeholder="Describe your experience..."></textarea>
                    <small class="form-text text-muted"><span id="charCount">0</span> / 1200</small>
                </div>

                <!-- Total Score -->
                <h6>Total Score</h6>
                <div class="rating-stars" id="ratingStars">
                    <i class="fa fa-star" data-value="1"></i>
                    <i class="fa fa-star" data-value="2"></i>
                    <i class="fa fa-star" data-value="3"></i>
                    <i class="fa fa-star" data-value="4"></i>
                    <i class="fa fa-star" data-value="5"></i>
                </div>

            </div>

            <div class="modal-footer text-center">
                <button type="button" class="btn btn-maincolor mx-auto text-center">Send</button>
            </div>

        </div>
    </div>
</div>

<!-- Modal -->

<!-- Give Rating Modal -->
<div class="modal fade" id="giveRatingModal" tabindex="-1" role="dialog" aria-labelledby="giveRatingModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form id="giveRatingForm">
            @csrf
            <input type="hidden" name="reviewed_user_id" value="{{ $user->id }}">

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Give Rating</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <label>Rating (1-5)</label>
                        <select name="rating" class="form-control" required>
                            <option value="">Select rating</option>
                            @for ($i = 5; $i >= 1; $i--)
                            <option value="{{ $i }}">{{ $i }} Star{{ $i > 1 ? 's' : '' }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Comment</label>
                        <textarea name="comment" class="form-control" required></textarea>
                    </div>

                    <div class="form-group">
                        <label>Are the photos accurate?</label>
                        <select name="photo_accurate" class="form-control">
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Have the agreements been fulfilled?</label>
                        <select name="agreement_fulfilled" class="form-control">
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Is the advertiser a smoker?</label>
                        <select name="is_smoker" class="form-control">
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Hygiene</label>
                        <select name="hygiene" class="form-control" required>
                            <option value="excellent">Excellent</option>
                            <option value="average">Average</option>
                            <option value="poor">Poor</option>
                        </select>

                    </div>

                    <div class="form-group">
                        <label>Ambience</label>
                        <select name="ambience" class="form-control" required>
                            <option value="very satisfying">Very Satisfying</option>
                            <option value="satisfying">Satisfying</option>
                            <option value="average">Average</option>
                            <option value="poor">Poor</option>
                        </select>
                    </div>



                    <div class="modal-footer">
                        <button type="submit" class="btn btn-maincolor">Submit Review</button>
                    </div>
                </div>
        </form>
    </div>
</div>



<!-- New Tab end -->


@endsection
@push('js')





<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>

<link href="https://cdn.jsdelivr.net/npm/lightbox2@2.11.3/dist/css/lightbox.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/lightbox2@2.11.3/dist/js/lightbox.min.js"></script>


<!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- post-card-js  -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const urlParams = new URLSearchParams(window.location.search);
        const activeTab = urlParams.get('tab');
        const storyId = urlParams.get('story_id');

        // Activate tab if "tab=feeds" is in URL
        if (activeTab === 'feeds') {
            // Activate the Feeds tab
            const feedsTab = document.querySelector('a[href="#tab01_pane"]');
            if (feedsTab) {
                feedsTab.click();

                // Ensure the tab content has loaded before scrolling
                setTimeout(() => {
                    if (storyId) {
                        const targetStory = document.querySelector(`.post-card[data-story-id="${storyId}"]`);
                        if (targetStory) {
                            targetStory.scrollIntoView({
                                behavior: 'smooth',
                                block: 'start'
                            });
                            targetStory.classList.add('highlight');
                            setTimeout(() => targetStory.classList.remove('highlight'), 2000);
                        }
                    }
                }, 500); // Adjust delay if needed
            }
        }
    });




    const isLoggedIn = @json(Auth::check());

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
            success: function(response) {
                // Show Swal success
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
</script>
<script>
    $(document).on('click', '.comment-like', function() {
        if (!isLoggedIn) {
            alert("You must be logged in to like a comment.");
            return;
        }
        let commentId = $(this).data('id');
        let userId = $(this).data('user-id');

        let likeBtn = $(this);
        let likeUrl = `{{ route('comments.like', ':id') }}`.replace(':id', commentId);

        $.ajax({
            url: likeUrl,

            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                user_id: userId
            },
            success: function(res) {
                likeBtn.find('.like-count').text(res.likes);
            }
        });
    });

    $(document).on('click', '.comment-reply-toggle', function() {
        if (!isLoggedIn) {
            alert("You must be logged in to like a comment.");
            return;
        }
        $(this).closest('.comment-content').find('.reply-section').toggle();
    });

    $(document).on('click', '.reply-send-btn', function() {
        if (!isLoggedIn) {
            alert("You must be logged in to like a comment.");
            return;
        }
        let commentId = $(this).data('comment-id');
        let userId = $(this).data('user-id');
        let storyId = $(this).data('story-id');
        let input = $(this).siblings('.reply-input');
        let text = input.val().trim();
        let commentUrl = `{{ route('comments.reply', ':id') }}`.replace(':id', commentId);

        if (!text) return; // prevent empty replies

        $.ajax({
            url: commentUrl,
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                user_id: userId,
                comment: text,
                story_id: storyId
            },
            success: function(reply) {
                let replyHtml = `
                <div class="comment reply">
                    <div class="comment-pic">
                        <img src="${reply.profile_image}" alt="Profile">
                    </div>
                    <div class="comment-content">
                        <div class="comment-author notranslate" translate="no">${reply.user_name}</div>
                        <div class="comment-text">${reply.comment}</div>
                        <div class="comment-actions">
                            <span class="comment-action">Just now</span>
                        </div>
                    </div>
                </div>
            `;

                // Append to the reply list under the current comment
                $(`.reply-list[data-comment-id="${commentId}"]`).append(replyHtml);

                input.val(''); // Clear the input field
            }
        });
    });


    $(document).ready(function() {
        // Enable/disable Send button based on input
        $('.comment-input').on('input', function() {
            const sendBtn = $(this).siblings('.comment-send-btn');
            sendBtn.prop('disabled', $(this).val().trim() === '');
        });

        // Handle Send button click
        $('.comment-send-btn').on('click', function(e) {
            e.preventDefault();
            if (!isLoggedIn) {
                alert("You must be logged in to like a comment.");
                return;
            }
            const button = $(this);
            const input = button.siblings('.comment-input');
            const comment = input.val().trim();
            if (!comment) return;

            const section = button.closest('.comment-section');
            const storyId = section.data('story-id');
            const userName = input.data('user-name');
            const userId = input.data('id');
            const profile = input.data('profile');
            const commentList = section.find('.comment-list');


            // Disable the input and button while sending
            input.prop('disabled', true);
            button.prop('disabled', true).text('Sending...');

            $.ajax({
                url: "{{ route('comments.store') }}",
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    news_and_story_id: storyId,
                    comment: comment,
                    user_id: userId
                },
                success: function(res) {
                    console.log(res);
                    input.val('').prop('disabled', false);
                    button.prop('disabled', true).text('Send');
                    section.find('.no-comments').remove();

                    const newComment = `
                    <div class="comment">
                        <div class="comment-pic">
                            <img src="${profile}" alt="Profile">
                        </div>
                        <div class="comment-content">
                            <div class="comment-author">${userName}</div>
                            <div class="comment-text">${comment}</div>
                            <div class="comment-actions">
                                <span class="comment-like comment-action" data-id="${res.comment_id ?? ''}" data-user-id="{{$user->id}}"> Like</span>
                                
                                <span class="comment-action">Just now</span>
                            </div>
                        </div>
                    </div>`;

                    commentList.append(newComment);
                    $(`.comment-count-top-${storyId} .comment-total, .comment-count-bottom-${storyId} .comment-total`)
                        .text(function(i, oldText) {
                            return parseInt(oldText) + 1;
                        });

                },
                error: function(err) {
                    alert('Error submitting comment');
                    input.prop('disabled', false);
                    button.prop('disabled', false).text('Send');
                }
            });
        });
    });
    $(document).on('click', '.like-button', function() {

        if (!isLoggedIn) {
            alert("You must be logged in to like a comment.");
            return;
        }
        var button = $(this);
        var storyId = button.data('story-id');
        var likeText = button.find('.like-text');
        var likeCountElement = button.find('.like-count');
        var topCountElement = $('.top-like-count-' + storyId).find('.like-count');
        var icon = button.find('.like-icon');
        var userId = button.data('id');

        $.ajax({
            url: '{{ route("like.toggle") }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                news_and_story_id: storyId,
                user_id: userId
            },
            success: function(res) {

                let count = parseInt(likeCountElement.text());

                if (res.status === 'liked') {
                    // Only increase once
                    if (!button.hasClass('liked')) {
                        likeCountElement.text(count + 1);
                        topCountElement.text(count + 1);
                    }

                    button.addClass('liked');
                    likeText.text('I Like');
                    icon.removeClass('far').addClass('fas text-primary');
                } else if (res.status === 'unliked') {
                    // Only decrease once
                    if (button.hasClass('liked')) {
                        likeCountElement.text(count - 1);
                        topCountElement.text(count - 1);
                    }

                    button.removeClass('liked');
                    likeText.text('I Like');
                    icon.removeClass('fas text-primary').addClass('far');
                }
            },
            error: function() {
                alert('Please login or try again.');
            }
        });
    });
</script>

















<script>
    const newsList = document.getElementById('newsList');
    let scrollSpeed = 0.5; // speed of scroll
    let direction = 1; // 1 = scroll down, -1 = scroll up
    let isFinished = false; // stop after reaching top

    function autoScroll() {
        if (isFinished) return; // if finished, stop

        newsList.scrollTop += scrollSpeed * direction;

        // If reached bottom
        if (newsList.scrollTop + newsList.clientHeight >= newsList.scrollHeight) {
            direction = -1; // start scrolling UP
        }
        // If reached top again after scrolling up
        if (newsList.scrollTop <= 0 && direction === -1) {
            isFinished = true; 
        }
    }

    let scrollInterval = setInterval(autoScroll, 20);
    $(document).ready(function() {
        $('#giveRatingForm').on('submit', function(e) {
            e.preventDefault();

            var form = $(this);
            var btn = form.find('button[type="submit"]');
            var originalText = btn.html();

            btn.prop('disabled', true).html('Submitting...');

            $.ajax({
                url: '{{ route("review.store") }}',
                type: 'POST',
                data: form.serialize(),
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: response.message || 'Review submitted successfully.',
                        confirmButtonColor: '#3085d6',
                    }).then(() => {
                        $('#giveRatingModal').modal('hide');
                        form[0].reset();
                        location.reload();
                    });
                },
                error: function(xhr) {
                    var msg = 'Something went wrong.';
                    if (xhr.status === 409) {
                        msg = xhr.responseJSON.message;
                    } else if (xhr.responseJSON && xhr.responseJSON.errors) {
                        msg = Object.values(xhr.responseJSON.errors).join("\n");
                    }

                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: msg,
                        confirmButtonColor: '#d33',
                    });
                },
                complete: function() {
                    btn.prop('disabled', false).html(originalText);
                }
            });
        });
    });
</script>


<script>
    // const thumbnailSlider = new Swiper(".thumbnail-slider", {
    //     spaceBetween: 10,
    //     slidesPerView: 'auto', // ✅ let Swiper size slides automatically
    //     freeMode: false, // ✅ turn off freeMode for equal spacing
    //     watchSlidesProgress: true,
    //     slideToClickedSlide: true,
    //     scrollbar: {
    //         el: ".thumbnail-slider .swiper-scrollbar",
    //         draggable: true,
    //     },
    // });

    // const mainSlider = new Swiper(".main-slider", {
    //     spaceBetween: 10,
    //     navigation: {
    //         nextEl: ".swiper-button-next",
    //         prevEl: ".swiper-button-prev",
    //     },
    //     thumbs: {
    //         swiper: thumbnailSlider,
    //     },
    // });

    window.addEventListener('load', function() {
    var thumbSwiper = new Swiper('.thumbnail-slider', {
        slidesPerView: 'auto',
        spaceBetween: 10,
        watchSlidesProgress: true,
        loop: false,
    });

    var mainSwiper = new Swiper('.main-slider', {
        slidesPerView: 1,
        spaceBetween: 10,
        loop: false,
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        thumbs: {
            swiper: thumbSwiper
        }
    });

    mainSwiper.update();
    thumbSwiper.update();
});

</script>


<script>
  Fancybox.bind("[data-fancybox='gallery']", {
    Toolbar: {
      display: ["zoom","fullscreen","close"]
    },
    Thumbs: false,
  });
$(document).ready(function() {
    var videoShow = '{{ $videoShow }}';
    videoShow == '1' ? $("#tab07").closest("li").removeClass("d-none"):"";
});
</script>

@endpush