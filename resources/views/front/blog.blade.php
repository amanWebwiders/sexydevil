@extends('front.layout.layout')

@section('content')

    <div class="main-area" id="blog-page-content">
        <!-- Main Blog Section -->
        <section class="blog-main-wrapper">
            <div class="container-fluid">

                <div class="blog-filter-card">
                    <div class="blog-filter-header">
                        <h1 class="blog-filter-header-title">
                            <i class="fa fa-sliders-h"></i>
                            {{ $activeCategory ? $activeCategory->name : 'Blog' }}
                        </h1>
                        <span class="filter-count-badge">
                            {{ $blogs->total() }} Article{{ $blogs->total() === 1 ? '' : 's' }}{{ $isFiltered ? ' Found' : '' }}
                        </span>
                    </div>

                    <form id="blogFilterForm" method="GET" action="{{ route('blogs') }}">
                        <div class="row align-items-end">
                            <!-- Country Filter -->
                            <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
                                <label class="form-label" for="filterCountry"><i class="fa fa-globe text-theme mr-1"></i>
                                    Country</label>
                                <select id="filterCountry" name="country" class="form-control" data-resets="filterState,filterCity">
                                    <option value="">All Countries</option>
                                    @foreach ($filterCountries as $country)
                                        <option value="{{ $country->id }}" @selected($filters['country_id'] == $country->id)>{{ $country->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- State Filter -->
                            <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
                                <label class="form-label" for="filterState"><i class="fa fa-map text-theme mr-1"></i>
                                    State</label>
                                <select id="filterState" name="state" class="form-control" data-resets="filterCity" @disabled($filterStates->isEmpty())>
                                    <option value="">All States</option>
                                    @foreach ($filterStates as $state)
                                        <option value="{{ $state->id }}" @selected($filters['state_id'] == $state->id)>{{ $state->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- City Filter -->
                            <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
                                <label class="form-label" for="filterCity"><i
                                        class="fa fa-map-marker-alt text-theme mr-1"></i>
                                    City</label>
                                <select id="filterCity" name="city" class="form-control" @disabled($filterCities->isEmpty())>
                                    <option value="">All Cities</option>
                                    @foreach ($filterCities as $city)
                                        <option value="{{ $city->id }}" @selected($filters['city_id'] == $city->id)>{{ $city->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Category Filter -->
                            <div class="col-lg-3 col-md-6 col-sm-6 mb-3">
                                <label class="form-label" for="filterCategory"><i class="fa fa-tags text-theme mr-1"></i>
                                    Category</label>
                                <select id="filterCategory" name="category" class="form-control">
                                    <option value="">All Categories</option>
                                    @foreach ($blogTopics as $topic)
                                        <option value="{{ $topic->slug }}" @selected($filters['category'] === $topic->slug)>{{ $topic->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Search Input & Buttons -->
                            <div class="col-lg-3 col-md-6 col-sm-12 mb-3">
                                <label class="form-label" for="filterKeyword"><i class="fa fa-search text-theme mr-1"></i>
                                    Keyword</label>
                                <div class="d-flex gap-2" style="gap: 8px;">
                                    <input type="search" id="filterKeyword" name="q" class="form-control" placeholder="Search articles..."
                                        value="{{ $filters['q'] }}" maxlength="100">
                                    <button type="submit" class="btn-filter-reset" title="Search" style="width: 48px; min-width: 48px;">
                                        <i class="fa fa-search"></i>
                                    </button>
                                    @if ($isFiltered)
                                        <a href="{{ route('blogs') }}" class="btn-filter-reset d-inline-flex align-items-center justify-content-center"
                                            title="Reset Filters" style="width: 48px; min-width: 48px;">
                                            <i class="fa fa-undo"></i>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                @if ($blogs->isEmpty())
                    <div class="no-results-alert" style="display: block;">
                        <i class="fa fa-search-minus"></i>
                        @if ($isFiltered)
                            <h2 class="text-white mb-2 h4">No Matching Blog Articles Found</h2>
                            <p class="text-white-50 mb-3">We couldn't find any articles matching your selected criteria. Try
                                adjusting the location, category or keyword.</p>
                            <a href="{{ route('blogs') }}" class="btn-filter-apply"
                                style="display: inline-flex; width: auto; padding: 0 25px;">
                                <i class="fa fa-sync-alt mr-2"></i> Reset All Filters
                            </a>
                        @else
                            <h2 class="text-white mb-2 h4">No Articles Yet</h2>
                            <p class="text-white-50 mb-0">New guides and stories are on their way. Check back soon.</p>
                        @endif
                    </div>
                @endif

                <div class="row" id="blogMainContentRow">

                    <!-- LEFT COLUMN -->
                    <div class="col-xl-9 col-lg-8 col-md-12">
                        @if ($blogs->isNotEmpty())
                            <div class="trending-section mb-5">
                                <div class="blog-section-header">
                                    <h2 class="blog-section-title">
                                        <i class="fa fa-fire"></i> {{ $isFiltered ? 'Results' : 'Latest Articles' }}
                                    </h2>
                                    @if ($blogs->lastPage() > 1)
                                        <span class="text-white-50" style="font-size: 13px;">Page {{ $blogs->currentPage() }} of {{ $blogs->lastPage() }}</span>
                                    @endif
                                </div>

                                <div class="row">
                                    @foreach ($blogs as $blog)
                                        @php
                                            $url = route('blog.show', $blog->slug);
                                            $location = optional($blog->city)->name ?: optional($blog->state)->name ?: optional($blog->country)->name;
                                        @endphp
                                        <div class="col-xl-4 col-md-6 mb-4">
                                            <article class="trending-card">
                                                <div class="trending-img-box">
                                                    <a href="{{ $url }}" tabindex="-1" aria-hidden="true">
                                                        <img src="{{ $blog->featured_image ? $blog->featured_image_url : asset('images/escort_logo1.png') }}"
                                                            alt="{{ $blog->featured_image_alt ?: $blog->title }}" loading="lazy">
                                                    </a>
                                                    @if ($blog->categories->isNotEmpty())
                                                        <span class="category-badge">{{ $blog->categories->first()->name }}</span>
                                                    @endif
                                                </div>
                                                <div class="trending-content">
                                                    <div class="trending-meta">
                                                        <img src="{{ asset('images/default-profile.png') }}" class="author-avatar" alt="">
                                                        <span class="author-name">{{ optional($blog->author)->name ?: config('app.name') }}</span>
                                                        <time class="post-date" datetime="{{ $blog->published_at->toAtomString() }}"><i class="fa fa-clock"></i> {{ $blog->published_at->format('d M Y') }}</time>
                                                    </div>
                                                    <h3 class="trending-title">
                                                        <a href="{{ $url }}">{{ $blog->title }}</a>
                                                    </h3>
                                                    <p class="trending-excerpt">
                                                        {{ \Illuminate\Support\Str::limit($blog->excerpt ?: $blog->plain_text, 140) }}
                                                    </p>
                                                    <div class="trending-footer">
                                                        @if ($location)
                                                            <span class="post-location-tag"><i class="fa fa-map-marker-alt"></i> {{ $location }}</span>
                                                        @else
                                                            <span class="post-location-tag"><i class="fa fa-book-open"></i> {{ $blog->reading_minutes }} min read</span>
                                                        @endif
                                                        <a href="{{ $url }}" class="read-more-link" aria-label="Read more: {{ $blog->title }}">Read More <i
                                                                class="fa fa-arrow-right"></i></a>
                                                    </div>
                                                </div>
                                            </article>
                                        </div>
                                    @endforeach
                                </div>

                                @if ($blogs->hasPages())
                                    <nav class="d-flex justify-content-center mt-2" aria-label="Blog pages">
                                        {{ $blogs->onEachSide(1)->links('pagination::bootstrap-4') }}
                                    </nav>
                                @endif
                            </div>
                        @endif
                    </div>

                    <!-- RIGHT COLUMN (STICKY SIDEBAR) -->
                    <div class="col-xl-3 col-lg-4 col-md-12">
                        <aside class="blog-sidebar">
                            @if ($recentBlogs->isNotEmpty())
                                <div class="sidebar-widget">
                                    <h3 class="sidebar-widget-title">
                                        <span><i class="fa fa-clock text-danger mr-2"></i> Recent Posts</span>
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
                                                    <div class="sidebar-post-date"><i class="fa fa-calendar-alt text-danger mr-1"></i> {{ $recent->published_at->format('d M Y') }}</div>
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
    </div>

    <script>
        // Filters submit on change; changing a parent location clears its now-invalid children.
        document.querySelectorAll('#blogFilterForm select').forEach(function (select) {
            select.addEventListener('change', function () {
                (select.getAttribute('data-resets') || '').split(',').filter(Boolean).forEach(function (id) {
                    document.getElementById(id).value = '';
                });
                select.form.submit();
            });
        });
    </script>

@endsection
