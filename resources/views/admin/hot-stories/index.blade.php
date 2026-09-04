@extends('admin.layout.layout')

@section('content')
<style>
    .story-card-stat {
        background: #ffffff;
        border-radius: 10px;
        padding: 18px 20px;
        border: 1px solid #e5e7eb;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        display: flex;
        align-items: center;
        gap: 16px;
        transition: transform 0.15s ease, box-shadow 0.15s ease;
    }
    .story-card-stat:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);
    }
    .story-stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
    }
    .story-thumb-box {
        width: 72px;
        height: 72px;
        border-radius: 8px;
        overflow: hidden;
        position: relative;
        background: #111827;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid #e5e7eb;
    }
    .story-thumb-box img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .story-thumb-box .play-badge {
        position: absolute;
        width: 28px;
        height: 28px;
        background: rgba(0,0,0,0.65);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #ffffff;
        font-size: 11px;
    }
    .btn-action-view {
        background: #2563eb !important;
        border-color: #2563eb !important;
        color: #ffffff !important;
    }
    .btn-action-delete {
        background: #dc2626 !important;
        border-color: #dc2626 !important;
        color: #ffffff !important;
    }
    .btn-action-block {
        background: #f59e0b !important;
        border-color: #f59e0b !important;
        color: #ffffff !important;
    }
</style>

