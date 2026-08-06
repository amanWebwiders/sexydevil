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
    $isVideo = in_array($ext, ['mp4', 'mov', 'webm', 'avi']);
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
        @else

        <div class="w-100 h-100 bg-cover bg-center reels-bg-img"
          style="background-image: url('{{ $firstStory ? config('app.img_url') . $mediaFile : config('app.img_url') . (isset($users->profile_image) && Storage::disk('public')->exists($users->profile_image) ? $users->profile_image :"profile_image/default-profile.png" )}}');">
        </div>
        @endif

        <div class="profile-overlay">
          <h5>{{$users->nickname}} <i class="fas fa-check-circle text-primary"></i></h5>
          <p>@ {{$users->nickname}} · #{{$users->sexual_orientation}} #{{$users->sex_location}} </p>
        </div>
        <div class="action-icons text-center">
          @if(isset($users->profile_image) && Storage::disk('public')->exists($users->profile_image))
            <img src="{{config('app.img_url') . $users->profile_image }}" alt="">
          @else
            <img src="{{ asset('storage/profile_image/default-profile.png') }}" alt="">
          @endif

          <button class="reel-action-button like-button {{ $userLiked ? 'liked' : '' }}"
            data-story-id="{{ $firstStory->id }}"
            data-id="{{ auth()->id() }}">
            <i class="{{ $userLiked ? 'fas' : 'far' }} fa-heart fa-solid action-icon {{ $userLiked ? 'text-danger' : '' }}"></i>
            <span class="like-count">{{ $firstStory->likes->count() }}</span>
          </button>
          <a href="{{ route('user.profile.show', ['id' => $users->id]) }}?tab=feeds&story_id={{ $firstStory->id }}"
            class="reel-action-button comment-button"
            data-id="{{ $users->id }}"
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
          <h6 class="text-center">{{$users->nickname}} <i class="fas fa-check-circle text-primary"></i></h6>
        </div>
        <hr class="reels-border my-2">
        <h6 class="mt-3 mb-2">{{$users->slogan}}</h6>
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
          <a href="{{ route('user.profile.show', $users->id) }}" class="btn btn-maincolor cards-btn view-prof-btn w-100 ml-1">View Profile</a>
          <a href="https://api.whatsapp.com/send?text={{ urlencode(route('user.profile.show', $users->id)) }}"
            target="_blank">
            <i class="fab fa-whatsapp ml-2"></i>
          </a>
          <a href="https://t.me/share/url?url={{ urlencode(route('user.profile.show', $users->id)) }}&text={{ urlencode($users->nickname . '\'s profile') }}"
            target="_blank">
            <i class="fab fa-telegram-plane ml-2"></i>
          </a>

        </div>
        <p style="" class="mt-2 fs-14">
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
                <img src="{{ config('app.img_url').$mediaFile }}" alt="User Post" class="w-100 rounded" />
                </a>
                @endif

                <div class="fav-btn"><button class="reel-action-button like-button {{ $userLiked ? 'liked' : '' }}"
                    data-story-id="{{ $story->id }}"
                    data-id="{{ auth()->id() }}">
                    <i class="{{ $userLiked ? 'fas' : 'far' }} fa-heart fa-solid action-icon {{ $userLiked ? 'text-danger' : '' }}"></i>
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
    <p class="btn btn-block btn-maincolor mr-3">No users found.</p>
@endforelse