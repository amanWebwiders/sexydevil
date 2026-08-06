@forelse($data as $story)
<div class="post-card">
    <div class="post-header">
        <div class="profile-pic">
            <img src="{{ config('app.img_url') . $story->user->profile_image }}" alt="Profile">
        </div>
        <div class="user-info">
            <h4 class="user-name">{{$story->user->name}}</h4>
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
            $isVideo = in_array($ext, ['mp4', 'mov', 'webm', 'avi']);
            @endphp

            @if($isVideo)
            <video src="{{ config('app.img_url') . $story->images }}"
                class="post-image"
                muted autoplay loop playsinline></video>
            @else
            <img src="{{ url('storage/app/public/' . $story->images) }}"
                alt="Post media"
                class="post-image {{config('app.img_url') . $story->images }}">
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
@endforelse