<div id="content" class="app-content">
    <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
        <div>
            <h1 class="page-header mb-1">
                <i class="fa-solid fa-fire text-danger me-2"></i> Hot Stories Moderation & Content Management
            </h1>
            <p class="text-muted mb-0">
                Stories are published directly without pre-verification. Moderate, preview, or permanently delete violating content from this feed.
            </p>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-danger" id="bulkDeleteBtn" style="display: none;">
                <i class="fa-solid fa-trash me-1"></i> Delete Selected (<span id="selectedCount">0</span>)
            </button>
            <a href="{{ route('reels') }}" target="_blank" class="btn btn-outline-dark" style="background:#fff !important; color:#111 !important; border:1px solid #ccc !important;">
                <i class="fa-solid fa-arrow-up-right-from-square me-1"></i> View Live Feed
            </a>
        </div>
    </div>

    <!-- Stat Cards -->
    <div class="row g-3 mb-4">
        <div class="col-xl-3 col-sm-6">
            <div class="story-card-stat">
                <div class="story-stat-icon" style="background: #fef2f2; color: #dc2626;">
                    <i class="fa-solid fa-film"></i>
                </div>
                <div>
                    <div class="text-muted small fw-semibold">Total Stories</div>
                    <div class="fs-4 fw-bold text-dark">{{ number_format($totalStories) }}</div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6">
            <div class="story-card-stat">
                <div class="story-stat-icon" style="background: #eff6ff; color: #2563eb;">
                    <i class="fa-solid fa-video"></i>
                </div>
                <div>
                    <div class="text-muted small fw-semibold">Video Stories</div>
                    <div class="fs-4 fw-bold text-dark">{{ number_format($videoStories) }}</div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6">
            <div class="story-card-stat">
                <div class="story-stat-icon" style="background: #fdf4ff; color: #a855f7;">
                    <i class="fa-solid fa-image"></i>
                </div>
                <div>
                    <div class="text-muted small fw-semibold">Image Stories</div>
                    <div class="fs-4 fw-bold text-dark">{{ number_format($imageStories) }}</div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6">
            <div class="story-card-stat">
                <div class="story-stat-icon" style="background: #f0fdf4; color: #16a34a;">
                    <i class="fa-solid fa-users"></i>
                </div>
                <div>
                    <div class="text-muted small fw-semibold">Active Creators</div>
                    <div class="fs-4 fw-bold text-dark">{{ number_format($activeCreators) }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter & Search Toolbar -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-3">
            <form method="GET" action="{{ route('admin.hot-stories.index') }}" class="row g-2 align-items-center">
                <div class="col-md-5">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0"><i class="fa-solid fa-magnifying-glass text-muted"></i></span>
                        <input type="text" name="search" class="form-control border-start-0" placeholder="Search by caption, creator name, email..." value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <select name="media_type" class="form-select">
                        <option value="">All Media Types</option>
                        <option value="video" {{ request('media_type') === 'video' ? 'selected' : '' }}>Videos Only</option>
                        <option value="image" {{ request('media_type') === 'image' ? 'selected' : '' }}>Images Only</option>
                    </select>
                </div>
                <div class="col-md-4 d-flex gap-2">
                    <button type="submit" class="btn btn-primary px-3">
                        <i class="fa-solid fa-filter me-1"></i> Filter
                    </button>
                    @if(request()->filled('search') || request()->filled('media_type'))
                    <a href="{{ route('admin.hot-stories.index') }}" class="btn btn-secondary px-3">
                        <i class="fa-solid fa-rotate-left me-1"></i> Reset
                    </a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <!-- Stories Table Card -->
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th width="40" class="text-center">
                                <input type="checkbox" id="selectAllStories" class="form-check-input" style="cursor: pointer;">
                            </th>
                            <th width="60">ID</th>
                            <th width="90">Media</th>
                            <th>Creator / Model</th>
                            <th>Caption / Content</th>
                            <th width="120" class="text-center">Engagement</th>
                            <th width="180">Published Date</th>
                            <th width="100">Status</th>
                            <th width="160" class="text-end pe-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($stories as $story)
                        @php
                            $user = $story->user;
                            $mediaPath = $story->images ?? $story->videos;
                            $ext = strtolower(pathinfo($mediaPath, PATHINFO_EXTENSION));
                            $isVideo = in_array($ext, ['mp4', 'webm', 'mov', 'ogg']) || !empty($story->videos);
                            $fullMediaUrl = config('app.img_url') . $mediaPath;
                            $thumbUrl = !empty($story->thumbnail) ? asset('storage/' . $story->thumbnail) : $fullMediaUrl;
                            $plainText = strip_tags($story->text ?? $story->title ?? '-');
                        @endphp
                        <tr id="story-row-{{ $story->id }}">
                            <td class="text-center">
                                <input type="checkbox" class="form-check-input story-checkbox" value="{{ $story->id }}" style="cursor: pointer;">
                            </td>
                            <td class="fw-semibold text-muted">#{{ $story->id }}</td>
                            <td>
                                <div class="story-thumb-box preview-trigger" 
                                     data-id="{{ $story->id }}"
                                     data-type="{{ $isVideo ? 'video' : 'image' }}"
                                     data-media="{{ $fullMediaUrl }}"
                                     data-title="{{ $story->title }}"
                                     data-caption="{{ $plainText }}"
                                     data-creator="{{ $user->name ?? 'User #' . $story->user_id }}"
                                     title="Click to preview full story">
                                    <img src="{{ $thumbUrl }}" alt="Story Thumbnail" onerror="this.src='{{ asset('storage/profile_image/default-profile.png') }}'">
                                    @if($isVideo)
                                    <div class="play-badge">
                                        <i class="fa-solid fa-play"></i>
                                    </div>
                                    @endif
                                </div>
                            </td>
                            <td>
                                @if($user)
                                <div class="d-flex align-items-center gap-2">
                                    <img src="{{ !empty($user->profile_image) ? config('app.img_url') . $user->profile_image : asset('storage/profile_image/default-profile.png') }}" 
                                         alt="{{ $user->name }}" 
                                         class="rounded-circle border" 
                                         width="36" height="36" style="object-fit: cover;">
                                    <div>
                                        <div class="fw-bold text-dark">
                                            <a href="{{ route('admin.edit-user', $user->id) }}" class="text-decoration-none text-dark hover-primary" title="View/Edit Profile">
                                                {{ $user->nickname ?? $user->name }}
                                            </a>
                                            @if($user->user_status == 1)
                                            <span class="badge bg-danger ms-1" style="font-size: 10px;">BLOCKED</span>
                                            @endif
                                        </div>
                                        <small class="text-muted">{{ $user->email }}</small>
                                    </div>
                                </div>
                                @else
                                <span class="text-muted">Deleted User (ID #{{ $story->user_id }})</span>
                                @endif
                            </td>
                            <td>
                                @if($story->title)
                                <div class="fw-semibold text-dark small">{{ Str::limit($story->title, 40) }}</div>
                                @endif
                                <div class="text-muted small" title="{{ $plainText }}">
                                    {{ Str::limit($plainText, 70) }}
                                </div>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-light text-dark border me-1" title="Likes">
                                    <i class="fa-solid fa-heart text-danger me-1"></i> {{ $story->likes->count() }}
                                </span>
                                <span class="badge bg-light text-dark border" title="Comments">
                                    <i class="fa-solid fa-comment text-primary me-1"></i> {{ $story->comments->count() }}
                                </span>
                            </td>
                            <td>
                                <div class="fw-semibold small text-dark">{{ $story->created_at ? $story->created_at->diffForHumans() : '-' }}</div>
                                <small class="text-muted" style="font-size: 11px;">{{ $story->created_at ? $story->created_at->format('Y-m-d H:i') : '' }}</small>
                            </td>
                            <td>
                                <span class="badge bg-success" style="font-size: 11px; padding: 5px 8px;">
                                    <i class="fa-solid fa-circle-check me-1"></i> Live
                                </span>
                            </td>
                            <td class="text-end pe-3">
                                <div class="btn-group btn-group-sm">
                                    <button class="btn btn-action-view preview-trigger" 
                                            data-id="{{ $story->id }}"
                                            data-type="{{ $isVideo ? 'video' : 'image' }}"
                                            data-media="{{ $fullMediaUrl }}"
                                            data-title="{{ $story->title }}"
                                            data-caption="{{ $plainText }}"
                                            data-creator="{{ $user->name ?? 'User #' . $story->user_id }}"
                                            title="Preview Story">
                                        <i class="fa-solid fa-eye"></i>
                                    </button>
                                    @if($user && $user->user_status == 0)
                                    <button class="btn btn-action-block block-creator-btn" 
                                            data-id="{{ $user->id }}" 
                                            data-name="{{ $user->nickname ?? $user->name }}"
                                            title="Block Creator Profile">
                                        <i class="fa-solid fa-ban"></i>
                                    </button>
                                    @endif
                                    <button class="btn btn-action-delete delete-story-btn" 
                                            data-id="{{ $story->id }}" 
                                            data-title="{{ $story->title ?? 'Story #' . $story->id }}"
                                            title="Delete Story Permanently">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center py-5 text-muted">
                                <i class="fa-solid fa-film fa-3x mb-3 text-secondary"></i>
                                <div class="fs-5 fw-semibold">No Hot Stories Found</div>
                                <p class="small text-muted mb-0">No stories match your search criteria.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if($stories->hasPages())
        <div class="card-footer bg-white d-flex align-items-center justify-content-between p-3 flex-wrap gap-2">
            <div class="text-muted small">
                Showing {{ $stories->firstItem() }} to {{ $stories->lastItem() }} of {{ $stories->total() }} stories
            </div>
            <div>
                {{ $stories->links('pagination::bootstrap-5') }}
            </div>
        </div>
        @endif
    </div>
</div>

<!-- Story Preview Modal -->
<div class="modal fade" id="storyPreviewModal" tabindex="-1" aria-labelledby="storyPreviewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-dark text-white p-3">
                <h5 class="modal-title" id="storyPreviewModalLabel">
                    <i class="fa-solid fa-fire text-danger me-2"></i> Story Preview - <span id="previewCreatorName">-</span>
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0 bg-black text-center position-relative" style="min-height: 400px; max-height: 70vh; overflow: hidden;">
                <div id="previewVideoContainer" style="display: none; height: 100%;">
                    <video id="previewVideo" controls style="max-height: 70vh; width: 100%; object-fit: contain;">
                        <source src="" type="video/mp4">
                    </video>
                </div>
                <div id="previewImageContainer" style="display: none; height: 100%;">
                    <img id="previewImage" src="" alt="Story Preview" style="max-height: 70vh; max-width: 100%; object-fit: contain;">
                </div>
            </div>
            <div class="modal-footer bg-light p-3 d-flex justify-content-between">
                <div class="text-start" style="max-width: 70%;">
                    <div class="fw-bold text-dark" id="previewStoryTitle"></div>
                    <small class="text-muted" id="previewStoryCaption"></small>
                </div>
                <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@push('js')
<script>
$(document).ready(function() {
    // Media preview trigger
    $(document).on('click', '.preview-trigger', function() {
        const type = $(this).data('type');
        const media = $(this).data('media');
        const title = $(this).data('title') || '';
        const caption = $(this).data('caption') || '';
        const creator = $(this).data('creator') || '';

        $('#previewCreatorName').text(creator);
        $('#previewStoryTitle').text(title);
        $('#previewStoryCaption').text(caption);

        if (type === 'video') {
            $('#previewImageContainer').hide();
            $('#previewVideoContainer').show();
            const video = document.getElementById('previewVideo');
            video.src = media;
            video.load();
        } else {
            $('#previewVideoContainer').hide();
            $('#previewImageContainer').show();
            $('#previewImage').attr('src', media);
        }

        const modal = new bootstrap.Modal(document.getElementById('storyPreviewModal'));
        modal.show();
    });

    // Pause video when modal is closed
    $('#storyPreviewModal').on('hidden.bs.modal', function() {
        const video = document.getElementById('previewVideo');
        if (video) {
            video.pause();
            video.src = '';
        }
    });

    // Delete single story
    $(document).on('click', '.delete-story-btn', function() {
        const storyId = $(this).data('id');
        const storyTitle = $(this).data('title');
        const $row = $('#story-row-' + storyId);

        Swal.fire({
            title: 'Delete Story Permanently?',
            text: 'Are you sure you want to delete "' + storyTitle + '"? It will immediately stop showing up anywhere on the site.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            confirmButtonText: 'Yes, Delete Now!',
            cancelButtonText: 'Cancel',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Deleting...',
                    text: 'Removing story and media files...',
                    allowOutsideClick: false,
                    didOpen: () => { Swal.showLoading(); }
                });

                $.ajax({
                    url: '{{ route("admin.hot-stories.destroy", ":id") }}'.replace(':id', storyId),
                    type: 'DELETE',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        Swal.fire('Deleted!', response.message, 'success');
                        $row.fadeOut(300, function() { $(this).remove(); });
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                        Swal.fire('Error!', 'Failed to delete story.', 'error');
                    }
                });
            }
        });
    });

    // Block Creator
    $(document).on('click', '.block-creator-btn', function() {
        const userId = $(this).data('id');
        const userName = $(this).data('name');

        Swal.fire({
            title: 'Block Creator Profile?',
            text: 'Block "' + userName + '"? Their profile and all stories will immediately stop showing up anywhere on the site.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#f59e0b',
            confirmButtonText: 'Yes, Block Profile!',
            cancelButtonText: 'Cancel',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '{{ route("admin.users.block", ":id") }}'.replace(':id', userId),
                    type: 'POST',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        Swal.fire('Blocked!', 'Creator has been blocked and removed from live feeds.', 'success').then(() => {
                            location.reload();
                        });
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                        Swal.fire('Error!', 'Failed to block creator.', 'error');
                    }
                });
            }
        });
    });

    // Select all checkboxes
    $('#selectAllStories').on('change', function() {
        $('.story-checkbox').prop('checked', $(this).is(':checked'));
        updateBulkDeleteButton();
    });

    $(document).on('change', '.story-checkbox', function() {
        updateBulkDeleteButton();
    });

    function updateBulkDeleteButton() {
        const count = $('.story-checkbox:checked').length;
        $('#selectedCount').text(count);
        if (count > 0) {
            $('#bulkDeleteBtn').fadeIn(200);
        } else {
            $('#bulkDeleteBtn').fadeOut(200);
        }
    }

    // Bulk delete action
    $('#bulkDeleteBtn').on('click', function() {
        const selectedIds = [];
        $('.story-checkbox:checked').each(function() {
            selectedIds.push($(this).val());
        });

        if (selectedIds.length === 0) return;

        Swal.fire({
            title: 'Delete ' + selectedIds.length + ' Stories?',
            text: 'This will permanently remove all selected stories from the site and delete their media files.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            confirmButtonText: 'Yes, Delete Selected!',
            cancelButtonText: 'Cancel',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Deleting...',
                    text: 'Cleaning up selected stories...',
                    allowOutsideClick: false,
                    didOpen: () => { Swal.showLoading(); }
                });

                $.ajax({
                    url: '{{ route("admin.hot-stories.bulk-delete") }}',
                    type: 'POST',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        ids: selectedIds
                    },
                    success: function(response) {
                        Swal.fire('Deleted!', response.message, 'success').then(() => {
                            location.reload();
                        });
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                        Swal.fire('Error!', 'Failed to delete stories.', 'error');
                    }
                });
            }
        });
    });
});
</script>
@endpush
@endsection
