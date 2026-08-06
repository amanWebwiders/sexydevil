@foreach ($comment->replies as $reply)
    <div class="comment reply" data-comment-id="{{ $reply->id }}">
        <div class="comment-pic">
            <img src="{{ asset('storage/' . ($reply->user->profile_image ?? 'default.jpg')) }}" alt="Profile">
        </div>
        <div class="comment-content">
            <div class="comment-author notranslate" translate="no">{{ $reply->user->nickname }}</div>
            <div class="comment-text">{{ $reply->comment }}</div>
            <div class="comment-actions">
                <span class="comment-reply-toggle comment-action">Reply</span>
                <span class="comment-time">{{ $reply->created_at->diffForHumans() }}</span>
            </div>

            {{-- Inline reply box --}}
            <div class="reply-section" style="display: none;">
                <input type="text" class="reply-input" placeholder="Write a reply..." />
                <button class="reply-send-btn"
                    data-comment-id="{{ $reply->id }}"
                    data-story-id="{{ $story->id }}"
                    data-user-id="{{ $user->id }}">
                    Send
                </button>
            </div>

            {{-- Recursive reply list --}}
            @if ($reply->replies->count() > 0)
                <div class="reply-list" data-comment-id="{{ $reply->id }}">
                    @include('partials.replies', ['comment' => $reply, 'story' => $story, 'user' => $user])
                </div>
            @endif
        </div>
    </div>
@endforeach
