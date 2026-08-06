@extends('front.layout.layout')
@section('content')

  <style>
    body::-webkit-scrollbar {
      display: none;
      /* Chrome, Safari, Opera */
    }

    .reels-main-box {
      margin-top: 155px;
    }

    .reels-bg-img {
      background-repeat: no-repeat;
      background-position: center;
      background-size: contain;
    }

    .profile-media::before {
      content: "";
      position: absolute;
      inset: 0;
      background: linear-gradient(to top, rgb(0 0 0 / 50%), rgba(0, 0, 0, 0));

    }

    .reels-bg-video {
      object-fit: contain;
      object-position: center;
    }

    button.reel-action-button.like-button.liked i {
      color: #dc3545 !important;
    }

    .reel-action-button {
      background: none;
      border: none;
      padding: 0;
    }

    .gallery video {
      width: 100%;
      height: 150px;
      object-fit: cover;
      border-radius: 6px;

    }

    .reels-detail-ui i {
      font-size: 24px;
    }

    .reels-card {
      height: calc(100vh - 165px);
      margin-top: 2.5rem;
      max-width: 1200px;
      margin: auto;
      overflow-y: scroll;
      scroll-snap-type: y mandatory;

      /* Hide scrollbar for this container only */
      scrollbar-width: none;
      /* Firefox */
      -ms-overflow-style: none;
      /* IE and Edge */
    }

    .reels-card::-webkit-scrollbar {
      display: none;
      /* Chrome, Safari, Opera */
    }

    .reels-border {
      border-color: #4d4d4d !important;
    }

    .profile-section {
      display: flex;
      height: calc(100dvh - 165px);
      overflow: hidden;
      color: #fff;
      scroll-snap-align: start;
      justify-content: space-between
    }

    .profile-media {
      position: relative;
      background-size: cover;
      background-position: center;
      /* flex: 2; */
      width: 650px;
      background: #000;
    }

    .profile-overlay {
      position: absolute;
      bottom: 20px;
      left: 20px;
    }

    .profile-overlay h5 {
      margin: 0;
      font-weight: bold;
    }

    .profile-overlay p {
      margin: 0;
      font-size: 14px;
      opacity: 0.8;
    }

    .fs-14 {
      font-size: 12px;
      line-height: 1.2;
    }

    .action-icons {
      position: absolute;
      right: 15px;
      bottom: 0%;
      display: flex;
      flex-direction: column;
      align-items: center;
    }

    .action-icons img {
      width: 40px;
      height: 40px;
      border-radius: 100%;
      margin-bottom: 15px;
      object-fit: cover;
    }

    .action-icons i {
      font-size: 22px;
      margin-bottom: 15px;
      cursor: pointer;
    }

    .profile-info {
      background: #111;
      width: 400px;
      padding: 15px;
      overflow-y: scroll;
      /* or auto if you want it to appear when needed */
      scrollbar-width: none;
      /* Firefox */
    }

    /* For Chrome, Edge, Safari */
    .profile-info::-webkit-scrollbar {
      display: none;
    }


    .stats {
      display: flex;
      justify-content: space-between;
      margin-bottom: 10px;
      text-align: center;
    }

    .stats img {
      width: 50px;
      height: 50px;
      border-radius: 100%;
      object-fit: cover;
    }

    .stats div {
      flex: 1;
    }

    .stats strong {
      display: block;
      font-size: 14px;
    }

    .stats p {

      font-size: 14px;
    }

    .gallery {
      margin-top: 15px;
    }

    .gallery img {
      width: 100%;
      height: 150px;
      object-fit: cover;
      border-radius: 6px;
      /* margin-bottom: 10px; */
    }

    .total-view-btn {
      position: absolute;
      bottom: 8px;
      left: 8px;
    }

    .fav-btn {
      position: absolute;
      bottom: 8px;
      right: 8px;
    }




    .gallery p {
      margin-bottom: 0;
      font-size: 12px;
      line-height: 1.2;
      margin-top: 5px;
    }

    .reels-model-name i {
      color: #1C8EFB;
    }

    .reels-card i {
      color: #fff !important;
    }

    .btn.btn-block.btn-maincolor {
      width: fit-content;
      margin: auto;
    }

    @media (max-width: 768px) {

      .profile-section {
        /* flex-direction: column; */
        justify-content: center;
        height: 100vh;
      }

      .profile-media {
        height: calc(100dvh - 100px);
      }

      .profile-info {
        height: auto;
      }

      .reels-card {
        margin-top: 192px;
      }
    }



    @media screen and (max-width:820px) {
      .reels-card {
        height: calc(100vh - 0px);

      }
    }


    @media screen and (min-width:1025px) {
      .mobile-close {
        display: none;
      }
    }






    /* === Mobile right-drawer popup for profile-info === */
    @media (max-width: 1024px) {


      /* freeze page scroll when popup open */
      body.no-scroll {
        overflow: hidden;
      }

      /* .reels-card {
                          height: calc(100vh - 0px);

                        } */

      .profile-media {
        width: 100%;
      }

      /* slide-in drawer */
      .profile-info {
        position: fixed !important;
        top: 0;
        right: -100%;
        height: 100vh;
        width: 85vw;
        /* responsive width */
        max-width: 420px;
        z-index: 1050;
        transition: right .28s ease-in-out;
        /* keep your existing background/scroll styles */
      }

      .profile-info.mobile-active {
        right: 0;
      }

      /* dark backdrop behind the drawer */
      .mobile-backdrop {
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, .55);
        opacity: 0;
        pointer-events: none;
        z-index: 1040;
        transition: opacity .2s ease-in-out;
      }

      .mobile-backdrop.show {
        opacity: 1;
        pointer-events: auto;
      }

      /* close (×) button inside the drawer */
      .profile-info .mobile-close {
        background: transparent;
        border: 0;
        color: #fff;
        font-size: 28px;
        line-height: 1;
        position: sticky;
        /* stays at top when scrolling drawer */
        top: 0;
        float: right;
        padding: 8px 6px;
        cursor: pointer;
        z-index: 2;
      }

      /* make left-side name clearly tappable on mobile */
      .profile-overlay {
        cursor: pointer;
      }
    }



    body {
      padding-top: 0px !important;
    }



    .filter-btn-float {
      right: 5%;
      top: 20px;
      padding: 5px 10px;
      margin-left: auto;
      display: block;
      margin-top: 1rem !important;
      margin-right: 0rem !important;
      position: relative;
    }

    div#reelsContainer {
      max-width: 96%;
    }

    .reels-card {
      margin-top: -2.5rem;
    }

    .reels-card:has(.btn-block) {
      margin-top: 0px !important;
    }

    @media (max-width: 1500px) {

      .filter-btn-float {
        right: 0%;
      }

    }

    @media (max-width: 1280px) {

      .filter-btn-float {
        right: 0%;
      }

    }

    @media (max-width: 992px) {

      div#reelsContainer {
        max-width: 100%;
      }

      .reels-card {
        margin-top: -20px;
      }

    }


    @media (max-width: 767px) {
      .reels-main-box {
        margin-top: 12rem;
      }

      .profile-media {
        height: calc(100dvh - 220px);
      }

      button.filter-btn-float {
        z-index: 9;
      }

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

  </style>


  <div class="reels-main-box">
    <div class="container-fluid">


      <button type="button" class="filter-btn-float" data-toggle="modal" data-target="#exampleModal">
        <i class="fa-solid fa-filter"></i>
      </button>


      <!-- Modal -->
      <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Search Filter</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="col-12 mb-4 px-0">
                <label>Country</label>
                <select id="country" onchange="return fetchState($(this))" name="country" class="form-control">
                  <option value="">Worldwide (All The Countries)</option>
                  @foreach ($country as $_country)
                    <option value="{{ $_country["id"] }}">{{ $_country["country"] }}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-12 mb-4 px-0">
                <label>State</label>
                <select id="state" onchange="return fetchCity($(this))" name="state" class="form-control">
                </select>
              </div>
              <div class="col-12 mb-4 px-0">
                <label>City</label>
                <select id="city" name="city" class="form-control">
                </select>
              </div>
              <div class="col-12 mb-4 px-0">
                <button type="button" class="btn-maincolor py-2 mx-auto getReels">Search</button>
              </div>
            </div>
          </div>
        </div>
      </div>




      <div class="reels-card">
        @forelse($allUsers as $users)
          @php

            $ext = strtolower(pathinfo($users->images, PATHINFO_EXTENSION));
            $isVideo = in_array($ext, ['mp4', 'mov', 'webm', 'avi']);
            $storyId = $users->id;
            $text = strip_tags($users->description);
            $words = explode(' ', $text);
            $preview = implode(' ', array_slice($words, 0, 20));
            $hasMore = count($words) > 20;
            $userlogin = auth()->user();
            $userLiked = false;
            $views = getBoostedViews($users->reviewsReceived->count(), $users->id);
            $firstStory = $users->stories->first();

            $mediaFile = null;
            $isVideo = false;

            if ($firstStory) {
              $file = $firstStory->images ?? $firstStory->videos;
              $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
              $isVideo = in_array($ext, ['mp4', 'ogg', 'webm', 'avi']);
              $mediaFile = $file;
            }
          @endphp
          @if($users->stories->count() > 0)

            <div class="profile-section mb-5" id="reelsContainer">
              <div class="profile-media">
                @if($firstStory && $isVideo)
                  {{-- Show video if first post is video --}}
                  <div class="video-wrapper position-relative">
    
                      <video class="w-100 h-100 object-cover reels-bg-video myVideo" poster="{{ url('storage/app/public/' . $firstStory->thumbnail) }}">
                          <source src="{{ config('app.img_url'). $mediaFile }}">
                      </video>

                      <!-- Play Icon -->
                      <div class="play-btn">
                          <i class="fa fa-play"></i>
                      </div>

                  </div>
                  <!-- <video class="w-100 h-100 object-cover reels-bg-video" loop>
                    <source src="{{ config('app.img_url'). $mediaFile }}" type="video/mp4">
                  </video> -->
                @else

                  <div class="w-100 h-100 bg-cover bg-center reels-bg-img"
                    style="background-image: url('{{ $firstStory ? config('app.img_url') . $mediaFile : config('app.img_url') . (isset($users->profile_image) && Storage::disk('public')->exists($users->profile_image) ? $users->profile_image :"profile_image/default-profile.png" )}}');">
                  </div>
                @endif

                <div class="profile-overlay">
                  <h5 class="notranslate" translate="no">{{$users->nickname}} <i class="fas fa-check-circle text-primary"></i></h5>
                  <p class="notranslate" translate="no">@ {{$users->nickname}} · #{{$users->sexual_orientation}} #{{$users->sex_location}} </p>
                </div>
                <div class="action-icons text-center">
                  @if(isset($users->profile_image) && Storage::disk('public')->exists($users->profile_image))
                  <img src="{{config('app.img_url') . $users->profile_image }}" alt="">
                  @else
                  <img src="{{ asset('storage/profile_image/default-profile.png') }}" alt="">
                  @endif
                  <button class="reel-action-button like-button {{ $userLiked ? 'liked' : '' }}"
                    data-story-id="{{ $firstStory->id }}" data-id="{{ auth()->id() }}">
                    <i
                      class="{{ $userLiked ? 'fas' : 'far' }} fa-heart fa-solid action-icon {{ $userLiked ? 'text-danger' : '' }}"></i>
                    <span class="like-count">{{ $firstStory->likes->count() }}</span>
                  </button>
                  <a href="{{ route('user.profile.show', ['id' => $users->id]) }}?tab=feeds&story_id={{ $firstStory->id }}"
                    class="reel-action-button comment-button" data-id="{{ $users->id }}"
                    data-story-id="{{ $firstStory->id }}">
                    <i class="fas fa-comment action-icon"></i>
                    <span>{{ $firstStory->comments->count() }}</span>
                  </a>
                  <button class="reel-action-button" onclick="shareReel({{ $firstStory->id }})">
                    <i class="fas fa-share action-icon"></i>
                    <span></span>
                  </button>
                </div>
              </div>






              <div class="profile-info">
                <div class="reels-model-name">
                  <h6 class="text-center notranslate" translate="no">{{$users->nickname}} <i class="fas fa-check-circle text-primary"></i></h6>
                </div>
                <hr class="reels-border my-2">
                <h6 class="mt-3 mb-2 notranslate" translate="no">{{$users->slogan}}</h6>
                <div class="stats">
                  <div>
                    @if(isset($users->profile_image) && Storage::disk('public')->exists($users->profile_image))
                    <img src="{{ config('app.img_url') . $users->profile_image }}" alt="">
                    @else
                    <img src="{{ asset('storage/profile_image/default-profile.png') }}" alt="">
                    @endif
                  </div>
                  <div>
                    <p>
                      <strong>{{ $users->stories->count() }}</strong> Posts
                    </p>
                  </div>
                  <div>
                    <p>
                      <strong>{{ number_format($views['count']) }} </strong> {{ Str::plural('View', $views['count']) }}
                    </p>
                  </div>
                  <!-- <div>
                                                                          <p>
                                                                            <strong>78.7k</strong> Followers
                                                                          </p>
                                                                        </div> -->
                </div>
                <div class="d-flex align-items-center reels-detail-ui">
                  <!-- <button class="btn  btn-maincolor cards-btn w-100 mr-1">Follow</button> -->
                  <a href="{{ route('user.profile.show', $users->id) }}"
                    class="btn btn-maincolor cards-btn view-prof-btn w-100 ml-1">View Profile</a>
                  <a href="https://api.whatsapp.com/send?text={{ urlencode(route('user.profile.show', $users->id)) }}"
                    target="_blank">
                    <i class="fab fa-whatsapp ml-2"></i>
                  </a>
                  <a href="https://t.me/share/url?url={{ urlencode(route('user.profile.show', $users->id)) }}&text={{ urlencode($users->nickname . '\'s profile') }}"
                    target="_blank">
                    <i class="fab fa-telegram-plane ml-2"></i>
                  </a>

                </div>
                <p style="" class="mt-2 fs-14 notranslate" translate="no">
                  <span>{{ $preview }}
                    @if ($hasMore)
                      <span id="dots-{{ $storyId }}">...</span>
                      <span id="more-{{ $storyId }}" class="more-text">{{ implode(' ', array_slice($words, 20)) }}</span>
                    @endif</span>
                  @if ($hasMore)
                    <a id="btn-{{ $storyId }}" onclick="toggleText({{ $storyId }})">Read more</a>
                  @endif
                </p>
                <div class="gallery row">
                  @foreach($users->stories as $key => $story)
                    @php
                      $ext = strtolower(pathinfo($story->images ?? $story->videos, PATHINFO_EXTENSION));
                      $isVideo = in_array($ext, ['mp4', 'mov', 'webm', 'avi']);
                      $mediaFile = $story->images ?? $story->videos;
                    @endphp

                    {{-- first media: show big or highlighted --}}

                    <div class="col-6">
                      <!--  -->
                        <div class="position-relative h-100">
                          @if($isVideo)
                          <div class="video-wrapper position-relative">
    
                              <video class="w-100 object-cover reels-bg-video myVideo" poster="{{ url('storage/app/public/' . $story->thumbnail) }}">
                                  <source src="{{ config('app.img_url'). $mediaFile }}">
                              </video>

                              <!-- Play Icon -->
                              <div class="play-btn">
                                  <i class="fa fa-play"></i>
                              </div>

                          </div>
                          @else
                          <a href="{{ route('user.profile.show', ['id' => $users->id]) }}?tab=feeds&story_id={{ $story->id }}">
                          <img src="{{ config('app.img_url') . $mediaFile }}" alt="User Post" class="w-100 rounded" />
                          </a>
                          @endif

                          <div class="fav-btn"><button class="reel-action-button like-button {{ $userLiked ? 'liked' : '' }}"
                              data-story-id="{{ $story->id }}" data-id="{{ auth()->id() }}">
                              <i
                                class="{{ $userLiked ? 'fas' : 'far' }} fa-heart fa-solid action-icon {{ $userLiked ? 'text-danger' : '' }}"></i>
                              <span class="like-count">{{ $story->likes->count() }}</span>
                            </button></div>
                        </div>
                    </div>

                  @endforeach
                </div>

              </div>
            </div>
            <hr>
          @endif
        @empty
          <p class="btn btn-block btn-maincolor">No users found.</p>
        @endforelse

      </div>
      <div class="row">
          <div class="col-lg-12 text-justify locationSeoContent">
              {!! $locationSeoContent['data']->content ?? "" !!}
          </div>
      </div> 
    </div>
  </div>
  <!-- <div class="reels_main_container">
                        <a href="index.blade.php" class="home"><i class="fa-solid fa-house-chimney"></i></a>
                        <div class="filter-buttons">
                            <div class="filter-group">
                                <button class="filter-button" id="countryFilter">
                                    <i class="fas fa-globe filter-icon"></i> Country
                                </button>
                                <div class="filter-dropdown" id="countryDropdown">
                                    @foreach($countries as $country)
                                    <div class="filter-option" data-value="{{$country->id}}">{{$country->name}}</div>
                                    @endforeach

                                </div>
                            </div>
                            <div class="filter-group">
                                <button class="filter-button" id="cityFilter">
                                    <i class="fas fa-city filter-icon"></i> City
                                </button>
                                <div class="filter-dropdown" id="cityDropdown">
                                    <div class="filter-option" data-value="all">All Cities</div>
                                    <div class="filter-option" data-value="newyork">New York</div>
                                    <div class="filter-option" data-value="london">London</div>
                                    <div class="filter-option" data-value="mumbai">Mumbai</div>
                                    <div class="filter-option" data-value="tokyo">Tokyo</div>
                                </div>
                            </div>
                        </div>
                        <div class="reels-container" id="reelsContainer">


                            @foreach($data as $story)
                            @php
                            $ext = strtolower(pathinfo($story->images, PATHINFO_EXTENSION));
                            $isVideo = in_array($ext, ['mp4', 'mov', 'webm', 'avi']);
                            $storyId = $story->id;
                            $text = strip_tags($story->text);
                            $words = explode(' ', $text);
                            $preview = implode(' ', array_slice($words, 0, 20));
                            $hasMore = count($words) > 20;
                            $userlogin = auth()->user();
                            $userLiked = false;

                            if ($userlogin) {
                            $userLiked = $userlogin->likes->where('news_and_story_id', $story->id)->isNotEmpty();
                            }
                            @endphp
                            <div class="reel" data-id="{{ $storyId }}" data-country="usa" data-city="newyork">
                                @if($isVideo)
                                <video class="reel-video" src="{{ asset('storage/' . $story->images) }}" loop muted autoplay playsinline></video>
                                @else
                                <img class="reel-video" src="{{ asset('storage/' . $story->images) }}" alt="Image">
                                @endif
                                <div class="reel-overlay">
                                    <a href="{{ route('user.profile.show', ['id' => $story->user->id]) }}">
                                    <div class="profile-info">
                                        <img src="{{ asset('storage/' . $story->user->profile_image) }}" class="profile-pic">
                                        <span class="username">{{$story->user->name}}</span>
                                    </div>
                               </a>

                                    <p class="caption">{{$story->title}}</p>
                                    <div class="music-info">

                                        <span>{{ $preview }}
                                            @if ($hasMore)
                                            <span id="dots-{{ $storyId }}">...</span>
                                            <span id="more-{{ $storyId }}" class="more-text">{{ implode(' ', array_slice($words, 20)) }}</span>
                                            @endif</span>
                                        @if ($hasMore)
                                        <a id="btn-{{ $storyId }}" onclick="toggleText({{ $storyId }})">Read more</a>
                                        @endif
                                    </div>
                                </div>
                                <div class="reel-action-buttons">
                                    <button class="reel-action-button like-button {{ $userLiked ? 'liked' : '' }}"
                                        data-story-id="{{ $story->id }}"
                                        data-user-id="{{ auth()->id() }}">
                                        <i class="{{ $userLiked ? 'fas' : 'far' }} fa-heart action-icon {{ $userLiked ? 'text-danger' : '' }}"></i>
                                        <span class="like-count">{{ $story->likes->count() }}</span>
                                    </button>

                                    <button class="reel-action-button" onclick="shareReel({{ $story->id }})">
                                        <i class="fas fa-share action-icon"></i>
                                        <span></span>
                                    </button>
                                    <a href="{{ route('user.profile.show', ['id' => $story->user->id]) }}?tab=feeds&story_id={{ $story->id }}"
                                        class="reel-action-button comment-button"
                                        data-user-id="{{ $story->user->id }}"
                                        data-story-id="{{ $story->id }}">
                                        <i class="fas fa-comment action-icon"></i>
                                        <span>{{ $story->comments->count() }}</span>
                                    </a>

                                </div>
                            </div>
                            @endforeach



                        </div>
                    </div> -->
@endsection
@push('js')

  <script>
    const isLoggedIn = @json(Auth::check());

    function shareReel(reelId) {
      const url = `${window.location.origin}${window.location.pathname}?reel_id=${reelId}`;
      const text = `Check out this reel: ${url}`;

      if (navigator.share) {
        navigator.share({
          title: "Check this reel",
          text: "Watch this awesome reel!",
          url: url
        }).catch(console.error);
      } else {
        // fallback to WhatsApp share
        window.open(`https://wa.me/?text=${encodeURIComponent(text)}`, '_blank');
      }
    }
    document.addEventListener("DOMContentLoaded", function () {
      const params = new URLSearchParams(window.location.search);
      const reelId = params.get("reel_id");

      if (reelId) {
        const reelElement = document.querySelector(`.reel[data-id="${reelId}"]`);
        if (reelElement) {
          // Scroll to it smoothly
          reelElement.scrollIntoView({
            behavior: "smooth",
            block: "center"
          });

          // Optional: Add visual effect to highlight it
          reelElement.classList.add("highlighted-reel");
        }
      }
    });
    document.addEventListener("DOMContentLoaded", function () {
      const urlParams = new URLSearchParams(window.location.search);
      const tab = urlParams.get('tab');
      const storyId = urlParams.get('story_id');

      if (tab === 'feeds') {
        // Simulate tab click
        document.querySelector('#tab01').click();

        // Add active class to make sure the content is shown
        document.querySelector('.col-lg-9')?.classList.add('newsactive');

        // Scroll to the specific story
        if (storyId) {
          setTimeout(() => {
            const storyDiv = document.querySelector(`.post-card[data-story-id="${storyId}"]`);
            if (storyDiv) {
              storyDiv.scrollIntoView({
                behavior: 'smooth',
                block: 'center'
              });
              storyDiv.classList.add('highlight-story'); // Optional: add class for animation
            }
          }, 300); // Slight delay to ensure tab content is rendered
        }
      }
    });
    $(document).ready(function () {
      $(document).on('click', '.like-button', function (e) {
        e.preventDefault();
        e.stopPropagation();
        console.log('asdasdkjlansd');
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
          success: function (res) {

            let count = parseInt(likeCountElement.text());

            if (res.status === 'liked') {
              // Only increase once
              if (!button.hasClass('liked')) {
                likeCountElement.text(count + 1);
                topCountElement.text(count + 1);
              }

              button.addClass('liked');
              likeText.text('like');
              icon.removeClass('far').addClass('fas text-primary');
            } else if (res.status === 'unliked') {
              // Only decrease once
              if (button.hasClass('liked')) {
                likeCountElement.text(count - 1);
                topCountElement.text(count - 1);
              }

              button.removeClass('liked');
              likeText.text('Like');
              icon.removeClass('fas text-primary').addClass('far');
            }
          },
          error: function () {
            alert('Please login or try again.');
          }
        });
      });
    });

    function toggleText(id) {
      const dots = document.getElementById('dots-' + id);
      const moreText = document.getElementById('more-' + id);
      const btnText = document.getElementById('btn-' + id);

      if (!moreText || !dots || !btnText) return;

      if (moreText.style.display === 'inline') {
        moreText.style.display = 'none';
        dots.style.display = 'inline';
        btnText.innerText = 'Read more';
      } else {
        moreText.style.display = 'inline';
        dots.style.display = 'none';
        btnText.innerText = 'Read less';
      }
    }

    // Optional: default hide extra text
    document.addEventListener('DOMContentLoaded', function () {
      document.querySelectorAll('.more-text').forEach(function (el) {
        el.style.display = 'none';
      });
    });
    // Sample reel data
    const reelData = [{
      id: 1,
      username: "user123",
      profilePic: "https://randomuser.me/api/portraits/women/44.jpg",
      videoUrl: "https://youtu.be/jnUFDqoUyuk",
      caption: "Enjoying the sunset at the beach! #vacation",
      music: "Original Sound - user123",
      likes: 1243,
      country: "usa",
      city: "newyork",
      liked: false
    },
    {
      id: 2,
      username: "traveler22",
      profilePic: "https://randomuser.me/api/portraits/men/32.jpg",
      videoUrl: "https://youtu.be/ncyohWSbwnE",
      caption: "Mountain views are the best views 🏔️",
      music: "Nature Sounds - traveler22",
      likes: 876,
      country: "uk",
      city: "london",
      liked: false
    },
    {
      id: 3,
      username: "foodie_queen",
      profilePic: "https://randomuser.me/api/portraits/women/68.jpg",
      videoUrl: "https://youtu.be/93AfDeSmLOY",
      caption: "Trying this new restaurant in town! So delicious!",
      music: "Trending Sound - foodie_queen",
      likes: 2456,
      country: "india",
      city: "mumbai",
      liked: false
    },
    {
      id: 4,
      username: "tech_guy",
      profilePic: "https://randomuser.me/api/portraits/men/75.jpg",
      videoUrl: "https://youtu.be/j1GPnc34UKA",
      caption: "Check out my new setup! #gamingsetup",
      music: "Electronic Beat - tech_guy",
      likes: 3421,
      country: "japan",
      city: "tokyo",
      liked: false
    }
    ];

    // Initialize the reels
    function initReels(filteredData = reelData) {
      const container = document.getElementById('reelsContainer');




      // Add event listeners for like buttons
      document.querySelectorAll('.like-button').forEach(button => {
        button.addEventListener('click', function () {
          const reelId = parseInt(this.dataset.id);
          const reel = reelData.find(r => r.id === reelId);

          if (reel) {
            reel.liked = !reel.liked;
            if (reel.liked) {
              reel.likes++;
              this.classList.add('liked');
            } else {
              reel.likes--;
              this.classList.remove('liked');
            }
            this.querySelector('span').textContent = formatLikeCount(reel.likes);
          }
        });
      });

      // Make videos play/pause when scrolled into view
      const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
          const video = entry.target.querySelector('.reel-video');
          if (entry.isIntersecting) {
            video.play();
          } else {
            video.pause();
          }
        });
      }, {
        threshold: 0.7
      });

      document.querySelectorAll('.reel').forEach(reel => {
        observer.observe(reel);
      });
    }

    // Format like count (e.g., 1200 -> 1.2K)
    function formatLikeCount(count) {
      if (count >= 1000000) {
        return (count / 1000000).toFixed(1) + 'M';
      } else if (count >= 1000) {
        return (count / 1000).toFixed(1) + 'K';
      }
      return count.toString();
    }

    // Filter functionality
    let currentCountryFilter = 'all';
    let currentCityFilter = 'all';

    function applyFilters() {
      let filtered = reelData;

      if (currentCountryFilter !== 'all') {
        filtered = filtered.filter(reel => reel.country === currentCountryFilter);
      }

      if (currentCityFilter !== 'all') {
        filtered = filtered.filter(reel => reel.city === currentCityFilter);
      }

      initReels(filtered);
    }


    let autoSlideInterval;
    const autoSlideDuration = 8000; // 8 seconds

    function startAutoSlide() {
      clearInterval(autoSlideInterval);
      autoSlideInterval = setInterval(() => {
        const reels = document.querySelectorAll('.reel');
        let currentIndex = -1;

        reels.forEach((reel, index) => {
          const rect = reel.getBoundingClientRect();
          if (rect.top >= 0 && rect.top < window.innerHeight * 0.5) {
            currentIndex = index;
          }
        });

        if (currentIndex !== -1 && currentIndex < reels.length - 1) {
          reels[currentIndex + 1].scrollIntoView({
            behavior: 'smooth'
          });
        } else if (currentIndex === reels.length - 1) {
          // Optionally go back to first reel
          reels[0].scrollIntoView({
            behavior: 'smooth'
          });
        }
      }, autoSlideDuration);
    }
  </script>



  <!-- new script -->
  <script>
