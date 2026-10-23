@extends('front.layout.layout')

@section('content')

    <div class="main-area" id="blog-page-content">

        <!-- Main Blog Detail Section -->
        <section class="blog-main-wrapper blog-detail-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xl-9 col-lg-8 col-md-12">
                        <article class="post-single-article">

                            <!-- Breadcrumb Navigation -->
                            <nav aria-label="breadcrumb" class="post-breadcrumb-nav">
                                <ol class="breadcrumb post-breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="fa fa-home mr-1"></i>
                                            Home</a></li>
                                    <li class="breadcrumb-item"><a href="{{ route('blogs') }}">Inspiration</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">3 Easy Ways To Make Your iPhone
                                        Faster</li>
                                </ol>
                            </nav>

                            <!-- Post Header & Title -->
                            <header class="post-header">
                                <h1 class="post-main-title">3 Easy Ways To Make Your iPhone Faster</h1>

                                <!-- Meta Information Bar -->
                                <div class="post-meta-bar">
                                    <div class="meta-author">
                                        <img src="{{ asset('images/default-profile.png') }}" class="meta-author-avatar"
                                            alt="Katen Doe">
                                        <span class="meta-author-name">Katen Doe</span>
                                    </div>
                                    <span class="meta-divider">•</span>
                                    <div class="meta-item">
                                        <a href="{{ route('blogs') }}" class="meta-badge">Inspiration</a>
                                    </div>
                                    <span class="meta-divider">•</span>
                                    <div class="meta-item">
                                        <i class="fa fa-calendar-alt"></i> 01 August 2021
                                    </div>
                                    <span class="meta-divider">•</span>
                                    <div class="meta-item">
                                        <i class="fa fa-clock"></i> 3 Mins Read
                                    </div>
                                </div>
                            </header>

                            <!-- Featured Hero Image -->
                            <div class="post-hero-image-wrap">
                                <img src="{{ asset('images/blog/03-big.jpg') }}"
                                    alt="3 Easy Ways To Make Your iPhone Faster" class="post-hero-img">
                            </div>

                            <!-- Post Article Content Body -->
                            <div class="post-article-body">
                                <p class="lead-paragraph">
                                    The European languages are members of the same family. Their separate existence is a
                                    myth. For science, music, sport, etc, Europe uses the same vocabulary. The languages
                                    only differ in their grammar, their pronunciation and their most common words.
                                </p>

                                <p>
                                    Everyone realizes why a new common language would be desirable: one could refuse to pay
                                    expensive translators. To achieve this, it would be necessary to have uniform grammar,
                                    pronunciation and more common words. If several languages coalesce, the grammar of the
                                    resulting language is more simple and regular than that of the individual languages.
                                </p>

                                <!-- Styled Blockquote -->
                                <blockquote class="post-blockquote">
                                    <div class="quote-icon">
                                        <i class="fa fa-quote-left"></i>
                                    </div>
                                    <p class="quote-text">
                                        "The European languages are members of the same family. Their separate existence is
                                        a myth. For science, music, sport, Europe uses the same shared foundation."
                                    </p>
                                    <footer class="quote-author">— Occidental Linguistic Review</footer>
                                </blockquote>

                                <p>
                                    The languages only differ in their grammar, their pronunciation and their most common
                                    words. Everyone realizes why a new common language would be desirable: one could refuse
                                    to pay expensive translators.
                                </p>

                                <!-- Center Inline Image with Caption -->
                                <figure class="post-inline-figure">
                                    <div class="figure-img-wrap">
                                        <img src="{{ asset('images/blog/05.jpg') }}"
                                            alt="Minimalist Space and Performance Focus">
                                    </div>
                                    <figcaption class="post-figure-caption">
                                        <i class="fa fa-camera mr-1"></i> Minimalist setup: Streamlining background
                                        operations for seamless speed.
                                    </figcaption>
                                </figure>

                                <p>
                                    The languages only differ in their grammar, their pronunciation and their most common
                                    words. Everyone realizes why a new common language would be desirable: one could refuse
                                    to pay expensive translators.
                                </p>

                                <!-- Two-Column Section: Left Image, Right Text -->
                                <div class="post-two-col-block">
                                    <div class="row align-items-center">
                                        <div class="col-md-5 mb-3 mb-md-0">
                                            <div class="two-col-img-wrap">
                                                <img src="{{ asset('images/blog/04.jpg') }}"
                                                    alt="Optimized Structure & Aesthetics">
                                            </div>
                                        </div>
                                        <div class="col-md-7">
                                            <p class="two-col-text">
                                                One catch, of course, is that only the biggest and most prestigious
                                                galleries will usually exhibit paintings. This is because they have a
                                                reputation to maintain, and will only consider artists whose works they know
                                                will sell.
                                            </p>
                                            <p class="two-col-text">
                                                If you're not lucky enough to be represented by a gallery, don't worry: you
                                                can still exhibit your work. There are plenty of cafes, restaurants and
                                                other local venues that are happy to display art. The new common language
                                                will be more simple and regular.
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Subheading -->
                                <div class="post-subheading-wrap">
                                    <h3 class="post-subheading">I should be incapable of drawing a single stroke</h3>
                                </div>

                                <!-- Feature List / Bullet Points -->
                                <ul class="post-feature-list">
                                    <li>
                                        <i class="fa fa-check-circle list-icon"></i>
                                        <span><strong>Cache Optimization:</strong> Regularly flush transient application
                                            data to instantly reclaim gigabytes of storage.</span>
                                    </li>
                                    <li>
                                        <i class="fa fa-check-circle list-icon"></i>
                                        <span><strong>Background Refresh Tuning:</strong> Restrict high-drain background
                                            processes to preserve peak responsiveness and battery.</span>
                                    </li>
                                    <li>
                                        <i class="fa fa-check-circle list-icon"></i>
                                        <span><strong>Thermal Throttling Prevention:</strong> Keep your device operating in
                                            moderate temperatures to avoid clock speed degradation.</span>
                                    </li>
                                    <li>
                                        <i class="fa fa-check-circle list-icon"></i>
                                        <span><strong>System Storage Indexing:</strong> Periodic re-indexing frees up memory
                                            headroom for heavy resource-demanding apps.</span>
                                    </li>
                                    <li>
                                        <i class="fa fa-check-circle list-icon"></i>
                                        <span><strong>Motion & Transparency Settings:</strong> Minor UI adjustments
                                            eliminate rendering bottlenecks on older device models.</span>
                                    </li>
                                </ul>

                                <p>
                                    To an English person, it will seem like simplified English, as a skeptical Cambridge
                                    friend of mine told me what Occidental is. The European languages are members of the
                                    same family. Their separate existence is a myth. For science, music, sport, etc, Europe
                                    uses the same vocabulary.
                                </p>

                                <!-- Bottom Post Footer Bar: Tags & Social Share -->
                                <footer class="post-footer-bar">
                                    <!-- Left: Tag Pills -->
                                    <div class="post-tags-wrap">
                                        <span class="tags-label"><i class="fa fa-tags text-danger mr-1"></i> Tags:</span>
                                        <a href="{{ route('blogs') }}" class="tag-pill">#Trending</a>
                                        <a href="{{ route('blogs') }}" class="tag-pill">#Video</a>
                                        <a href="{{ route('blogs') }}" class="tag-pill">#Featured</a>
                                        <a href="{{ route('blogs') }}" class="tag-pill">#Inspiration</a>
                                    </div>

                                    <!-- Right: Social Share Buttons -->
                                    <div class="post-share-wrap">
                                        <span class="share-label">Share:</span>
                                        <div class="post-share-btns">
                                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}"
                                                target="_blank" rel="noopener noreferrer" class="share-circle-btn"
                                                title="Share on Facebook">
                                                <i class="fa-brands fa-facebook-f"></i>
                                            </a>
                                            <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text=3+Easy+Ways+To+Make+Your+iPhone+Faster"
                                                target="_blank" rel="noopener noreferrer" class="share-circle-btn"
                                                title="Share on X (Twitter)">
                                                <i class="fa-brands fa-x-twitter"></i>
                                            </a>
                                            <a href="https://pinterest.com/pin/create/button/?url={{ urlencode(url()->current()) }}"
                                                target="_blank" rel="noopener noreferrer" class="share-circle-btn"
                                                title="Share on Pinterest">
                                                <i class="fa-brands fa-pinterest"></i>
                                            </a>
                                            <a href="https://t.me/share/url?url={{ urlencode(url()->current()) }}&text=3+Easy+Ways+To+Make+Your+iPhone+Faster"
                                                target="_blank" rel="noopener noreferrer" class="share-circle-btn"
                                                title="Share on Telegram">
                                                <i class="fa-brands fa-telegram"></i>
                                            </a>
                                            <a href="https://api.whatsapp.com/send?text={{ urlencode('3 Easy Ways To Make Your iPhone Faster - ' . url()->current()) }}"
                                                target="_blank" rel="noopener noreferrer" class="share-circle-btn"
                                                title="Share on WhatsApp">
                                                <i class="fa-brands fa-whatsapp"></i>
                                            </a>
                                            <button type="button" class="share-circle-btn"
                                                onclick="copyDetailPostLink(this);" title="Copy Link">
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

                            <!-- WIDGET 1: POPULAR POSTS -->
                            <div class="sidebar-widget">
                                <h3 class="sidebar-widget-title">
                                    <span><i class="fa fa-fire text-danger mr-2"></i> Popular Posts</span>
                                </h3>

                                <div class="sidebar-posts-list">
                                    <!-- Item 1 -->
                                    <div class="sidebar-post-item">
                                        <div class="sidebar-post-thumb">
                                            <a href="{{ route('blog_detail') }}">
                                                <img src="{{ asset('images/blog/01.jpg') }}" alt="Popular Post 1">
                                                <span class="sidebar-post-number">1</span>
                                            </a>
                                        </div>
                                        <div class="sidebar-post-info">
                                            <h4 class="sidebar-post-title">
                                                <a href="{{ route('blog_detail') }}">3 Easy Ways To Make Your iPhone
                                                    Faster</a>
                                            </h4>
                                            <div class="sidebar-post-date">
                                                <i class="fa fa-calendar-alt text-danger mr-1"></i> 20 March 2024
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Item 2 -->
                                    <div class="sidebar-post-item">
                                        <div class="sidebar-post-thumb">
                                            <a href="{{ route('blog_detail') }}">
                                                <img src="{{ asset('images/blog/02.jpg') }}" alt="Popular Post 2">
                                                <span class="sidebar-post-number">2</span>
                                            </a>
                                        </div>
                                        <div class="sidebar-post-info">
                                            <h4 class="sidebar-post-title">
                                                <a href="{{ route('blog_detail') }}">An Incredibly Easy Method That Works
                                                    For All</a>
                                            </h4>
                                            <div class="sidebar-post-date">
                                                <i class="fa fa-calendar-alt text-danger mr-1"></i> 18 March 2024
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Item 3 -->
                                    <div class="sidebar-post-item">
                                        <div class="sidebar-post-thumb">
                                            <a href="{{ route('blog_detail') }}">
                                                <img src="{{ asset('images/blog/06.jpg') }}" alt="Popular Post 3">
                                                <span class="sidebar-post-number">3</span>
                                            </a>
                                        </div>
                                        <div class="sidebar-post-info">
                                            <h4 class="sidebar-post-title">
                                                <a href="{{ route('blog_detail') }}">10 Ways To Revamp Your Morning
                                                    Routine</a>
                                            </h4>
                                            <div class="sidebar-post-date">
                                                <i class="fa fa-calendar-alt text-danger mr-1"></i> 15 March 2024
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- WIDGET 2: EXPLORE TOPICS -->
                            <div class="sidebar-widget">
                                <h3 class="sidebar-widget-title">
                                    <span><i class="fa fa-folder-open text-danger mr-2"></i> Explore Topics</span>
                                </h3>
                                <ul class="topics-list">
                                    <li class="topic-item">
                                        <a href="{{ route('blogs') }}" class="topic-link">
                                            <span class="topic-name"><i class="fa fa-chevron-right"></i> Lifestyle</span>
                                            <span class="topic-count">3</span>
                                        </a>
                                    </li>
                                    <li class="topic-item">
                                        <a href="{{ route('blogs') }}" class="topic-link">
                                            <span class="topic-name"><i class="fa fa-chevron-right"></i> Inspiration</span>
                                            <span class="topic-count">2</span>
                                        </a>
                                    </li>
                                    <li class="topic-item">
                                        <a href="{{ route('blogs') }}" class="topic-link">
                                            <span class="topic-name"><i class="fa fa-chevron-right"></i> Fashion</span>
                                            <span class="topic-count">4</span>
                                        </a>
                                    </li>
                                    <li class="topic-item">
                                        <a href="{{ route('blogs') }}" class="topic-link">
                                            <span class="topic-name"><i class="fa fa-chevron-right"></i> Polling</span>
                                            <span class="topic-count">1</span>
                                        </a>
                                    </li>
                                    <li class="topic-item">
                                        <a href="{{ route('blogs') }}" class="topic-link">
                                            <span class="topic-name"><i class="fa fa-chevron-right"></i> Trending</span>
                                            <span class="topic-count">5</span>
                                        </a>
                                    </li>
                                    <li class="topic-item">
                                        <a href="{{ route('blogs') }}" class="topic-link">
                                            <span class="topic-name"><i class="fa fa-chevron-right"></i> Culture</span>
                                            <span class="topic-count">2</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>

                            <!-- WIDGET 3: NEWSLETTER -->
                            <div class="sidebar-widget newsletter-widget">
                                <div class="newsletter-icon-wrap">
                                    <i class="fa fa-envelope-open-text"></i>
                                </div>
                                <h4>Newsletter</h4>
                                <p>Join <strong>70,000 subscribers!</strong> Get premier stories, inspiration, and trends
                                    directly in your inbox.</p>

                                <form id="detailNewsletterForm"
                                    onsubmit="event.preventDefault(); handleDetailNewsletter(this);">
                                    <input type="email" class="form-control" placeholder="Email address..." required>
                                    <button type="submit" class="newsletter-btn">
                                        <i class="fa fa-paper-plane mr-1"></i> Sign Up
                                    </button>
                                </form>
                                <p class="newsletter-note">By signing up, you agree to our Privacy Policy</p>
                            </div>

                        </aside>
                    </div>

                </div>
                @if (!empty($locationSeoContent['data']->content))
                    <div class="row">
                        <div class="col-lg-12 text-justify locationSeoContent">
                            {!! $locationSeoContent['data']->content !!}
                        </div>
                    </div>
                @endif
            </div>
        </section>

        <!-- Floating Copy Toast Notification -->
        <div id="copyToast" class="custom-toast" role="alert">
            <i class="fa fa-check-circle"></i>
            <span id="toastMessage">Link copied to clipboard!</span>
        </div>
    </div>

    <script>
        function copyDetailPostLink(buttonElement) {
            var currentUrl = window.location.href;
            if (navigator.clipboard && window.isSecureContext) {
                navigator.clipboard.writeText(currentUrl).then(function () {
                    showToastNotification("Article link copied to clipboard!");
                }).catch(function () {
                    fallbackCopyUrl(currentUrl);
                });
            } else {
                fallbackCopyUrl(currentUrl);
            }

            // Button micro-interaction animation
            if (buttonElement) {
                buttonElement.style.transform = 'scale(1.25)';
                setTimeout(function () {
                    buttonElement.style.transform = '';
                }, 300);
            }
        }
        function fallbackCopyUrl(text) {
            var tempInput = document.createElement("input");
            tempInput.value = text;
            document.body.appendChild(tempInput);
            tempInput.select();
            try {
                document.execCommand("copy");
                showToastNotification("Article link copied to clipboard!");
            } catch (err) {
                showToastNotification("Press Ctrl+C to copy URL");
            }
            document.body.removeChild(tempInput);
        }

        /**
         * Display floating toast notification
         */
        function showToastNotification(message) {
            var toast = document.getElementById("copyToast");
            var toastMsg = document.getElementById("toastMessage");
            if (!toast) return;

            if (toastMsg && message) {
                toastMsg.innerText = message;
            }

            toast.classList.add("show");
            clearTimeout(window.toastTimer);
            window.toastTimer = setTimeout(function () {
                toast.classList.remove("show");
            }, 3000);
        }

        /**
         * Handle newsletter form submission in sidebar
         */
        function handleDetailNewsletter(formElement) {
            var emailInput = formElement.querySelector("input[type='email']");
            var emailValue = emailInput ? emailInput.value.trim() : "";

            if (!emailValue) return;

            var submitBtn = formElement.querySelector("button[type='submit']");
            var originalBtnContent = submitBtn ? submitBtn.innerHTML : "";

            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fa fa-spinner fa-spin mr-1"></i> Subscribing...';
            }

            setTimeout(function () {
                if (emailInput) emailInput.value = "";
                if (submitBtn) {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = '<i class="fa fa-check mr-1"></i> Subscribed!';
                    submitBtn.style.backgroundColor = '#28a745';
                }

                showToastNotification("Thank you! You've joined 70,000+ subscribers.");

                setTimeout(function () {
                    if (submitBtn) {
                        submitBtn.innerHTML = originalBtnContent;
                        submitBtn.style.backgroundColor = '';
                    }
                }, 3500);
            }, 600);
        }
    </script>

@endsection