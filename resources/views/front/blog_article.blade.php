@extends('front.layout.layout')

@section('content')

    @php
        $location = collect([optional($blog->city)->name, optional($blog->state)->name, optional($blog->country)->name])->filter()->implode(', ');
        $shareUrl = $blog->slug ? route('blog.show', $blog->slug) : url()->current();
    @endphp

    <style>
        #blog-page-content .blog-preview-banner {
            background: #1e3a8a; color: #fff; border-radius: 10px; padding: 12px 18px; margin-bottom: 20px;
            display: flex; align-items: center; gap: 10px; font-size: 14px;
        }
        #blog-page-content .post-hero-video { position: relative; border-radius: 16px; overflow: hidden; background: #000; margin-bottom: 30px; }
        #blog-page-content .post-hero-video iframe, #blog-page-content .post-hero-video video { display: block; width: 100%; aspect-ratio: 16 / 9; border: 0; }
        #blog-page-content .post-location { color: #cccccc; }

        /* Rich text written in the admin editor */
        #blog-page-content .blog-rich-content h2,
        #blog-page-content .blog-rich-content h3,
        #blog-page-content .blog-rich-content h4 { color: #ffffff; font-weight: 700; line-height: 1.35; margin: 32px 0 14px; }
        #blog-page-content .blog-rich-content h2 { font-size: 26px; }
        #blog-page-content .blog-rich-content h3 { font-size: 22px; }
        #blog-page-content .blog-rich-content h4 { font-size: 18px; }
        #blog-page-content .blog-rich-content a { color: #bc1212; font-weight: 600; text-decoration: underline; text-underline-offset: 3px; }
        #blog-page-content .blog-rich-content a:hover { color: #ffffff; }
        #blog-page-content .blog-rich-content ul,
        #blog-page-content .blog-rich-content ol { color: #cccccc; padding-left: 24px; margin-bottom: 22px; }
        #blog-page-content .blog-rich-content li { margin-bottom: 8px; line-height: 1.75; }
        #blog-page-content .blog-rich-content img,
        #blog-page-content .blog-rich-content video { max-width: 100%; height: auto; border-radius: 12px; }
        #blog-page-content .blog-rich-content iframe { max-width: 100%; width: 100%; height: auto; aspect-ratio: 16 / 9; border: 0; border-radius: 12px; }
        #blog-page-content .blog-rich-content figure { margin: 28px 0; max-width: 100%; }
        #blog-page-content .blog-rich-content figure.image { display: table; }
        #blog-page-content .blog-rich-content figcaption { color: #999999; font-size: 13px; text-align: center; padding-top: 10px; }
        #blog-page-content .blog-rich-content blockquote {
            background-color: #161616; border-left: 4px solid #bc1212; border-radius: 0 12px 12px 0;
            padding: 20px 26px; margin: 28px 0; color: #e5e5e5; font-style: italic;
        }
        #blog-page-content .blog-rich-content blockquote p:last-child { margin-bottom: 0; }
        #blog-page-content .blog-rich-content table { width: 100%; border-collapse: collapse; margin: 24px 0; color: #cccccc; display: block; overflow-x: auto; }
        #blog-page-content .blog-rich-content th,
        #blog-page-content .blog-rich-content td { border: 1px solid #2c2c2c; padding: 10px 12px; }
        #blog-page-content .blog-rich-content th { background: #161616; color: #ffffff; }
        #blog-page-content .blog-rich-content pre { background: #0d0d0d; border: 1px solid #242424; color: #e5e5e5; border-radius: 10px; padding: 16px; overflow-x: auto; font-size: 14px; }
        #blog-page-content .blog-rich-content hr { border: 0; border-top: 1px solid #2c2c2c; margin: 32px 0; }
        #blog-page-content .blog-rich-content mark { background: #bc1212; color: #fff; padding: 0 4px; }
        #blog-page-content .blog-rich-content .blog-callout { border-left: 4px solid #3b82f6; background: rgba(59, 130, 246, .08); border-radius: 10px; padding: 16px 20px; margin: 26px 0; color: #e5e5e5; }
        #blog-page-content .blog-rich-content .blog-callout-tip { border-color: #22c55e; background: rgba(34, 197, 94, .08); }
        #blog-page-content .blog-rich-content .blog-callout-warning { border-color: #f59e0b; background: rgba(245, 158, 11, .08); }
        #blog-page-content .blog-rich-content .blog-callout p:last-child { margin-bottom: 0; }
        #blog-page-content .blog-rich-content p.blog-lead { font-size: 18px; color: #f1f1f1; line-height: 1.75; }
        #blog-page-content .blog-rich-content a.blog-btn { display: inline-block; background: #bc1212; color: #fff; padding: 10px 22px; border-radius: 999px; text-decoration: none; font-weight: 700; }
        #blog-page-content .blog-rich-content a.blog-btn:hover { background: #ffffff; color: #bc1212; }
    </style>

    <div class="main-area" id="blog-page-content">
        <section class="blog-main-wrapper blog-detail-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xl-9 col-lg-8 col-md-12">
                        @if ($isPreview)
                            <div class="blog-preview-banner" role="note">
                                <i class="fa fa-eye"></i>
                                <span><strong>Preview</strong> — status: {{ \App\Models\Blog::STATUSES[$blog->effective_status] ?? ucfirst($blog->status) }}. Only signed-in admins can see this page.</span>
                            </div>
                        @endif

                        <article class="post-single-article">
                            <nav aria-label="breadcrumb" class="post-breadcrumb-nav">
                                <ol class="breadcrumb post-breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="fa fa-home mr-1"></i> Home</a></li>
                                    <li class="breadcrumb-item"><a href="{{ route('blogs') }}">Blog</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">{{ $blog->title }}</li>
                                </ol>
                            </nav>

                            <header class="post-header">
                                <h1 class="post-main-title">{{ $blog->title }}</h1>

                                <div class="post-meta-bar">
                                    <div class="meta-author">
                                        <img src="{{ asset('images/default-profile.png') }}" class="meta-author-avatar" alt="">
                                        <span class="meta-author-name">{{ optional($blog->author)->name ?? config('app.name') }}</span>
                                    </div>
                                    @foreach ($blog->categories as $category)
                                        <span class="meta-divider">•</span>
                                        <div class="meta-item"><span class="meta-badge">{{ $category->name }}</span></div>
                                    @endforeach
                                    <span class="meta-divider">•</span>
                                    <div class="meta-item">
                                        <i class="fa fa-calendar-alt"></i>
                                        @if ($blog->published_at)
                                            <time datetime="{{ $blog->published_at->toIso8601String() }}">{{ $blog->published_at->format('d F Y') }}</time>
                                        @else
                                            Not published yet
                                        @endif
                                    </div>
                                    <span class="meta-divider">•</span>
                                    <div class="meta-item"><i class="fa fa-clock"></i> {{ $blog->reading_minutes }} Min{{ $blog->reading_minutes > 1 ? 's' : '' }} Read</div>
                                    @if ($location)
                                        <span class="meta-divider">•</span>
                                        <div class="meta-item post-location"><i class="fa fa-map-marker-alt"></i> {{ $location }}</div>
                                    @endif
                                </div>
                            </header>

                            @if ($blog->shows_featured_video)
                                <div class="post-hero-video">
                                    @if ($blog->featured_video)
                                        <video controls preload="metadata" playsinline @if ($blog->featured_image) poster="{{ $blog->featured_image_url }}" @endif>
                                            <source src="{{ $blog->featured_video_file_url }}">
                                        </video>
                                    @else
                                        <iframe src="{{ $blog->featured_video_embed_url }}" title="{{ $blog->title }}" loading="lazy"
                                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; fullscreen" allowfullscreen></iframe>
                                    @endif
                                </div>
                            @elseif ($blog->featured_image)
                                <div class="post-hero-image-wrap">
                                    <img src="{{ $blog->featured_image_url }}" alt="{{ $blog->featured_image_alt ?: $blog->title }}" class="post-hero-img">
                                </div>
                            @endif

                            <div class="post-article-body">
                                @if ($blog->excerpt)
                                    <p class="lead-paragraph">{{ $blog->excerpt }}</p>
                                @endif

                                {{-- Content is sanitized with App\Services\HtmlSanitizer when it is saved. --}}
                                <div class="blog-rich-content">{!! $blog->content !!}</div>

                                <footer class="post-footer-bar">
                                    <div class="post-tags-wrap">
                                        @if ($blog->categories->isNotEmpty())
                                            <span class="tags-label"><i class="fa fa-tags text-danger mr-1"></i> Categories:</span>
                                            @foreach ($blog->categories as $category)
                                                <span class="tag-pill">#{{ $category->name }}</span>
                                            @endforeach
                                        @endif
                                    </div>

                                    <div class="post-share-wrap">
                                        <span class="share-label">Share:</span>
                                        <div class="post-share-btns">
                                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode($shareUrl) }}" target="_blank" rel="noopener noreferrer" class="share-circle-btn" title="Share on Facebook">
                                                <i class="fa-brands fa-facebook-f"></i>
                                            </a>
                                            <a href="https://twitter.com/intent/tweet?url={{ urlencode($shareUrl) }}&text={{ urlencode($blog->title) }}" target="_blank" rel="noopener noreferrer" class="share-circle-btn" title="Share on X (Twitter)">
                                                <i class="fa-brands fa-x-twitter"></i>
                                            </a>
                                            <a href="https://t.me/share/url?url={{ urlencode($shareUrl) }}&text={{ urlencode($blog->title) }}" target="_blank" rel="noopener noreferrer" class="share-circle-btn" title="Share on Telegram">
                                                <i class="fa-brands fa-telegram"></i>
                                            </a>
                                            <a href="https://api.whatsapp.com/send?text={{ urlencode($blog->title . ' - ' . $shareUrl) }}" target="_blank" rel="noopener noreferrer" class="share-circle-btn" title="Share on WhatsApp">
                                                <i class="fa-brands fa-whatsapp"></i>
                                            </a>
                                            <button type="button" class="share-circle-btn" onclick="copyArticleLink(this);" data-url="{{ $shareUrl }}" title="Copy Link">
                                                <i class="fa-solid fa-link"></i>
                                            </button>
                                        </div>
                                    </div>
                                </footer>
                            </div>
                        </article>
                    </div>

                    <div class="col-xl-3 col-lg-4 col-md-12">
                        <aside class="blog-sidebar">
                            @if ($recentBlogs->isNotEmpty())
                                <div class="sidebar-widget">
                                    <h3 class="sidebar-widget-title">
                                        <span><i class="fa fa-fire text-danger mr-2"></i> Recent Posts</span>
                                    </h3>
                                    <div class="sidebar-posts-list">
                                        @foreach ($recentBlogs as $index => $recent)
                                            <div class="sidebar-post-item">
                                                <div class="sidebar-post-thumb">
                                                    <a href="{{ route('blog.show', $recent->slug) }}">
                                                        <img src="{{ $recent->featured_image ? $recent->featured_image_url : asset('images/escort_logo1.png') }}" alt="{{ $recent->featured_image_alt ?: $recent->title }}" loading="lazy">
                                                        <span class="sidebar-post-number">{{ $index + 1 }}</span>
                                                    </a>
                                                </div>
                                                <div class="sidebar-post-info">
                                                    <h4 class="sidebar-post-title"><a href="{{ route('blog.show', $recent->slug) }}">{{ $recent->title }}</a></h4>
                                                    <div class="sidebar-post-date"><i class="fa fa-calendar-alt text-danger mr-1"></i> {{ $recent->published_at->format('d F Y') }}</div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            @if ($blogTopics->isNotEmpty())
                                <div class="sidebar-widget">
                                    <h3 class="sidebar-widget-title">
                                        <span><i class="fa fa-folder-open text-danger mr-2"></i> Explore Topics</span>
                                    </h3>
                                    <ul class="topics-list">
                                        @foreach ($blogTopics as $topic)
                                            <li class="topic-item">
                                                <a href="{{ route('blogs', ['category' => $topic->slug]) }}" class="topic-link">
                                                    <span class="topic-name"><i class="fa fa-chevron-right"></i> {{ $topic->name }}</span>
                                                    <span class="topic-count">{{ $topic->blogs_count }}</span>
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </aside>
                    </div>
                </div>
            </div>
        </section>

        <div id="copyToast" class="custom-toast" role="alert">
            <i class="fa fa-check-circle"></i>
            <span id="toastMessage">Link copied to clipboard!</span>
        </div>
    </div>

    <script>
        function copyArticleLink(button) {
            var url = button.getAttribute('data-url');
            var done = function () {
                var toast = document.getElementById('copyToast');
                toast.classList.add('show');
                clearTimeout(window.toastTimer);
                window.toastTimer = setTimeout(function () { toast.classList.remove('show'); }, 3000);
            };
            if (navigator.clipboard && window.isSecureContext) {
                navigator.clipboard.writeText(url).then(done);
            } else {
                var input = document.createElement('input');
                input.value = url;
                document.body.appendChild(input);
                input.select();
                document.execCommand('copy');
                document.body.removeChild(input);
                done();
            }
        }
    </script>

    @unless($isPreview)
        @push('seo')
            @php
                $articleSchema = array_filter([
                    '@context' => 'https://schema.org',
                    '@type' => 'BlogPosting',
                    'mainEntityOfPage' => ['@type' => 'WebPage', '@id' => $blog->canonical_url ?: $shareUrl],
                    'headline' => \Illuminate\Support\Str::limit($blog->title, 110, ''),
                    'description' => $blog->seo_description,
                    'image' => $blog->featured_image_url,
                    'datePublished' => optional($blog->published_at)->toAtomString(),
                    'dateModified' => optional($blog->updated_at)->toAtomString(),
                    'author' => ['@type' => 'Organization', 'name' => config('app.name'), 'url' => url('/')],
                    'publisher' => ['@type' => 'Organization', 'name' => config('app.name'), 'logo' => ['@type' => 'ImageObject', 'url' => asset('images/escort_logo1.png')]],
                    'articleSection' => optional($blog->categories->first())->name,
                    'keywords' => $blog->meta_keywords,
                    'wordCount' => str_word_count($blog->plain_text),
                ]);
                $breadcrumbSchema = [
                    '@context' => 'https://schema.org',
                    '@type' => 'BreadcrumbList',
                    'itemListElement' => [
                        ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => url('/')],
                        ['@type' => 'ListItem', 'position' => 2, 'name' => 'Blog', 'item' => url('/blogs')],
                        ['@type' => 'ListItem', 'position' => 3, 'name' => $blog->title, 'item' => $shareUrl],
                    ],
                ];
            @endphp
            @if($blog->published_at)
                <meta property="article:published_time" content="{{ $blog->published_at->toAtomString() }}" />
                <meta property="article:modified_time" content="{{ $blog->updated_at->toAtomString() }}" />
            @endif
            <script type="application/ld+json">{!! json_encode($articleSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG) !!}</script>
            <script type="application/ld+json">{!! json_encode($breadcrumbSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG) !!}</script>
        @endpush
    @endunless

@endsection
