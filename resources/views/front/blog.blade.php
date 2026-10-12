@extends('front.layout.layout')

@section('content')

    <!-- Swiper Slider CSS CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />

    <div class="main-area" id="blog-page-content">
        <!-- Main Blog Section -->
        <section class="blog-main-wrapper">
            <div class="container-fluid">

                <div class="blog-filter-card">
                    <div class="blog-filter-header">
                        <h3 class="blog-filter-header-title">
                            <i class="fa fa-sliders-h"></i> Filter Blog Articles
                        </h3>
                        <span class="filter-count-badge" id="filterArticlesCount">Showing All Articles</span>
                    </div>

                    <form id="blogFilterForm" onsubmit="event.preventDefault(); applyBlogFilters();">
                        <div class="row align-items-end">
                            <!-- Country Filter -->
                            <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
                                <label class="form-label" for="filterCountry"><i class="fa fa-globe text-theme mr-1"></i>
                                    Country</label>
                                <select id="filterCountry" class="form-control"
                                    onchange="onCountryChange(); applyBlogFilters();">
                                    <option value="">All Countries</option>
                                    <option value="United States">United States</option>
                                    <option value="United Kingdom">United Kingdom</option>
                                    <option value="Australia">Australia</option>
                                    <option value="Canada">Canada</option>
                                    <option value="Germany">Germany</option>
                                    <option value="United Arab Emirates">UAE</option>
                                </select>
                            </div>

                            <!-- State Filter -->
                            <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
                                <label class="form-label" for="filterState"><i class="fa fa-map text-theme mr-1"></i>
                                    State</label>
                                <select id="filterState" class="form-control" onchange="applyBlogFilters();">
                                    <option value="">All States</option>
                                    <option value="California">California</option>
                                    <option value="New York">New York</option>
                                    <option value="Florida">Florida</option>
                                    <option value="Texas">Texas</option>
                                    <option value="London">London (Greater)</option>
                                    <option value="Dubai">Dubai Emirate</option>
                                </select>
                            </div>

                            <!-- City Filter -->
                            <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
                                <label class="form-label" for="filterCity"><i
                                        class="fa fa-map-marker-alt text-theme mr-1"></i>
                                    City</label>
                                <select id="filterCity" class="form-control" onchange="applyBlogFilters();">
                                    <option value="">All Cities</option>
                                    <option value="Los Angeles">Los Angeles</option>
                                    <option value="New York City">New York City</option>
                                    <option value="Miami">Miami</option>
                                    <option value="Las Vegas">Las Vegas</option>
                                    <option value="London">London</option>
                                    <option value="Dubai">Dubai</option>
                                </select>
                            </div>

                            <!-- Category Filter -->
                            <div class="col-lg-3 col-md-6 col-sm-6 mb-3">
                                <label class="form-label" for="filterCategory"><i class="fa fa-tags text-theme mr-1"></i>
                                    Category</label>
                                <select id="filterCategory" class="form-control" onchange="applyBlogFilters();">
                                    <option value="">All Categories</option>
                                    <option value="VIP Escorts">VIP Escorts</option>
                                    <option value="Nightlife">Nightlife & Parties</option>
                                    <option value="Dating Tips">Dating Tips</option>
                                    <option value="Luxury Lifestyle">Luxury Lifestyle</option>
                                    <option value="Travel Guides">Travel Guides</option>
                                </select>
                            </div>

                            <!-- Search Input & Buttons -->
                            <div class="col-lg-3 col-md-6 col-sm-12 mb-3">
                                <label class="form-label" for="filterKeyword"><i class="fa fa-search text-theme mr-1"></i>
                                    Keyword</label>
                                <div class="d-flex gap-2" style="gap: 8px;">
                                    <input type="text" id="filterKeyword" class="form-control" placeholder="Search title..."
                                        onkeyup="applyBlogFilters();">
                                    <button type="button" class="btn-filter-reset" onclick="resetBlogFilters();"
                                        title="Reset Filters" style="width: 48px; min-width: 48px;">
                                        <i class="fa fa-undo"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <div id="noResultsAlert" class="no-results-alert">
                    <i class="fa fa-search-minus"></i>
                    <h4 class="text-white mb-2">No Matching Blog Articles Found</h4>
                    <p class="text-white-50 mb-3">We couldn't find any articles matching your selected criteria. Try
                        adjusting
                        the city, country, or category filter.</p>
                    <button type="button" class="btn-filter-apply" onclick="resetBlogFilters();"
                        style="display: inline-flex; width: auto; padding: 0 25px;">
                        <i class="fa fa-sync-alt mr-2"></i> Reset All Filters
                    </button>
                </div>

                <div class="row" id="blogMainContentRow">

                    <!-- LEFT COLUMN: 8 Columns -->
                    <div class="col-xl-9 col-lg-8 col-md-12">
                        <div class="trending-section mb-5" id="trendingSection">
                            <div class="blog-section-header">
                                <h2 class="blog-section-title">
                                    <i class="fa fa-fire"></i> Trending Articles
                                </h2>
                                <span class="text-white-50" style="font-size: 13px;">Top Selected For You</span>
                            </div>

                            <div class="row">
                                <!-- Card 1 -->
                                <div class="col-xl-4 col-md-6 mb-4 filterable-blog-card" data-country="United States"
                                    data-state="California" data-city="Los Angeles" data-category="VIP Escorts"
                                    data-title="Posts About Business & VIP Luxury Lifestyle in Los Angeles">
                                    <a href="{{ route('blog_detail') }}">
                                        <div class="trending-card">
                                            <div class="trending-img-box">
                                                <img src="{{ asset('images/blog/01.jpg') }}"
                                                    alt="VIP Luxury Escorts Los Angeles">
                                                <span class="category-badge">VIP Escorts</span>
                                                <button class="card-action-btn" title="Share Article"><i
                                                        class="fa fa-share-alt"></i></button>
                                            </div>
                                            <div class="trending-content">
                                                <div class="trending-meta">
                                                    <img src="{{ asset('images/default-profile.png') }}"
                                                        class="author-avatar" alt="Author">
                                                    <span class="author-name">Katen Doe</span>
                                                    <span class="post-date"><i class="fa fa-clock"></i> 24 Mar 2026</span>
                                                </div>
                                                <h3 class="trending-title">
                                                    <a href="javascript:void(0);">Posts About Business & VIP Luxury
                                                        Lifestyle in
                                                        Los
                                                        Angeles</a>
                                                </h3>
                                                <p class="trending-excerpt">
                                                    Experience the high-profile companion etiquette and premier
                                                    entertainment
                                                    secrets from top VIP models in Los Angeles.
                                                </p>
                                                <div class="trending-footer">
                                                    <span class="post-location-tag"><i class="fa fa-map-marker-alt"></i> Los
                                                        Angeles, USA</span>
                                                    <a href="javascript:void(0);" class="read-more-link">Read More <i
                                                            class="fa fa-arrow-right"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <!-- Card 2 -->
                                <div class="col-xl-4 col-md-6 mb-4 filterable-blog-card" data-country="United Kingdom"
                                    data-state="London" data-city="London" data-category="Nightlife"
                                    data-title="5 Easy Ways You Can Elevate Your London Nightlife Experience">
                                    <div class="trending-card">
                                        <div class="trending-img-box">
                                            <img src="{{ asset('images/blog/02.jpg') }}" alt="London Nightlife">
                                            <span class="category-badge">Nightlife</span>
                                            <button class="card-action-btn" title="Share Article"><i
                                                    class="fa fa-share-alt"></i></button>
                                        </div>
                                        <div class="trending-content">
                                            <div class="trending-meta">
                                                <img src="{{ asset('images/default-profile.png') }}" class="author-avatar"
                                                    alt="Author">
                                                <span class="author-name">David Ross</span>
                                                <span class="post-date"><i class="fa fa-clock"></i> 22 Mar 2026</span>
                                            </div>
                                            <h3 class="trending-title">
                                                <a href="javascript:void(0);">5 Easy Ways You Can Elevate Your London
                                                    Nightlife
                                                    Experience</a>
                                            </h3>
                                            <p class="trending-excerpt">
                                                A comprehensive insider guide to London's most secretive clubs, private
                                                suites,
                                                and unforgettable nighttime celebrations.
                                            </p>
                                            <div class="trending-footer">
                                                <span class="post-location-tag"><i class="fa fa-map-marker-alt"></i>
                                                    London,
                                                    UK</span>
                                                <a href="javascript:void(0);" class="read-more-link">Read More <i
                                                        class="fa fa-arrow-right"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Card 3 -->
                                <div class="col-xl-4 col-md-6 mb-4 filterable-blog-card" data-country="United States"
                                    data-state="Florida" data-city="Miami" data-category="Luxury Lifestyle"
                                    data-title="The Ultimate Yacht & Beach VIP Guide In Miami South Beach">
                                    <div class="trending-card">
                                        <div class="trending-img-box">
                                            <img src="{{ asset('images/blog/04.jpg') }}" alt="Miami Luxury Lifestyle">
                                            <span class="category-badge">Luxury Lifestyle</span>
                                            <button class="card-action-btn" title="Share Article"><i
                                                    class="fa fa-share-alt"></i></button>
                                        </div>
                                        <div class="trending-content">
                                            <div class="trending-meta">
                                                <img src="{{ asset('images/default-profile.png') }}" class="author-avatar"
                                                    alt="Author">
                                                <span class="author-name">Elena Rose</span>
                                                <span class="post-date"><i class="fa fa-clock"></i> 18 Mar 2026</span>
                                            </div>
                                            <h3 class="trending-title">
                                                <a href="javascript:void(0);">The Ultimate Yacht & Beach VIP Guide In
                                                    Miami
                                                    South Beach</a>
                                            </h3>
                                            <p class="trending-excerpt">
                                                Everything you need to plan private yacht escapades, luxury dinners, and
                                                glamorous evenings along the coast.
                                            </p>
                                            <div class="trending-footer">
                                                <span class="post-location-tag"><i class="fa fa-map-marker-alt"></i>
                                                    Miami,
                                                    USA</span>
                                                <a href="javascript:void(0);" class="read-more-link">Read More <i
                                                        class="fa fa-arrow-right"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Card 4 -->
                                <div class="col-xl-4 col-md-6 mb-4 filterable-blog-card" data-country="United Arab Emirates"
                                    data-state="Dubai" data-city="Dubai" data-category="Dating Tips"
                                    data-title="Exclusive Dating Etiquette & Luxury Companion Secrets in Dubai">
                                    <div class="trending-card">
                                        <div class="trending-img-box">
                                            <img src="{{ asset('images/blog/05.jpg') }}" alt="Dubai Dating Tips">
                                            <span class="category-badge">Dating Tips</span>
                                            <button class="card-action-btn" title="Share Article"><i
                                                    class="fa fa-share-alt"></i></button>
                                        </div>
                                        <div class="trending-content">
                                            <div class="trending-meta">
                                                <img src="{{ asset('images/default-profile.png') }}" class="author-avatar"
                                                    alt="Author">
                                                <span class="author-name">Sophia Noor</span>
                                                <span class="post-date"><i class="fa fa-clock"></i> 15 Mar 2026</span>
                                            </div>
                                            <h3 class="trending-title">
                                                <a href="javascript:void(0);">Exclusive Dating Etiquette & Luxury
                                                    Companion
                                                    Secrets in Dubai</a>
                                            </h3>
                                            <p class="trending-excerpt">
                                                Mastering the art of discreet gentlemanly etiquette when entertaining
                                                high-caliber companions in Dubai.
                                            </p>
                                            <div class="trending-footer">
                                                <span class="post-location-tag"><i class="fa fa-map-marker-alt"></i>
                                                    Dubai,
                                                    UAE</span>
                                                <a href="javascript:void(0);" class="read-more-link">Read More <i
                                                        class="fa fa-arrow-right"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="editors-pick-wrapper mb-5" id="editorsPickSection">
                            <div class="blog-section-header">
                                <h2 class="blog-section-title">
                                    <i class="fa fa-star"></i> Editor's Pick
                                </h2>
                                <span class="text-white-50" style="font-size: 13px;">Curated Highlights</span>
                            </div>

                            <div class="row">
                                <!-- Featured Main Card (Left) -->
                                <div class="col-lg-7 col-md-12 mb-4 filterable-blog-card" data-country="United States"
                                    data-state="New York" data-city="New York City" data-category="VIP Escorts"
                                    data-title="15 Unheard Ways To Achieve Greater Moments in New York">
                                    <div class="editor-featured-card">
                                        <div class="editor-featured-img">
                                            <img src="{{ asset('images/blog/03-big.jpg') }}" alt="Editor's Pick NYC">
                                            <span class="category-badge">VIP Escorts</span>
                                            <button class="card-action-btn" title="Share Article"><i
                                                    class="fa fa-share-alt"></i></button>
                                        </div>
                                        <div class="editor-featured-body">
                                            <div class="trending-meta">
                                                <img src="{{ asset('images/default-profile.png') }}" class="author-avatar"
                                                    alt="Author">
                                                <span class="author-name">Alexander Wright</span>
                                                <span class="post-date"><i class="fa fa-clock"></i> 27 Mar 2026</span>
                                            </div>
                                            <h3 class="editor-featured-title">
                                                <a href="javascript:void(0);">15 Unheard Ways To Achieve Greater Moments in
                                                    New
                                                    York</a>
                                            </h3>
                                            <p class="editor-featured-excerpt">
                                                From discreet Manhattan rooftop reservations to private penthouse suites,
                                                discover the definitive guide to enjoying New York City like true royalty.
                                            </p>
                                            <div class="trending-footer mt-auto">
                                                <span class="post-location-tag"><i class="fa fa-map-marker-alt"></i> New
                                                    York
                                                    City, USA</span>
                                                <a href="javascript:void(0);" class="read-more-link">Read Full Story <i
                                                        class="fa fa-arrow-right"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- 4 Compact Horizontal Cards (Right) -->
                                <div class="col-lg-5 col-md-12">
                                    <!-- Compact 1 -->
                                    <div class="editor-compact-item filterable-blog-card" data-country="United States"
                                        data-state="California" data-city="Los Angeles" data-category="Lifestyle"
                                        data-title="3 Easy Ways To Make Your Encounters Better">
                                        <div class="editor-compact-thumb">
                                            <img src="{{ asset('images/blog/06.jpg') }}" alt="Compact Post 1">
                                        </div>
                                        <div class="editor-compact-info">
                                            <div class="editor-compact-tag">Lifestyle</div>
                                            <h4 class="editor-compact-title">
                                                <a href="javascript:void(0);">3 Easy Ways To Make Your Encounters Better</a>
                                            </h4>
                                            <div class="editor-compact-date">
                                                <i class="fa fa-calendar-alt text-danger"></i> 19 Mar 2026
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Compact 2 -->
                                    <div class="editor-compact-item filterable-blog-card" data-country="Australia"
                                        data-state="Victoria" data-city="Melbourne" data-category="Nightlife"
                                        data-title="Secret Rooftop Lounges You Must Visit in 2026">
                                        <div class="editor-compact-thumb">
                                            <img src="{{ asset('images/blog/07.jpg') }}" alt="Compact Post 2">
                                        </div>
                                        <div class="editor-compact-info">
                                            <div class="editor-compact-tag">Nightlife</div>
                                            <h4 class="editor-compact-title">
                                                <a href="javascript:void(0);">Secret Rooftop Lounges You Must Visit in
                                                    2026</a>
                                            </h4>
                                            <div class="editor-compact-date">
                                                <i class="fa fa-calendar-alt text-danger"></i> 14 Mar 2026
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Compact 3 -->
                                    <div class="editor-compact-item filterable-blog-card" data-country="Canada"
                                        data-state="Ontario" data-city="Toronto" data-category="Travel Guides"
                                        data-title="10 Rules For Booking Five-Star Escort Suites">
                                        <div class="editor-compact-thumb">
                                            <img src="{{ asset('images/blog/08.jpg') }}" alt="Compact Post 3">
                                        </div>
                                        <div class="editor-compact-info">
                                            <div class="editor-compact-tag">Travel Guides</div>
                                            <h4 class="editor-compact-title">
                                                <a href="javascript:void(0);">10 Rules For Booking Five-Star Escort
                                                    Suites</a>
                                            </h4>
                                            <div class="editor-compact-date">
                                                <i class="fa fa-calendar-alt text-danger"></i> 10 Mar 2026
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Compact 4 -->
                                    <div class="editor-compact-item filterable-blog-card" data-country="United States"
                                        data-state="Nevada" data-city="Las Vegas" data-category="VIP Escorts"
                                        data-title="High Roller Party Secrets in Downtown Las Vegas">
                                        <div class="editor-compact-thumb">
                                            <img src="{{ asset('images/blog/09.jpg') }}" alt="Compact Post 4">
                                        </div>
                                        <div class="editor-compact-info">
                                            <div class="editor-compact-tag">VIP Escorts</div>
                                            <h4 class="editor-compact-title">
                                                <a href="javascript:void(0);">High Roller Party Secrets in Downtown Las
                                                    Vegas</a>
                                            </h4>
                                            <div class="editor-compact-date">
                                                <i class="fa fa-calendar-alt text-danger"></i> 05 Mar 2026
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- ==============================================
                                                                                                                                                                                                 RIGHT COLUMN: 4 Columns (STICKY SIDEBAR)
                                                                                                                                                                                                 ============================================== -->
                    <div class="col-xl-3 col-lg-4 col-md-12">
                        <aside class="blog-sidebar">

                            <!-- WIDGET 1: POPULAR & RECENT TABS -->
                            <div class="sidebar-widget">
                                <div class="sidebar-tabs-nav">
                                    <button type="button" class="sidebar-tab-btn active"
                                        onclick="switchSidebarTab(this, 'popularPostsTab');">
                                        <i class="fa fa-chart-line mr-1"></i> Popular
                                    </button>
                                    <button type="button" class="sidebar-tab-btn"
                                        onclick="switchSidebarTab(this, 'recentPostsTab');">
                                        <i class="fa fa-clock mr-1"></i> Recent
                                    </button>
                                </div>

                                <!-- Popular Posts Pane -->
                                <div class="sidebar-tab-pane active" id="popularPostsTab">
                                    <!-- Item 1 -->
                                    <div class="sidebar-post-item">
                                        <div class="sidebar-post-thumb">
                                            <img src="{{ asset('images/blog/01.jpg') }}" alt="Popular 1">
                                            <span class="sidebar-post-number">1</span>
                                        </div>
                                        <div class="sidebar-post-info">
                                            <h4 class="sidebar-post-title">
                                                <a href="javascript:void(0);">15 Unheard Ways To Achieve Greater Moments</a>
                                            </h4>
                                            <div class="sidebar-post-date"><i
                                                    class="fa fa-calendar-alt text-danger mr-1"></i>
                                                27 Mar 2026</div>
                                        </div>
                                    </div>

                                    <!-- Item 2 -->
                                    <div class="sidebar-post-item">
                                        <div class="sidebar-post-thumb">
                                            <img src="{{ asset('images/blog/02.jpg') }}" alt="Popular 2">
                                            <span class="sidebar-post-number">2</span>
                                        </div>
                                        <div class="sidebar-post-info">
                                            <h4 class="sidebar-post-title">
                                                <a href="javascript:void(0);">5 Easy Ways You Can Elevate Your Nightlife</a>
                                            </h4>
                                            <div class="sidebar-post-date"><i
                                                    class="fa fa-calendar-alt text-danger mr-1"></i>
                                                22 Mar 2026</div>
                                        </div>
                                    </div>

                                    <!-- Item 3 -->
                                    <div class="sidebar-post-item">
                                        <div class="sidebar-post-thumb">
                                            <img src="{{ asset('images/blog/04.jpg') }}" alt="Popular 3">
                                            <span class="sidebar-post-number">3</span>
                                        </div>
                                        <div class="sidebar-post-info">
                                            <h4 class="sidebar-post-title">
                                                <a href="javascript:void(0);">An Incredibly Easy Method That Works For
                                                    All</a>
                                            </h4>
                                            <div class="sidebar-post-date"><i
                                                    class="fa fa-calendar-alt text-danger mr-1"></i>
                                                18 Mar 2026</div>
                                        </div>
                                    </div>

                                    <!-- Item 4 -->
                                    <div class="sidebar-post-item">
                                        <div class="sidebar-post-thumb">
                                            <img src="{{ asset('images/blog/05.jpg') }}" alt="Popular 4">
                                            <span class="sidebar-post-number">4</span>
                                        </div>
                                        <div class="sidebar-post-info">
                                            <h4 class="sidebar-post-title">
                                                <a href="javascript:void(0);">10 Rules For Booking Five-Star Escort
                                                    Suites</a>
                                            </h4>
                                            <div class="sidebar-post-date"><i
                                                    class="fa fa-calendar-alt text-danger mr-1"></i>
                                                15 Mar 2026</div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Recent Posts Pane -->
                                <div class="sidebar-tab-pane" id="recentPostsTab">
                                    <!-- Item 1 -->
                                    <div class="sidebar-post-item">
                                        <div class="sidebar-post-thumb">
                                            <img src="{{ asset('images/blog/08.jpg') }}" alt="Recent 1">
                                            <span class="sidebar-post-number">1</span>
                                        </div>
                                        <div class="sidebar-post-info">
                                            <h4 class="sidebar-post-title">
                                                <a href="javascript:void(0);">High Roller Party Secrets in Downtown Las
                                                    Vegas</a>
                                            </h4>
                                            <div class="sidebar-post-date"><i
                                                    class="fa fa-calendar-alt text-danger mr-1"></i>
                                                Today</div>
                                        </div>
                                    </div>

                                    <!-- Item 2 -->
                                    <div class="sidebar-post-item">
                                        <div class="sidebar-post-thumb">
                                            <img src="{{ asset('images/blog/09.jpg') }}" alt="Recent 2">
                                            <span class="sidebar-post-number">2</span>
                                        </div>
                                        <div class="sidebar-post-info">
                                            <h4 class="sidebar-post-title">
                                                <a href="javascript:void(0);">Secret Rooftop Lounges You Must Visit in
                                                    2026</a>
                                            </h4>
                                            <div class="sidebar-post-date"><i
                                                    class="fa fa-calendar-alt text-danger mr-1"></i>
                                                Yesterday</div>
                                        </div>
                                    </div>

                                    <!-- Item 3 -->
                                    <div class="sidebar-post-item">
                                        <div class="sidebar-post-thumb">
                                            <img src="{{ asset('images/blog/06.jpg') }}" alt="Recent 3">
                                            <span class="sidebar-post-number">3</span>
                                        </div>
                                        <div class="sidebar-post-info">
                                            <h4 class="sidebar-post-title">
                                                <a href="javascript:void(0);">3 Easy Ways To Make Your Encounters Better</a>
                                            </h4>
                                            <div class="sidebar-post-date"><i
                                                    class="fa fa-calendar-alt text-danger mr-1"></i> 3
                                                Days Ago</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="sidebar-widget">
                                <h3 class="sidebar-widget-title">
                                    <span><i class="fa fa-folder-open text-danger mr-2"></i> Explore Topics</span>
                                </h3>
                                <ul class="topics-list">
                                    <li class="topic-item">
                                        <a href="javascript:void(0);" class="topic-link"
                                            onclick="quickFilterByCategory('VIP Escorts');">
                                            <span class="topic-name"><i class="fa fa-chevron-right"></i> VIP Escorts</span>
                                            <span class="topic-count">18</span>
                                        </a>
                                    </li>
                                    <li class="topic-item">
                                        <a href="javascript:void(0);" class="topic-link"
                                            onclick="quickFilterByCategory('Nightlife');">
                                            <span class="topic-name"><i class="fa fa-chevron-right"></i> Nightlife &
                                                Parties</span>
                                            <span class="topic-count">14</span>
                                        </a>
                                    </li>
                                    <li class="topic-item">
                                        <a href="javascript:void(0);" class="topic-link"
                                            onclick="quickFilterByCategory('Dating Tips');">
                                            <span class="topic-name"><i class="fa fa-chevron-right"></i> Dating Tips</span>
                                            <span class="topic-count">22</span>
                                        </a>
                                    </li>
                                    <li class="topic-item">
                                        <a href="javascript:void(0);" class="topic-link"
                                            onclick="quickFilterByCategory('Luxury Lifestyle');">
                                            <span class="topic-name"><i class="fa fa-chevron-right"></i> Luxury
                                                Lifestyle</span>
                                            <span class="topic-count">11</span>
                                        </a>
                                    </li>
                                    <li class="topic-item">
                                        <a href="javascript:void(0);" class="topic-link"
                                            onclick="quickFilterByCategory('Travel Guides');">
                                            <span class="topic-name"><i class="fa fa-chevron-right"></i> Travel
                                                Guides</span>
                                            <span class="topic-count">09</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>

                            <div class="sidebar-widget newsletter-widget">
                                <div class="newsletter-icon-wrap">
                                    <i class="fa fa-envelope-open-text"></i>
                                </div>
                                <h4>Newsletter</h4>
                                <p>Join <strong>25,000+ VIP subscribers</strong> to receive private invitations, top
                                    stories,
                                    and city guides directly in your inbox.</p>

                                <form onsubmit="event.preventDefault(); handleNewsletterSubscribe(this);">
                                    <input type="email" class="form-control" placeholder="Enter your email address..."
                                        required>
                                    <button type="submit" class="newsletter-btn">
                                        <i class="fa fa-paper-plane mr-1"></i> Sign Up
                                    </button>
                                </form>
                                <p class="newsletter-note">By signing up, you agree to our Terms & Privacy Policy.</p>
                            </div>

                            <!-- WIDGET 4: TAG CLOUDS -->
                            <div class="sidebar-widget">
                                <h3 class="sidebar-widget-title">
                                    <span><i class="fa fa-hashtag text-danger mr-2"></i> Tag Clouds</span>
                                </h3>
                                <div class="tag-cloud-list">
                                    <a href="javascript:void(0);" class="tag-pill"
                                        onclick="quickSearchByTag('VIP');">#VIP</a>
                                    <a href="javascript:void(0);" class="tag-pill"
                                        onclick="quickSearchByTag('Nightlife');">#Nightlife</a>
                                    <a href="javascript:void(0);" class="tag-pill"
                                        onclick="quickSearchByTag('Luxury');">#Luxury</a>
                                    <a href="javascript:void(0);" class="tag-pill"
                                        onclick="quickSearchByTag('Escorts');">#Escorts</a>
                                    <a href="javascript:void(0);" class="tag-pill"
                                        onclick="quickSearchByTag('Dating');">#Dating</a>
                                    <a href="javascript:void(0);" class="tag-pill"
                                        onclick="quickSearchByTag('Models');">#Models</a>
                                    <a href="javascript:void(0);" class="tag-pill"
                                        onclick="quickSearchByTag('Hotels');">#Hotels</a>
                                    <a href="javascript:void(0);" class="tag-pill"
                                        onclick="quickSearchByTag('Suites');">#Suites</a>
                                    <a href="javascript:void(0);" class="tag-pill"
                                        onclick="quickSearchByTag('Private');">#Private</a>
                                </div>
                            </div>

                        </aside>
                    </div>

                </div>

                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="inspiration-wrapper" id="inspirationSection">
                                <div class="blog-section-header">
                                    <h2 class="blog-section-title">
                                        <i class="fa fa-compass"></i> Inspiration & Spotlight
                                    </h2>
                                    <div class="carousel-nav-controls">
                                        <button type="button" class="carousel-arrow-btn" id="carouselPrevBtn"
                                            onclick="moveCarousel(-1);" title="Previous">
                                            <i class="fa fa-chevron-left"></i>
                                        </button>
                                        <button type="button" class="carousel-arrow-btn" id="carouselNextBtn"
                                            onclick="moveCarousel(1);" title="Next">
                                            <i class="fa fa-chevron-right"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="swiper inspirationSwiper">
                                    <div class="swiper-wrapper">

                                        <!-- Slide 1 -->
                                        <div class="swiper-slide">
                                            <div class="inspiration-card">
                                                <img src="{{ asset('images/blog/07-big.jpg') }}" class="inspiration-card-bg"
                                                    alt="Inspiration 1">
                                                <div class="inspiration-card-overlay"></div>
                                                <div class="inspiration-card-content">
                                                    <span class="inspiration-badge">Spotlight</span>
                                                    <h3 class="inspiration-title">
                                                        <a href="javascript:void(0);">Feel Like A Pro With The Help Of These
                                                            7 Dating Tips</a>
                                                    </h3>
                                                    <div class="inspiration-meta">
                                                        <span><i class="fa fa-user text-danger mr-1"></i> Marcus Reed</span>
                                                        <span><i class="fa fa-calendar-alt text-danger mr-1"></i> 26 Mar
                                                            2026</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Slide 2 -->
                                        <div class="swiper-slide">
                                            <div class="inspiration-card">
                                                <img src="{{ asset('images/home_1.jpg') }}" class="inspiration-card-bg"
                                                    alt="Inspiration 2">
                                                <div class="inspiration-card-overlay"></div>
                                                <div class="inspiration-card-content">
                                                    <span class="inspiration-badge">VIP Stories</span>
                                                    <h3 class="inspiration-title">
                                                        <a href="javascript:void(0);">Want To Have A More Appealing
                                                            Companion Profile?</a>
                                                    </h3>
                                                    <div class="inspiration-meta">
                                                        <span><i class="fa fa-user text-danger mr-1"></i> Jessica
                                                            Vance</span>
                                                        <span><i class="fa fa-calendar-alt text-danger mr-1"></i> 21 Mar
                                                            2026</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Slide 3 -->
                                        <div class="swiper-slide">
                                            <div class="inspiration-card">
                                                <img src="{{ asset('images/home_2.jpg') }}" class="inspiration-card-bg"
                                                    alt="Inspiration 3">
                                                <div class="inspiration-card-overlay"></div>
                                                <div class="inspiration-card-content">
                                                    <span class="inspiration-badge">Global Escorts</span>
                                                    <h3 class="inspiration-title">
                                                        <a href="javascript:void(0);">Top 10 Global Destinations For Elite
                                                            Gentleman Getaways</a>
                                                    </h3>
                                                    <div class="inspiration-meta">
                                                        <span><i class="fa fa-user text-danger mr-1"></i> Lucas Silva</span>
                                                        <span><i class="fa fa-calendar-alt text-danger mr-1"></i> 17 Mar
                                                            2026</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Slide 4 -->
                                        <div class="swiper-slide">
                                            <div class="inspiration-card">
                                                <img src="{{ asset('images/home_3.jpg') }}" class="inspiration-card-bg"
                                                    alt="Inspiration 4">
                                                <div class="inspiration-card-overlay"></div>
                                                <div class="inspiration-card-content">
                                                    <span class="inspiration-badge">Discretion</span>
                                                    <h3 class="inspiration-title">
                                                        <a href="javascript:void(0);">How To Maintain Absolute Discretion &
                                                            Privacy Always</a>
                                                    </h3>
                                                    <div class="inspiration-meta">
                                                        <span><i class="fa fa-user text-danger mr-1"></i> Brandon
                                                            Miller</span>
                                                        <span><i class="fa fa-calendar-alt text-danger mr-1"></i> 12 Mar
                                                            2026</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Slide 5 -->
                                        <div class="swiper-slide">
                                            <div class="inspiration-card">
                                                <img src="{{ asset('images/blog/03-big.jpg') }}" class="inspiration-card-bg"
                                                    alt="Inspiration 5">
                                                <div class="inspiration-card-overlay"></div>
                                                <div class="inspiration-card-content">
                                                    <span class="inspiration-badge">Exclusive</span>
                                                    <h3 class="inspiration-title">
                                                        <a href="javascript:void(0);">Exclusive Penthouse Parties & VIP City
                                                            Encounters</a>
                                                    </h3>
                                                    <div class="inspiration-meta">
                                                        <span><i class="fa fa-user text-danger mr-1"></i> Sophia Rose</span>
                                                        <span><i class="fa fa-calendar-alt text-danger mr-1"></i> 08 Mar
                                                            2026</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Slide 6 -->
                                        <div class="swiper-slide">
                                            <div class="inspiration-card">
                                                <img src="{{ asset('images/blog/04.jpg') }}" class="inspiration-card-bg"
                                                    alt="Inspiration 6">
                                                <div class="inspiration-card-overlay"></div>
                                                <div class="inspiration-card-content">
                                                    <span class="inspiration-badge">Fine Dining</span>
                                                    <h3 class="inspiration-title">
                                                        <a href="javascript:void(0);">The Art Of Fine Dining & Luxury Date
                                                            Etiquette</a>
                                                    </h3>
                                                    <div class="inspiration-meta">
                                                        <span><i class="fa fa-user text-danger mr-1"></i> David Lee</span>
                                                        <span><i class="fa fa-calendar-alt text-danger mr-1"></i> 04 Mar
                                                            2026</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Slide 7 -->
                                        <div class="swiper-slide">
                                            <div class="inspiration-card">
                                                <img src="{{ asset('images/blog/05.jpg') }}" class="inspiration-card-bg"
                                                    alt="Inspiration 7">
                                                <div class="inspiration-card-overlay"></div>
                                                <div class="inspiration-card-content">
                                                    <span class="inspiration-badge">Nightclubs</span>
                                                    <h3 class="inspiration-title">
                                                        <a href="javascript:void(0);">Top International Nightclubs For High
                                                            Rollers</a>
                                                    </h3>
                                                    <div class="inspiration-meta">
                                                        <span><i class="fa fa-user text-danger mr-1"></i> Mia Taylor</span>
                                                        <span><i class="fa fa-calendar-alt text-danger mr-1"></i> 01 Mar
                                                            2026</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Slide 8 -->
                                        <div class="swiper-slide">
                                            <div class="inspiration-card">
                                                <img src="{{ asset('images/blog/08.jpg') }}" class="inspiration-card-bg"
                                                    alt="Inspiration 8">
                                                <div class="inspiration-card-overlay"></div>
                                                <div class="inspiration-card-content">
                                                    <span class="inspiration-badge">Companionship</span>
                                                    <h3 class="inspiration-title">
                                                        <a href="javascript:void(0);">Redefining High-Profile Social
                                                            Companionship</a>
                                                    </h3>
                                                    <div class="inspiration-meta">
                                                        <span><i class="fa fa-user text-danger mr-1"></i> Alex Morgan</span>
                                                        <span><i class="fa fa-calendar-alt text-danger mr-1"></i> 25 Feb
                                                            2026</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <!-- Load More Button -->
                            <div class="load-more-section">
                                <button type="button" class="btn-load-more"
                                    onclick="alert('All latest articles are currently displayed.');">
                                    <i class="fa fa-spinner fa-spin mr-1" style="display: none;" id="loadMoreSpinner"></i>
                                    Load
                                    More
                                    Articles <i class="fa fa-chevron-down ml-1"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>


    <!-- Swiper Slider JS CDN -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
    <script>
        // Tab Switcher for Sidebar
        function switchSidebarTab(btnElement, targetTabId) {
            document.querySelectorAll('.sidebar-tab-btn').forEach(btn => btn.classList.remove('active'));
            document.querySelectorAll('.sidebar-tab-pane').forEach(pane => pane.classList.remove('active'));

            btnElement.classList.add('active');
            const targetPane = document.getElementById(targetTabId);
            if (targetPane) {
                targetPane.classList.add('active');
            }
        }

        // Swiper Slider Initialization (lg: 4, xl: 5, tablet: 2, mobile: 1)
        document.addEventListener('DOMContentLoaded', function () {
            if (typeof Swiper !== 'undefined') {
                const inspirationSwiper = new Swiper('.inspirationSwiper', {
                    slidesPerView: 1, // Mobile default: 1 card
                    spaceBetween: 14,
                    loop: true,
                    autoplay: {
                        delay: 3500,
                        disableOnInteraction: false,
                    },
                    navigation: {
                        nextEl: '#carouselNextBtn',
                        prevEl: '#carouselPrevBtn',
                    },
                    breakpoints: {
                        // Mobile (< 768px): 1 card
                        0: {
                            slidesPerView: 1,
                            spaceBetween: 12
                        },
                        // Tablet (>= 768px): 2 cards
                        768: {
                            slidesPerView: 2,
                            spaceBetween: 15
                        },
                        // LG screen (>= 992px): 4 cards
                        992: {
                            slidesPerView: 4,
                            spaceBetween: 18
                        },
                        // XL screen (>= 1200px): 5 cards
                        1200: {
                            slidesPerView: 5,
                            spaceBetween: 20
                        }
                    }
                });
            }
        });

        // Dependent Dropdown Logic (Country -> State/City)
        function onCountryChange() {
            const country = document.getElementById('filterCountry').value;
            const stateSelect = document.getElementById('filterState');
            const citySelect = document.getElementById('filterCity');

            if (country === 'United States') {
                stateSelect.value = 'California';
                citySelect.value = 'Los Angeles';
            } else if (country === 'United Kingdom') {
                stateSelect.value = 'London';
                citySelect.value = 'London';
            } else if (country === 'United Arab Emirates') {
                stateSelect.value = 'Dubai';
                citySelect.value = 'Dubai';
            } else if (country === '') {
                stateSelect.value = '';
                citySelect.value = '';
            }
        }

        // Comprehensive Client-side Filter Logic
        function applyBlogFilters() {
            const countryVal = (document.getElementById('filterCountry')?.value || '').toLowerCase();
            const stateVal = (document.getElementById('filterState')?.value || '').toLowerCase();
            const cityVal = (document.getElementById('filterCity')?.value || '').toLowerCase();
            const categoryVal = (document.getElementById('filterCategory')?.value || '').toLowerCase();
            const keywordVal = (document.getElementById('filterKeyword')?.value || '').trim().toLowerCase();

            const cards = document.querySelectorAll('.filterable-blog-card');
            let visibleCount = 0;

            cards.forEach(card => {
                const cardCountry = (card.getAttribute('data-country') || '').toLowerCase();
                const cardState = (card.getAttribute('data-state') || '').toLowerCase();
                const cardCity = (card.getAttribute('data-city') || '').toLowerCase();
                const cardCategory = (card.getAttribute('data-category') || '').toLowerCase();
                const cardTitle = (card.getAttribute('data-title') || card.textContent || '').toLowerCase();

                const matchCountry = !countryVal || cardCountry.includes(countryVal);
                const matchState = !stateVal || cardState.includes(stateVal);
                const matchCity = !cityVal || cardCity.includes(cityVal);
                const matchCategory = !categoryVal || cardCategory.includes(categoryVal);
                const matchKeyword = !keywordVal || cardTitle.includes(keywordVal);

                if (matchCountry && matchState && matchCity && matchCategory && matchKeyword) {
                    card.style.display = '';
                    visibleCount++;
                } else {
                    card.style.display = 'none';
                }
            });

            // Update count badge & no-results alert
            const countBadge = document.getElementById('filterArticlesCount');
            const noResults = document.getElementById('noResultsAlert');
            const mainContent = document.getElementById('blogMainContentRow');

            if (countBadge) {
                countBadge.textContent = `${visibleCount} Article${visibleCount === 1 ? '' : 's'} Found`;
            }

            if (visibleCount === 0) {
                if (noResults) noResults.style.display = 'block';
            } else {
                if (noResults) noResults.style.display = 'none';
            }
        }

        // Reset All Filters
        function resetBlogFilters() {
            const country = document.getElementById('filterCountry');
            const state = document.getElementById('filterState');
            const city = document.getElementById('filterCity');
            const category = document.getElementById('filterCategory');
            const keyword = document.getElementById('filterKeyword');

            if (country) country.value = '';
            if (state) state.value = '';
            if (city) city.value = '';
            if (category) category.value = '';
            if (keyword) keyword.value = '';

            applyBlogFilters();
        }

        // Quick filter triggers from sidebar
        function quickFilterByCategory(catName) {
            const categorySelect = document.getElementById('filterCategory');
            if (categorySelect) {
                categorySelect.value = catName;
                applyBlogFilters();
                window.scrollTo({ top: document.querySelector('.blog-filter-card').offsetTop - 80, behavior: 'smooth' });
            }
        }

        function quickSearchByTag(tag) {
            const keywordInput = document.getElementById('filterKeyword');
            if (keywordInput) {
                keywordInput.value = tag;
                applyBlogFilters();
                window.scrollTo({ top: document.querySelector('.blog-filter-card').offsetTop - 80, behavior: 'smooth' });
            }
        }

        function handleNewsletterSubscribe(form) {
            alert('Thank you for subscribing to our VIP newsletter!');
            form.reset();
        }
    </script>
@endsection