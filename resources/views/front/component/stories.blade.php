<style>
    .stories-container {
        display: flex;
        overflow-x: auto;
        gap: 15px;
        margin-bottom: 1rem;
        -webkit-overflow-scrolling: touch;
    }

    .story-circle {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        display: flex;
        justify-content: center;
        align-items: center;
        background: linear-gradient(45deg, #f09433, #e6683c, #dc2743, #cc2366, #bc1888);
        padding: 2px;
        cursor: pointer;
        flex-shrink: 0;
    }

    .story-inner {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        background-color: white;
        display: flex;
        justify-content: center;
        align-items: center;
        overflow: hidden;
    }

    .story-inner img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .story-username {
        font-size: 12px;
        text-align: center;
        margin-top: 5px;
        color: #fff;
    }



    /* Story Viewer */
    .story-viewer {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: black;
        z-index: 999999;
        display: none;
        flex-direction: column;
    }

    .story-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(255, 255, 255, 0.5);
        backdrop-filter: blur(5px);
        -webkit-backdrop-filter: blur(5px);
        z-index: 99999;
        display: none;
    }


    @supports not (backdrop-filter: blur(5px)) {
        .story-overlay {
            background-color: rgba(255, 255, 255, 0.8);
        }
    }

    .story-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px;
        padding-top: 30px;
        color: white;
        position: relative;
        z-index: 2;
        background: linear-gradient(to bottom, rgba(0, 0, 0, 1), rgba(0, 0, 0, 0));
    }

    .story-user {
        display: flex;
        gap: 10px;
    }

    .story-user-avatar {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        overflow: hidden;
    }

    .story-user-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .story-user-name {
        font-weight: 600;
        font-size: 14px;
        line-height: 1;
    }

    .story-user-time {
        font-size: 9px;
        line-height: 2;
    }

    .story-close {
        background: none;
        border: none;
        color: white;
        font-size: 20px;
        cursor: pointer;
        padding: 0px;
        background: transparent !important;
    }

    .story-progress-container {
        display: none;
        gap: 5px;
        padding: 10px;
        z-index: 2;
        background: #00000020;
        width: 100%;
        left: 0;
        top: 0px;
    }

    .story-progress {
        display: none;
        height: 2px;
        background-color: rgba(255, 255, 255, 0.4);
        flex-grow: 1;
        border-radius: 2px;
        overflow: hidden;
    }

    .story-progress-bar {
        display: none;
        height: 100%;
        background-color: white;
        width: 0%;
        transition: width 0.1s linear;
    }

    .story-content {
        flex-grow: 1;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .story-image {
        width: 100%;
        height: 100%;
        /* object-fit: cover; */
        position: absolute;
        top: 0;
        left: 0;
    }

    .story-footer {
        padding: 15px;
        color: white;
        position: relative;
        z-index: 2;
        background: linear-gradient(to top, rgba(0, 0, 0, 1), rgba(0, 0, 0, 0));
    }

    .story-title {
        font-weight: 600;
        margin-bottom: 5px;
        font-size: 16px;
    }

    .story-caption {
        font-size: 14px;
        line-height: 1.3;
        margin-bottom: 10px;
    }

    .story-input {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .story-input input {
        flex-grow: 1;
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2) !important;
        border-radius: 20px !important;
        padding: 8px 15px;
        color: white;
        outline: none;
        height: 40px;
    }

    .story-input button {
        background: none;
        border: none;
        color: white;
        font-size: 20px;
        cursor: pointer;
    }

    .story-nav {
        position: absolute;
        top: 0;
        bottom: 0;
        width: 50%;
        cursor: pointer;
        z-index: 1;
    }

    .story-prev {
        left: 0;
    }

    .story-next {
        right: 0;
    }


    .stories-container {
        /* background-color: #000; */
        overflow-y: auto;
        /* justify-content: center */
    }

    /* For Webkit browsers (Chrome, Safari, Edge) */
    .stories-container::-webkit-scrollbar {
        width: 4px;
    }

    .stories-container::-webkit-scrollbar-track {
        background: transparent;
    }

    .stories-container::-webkit-scrollbar-thumb {
        background-color: rgba(255, 255, 255, 0.2);
        border-radius: 2px;
    }

    .stories-container::-webkit-scrollbar-thumb:hover {
        background-color: rgba(255, 255, 255, 0.3);
    }

    /* For Firefox */
    .stories-container {
        scrollbar-width: thin;
        scrollbar-color: rgba(255, 255, 255, 0.2) transparent;
    }

    .read-more:hover {
        text-decoration: underline;
    }

    @media (min-width: 768px) {
        .story-viewer {
            width: 60vw;
            height: 80dvh;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            border-radius: 10px;
            overflow: hidden;
        }
    }

    @media (max-width: 768px) {
        .story-username {
            font-size: 10px;
        }

        .story-circle {
            width: 50px;
            height: 50px;
            min-width: 50px;
        }
    }
</style>
<div class="stories-container">
    @forelse($newsstory as $story)
    <div class="story" data-story-id="{{ $story->id }}"
        data-username="{{ $story->user->nickname }}"
        data-avatar="{{ config('app.img_url'). (isset($story->user->profile_image) && Storage::disk('public')->exists($story->user->profile_image) ? $story->user->profile_image:"profile_image/default-profile.png") }}"
        data-title="{{ $story->title ?? '' }}"
        data-caption="{{ htmlentities(strip_tags($story->text ?? '')) }}"
        data-media="{{ config('app.img_url') . $story->images }}"
        data-media-type="{{ Str::contains($story->images, ['.mp4', '.webm', '.mov']) ? 'video' : 'image' }}"
        data-created-at="{{ $story->created_at }}">

        <div class="story-circle">
            <div class="story-inner">
                @if(Str::contains($story->images, ['.mp4', '.webm', '.mov']))
                <video src="{{ config('app.img_url') . $story->images }}" muted playsinline preload="metadata" class="story-thumb-video"></video>
                @else
                <img src="{{ config('app.img_url') . $story->images }}" alt="Story" class="story-thumb-image">
                @endif
            </div>
        </div>
        <div class="story-username notranslate" translate="no">{{$story->user->nickname}}</div>
    </div>
    @empty
    <div class="no-news py-5">
        <h4>No Story Available</h4>
    </div>
    @endforelse
</div>

<div class="story-overlay"></div>
<div class="story-viewer">
    <div class="story-header">
        <div class="story-user">
            <div class="story-user-avatar">
                <img src="" alt="User">
            </div>
            <div>
                <div class="story-user-name"></div>
                <div class="story-user-time">2h ago</div>
            </div>
        </div>
        <button class="story-close">&times;</button>
        <div class="story-progress-container position-absolute d-none"></div>
    </div>
    <div class="story-content">
        <img class="story-image" src="" alt="Story" style="display: none;">
        <video class="story-video" style="display: none; max-height: 80vh;"></video>
        <div class="story-nav story-prev"></div>
        <div class="story-nav story-next"></div>
    </div>
    <div class="story-footer">
        <div class="story-title"></div>
        <div class="story-caption"></div>
    </div>
</div>

<script>
    function getMediaType(mediaUrl) {
        const extension = mediaUrl.split('.').pop().toLowerCase();
        return ['mp4', 'webm', 'mov'].includes(extension) ? 'video' : 'image';
    }

    function truncateCaption(caption, wordLimit = 20) {
        const words = caption.split(/\s+/);
        if (words.length <= wordLimit) return {
            short: caption,
            full: null
        };

        const shortText = words.slice(0, wordLimit).join(' ') + '...';
        return {
            short: shortText,
            full: caption
        };
    }

    const storyViewer = document.querySelector('.story-viewer');
    const storyOverlay = document.querySelector('.story-overlay');
    const storyImage = document.querySelector('.story-image');
    const storyVideo = document.querySelector('.story-video');
    const storyUsername = document.querySelector('.story-user-name');
    const storyUserAvatar = document.querySelector('.story-user-avatar img');
    const storyTitle = document.querySelector('.story-title');
    const storyCaption = document.querySelector('.story-caption');
    const progressContainer = document.querySelector('.story-progress-container');
    const closeButton = document.querySelector('.story-close');
    const prevNav = document.querySelector('.story-prev');
    const nextNav = document.querySelector('.story-next');
    const storyTime = document.querySelector('.story-user-time');

    let storyElements = document.querySelectorAll('.story');
    let stories = [];
    let currentStoryIndex = 0;
    let progressInterval;
    const storyDuration = 10000;

    function timeAgo(date) {
        const seconds = Math.floor((new Date() - new Date(date)) / 1000);
        const intervals = [{
                label: 'y',
                seconds: 31536000
            },
            {
                label: 'mo',
                seconds: 2592000
            },
            {
                label: 'w',
                seconds: 604800
            },
            {
                label: 'd',
                seconds: 86400
            },
            {
                label: 'h',
                seconds: 3600
            },
            {
                label: 'm',
                seconds: 60
            },
            {
                label: 's',
                seconds: 1
            },
        ];

        for (const interval of intervals) {
            const count = Math.floor(seconds / interval.seconds);
            if (count >= 1) return `${count}${interval.label} ago`;
        }
        return 'Just now';
    }

    storyElements.forEach(el => {
        stories.push({
            id: parseInt(el.dataset.storyId),
            username: el.dataset.username,
            avatar: el.dataset.avatar,
            title: el.dataset.title || '',
            caption: el.dataset.caption || '',
            media: el.dataset.media,
            mediaType: el.dataset.mediaType || getMediaType(el.dataset.media),
            created_at: el.dataset.createdAt
        });

        el.addEventListener('click', () => openStory(parseInt(el.dataset.storyId)));
    });

    function openStory(storyId) {
        const index = stories.findIndex(s => s.id === storyId);
        if (index === -1) return;

        currentStoryIndex = index;
        renderProgressBars();
        loadStory(index);

        storyViewer.style.display = 'flex';
        storyOverlay.style.display = 'flex';
        document.body.style.overflow = 'hidden';
        startProgress();
    }

    function loadStory(index) {
        const s = stories[index];
        console.log(s);
        storyUsername.textContent = s.username;
        storyUserAvatar.src = s.avatar;
        storyTitle.textContent = s.title ? s.title : '';
        // storyCaption.textContent = s.caption ? s.caption : '';

        storyTime.textContent = timeAgo(s.created_at);
        const {
            short,
            full
        } = truncateCaption(s.caption);
        if (full) {
            let isExpanded = false;
            storyCaption.innerHTML = `
            <span class="caption-text">${short}</span>
            <span class="read-toggle" style="color:#9c9ca7;cursor:pointer;"> Read more</span>
        `;

            const captionText = storyCaption.querySelector('.caption-text');
            const toggle = storyCaption.querySelector('.read-toggle');

            toggle.addEventListener('click', () => {
                isExpanded = !isExpanded;
                captionText.textContent = isExpanded ? full : short;
                toggle.textContent = isExpanded ? ' Read less' : ' Read more';
            });
        } else {
            storyCaption.textContent = short;
        }

        if (s.mediaType === 'video') {
            storyVideo.pause();
            storyVideo.removeAttribute('src');
            storyVideo.style.display = 'block';
            storyImage.style.display = 'none';
            storyVideo.src = s.media;
            storyVideo.load();
            storyVideo.play().catch(err => console.warn("Autoplay error:", err));
        } else {
            storyImage.src = s.media;
            storyImage.style.display = 'block';
            storyVideo.style.display = 'none';
            storyVideo.pause();
            storyVideo.removeAttribute('src');
            storyVideo.load();
        }

        document.querySelectorAll('.story-progress-bar').forEach((bar, i) => {
            bar.style.width = i < index ? '100%' : '0%';
        });
    }

    function renderProgressBars() {
        progressContainer.classList.remove('d-none');
        progressContainer.innerHTML = '';
        stories.forEach(() => {
            const bar = document.createElement('div');
            bar.classList.add('story-progress');
            bar.innerHTML = '<div class="story-progress-bar"></div>';
            progressContainer.appendChild(bar);
        });
    }

    function startProgress() {
        clearTimeout(progressInterval);

        const bars = document.querySelectorAll('.story-progress-bar');
        bars[currentStoryIndex].style.width = '0%';
        bars[currentStoryIndex].offsetWidth;
        bars[currentStoryIndex].style.transition = `width ${storyDuration}ms linear`;
        bars[currentStoryIndex].style.width = '100%';

        // progressInterval = setTimeout(() => nextStory(), storyDuration);
    }

    function nextStory() {
        if (currentStoryIndex < stories.length - 1) {
            currentStoryIndex++;
            loadStory(currentStoryIndex);
            startProgress();
        } else {
            closeStory();
        }
    }

    function prevStory() {
        if (currentStoryIndex > 0) {
            currentStoryIndex--;
            loadStory(currentStoryIndex);
            startProgress();
        }
    }

    function closeStory() {
        clearTimeout(progressInterval);
        storyViewer.style.display = 'none';
        storyOverlay.style.display = 'none';
        document.body.style.overflow = 'auto';
        document.querySelectorAll('video').forEach(video => {
            video.pause();
            video.currentTime = 0; // reset to beginning
        });
    }

    closeButton.addEventListener('click', closeStory);
    nextNav.addEventListener('click', nextStory);
    prevNav.addEventListener('click', prevStory);

    document.addEventListener('keydown', e => {
        if (storyViewer.style.display === 'flex') {
            if (e.key === 'ArrowRight') nextStory();
            else if (e.key === 'ArrowLeft') prevStory();
            else if (e.key === 'Escape') closeStory();
        }
    });

    let touchStartX = 0;
    let touchEndX = 0;

    storyViewer.addEventListener('touchstart', e => {
        touchStartX = e.changedTouches[0].screenX;
    });

    storyViewer.addEventListener('touchend', e => {
        touchEndX = e.changedTouches[0].screenX;
        if (touchEndX < touchStartX - 50) nextStory();
        else if (touchEndX > touchStartX + 50) prevStory();
    });
</script>