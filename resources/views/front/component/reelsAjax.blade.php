    @php
      $stories = $allStories ?? $allUsers ?? [];
    @endphp
    @forelse($stories as $story)
    @php
      $users = $story->user ?? null;
      if (!$users) {
          continue;
      }
      $storyId = $story->id;
      $text = strip_tags($story->text ?: $users->description);
      $words = explode(' ', $text);
      $preview = implode(' ', array_slice($words, 0, 20));
      $hasMore = count($words) > 20;
      $userlogin = auth()->user();
      $views = getBoostedViews($users->reviewsReceived ? $users->reviewsReceived->count() : 0, $users->id);

      $mediaFile = $story->images ?? $story->videos ?? '';
      $cleanMediaFile = ltrim(str_replace('storage/app/public/', '', $mediaFile), '/');
      $cleanMediaFile = preg_replace('#^storage/#', '', $cleanMediaFile);
      $ext = strtolower(pathinfo($cleanMediaFile, PATHINFO_EXTENSION));
      $isVideo = in_array($ext, ['mp4', 'mov', 'webm', 'avi', 'ogg']) || str_contains($cleanMediaFile, 'uploads/news/videos');
      $mediaUrl = $cleanMediaFile ? asset('storage/' . $cleanMediaFile) : '';

      $cleanThumb = $story->thumbnail ? ltrim(str_replace('storage/app/public/', '', $story->thumbnail), '/') : '';
      $cleanThumb = preg_replace('#^storage/#', '', $cleanThumb);
      $posterUrl = $cleanThumb ? asset('storage/' . $cleanThumb) : asset('images/escort_logo1.png');

      $userProfileImg = (isset($users->profile_image) && Storage::disk('public')->exists($users->profile_image))
          ? asset('storage/' . $users->profile_image)
          : asset('storage/profile_image/default-profile.png');

      $userLiked = ($userlogin) ? $story->likes->where('user_id', $userlogin->id)->isNotEmpty() : false;
    @endphp

    <div class="profile-section mb-5" id="reelsContainer-{{ $story->id }}" data-story-id="{{ $story->id }}" data-user-id="{{ $users->id }}">
      <div class="profile-media" id="profile-media-{{ $story->id }}">
        <div class="active-media-box w-100 h-100 position-relative">
          @if($isVideo)
            <div class="video-wrapper position-relative w-100 h-100">
              <video class="w-100 h-100 object-cover reels-bg-video myVideo" poster="{{ $posterUrl }}" playsinline loop>
                <source src="{{ $mediaUrl }}" type="video/mp4">
              </video>
              <div class="play-btn">
                <i class="fa fa-play"></i>
              </div>
            </div>
          @else
            <div class="w-100 h-100 position-relative d-flex align-items-center justify-content-center bg-black overflow-hidden">
              <img src="{{ $mediaUrl }}"
                   alt="{{ $users->nickname }}"
                   class="w-100 h-100 reels-bg-img"
                   onerror="this.onerror=null; this.src='{{ $userProfileImg }}';" />
            </div>
          @endif
        </div>

        <div class="profile-overlay">
          <h5 class="notranslate" translate="no">{{$users->nickname}} <i class="fas fa-check-circle text-primary"></i></h5>
          <p class="notranslate" translate="no">@ {{$users->nickname}} · #{{$users->sexual_orientation}} #{{$users->sex_location}} </p>
        </div>
        <div class="action-icons text-center">
          <img src="{{ $userProfileImg }}" alt="{{ $users->nickname }}">

          <button class="reel-action-button like-button {{ $userLiked ? 'liked' : '' }}"
            data-story-id="{{ $story->id }}"
            data-id="{{ auth()->id() }}">
            <i class="{{ $userLiked ? 'fas' : 'far' }} fa-heart fa-solid action-icon {{ $userLiked ? 'text-danger' : '' }}"></i>
            <span class="like-count">{{ $story->likes ? $story->likes->count() : 0 }}</span>
          </button>
          <a href="{{ route('user.profile.show', ['id' => $users->id]) . '?tab=feeds&story_id=' . $story->id }}"
            class="reel-action-button comment-button"
            data-id="{{ $users->id }}"
            data-story-id="{{ $story->id }}">
            <i class="fas fa-comment action-icon"></i>
            <span class="comment-count">{{ $story->comments ? $story->comments->count() : 0 }}</span>
          </a>
          <button class="reel-action-button" onclick="shareReel({{ $story->id }})">
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
            <img src="{{ $userProfileImg }}" alt="{{ $users->nickname }}">
          </div>
          <div>
            <p>
              <strong>{{ $users->stories ? $users->stories->count() : 0 }}</strong> Posts
            </p>
          </div>
          <div>
            <p>
              <strong>{{ number_format($views['count']) }} </strong> {{ Str::plural('View', $views['count']) }}
            </p>
          </div>
        </div>
        <div class="d-flex align-items-center reels-detail-ui">
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
        <p class="mt-2 fs-14 notranslate" translate="no">
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
          @if($users->stories)
          @foreach($users->stories as $key => $s)
          @php
            $sFile = $s->images ?? $s->videos ?? '';
            $sCleanFile = ltrim(str_replace('storage/app/public/', '', $sFile), '/');
            $sCleanFile = preg_replace('#^storage/#', '', $sCleanFile);
            $sExt = strtolower(pathinfo($sCleanFile, PATHINFO_EXTENSION));
            $sIsVideo = in_array($sExt, ['mp4', 'mov', 'webm', 'avi', 'ogg']) || str_contains($sCleanFile, 'uploads/news/videos');
            $sMediaUrl = $sCleanFile ? asset('storage/' . $sCleanFile) : '';
            $sCleanThumb = $s->thumbnail ? ltrim(str_replace('storage/app/public/', '', $s->thumbnail), '/') : '';
            $sCleanThumb = preg_replace('#^storage/#', '', $sCleanThumb);
            $sThumbUrl = $sCleanThumb ? asset('storage/' . $sCleanThumb) : asset('images/escort_logo1.png');
            $sLiked = ($userlogin) ? $s->likes->where('user_id', $userlogin->id)->isNotEmpty() : false;
          @endphp

          <div class="col-6 mb-3">
            <div class="position-relative h-100 gallery-story-item {{ $s->id == $story->id ? 'active-story-item' : '' }}"
                 style="cursor: pointer;"
                 data-user-id="{{ $users->id }}"
                 data-story-id="{{ $s->id }}"
                 data-media-url="{{ $sMediaUrl }}"
                 data-is-video="{{ $sIsVideo ? '1' : '0' }}"
                 data-poster-url="{{ $sThumbUrl }}"
                 data-like-count="{{ $s->likes ? $s->likes->count() : 0 }}"
                 data-is-liked="{{ $sLiked ? '1' : '0' }}"
                 data-comment-count="{{ $s->comments ? $s->comments->count() : 0 }}"
                 title="Click to view in main reel">
              @if($sIsVideo)
                <div class="video-wrapper position-relative">
                  <video class="w-100 object-cover reels-bg-video" poster="{{ $sThumbUrl }}" preload="metadata">
                    <source src="{{ $sMediaUrl }}" type="video/mp4">
                  </video>
                  <div class="play-btn">
                    <i class="fa fa-play"></i>
                  </div>
                </div>
              @else
                <div class="w-100 position-relative" style="height: 150px; background: #000; border-radius: 6px; overflow: hidden;">
                  <img src="{{ $sMediaUrl }}" alt="User Post" class="w-100 h-100" style="object-fit: cover;"
                       onerror="this.onerror=null; this.src='{{ $userProfileImg }}';" />
                </div>
              @endif

              <div class="fav-btn">
                <button class="reel-action-button like-button {{ $sLiked ? 'liked' : '' }}"
                  data-story-id="{{ $s->id }}"
                  data-id="{{ auth()->id() }}">
                  <i class="{{ $sLiked ? 'fas' : 'far' }} fa-heart fa-solid action-icon {{ $sLiked ? 'text-danger' : '' }}"></i>
                  <span class="like-count">{{ $s->likes ? $s->likes->count() : 0 }}</span>
                </button>
              </div>
            </div>
          </div>
          @endforeach
          @endif
        </div>

      </div>
    </div>
    <hr>
@empty
    <p class="btn btn-block btn-maincolor mr-3">No stories found.</p>
@endforelse