(function () {

    let backdrop;

    function ensureBackdrop() {
        backdrop = document.querySelector('.mobile-backdrop');
        if (!backdrop) {
            backdrop = document.createElement('div');
            backdrop.className = 'mobile-backdrop';
            document.body.appendChild(backdrop);
            backdrop.addEventListener('click', closeAll);
        }
    }

    function openFor(section) {
        const info = section.querySelector('.profile-info');
        if (!info) return;

        ensureBackdrop();
        closeAll();

        // Add close button if not exists (AJAX safe)
        if (!info.querySelector('.mobile-close')) {
            const closeBtn = document.createElement('button');
            closeBtn.type = 'button';
            closeBtn.className = 'mobile-close';
            closeBtn.innerHTML = '&times;';
            info.insertBefore(closeBtn, info.firstChild);
        }

        info.classList.add('mobile-active');
        backdrop.classList.add('show');
        document.body.classList.add('no-scroll');
    }

    function closeAll() {
        document.querySelectorAll('.profile-info.mobile-active')
            .forEach(el => el.classList.remove('mobile-active'));

        const bd = document.querySelector('.mobile-backdrop');
        if (bd) bd.classList.remove('show');

        document.body.classList.remove('no-scroll');
    }

    // ✅ AJAX-SAFE CLICK HANDLER
    document.addEventListener('click', function (e) {

        // Open drawer
        const trigger = e.target.closest('.profile-overlay');
        if (trigger && window.innerWidth <= 1024) {
            e.preventDefault();
            const section = trigger.closest('.profile-section');
            if (section) openFor(section);
        }

        // Close drawer
        if (e.target.classList.contains('mobile-close')) {
            closeAll();
        }
    });

    // Esc key close
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') closeAll();
    });

})();

    function fetchState(thiss) {
      var country_id = thiss.val();
      var route = "{{ route('getstates', ['country_id' => ':country_id']) }}";
      route = route.replace(':country_id', country_id);
      $.ajax({
        url: route,
        type: "get",
        dataType: 'json',
        beforeSend: function () {
          $("#state, #city").html("");
          $("#state").html(`<option value=''>---select state---</option>`);
        },
        success: function (data) {
          $.each(data, function (index, item) {
            $("#state").append(`<option value='${item.id}'>${item.name}</option>`);
          });
        }
      });
      return false;
    }

    function fetchCity(thiss) {
      var state_id = thiss.val();
      var route = "{{ route('getcities', ['state_id' => ':state_id']) }}";
      route = route.replace(':state_id', state_id);
      $.ajax({
        url: route,
        type: "get",
        dataType: 'json',
        beforeSend: function () {
          $("#city").html("");
        },
        success: function (data) {
          $("#city").html(`<option value=''>---select city---</option>`);
          $.each(data, function (index, item) {
            $("#city").append(`<option value='${item.id}'>${item.name}</option>`);
          });
        }
      });
      return false;
    }
    var page = search = 2

    function getReels() {
      search = 1;
      var myData = {};
      myData.country_id = $("#country").val();
      myData.state_id = $("#state").val();
      myData.city = $("#city").val();
      myData._token = '{{ csrf_token() }}';
      $.ajax({
        url: '{{ route('home.reels') }}?page=' + page,
        type: "post",
        data: myData,
        dataType: 'json',
        beforeSend: function () {
          //$(".reels-card").html('Process ....');
        },
        success: function (data) {
          if ($('#exampleModal').hasClass('show')) {
            $('#exampleModal').modal('toggle');
          }
          $(".locationSeoContent").html(data.content !== null ? data.content : '');
          if (data.status == 200) {
            if (page == 1) {
              $(".reels-card").html(data.data);
            } else {
              $(".reels-card").append(data.data);
            }
            records_from = data.records_from;
            page = data.page;
            console.log(data.page);
            console.log(page);
          } else {
            //$(".reels-card").html('No record found');
            //toastr.warning('{{ __('message.invalid_login') }}');
          }
        }
      });
      return false;

    }
    $(document).ready(function () {
      $('#country, #state, #city, #advertiser').select2({
        dropdownParent: $('#exampleModal')
      });
    })

    setInterval(function () {
      if (search == 2) {
        getReelsByInterval();
      } else {
        getReels();
      }
    }, 10000);

    var records_from = '{{ $records_from }}';
    function getReelsByInterval() {
      $.ajax({
        url: '{{ route('reels', ["city" => $city]) }}?page=' + page + '&records_from=' + records_from,
        type: "get",
        dataType: 'json',
        beforeSend: function () {
          //$(".reels-card").html('Process ....');
        },
        success: function (data) {
          if (data.status == 200) {
            $(".reels-card").append(data.list);
            records_from = data.records_from;
            page = data.page;
          } else {
            page = data.page;
            //$(".reels-card").html('No record found');
          }
        }
      });
      return false;

    }
    $('.getReels').click(function () {
      page = 1;
      getReels();
    });
  </script>
  <!-- new script end -->
@endpush