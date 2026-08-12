@extends('front.layout.layout')


    <style>
        .hours-left span {
            top: 10px;
        }

        .featured-devils-cards-slider {
            height: auto;
        }

        .featured-devils-cards-slider>div {
            padding-inline: 5px !important;
            height: auto;
        }

        .product_card {
            height: 100% !important;
            display: flex;
            min-height: 100%;
            flex-direction: column;
            background: #000;
        }

        .swiper-slide,
        .swiper-wrapper {
            height: auto !important;
        }

        .featured-devils-cards-slider-two {
            width: 100%;
            overflow: hidden;
        }

        .swiper-button-prev,
        .swiper-button-next {
            color: #bc1212 !important;
            background: #ffffff9e;
            height: 45px !important;
            width: 45px !important;
            border-radius: 100%;
            top: 20% !important;

        }

        .swiper-button-lock {
            display: flex !important;
            justify-content: center;
            align-items: center;
        }


        .swiper-button-next:after,
        .swiper-button-prev:after {
            font-size: 35px !important;
        }


        @media screen and (max-width:767px) {

            .swiper-button-prev,
            .swiper-button-next {
                top: 17% !important;
            }

        }

        .popularity-label {
            font-weight: bold;
            margin-left: 5px;
            color: #f1eaeb;
            font-size: 10px;
            letter-spacing: 1px
        }


        /* Optional: Navigation buttons */
        .nav-btn {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(0, 0, 0, 0.5);
            color: white;
            border: none;
            padding: 10px;
            cursor: pointer;
            z-index: 10;
        }

        .prev {
            left: 10px;
        }

        .next {
            right: 10px;
        }



        .owl-carousel {
            display: block !important;
        }

        .owl-carousel .owl-stage {
            display: flex !important;
        }

        .owl-carousel .owl-item {
            display: flex;
        }

        .owl-carousel .item {
            width: 100%;
        }
/* 
        .owl-nav{
            display:none;
        } */

        .owl-carousel .owl-item {
            opacity: 1;
            /* transition: opacity 0.2s ease 0.1s; */
        }


        .owl-nav, .owl-nav.disabled {
            display: block !important;
            display: flex !important;
            justify-content: space-between;
            align-items: center;
            position: absolute !important;
            top: 30% !important;
            left: -8px !important;
        }

        .owl-nav>button.owl-prev, .owl-nav.disabled >button.owl-prev, .owl-nav>button.owl-next, .owl-nav.disabled >button.owl-next {
            border-radius: 50px;
            padding: 10px;
            width: 50px;
            font-size: 24px;
        }

        @media (max-width:576px){
            .box-description {
                min-height: 120px !important;
            }

            .owl-carousel .owl-stage {
                display: flex !important;
                padding-left: 8px;
            }

            .owl-nav, .owl-nav.disabled {
                transform: translate(6px, 10px);
            }

            .owl-nav>button.owl-prev, .owl-nav.disabled >button.owl-prev, .owl-nav>button.owl-next, .owl-nav.disabled >button.owl-next {
                padding: 5px;
                width: 40px;
                font-size: 20px;
            }
        }
    </style>

    @section('content')

    <section class="main-area home_page">
        <div class="container-fluid">
            <div class="row">
                @include('front.component.category_sidebar')

                <!-- for mobile  -->
                <div class="d-flex d-lg-none justify-content-between col-12 px-0 mt-2 mb-4">
                    <a class="open-offcanvas" data-target="#offcanvas1">Quick links <i class="fa fa-external-link" aria-hidden="true" class="canvas-icon"></i>
                    </a>
                    <a class="open-offcanvas" data-target="#offcanvas2">Filters <i class="fa fa-filter" aria-hidden="true" class="canvas-icon"></i></a>
                </div>
                <div class="offcanvas offcanvas_left" id="offcanvas1">
                    <button type="button" class="close close-offcanvas" id="closeOffcanvas" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    @include('front.component.category_sidebar')
                </div>
                <div class="offcanvas" id="offcanvas2">
                    <button type="button" class="close close-offcanvas" id="closeOffcanvas" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    @include('front.component.filters')
                </div>
                <div class="offcanvas-backdrop" id="offcanvasBackdrop"></div>
                <!-- for mobile end  -->

                <div class="col-lg-10">
                    <h1 class="sr-only" style="position:absolute;width:1px;height:1px;padding:0;margin:-1px;overflow:hidden;clip:rect(0,0,0,0);border:0;">{{ !empty($locationSeo['data']->meta_title) ? $locationSeo['data']->meta_title : (!empty($city) ? ucfirst($city) . ' Escorts' : 'SexyDevil Escorts - Premium Escort Directory') }}</h1>
                    <section class="s-pt-80 s-pb-30 s-pb-md-70 s-pt-md-90 s-pb-xl-120 s-pt-xl-180">
                        @include('front.component.filters')
                    </section>
                    @php
                    $no_record = true;
                    @endphp

                    <!-- ******************************************** -->


                    <!-- Features Devil Section start -->
                    @if(isset($featuredUsers) && $featuredUsers->count())
                    @php
                    $no_record = false;
                    @endphp
                    <section class="Featured vip six_cards">
                        <div class="container-fluid">
                                <h2 class="heading mx-auto">Featured Devils</h2>

                                <div class="owl-carousel owl-theme featured-devils-cards-slider featured-devils-cards position-relative">
                                    
                                        @foreach($featuredUsers as $escort)
                                        
                                            <div class="item product_card index-cards">

                                                @php $authUser = Auth::guard('web')->user(); @endphp
                                                <div class="top-box">
                                                    <button class="wishlistBtn heart-button" data-auth="{{ $authUser ? $authUser->id : '' }}"
                                                        data-id="{{ $escort->id }}">
                                                        @php
                                                        $user_fav = getWishlistClass($escort->id);
                                                        @endphp
                                                        <i class="{{ $user_fav == "fa-solid fa-heart text-danger" ? $user_fav:(in_array($escort->id, $favorite_users) ? 'fa-solid fa-heart text-danger' : 'fa-regular fa-heart') }}"></i>
                                                    </button>
                                                    <div class="exclusive-label exclusive-vip notranslate" translate="no">VIP</div>                                                    
                                                    <!-- @php
                                                    $createdWithinTwoWeeks = $escort->created_at >= now()->subDays(14);
                                                    @endphp
                                                    @if($createdWithinTwoWeeks)
                                                    <div class="exclusive-label exclusive-new">New</div>
                                                    @endif -->
                                                    @if(!empty($escort->plan_id) && $escort->plan_end_date >= now())
                                                    <div class="corner-ribbon corner-ribbon-sm notranslate" translate="no">
                                                        <i class="fa-solid fa-fire"></i>
                                                        <span>{{ $escort->plan->tag ?? "" }}</span>
                                                    </div>
                                                    @endif

                                                    <!-- @if ($escort->profile_image)
                                                    <img src="{{ asset('storage/' . $escort->profile_image) }}" alt="Leora">
                                                    @else
                                                    <img src="{{ asset('storage/profile_image/default-profile.png') }}" alt="Slide 1">
                                                    @endif -->

                                                    <div class="slider" id="slider">
                                                        <a href="{{ route('user.profile.show', $escort->id) }}">
                                                            <div class="slides custom-slides">
                                                                
                                                                <!-- <div class="slide">
                                                                    <img src="{{ config('app.img_url') . $escort->profile_image }}" alt="{{ $escort->nickname }}">
                                                                </div> -->
                                                                @if(count($escort->images) == 0)
                                                                <div class="slide">
                                                                    <img src="{{ asset('storage/profile_image/default-profile.png') }}" alt="Default profile">
                                                                </div>
                                                                @endif
                                                                @if($escort->images)
                                                                @foreach($escort->images as $image)
                                                                @if($image->is_approved == 1)
                                                                <div class="slide">
                                                                    <img src="{{ config('app.img_url').$image->file_path }}" alt="{{ $escort->nickname }}">
                                                                </div>
                                                                @endif
                                                                @endforeach
                                                                @endif
                                                            </div>
                                                        </a>

                                                        <!-- <button class="nav-btn prev">&#10094;</button>
                                                    <button class="nav-btn next">&#10095;</button> -->
                                                    </div>

                                                   
                                                    @php
                                                    $views = getBoostedViews($escort->viewsReceived->count(), $escort->id);
                                                    @endphp
                                                    <div class="model-data-info">
                                                       <div class="tag-btn">
                                                          <!-- Age Section Start -->
                                                        @if (!empty($escort->displayed_age))
                                                        <p class="location-index age-block">{{ $escort->displayed_age }} Y.O</p>
                                                        @endif
                                                        <!-- Age section End -->
                                                         <!-- New btn tag start -->
                                                        @php
                                                        $createdWithinTwoWeeks = $escort->created_at >= now()->subDays(14);
                                                        @endphp
                                                        @if($createdWithinTwoWeeks)
                                                        <div class="exclusive-label exclusive-new">New</div>
                                                        @endif
                                                         <!-- New btn tag end-->
                                                       </div>
                                                          <!-- Review start start -->
                                                        @php
                                                        $reviews = $escort->reviewsReceived;
                                                        $average = $reviews->avg('rating');
                                                        $count = $reviews->count();
                                                        $fullStars = floor($average);
                                                        $emptyStars = 5 - $fullStars;
                                                        @endphp
                                                        @if($count > 0)
                                                        <div class="review-stars">
                                                            <div class="stars" style="color: gold;">
                                                                @if($count)
                                                                {!! str_repeat('★', $fullStars) . str_repeat('☆', $emptyStars) !!}
                                                                @else
                                                                {!! str_repeat('☆', 5) !!}
                                                                @endif
                                                            </div>
                                                            <div style="color: #e6e6e6;">{{ $count }} Review{{ $count == 1 ? '' : 's' }}</div>
                                                        </div>
                                                        @endif
                                                        <!-- Review start End -->
                                                        <!-- View Lable tag -->
                                                        <div class="views-label">
                                                            <span class="popularity-label">🔥 TRENDING</span>
                                                        </div>
                                                        <!-- View Lable tag  end-->


                                                    </div>
                                                  
                                                    
                                                    @php
                                                    /* $now = \Carbon\Carbon::now();
                                                    $nextAvailability = null;
                                                    if (!$escort->is_online && !empty($escort->availability)) {
                                                    for ($i = 0; $i < 7; $i++) {
                                                        $checkDay=strtolower($now->copy()->addDays($i)->format('l'));
                                                        if (!empty($escort->availability[$checkDay])) {
                                                        $startTime = $escort->availability[$checkDay]['start'] ?? null;
                                                        if ($startTime) {
                                                        $nextDate = $now->copy()->startOfDay()->addDays($i)->format('l, M j');
                                                        $nextAvailability = $nextDate . ' at ' . date('g:i A', strtotime($startTime));
                                                        break;
                                                        }
                                                        }
                                                        }
                                                        } */
                                                    @endphp
                                                         <!-- Active btn Section -->
                                                        <div class="exclusive-desc online-btn {{ $escort->is_online ? 'on' : 'off' }}">
                                                            <i class="fa fa-circle {{ $escort->is_online ? 'text-success' : '' }}"
                                                                title="{{ $escort->is_online ? 'Online' : 'Offline' }}"></i>
                                                        </div>
                                                </div>

                                                <div class="box-description">
                                                    <a href="#">

                                                        <h3 class="title-index notranslate" translate="no">{{ $escort->nickname }}</h3>
                                                        <div class="price">{{ format_price_dot(($escort->quickie_rates['1_hr'] ?? '0')) }}{{$escort->countries?->currency_symbol ?? '$'}}/hr, {{ format_price_dot(($escort->quickie_rates['overnight'] ?? '0')) }}{{$escort->countries?->currency_symbol ?? '$'}}/overnight</div>
                                                            <p class="location-index">
                                                        {{ $escort->city?->name ? $escort->city->name . ', ' : '' }}
                                                        {{ $escort->state?->name ? $escort->state->name . ', ' : '' }}
                                                        {{ $escort->countries?->name ?? '' }}
                                                    </p>
                                                        @php
                                                        $selectedServices = App\Models\UserEscortService::where('user_id', $escort->id)
                                                        ->whereNull('selection_id')->pluck('service_id')->toArray();
                                                        $selectedSelections = App\Models\UserEscortService::where('user_id', $escort->id)
                                                        ->whereNotNull('selection_id')->pluck('selection_id')->toArray();
                                                        $selectedCategoryNames = [];
                                                        foreach ($categories as $category) {
                                                        $filteredServices = $category->services->filter(function ($service) use ($selectedServices, $selectedSelections) {
                                                        return in_array($service->id, $selectedServices) ||
                                                        $service->selections->pluck('id')->intersect($selectedSelections)->isNotEmpty();
                                                        });
                                                        if ($filteredServices->isNotEmpty()) {
                                                        $selectedCategoryNames[] = $category->name;
                                                        }
                                                        }
                                                        @endphp

                                                        @if (!empty($selectedCategoryNames))
                                                        @php
                                                        $displayedCategories = array_slice($selectedCategoryNames, 0, 2);
                                                        $moreCategories = count($selectedCategoryNames) > 2;
                                                        @endphp
                                                        <!-- <p class="services">
                                                            {{ implode(', ', $displayedCategories) }}{{ $moreCategories ? ', …' : '' }}
                                                        </p> -->
                                                        @endif


                                                    </a>

                                                    <div class="card_btn_group">
                                                        @php $whatsappNumber = $escort->phone_code . $escort->phone; @endphp
                                                        <a href="https://wa.me/{{ $whatsappNumber }}?text=Hi%20I%20found%20your%20profile%20on%20the%20site" class="profileWhatsApp" target="_blank">
                                                            <div class="btn btn-maincolor cards-btn w-100">Book Now</div>
                                                        </a>
                                                        <a href="{{ route('user.profile.show', $escort->id) }}">
                                                            <div class="btn btn-maincolor cards-btn view-prof-btn">View Profile</div>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                      
                                        @endforeach
                                </div>
                        </div>
                    </section>
                    @endif
                    
                    
                    <!-- Features Devil Section end -->


                    
                    <!-- ******************************************** -->



                    <!-- ******************************************** -->



                    <!-- Three Card Section Start -->
                    @if(isset($divineObessions) && $divineObessions->count())
                    @php
                    $no_record = false;
                    @endphp
                    <section class="three_cards divine">
                        <div class="container-fluid">
                            <div class="">
                                <h2 class="heading mx-auto">Divine Obsession – Weekly Top 3</h2>
                                <div class="owl-carousel owl-theme featured-devils-cards row position-relative">
                                    @foreach($divineObessions as $escort)
                                        <div class="item product_card index-cards ">
                                            <a href="{{ route('user.profile.show', $escort->id) }}">
                                                @php
                                                $authUser = Auth::guard('web')->user();
                                                @endphp
                                                <div class="top-box">

                                                    <button class="wishlistBtn heart-button" data-auth="{{ $authUser ? $authUser->id : '' }}"
                                                        data-id="{{ $escort->id }}">
                                                        @php
                                                        $user_fav = getWishlistClass($escort->id);
                                                        @endphp
                                                        <i class="{{ $user_fav == "fa-solid fa-heart text-danger" ? $user_fav:(in_array($escort->id, $favorite_users) ? 'fa-solid fa-heart text-danger' : 'fa-regular fa-heart') }}"></i>
                                                    </button>
                                                    @if(isset($escort->is_featured))
                                                    <div class="exclusive-label exclusive-vip notranslate" translate="no">VIP</div>
                                                    @endif
                                                    @php
                                                    $createdWithinTwoWeeks = $escort->created_at >= now()->subDays(14);
                                                    @endphp
                                                    @if(!empty($escort->plan_id) && $escort->plan_end_date >= now())
                                                    <div class="corner-ribbon corner-ribbon-sm notranslate" translate="no">
                                                        <i class="fa-solid fa-fire"></i>

                                                        <span>{{$escort->plan->tag ?? ""}}</span>
                                                    </div>
                                                    @endif

                                                    <!-- @if ($escort->profile_image)
                                                <img src="{{ asset('storage/' . $escort->profile_image) }}" alt="Leora">
                                                @else
                                                <img src="{{ asset('storage/profile_image/default-profile.png') }}" alt="Slide 1">
                                                @endif -->
                                                    <div class="slider" id="slider">
                                                        <a href="{{ route('user.profile.show', $escort->id) }}">
                                                            <div class="slides custom-slides">
                                                                
                                                                <!-- <div class="slide">
                                                                    <img src="{{ config('app.img_url') . $escort->profile_image }}" alt="{{ $escort->nickname }}">
                                                                </div> -->
                                                                @if(count($escort->images) == 0)
                                                                <div class="slide">
                                                                    <img src="{{ asset('storage/profile_image/default-profile.png') }}" alt="Default profile">
                                                                </div>
                                                                @endif
                                                                @if($escort->images)
                                                                @foreach($escort->images as $image)
                                                                @if($image->is_approved == 1)
                                                                <div class="slide">
                                                                    <img src="{{ config('app.img_url'). $image->file_path }}" alt="{{ $escort->nickname }}">
                                                                </div>
                                                                @endif
                                                                @endforeach
                                                                @endif
                                                            </div>
                                                        </a>

                                                        <!-- <button class="nav-btn prev">&#10094;</button>
                                                    <button class="nav-btn next">&#10095;</button> -->
                                                    </div>


                                                    <div class="corner-ribbon corner-ribbon-sm notranslate" translate="no">
                                                        <i class="fa-solid fa-fire"></i>
                                                        <span>{{$escort->plan->tag ?? ""}}</span>
                                                    </div>
                                                    <!-- <div class="views-label">
                                                    @php
                                                    $viewCount = $escort->viewsReceived->count();
                                                    @endphp

                                                    @if ($viewCount > 1)
                                                    <i class="fa-solid fa-eye"></i> {{ $viewCount }} Views
                                                    @else
                                                    <i class="fa-solid fa-eye"></i> {{ $viewCount }} View
                                                    @endif
                                                </div> -->
                                                    <div class="model-data-info">
                                                        <div class="tag-btn">
                                                            <!-- Age block start-->
                                                             @if (!empty($escort->displayed_age))
                                                            <p class="location-index">{{ $escort->displayed_age }} Y.O</p>
                                                            @endif
                                                            <!-- Age block end-->
                                                            <!-- New btn start -->
                                                            @if($createdWithinTwoWeeks)
                                                            <div class="exclusive-label exclusive-new">New</div>
                                                            @endif
                                                            <!-- New btn end -->
                                                        </div>
                                                        <!-- Rating box start-->
                                                        @php
                                                        $reviews = $escort->reviewsReceived;
                                                        $average = $reviews->avg('rating');
                                                        $count = $reviews->count();
                                                        $fullStars = floor($average);
                                                        $emptyStars = 5 - $fullStars;
                                                        @endphp
                                                        @if($count > 0)
                                                        <div class="review-stars">
                                                            <div class="stars" style="color: gold;">
                                                                @if($count)
                                                                {!! str_repeat('★', $fullStars) . str_repeat('☆', $emptyStars) !!}
                                                                @else
                                                                {!! str_repeat('☆', 5) !!}
                                                                @endif
                                                            </div>
                                                            <div style="color: #e6e6e6;">{{ $count }} review{{ $count == 1 ? '' : 's' }}</div>
                                                        </div>
                                                        @endif
                                                        <!-- Rating box end-->
                                                        <!-- View label start -->   
                                                        @if(isset($escort->is_featured))
                                                            <div class="views-label">
                                                                <span class="popularity-label">🔥 VERY POPULAR TODAY</span>
                                                            </div>
                                                            <!-- View label end -->
                                                        @endif
                                                    </div>
                                                    @php
                                                    $now = \Carbon\Carbon::now();
                                                    $nextAvailability = null;
                                                    if (!$escort->is_online && !empty($escort->availability)) {
                                                    for ($i = 0; $i < 7; $i++) {
                                                        $checkDay=strtolower($now->copy()->addDays($i)->format('l'));
                                                        if (!empty($escort->availability[$checkDay])) {
                                                        $startTime = $escort->availability[$checkDay]['start'] ?? null;
                                                        if ($startTime) {
                                                        $nextDate = $now->copy()->startOfDay()->addDays($i)->format('l, M j');
                                                        $nextAvailability = $nextDate . ' at ' . date('g:i A', strtotime($startTime));
                                                        break;
                                                        }
                                                        }
                                                        }
                                                        }
                                                        @endphp

                                                        @if ($escort->is_online == 1)
                                                        <div class="exclusive-desc online-btn on">
                                                            <i class="fa fa-circle text-success" title="Online"></i>
                                                        </div>
                                                        @else
                                                        <div class="exclusive-desc online-btn off">
                                                            <i class="fa fa-circle" title="Offline"></i>
                                                        </div>
                                                        @endif
                                                </div>
                                                <div class="box-description">
                                                    <h3 class="title-index notranslate" translate="no">{{$escort->nickname}}</h3>
                                                    <div class="price">{{ format_price_dot(($escort->quickie_rates['1_hr'] ?? '0')) }}{{$escort->countries?->currency_symbol ?? '$'}}/hr, {{ format_price_dot(($escort->quickie_rates['overnight'] ?? '0')) }}{{$escort->countries?->currency_symbol ?? '$'}}/overnight</div>

                                                    <!-- @if($escort->slogan)
                                                <p class="slogan-index">"{{$escort->slogan}}"</p>
                                                @endif -->
                                                    <p class="location-index">
                                                        {{ $escort->city?->name ? $escort->city->name . ', ' : '' }}
                                                        {{ $escort->state?->name ? $escort->state->name . ', ' : '' }}
                                                        {{ $escort->countries?->name ?? '' }}
                                                    </p>

                                                    @php
                                                    $selectedServices = App\Models\UserEscortService::where('user_id', $escort->id)
                                                    ->whereNull('selection_id')
                                                    ->pluck('service_id')
                                                    ->toArray();

                                                    $selectedSelections = App\Models\UserEscortService::where('user_id', $escort->id)
                                                    ->whereNotNull('selection_id')
                                                    ->pluck('selection_id')
                                                    ->toArray();

                                                    $selectedCategoryNames = [];

                                                    foreach ($categories as $category) {
                                                    $filteredServices = $category->services->filter(function ($service) use ($selectedServices, $selectedSelections) {
                                                    return in_array($service->id, $selectedServices) ||
                                                    $service->selections->pluck('id')->intersect($selectedSelections)->isNotEmpty();
                                                    });

                                                    if ($filteredServices->isNotEmpty()) {
                                                    $selectedCategoryNames[] = $category->name;
                                                    }
                                                    }
                                                    @endphp

                                                    @if (!empty($selectedCategoryNames))
                                                    @php
                                                    $displayedCategories = array_slice($selectedCategoryNames, 0, 2);
                                                    $moreCategories = count($selectedCategoryNames) > 2;
                                                    @endphp
                                                    <!-- <p class="services">
                                                        {{ implode(', ', $displayedCategories) }}{{ $moreCategories ? ', …' : '' }}
                                                    </p> -->
                                                    @endif
                                                </div>
                                                <div class="card_btn_group">
                                                    @php $whatsappNumber = $escort->phone_code . $escort->phone; @endphp
                                                    <a href="https://wa.me/{{ $whatsappNumber }}?text=Hi%20I%20found%20your%20profile%20on%20the%20site" class="profileWhatsApp" target="_blank">
                                                        <div class="btn btn-maincolor cards-btn w-100">Book Now</div>
                                                    </a>
                                                    <a href="{{ route('user.profile.show', $escort->id) }}">
                                                        <div class="btn btn-maincolor cards-btn view-prof-btn">View Profile</div>
                                                    </a>
                                                </div>
                                            </a>
                                        </div>
                                    @endforeach
                                </div>

                            </div>
                        </div>
                    </section>
                    @endif


                    <!-- Three Card Section end -->



                    <!-- ******************************************** -->


                    
                    <!-- ******************************************** -->


                    <!-- 6 Devil Section Start -->
                    @if(isset($devilYou) && $devilYou->count())
                    <section class=" six_cards 6_devils">
                        <div class="container-fluid">
                                <h2 class="heading mx-auto">6 Devils You Can’t Miss Today</h2>

                                <div class="owl-carousel owl-theme featured-devils-cards-slider-two featured-devils-cards position-relative">
                                        @foreach($devilYou as $escort)
                                       
                                            <div class=" item product_card index-cards ">
                                                <a href="{{ route('user.profile.show', $escort->id) }}">
                                                    @php
                                                    $authUser = Auth::guard('web')->user();
                                                    @endphp
                                                    <div class="top-box">

                                                        <button class="wishlistBtn heart-button" data-auth="{{ $authUser ? $authUser->id : '' }}"
                                                            data-id="{{ $escort->id }}">
                                                            @php
                                                            $user_fav = getWishlistClass($escort->id);
                                                            @endphp
                                                            <i class="{{ $user_fav == "fa-solid fa-heart text-danger" ? $user_fav:(in_array($escort->id, $favorite_users) ? 'fa-solid fa-heart text-danger' : 'fa-regular fa-heart') }}"></i>
                                                        </button>
                                                        @if(isset($escort->is_featured))
                                                        <div class="exclusive-label exclusive-vip notranslate" translate="no">VIP</div>
                                                        @endif
                                                        @php
                                                        $createdWithinTwoWeeks = $escort->created_at >= now()->subDays(14);
                                                        @endphp
                                                        @if(!empty($escort->plan_id) && $escort->plan_end_date >= now())
                                                        <div class="corner-ribbon corner-ribbon-sm notranslate" translate="no">
                                                            <i class="fa-solid fa-fire"></i>

                                                            <span>{{$escort->plan->tag ?? ""}}</span>
                                                        </div>
                                                        @endif

                                                        <!-- @if ($escort->profile_image)
                                                    <img src="{{ asset('storage/' . $escort->profile_image) }}" alt="Leora">
                                                    @else
                                                    <img src="{{ asset('storage/profile_image/default-profile.png') }}" alt="Slide 1">
                                                    @endif -->
                                                        <div class="slider" id="slider">
                                                            <a href="{{ route('user.profile.show', $escort->id) }}">
                                                                <div class="slides custom-slides">
                                                                    
                                                                    <!-- <div class="slide">
                                                                        <img src="{{ config('app.img_url'). $escort->profile_image }}" alt="{{ $escort->nickname }}">
                                                                    </div> -->
                                                                    @if(count($escort->images) == 0)
                                                                    <div class="slide">
                                                                        <img src="{{ asset('storage/profile_image/default-profile.png') }}" alt="Default profile">
                                                                    </div>
                                                                    @endif
                                                                    @if($escort->images)
                                                                    @foreach($escort->images as $image)
                                                                    @if($image->is_approved == 1)
                                                                    <div class="slide">
                                                                        <img src="{{ config('app.img_url').$image->file_path }}" alt="{{ $escort->nickname }}">
                                                                    </div>
                                                                    @endif
                                                                    @endforeach
                                                                    @endif
                                                                </div>
                                                            </a>

                                                            <!-- <button class="nav-btn prev">&#10094;</button>
                                                    <button class="nav-btn next">&#10095;</button> -->
                                                        </div>


                                                        <div class="corner-ribbon corner-ribbon-sm notranslate" translate="no">
                                                            <i class="fa-solid fa-fire"></i>
                                                            <span>{{$escort->plan->tag ?? "" }}</span>
                                                        </div>
                                                        <div class="model-data-info">
                                                            <div class="tag-btn">
                                                                <!-- Age btn -->
                                                                @if (!empty($escort->displayed_age))
                                                                <p class="location-index">{{ $escort->displayed_age }} Y.O</p>
                                                                @endif
                                                                <!-- Age btn -->
                                                                <!-- New tag btn --> 
                                                                @if($createdWithinTwoWeeks)
                                                                <div class="exclusive-label exclusive-new">New</div>
                                                                @endif
                                                                <!-- New tag btn end--> 
                                                            </div>
                                                            <!-- Rating start start-->
                                                             @php
                                                            $reviews = $escort->reviewsReceived;
                                                            $average = $reviews->avg('rating');
                                                            $count = $reviews->count();
                                                            $fullStars = floor($average);
                                                            $emptyStars = 5 - $fullStars;
                                                            @endphp
                                                            @if($count > 0)
                                                            <div class="review-stars">
                                                                <div class="stars" style="color: gold;">
                                                                    @if($count)
                                                                    {!! str_repeat('★', $fullStars) . str_repeat('☆', $emptyStars) !!}
                                                                    @else
                                                                    {!! str_repeat('☆', 5) !!}
                                                                    @endif
                                                                </div>
                                                                <div style="color: #e6e6e6;">{{ $count }} review{{ $count == 1 ? '' : 's' }}</div>
                                                            </div>
                                                            @endif
                                                            <!-- Rating start end-->
                                                            <!-- View Label start-->                                                            
                                                            @if(isset($escort->is_featured))
                                                                <div class="views-label">
                                                                    <span class="popularity-label">🔥 TRENDING</span>
                                                                </div>
                                                                <!-- View label end -->
                                                            @endif
                                                            <!-- View Label end-->
                                                        </div>
                                                        
                                                        @php
                                                        $now = \Carbon\Carbon::now();
                                                        $nextAvailability = null;
                                                        if (!$escort->is_online && !empty($escort->availability)) {
                                                        for ($i = 0; $i < 7; $i++) {
                                                            $checkDay=strtolower($now->copy()->addDays($i)->format('l'));
                                                            if (!empty($escort->availability[$checkDay])) {
                                                            $startTime = $escort->availability[$checkDay]['start'] ?? null;
                                                            if ($startTime) {
                                                            $nextDate = $now->copy()->startOfDay()->addDays($i)->format('l, M j');
                                                            $nextAvailability = $nextDate . ' at ' . date('g:i A', strtotime($startTime));
                                                            break;
                                                            }
                                                            }
                                                            }
                                                            }
                                                            @endphp

                                                            @if ($escort->is_online == 1)
                                                            <div class="exclusive-desc online-btn on">
                                                                <i class="fa fa-circle text-success" title="Online"></i>
                                                            </div>
                                                            @else
                                                            <div class="exclusive-desc online-btn off">
                                                                <i class="fa fa-circle" title="Offline"></i>
                                                            </div>
                                                            @endif

                                                    </div>
                                                    <div class="box-description">
                                                        <h3 class="title-index notranslate" translate="no">{{$escort->nickname}}</h3>
                                                        <div class="price">{{ format_price_dot(($escort->quickie_rates['1_hr'] ?? '0')) }}{{$escort->countries?->currency_symbol ?? '$'}}/hr, {{ format_price_dot(($escort->quickie_rates['overnight'] ?? '0')) }}{{$escort->countries?->currency_symbol ?? '$'}}/overnight </div>

                                                        <!-- @if($escort->slogan)
                                                    <p class="slogan-index">"{{$escort->slogan}}"</p>
                                                    @endif -->

                                                        <p class="location-index">
                                                            {{ $escort->city?->name ? $escort->city->name . ', ' : '' }}
                                                            {{ $escort->state?->name ? $escort->state->name . ', ' : '' }}
                                                            {{ $escort->countries?->name ?? '' }}
                                                        </p>
                                                        @php
                                                        $selectedServices = App\Models\UserEscortService::where('user_id', $escort->id)
                                                        ->whereNull('selection_id')
                                                        ->pluck('service_id')
                                                        ->toArray();

                                                        $selectedSelections = App\Models\UserEscortService::where('user_id', $escort->id)
                                                        ->whereNotNull('selection_id')
                                                        ->pluck('selection_id')
                                                        ->toArray();

                                                        $selectedCategoryNames = [];

                                                        foreach ($categories as $category) {
                                                        $filteredServices = $category->services->filter(function ($service) use ($selectedServices, $selectedSelections) {
                                                        return in_array($service->id, $selectedServices) ||
                                                        $service->selections->pluck('id')->intersect($selectedSelections)->isNotEmpty();
                                                        });

                                                        if ($filteredServices->isNotEmpty()) {
                                                        $selectedCategoryNames[] = $category->name;
                                                        }
                                                        }
                                                        @endphp

                                                        @if (!empty($selectedCategoryNames))
                                                        @php
                                                        $displayedCategories = array_slice($selectedCategoryNames, 0, 2);
                                                        $moreCategories = count($selectedCategoryNames) > 2;
                                                        @endphp
                                                        <!-- <p class="services">
                                                            {{ implode(', ', $displayedCategories) }}{{ $moreCategories ? ', …' : '' }}
                                                        </p> -->
                                                        @endif
                                                    </div>
                                                    <div class="card_btn_group">
                                                        @php $whatsappNumber = $escort->phone_code . $escort->phone; @endphp
                                                        <a href="https://wa.me/{{ $whatsappNumber }}?text=Hi%20I%20found%20your%20profile%20on%20the%20site" class="profileWhatsApp" target="_blank">
                                                            <div class="btn btn-maincolor cards-btn w-100">Book Now</div>
                                                        </a>
                                                        <a href="{{ route('user.profile.show', $escort->id) }}">
                                                            <div class="btn btn-maincolor cards-btn view-prof-btn">View Profile</div>
                                                        </a>
                                                    </div>
                                                </a>
                                            </div>
                                        
                                        @endforeach
                                </div>
                        </div>
                    </section>
                    @endif
                    <!-- 6 Devil Section end -->


                    
                    <!-- ******************************************** -->



                      

                    <!-- ******************************************** -->

                    <!-- Six Card Section Start -->


                    @if(isset($FreshSins) && $FreshSins->count())
                    @php
                    $no_record = false;
                    @endphp
              
                    <section class=" six_cards free_sins">
                        <div class="container-fluid">
                            <div class="">
                                <h2 class="heading mx-auto">Fresh Sins New Escorts</h2>

                                <div class="owl-carousel owl-theme featured-devils-cards-slider-three featured-devils-cards position-relative">
                                        @foreach($FreshSins as $escort)



                                            <div class="item product_card index-cards ">
                                                <a href="{{ route('user.profile.show', $escort->id) }}">
                                                    @php
                                                    $authUser = Auth::guard('web')->user();
                                                    @endphp
                                                    <div class="top-box">

                                                        <button class="wishlistBtn heart-button" data-auth="{{ $authUser ? $authUser->id : '' }}"
                                                            data-id="{{ $escort->id }}">
                                                            @php
                                                            $user_fav = getWishlistClass($escort->id);
                                                            @endphp
                                                            <i class="{{ $user_fav == "fa-solid fa-heart text-danger" ? $user_fav:(in_array($escort->id, $favorite_users) ? 'fa-solid fa-heart text-danger' : 'fa-regular fa-heart') }}"></i>
                                                        </button>
                                                        @if(isset($escort->is_featured))
                                                            <div class="exclusive-label exclusive-vip notranslate" translate="no">VIP</div>
                                                        @endif
                                                        @php
                                                        $createdWithinTwoWeeks = $escort->created_at >= now()->subDays(14);
                                                        @endphp
                                                        @if(!empty($escort->plan_id) && $escort->plan_end_date >= now())
                                                        <div class="corner-ribbon corner-ribbon-sm notranslate" translate="no">
                                                            <i class="fa-solid fa-fire"></i>

                                                            <span>{{$escort->plan->tag ?? "" }}</span>
                                                        </div>
                                                        @endif

                                                        <!-- @if ($escort->profile_image)
                                                    <img src="{{ asset('storage/' . $escort->profile_image) }}" alt="Leora">
                                                    @else
                                                    <img src="{{ asset('storage/profile_image/default-profile.png') }}" alt="Slide 1">
                                                    @endif -->
                                                        <div class="slider" id="slider">
                                                            <a href="{{ route('user.profile.show', $escort->id) }}">
                                                                <div class="slides custom-slides">
                                                                    
                                                                    <!-- <div class="slide">
                                                                        <img src="{{ config('app.img_url'). $escort->profile_image }}" alt="{{ $escort->nickname }}">
                                                                    </div> -->
                                                                    @if(count($escort->images) == 0)
                                                                    <div class="slide">
                                                                        <img src="{{ asset('storage/profile_image/default-profile.png') }}" alt="Default profile">
                                                                    </div>
                                                                    @endif
                                                                    @if($escort->images)
                                                                    @foreach($escort->images as $image)
                                                                    @if($image->is_approved == 1)
                                                                    <div class="slide">
                                                                        <img src="{{ config('app.img_url').$image->file_path }}" alt="{{ $escort->nickname }}">
                                                                    </div>
                                                                    @endif
                                                                    @endforeach
                                                                    @endif

                                                                </div>
                                                            </a>
                                                        </div>

                                                        <div class="corner-ribbon corner-ribbon-sm notranslate" translate="no">
                                                            <i class="fa-solid fa-fire"></i>
                                                            <span>{{$escort->plan->tag ?? ""}}</span>
                                                        </div>
                                                        <div class="model-data-info">
                                                            <div class="tag-btn">
                                                                <!-- Age block -->
                                                                @if (!empty($escort->displayed_age))
                                                                    <p class="location-index">{{ $escort->displayed_age }} Y.O</p>
                                                                @endif
                                                                <!-- New btn -->
                                                                 @if($createdWithinTwoWeeks)
                                                                <div class="exclusive-label exclusive-new">New</div>
                                                                @endif
                                                            </div>
                                                            <!-- rating Start -->
                                                            @php
                                                            $reviews = $escort->reviewsReceived;
                                                            $average = $reviews->avg('rating');
                                                            $count = $reviews->count();
                                                            $fullStars = floor($average);
                                                            $emptyStars = 5 - $fullStars;
                                                            @endphp
                                                            @if($count > 0)
                                                            <div class="review-stars">
                                                                <div class="stars" style="color: gold;">
                                                                    @if($count)
                                                                    {!! str_repeat('★', $fullStars) . str_repeat('☆', $emptyStars) !!}
                                                                    @else
                                                                    {!! str_repeat('☆', 5) !!}
                                                                    @endif
                                                                </div>
                                                                <div style="color: #e6e6e6;">{{ $count }} review{{ $count == 1 ? '' : 's' }}</div>
                                                            </div>
                                                            @endif
                                                            <!-- View Label -->
                                                            @if(isset($escort->is_featured))
                                                                <div class="views-label">
                                                                    <span class="popularity-label">🔥 VERY POPULAR TODAY</span>
                                                                </div>
                                                                <!-- View label end -->
                                                            @endif
                                                        </div>
                                                        @php
                                                        $now = \Carbon\Carbon::now();
                                                        $nextAvailability = null;
                                                        if (!$escort->is_online && !empty($escort->availability)) {
                                                        for ($i = 0; $i < 7; $i++) {
                                                            $checkDay=strtolower($now->copy()->addDays($i)->format('l'));
                                                            if (!empty($escort->availability[$checkDay])) {
                                                            $startTime = $escort->availability[$checkDay]['start'] ?? null;
                                                            if ($startTime) {
                                                            $nextDate = $now->copy()->startOfDay()->addDays($i)->format('l, M j');
                                                            $nextAvailability = $nextDate . ' at ' . date('g:i A', strtotime($startTime));
                                                            break;
                                                            }
                                                            }
                                                            }
                                                            }
                                                            @endphp

                                                            @if ($escort->is_online == 1)
                                                            <div class="exclusive-desc online-btn on">
                                                                <i class="fa fa-circle text-success" title="Online"></i>
                                                            </div>
                                                            @else
                                                            <div class="exclusive-desc online-btn off">
                                                                <i class="fa fa-circle" title="Offline"></i>
                                                            </div>
                                                            @endif
                                                    </div>
                                                    <div class="box-description">
                                                        <h3 class="title-index notranslate" translate="no">{{$escort->nickname}}</h3>
                                                        <div class="price">{{ format_price_dot(($escort->quickie_rates['1_hr'] ?? '0')) }}{{$escort->countries?->currency_symbol ?? '$'}}/hr, {{ format_price_dot(($escort->quickie_rates['overnight'] ?? '0')) }}{{$escort->countries?->currency_symbol ?? '$'}}/overnight</div>

                                                        <!-- @if($escort->slogan)
                                                    <p class="slogan-index">"{{$escort->slogan}}"</p>
                                                    @endif -->

                                                        <!-- <p class="location-index">{{ $escort->countries?->name }}, {{ $escort->state?->name ?? 'N/A' }}</p> -->
                                                        <p class="location-index">
                                                            {{ $escort->city?->name ? $escort->city->name . ', ' : '' }}
                                                            {{ $escort->state?->name ? $escort->state->name . ', ' : '' }}
                                                            {{ $escort->countries?->name ?? '' }}
                                                        </p>

                                                        @php
                                                        $selectedServices = App\Models\UserEscortService::where('user_id', $escort->id)
                                                        ->whereNull('selection_id')
                                                        ->pluck('service_id')
                                                        ->toArray();

                                                        $selectedSelections = App\Models\UserEscortService::where('user_id', $escort->id)
                                                        ->whereNotNull('selection_id')
                                                        ->pluck('selection_id')
                                                        ->toArray();

                                                        $selectedCategoryNames = [];

                                                        foreach ($categories as $category) {
                                                        $filteredServices = $category->services->filter(function ($service) use ($selectedServices, $selectedSelections) {
                                                        return in_array($service->id, $selectedServices) ||
                                                        $service->selections->pluck('id')->intersect($selectedSelections)->isNotEmpty();
                                                        });

                                                        if ($filteredServices->isNotEmpty()) {
                                                        $selectedCategoryNames[] = $category->name;
                                                        }
                                                        }
                                                        @endphp

                                                        @if (!empty($selectedCategoryNames))
                                                        @php
                                                        $displayedCategories = array_slice($selectedCategoryNames, 0, 2);
                                                        $moreCategories = count($selectedCategoryNames) > 2;
                                                        @endphp
                                                        <!-- <p class="services">
                                                            {{ implode(', ', $displayedCategories) }}{{ $moreCategories ? ', …' : '' }}
                                                        </p> -->
                                                        @endif
                                                    </div>
                                                    <div class="card_btn_group">
                                                        @php $whatsappNumber = $escort->phone_code . $escort->phone; @endphp
                                                        <a href="https://wa.me/{{ $whatsappNumber }}?text=Hi%20I%20found%20your%20profile%20on%20the%20site" class="profileWhatsApp" target="_blank">
                                                            <div class="btn btn-maincolor cards-btn w-100">Book Now</div>
                                                        </a>
                                                        <a href="{{ route('user.profile.show', $escort->id) }}">
                                                            <div class="btn btn-maincolor cards-btn view-prof-btn">View Profile</div>
                                                        </a>
                                                    </div>
                                                </a>
                                            </div>
                                    
                                        @endforeach
                                </div>

                            </div>
                        </div>
                    </section>
                    
                    @endif

                    <!-- Six Card Section end -->   
                    
                    <!-- ******************************************** -->




                    <!-- ******************************************** -->

                    <!-- Spotlight Section Start -->



                    @if(isset($spotlightx) && $spotlightx->count())
                    @php
                    $no_record = false;
                    @endphp
                    <section class=" five_cards spotlight_x">
                        <div class="container-fluid">
                            <div class="">
                                <h2 class="heading mx-auto">Spotlight X –TS & Men</h2>

                                <div class="owl-carousel owl-theme featured-devils-cards-slider-four featured-devils-cards position-relative">
                                        @foreach($spotlightx as $escort)
                                            <div class=" item product_card index-cards ">
                                                <a href="{{ route('user.profile.show', $escort->id) }}">
                                                    @php
                                                    $authUser = Auth::guard('web')->user();
                                                    @endphp
                                                    <div class="top-box">

                                                        <button class="wishlistBtn heart-button" data-auth="{{ $authUser ? $authUser->id : '' }}"
                                                            data-id="{{ $escort->id }}">
                                                            @php
                                                            $user_fav = getWishlistClass($escort->id);
                                                            @endphp
                                                            <i class="{{ $user_fav == "fa-solid fa-heart text-danger" ? $user_fav:(in_array($escort->id, $favorite_users) ? 'fa-solid fa-heart text-danger' : 'fa-regular fa-heart') }}"></i>
                                                        </button>
                                                        @if($escort->is_featured)
                                                        <div class="exclusive-label exclusive-vip notranslate" translate="no">VIP</div>
                                                        @endif
                                                        @php
                                                        $createdWithinTwoWeeks = $escort->created_at >= now()->subDays(14);
                                                        @endphp 
                                                        @if(!empty($escort->plan_id) && $escort->plan_end_date >= now())
                                                        <div class="corner-ribbon corner-ribbon-sm notranslate" translate="no">
                                                            <i class="fa-solid fa-fire"></i>
                                                            <span>{{$escort->plan->tag ?? ""}}</span>
                                                        </div>
                                                        @endif

                                                        <!-- @if ($escort->profile_image)
                                                    <img src="{{ asset('storage/' . $escort->profile_image) }}" alt="Leora">
                                                    @else
                                                    <img src="{{ asset('storage/profile_image/default-profile.png') }}" alt="Slide 1">
                                                    @endif -->
                                                        <div class="slider" id="slider">
                                                            <a href="{{ route('user.profile.show', $escort->id) }}">
                                                                <div class="slides custom-slides">
                                                                    
                                                                    <!-- <div class="slide">
                                                                        <img src="{{ config('app.img_url'). $escort->profile_image }}" alt="{{ $escort->nickname }}">
                                                                    </div> -->
                                                                    @if(count($escort->images) == 0)
                                                                    <div class="slide">
                                                                        <img src="{{ asset('storage/profile_image/default-profile.png') }}" alt="Default profile">
                                                                    </div>
                                                                    @endif
                                                                    @if($escort->images)
                                                                    @foreach($escort->images as $image)
                                                                    @if($image->is_approved == 1)
                                                                    <div class="slide">
                                                                        <img src="{{ config('app.img_url').$image->file_path }}" alt="{{ $escort->nickname }}">
                                                                    </div>
                                                                    @endif
                                                                    @endforeach
                                                                    @endif
                                                                </div>
                                                            </a>

                                                            <!-- <button class="nav-btn prev">&#10094;</button>
                                                    <button class="nav-btn next">&#10095;</button> -->
                                                        </div>


                                                         <div class="model-data-info">
                                                            <div class="tag-btn">
                                                                <!-- Age block -->
                                                                  @if (!empty($escort->displayed_age))
                                                                <p class="location-index">{{ $escort->displayed_age }} Y.O</p>
                                                                @endif
                                                                <!-- New btn -->
                                                                 @if($createdWithinTwoWeeks)
                                                                <div class="exclusive-label exclusive-new">New</div>
                                                                @endif
                                                            </div>
                                                            <!-- rating Start -->
                                                            @php
                                                            $reviews = $escort->reviewsReceived;
                                                            $average = $reviews->avg('rating');
                                                            $count = $reviews->count();
                                                            $fullStars = floor($average);
                                                            $emptyStars = 5 - $fullStars;
                                                            @endphp
                                                            @if($count > 0)
                                                            <div class="review-stars">
                                                                <div class="stars" style="color: gold;">
                                                                    @if($count)
                                                                    {!! str_repeat('★', $fullStars) . str_repeat('☆', $emptyStars) !!}
                                                                    @else
                                                                    {!! str_repeat('☆', 5) !!}
                                                                    @endif
                                                                </div>
                                                                <div style="color: #e6e6e6;">{{ $count }} review{{ $count == 1 ? '' : 's' }}</div>
                                                            </div>
                                                            @endif
                                                            <!-- View Label -->
                                                            @if(isset($escort->is_featured))
                                                                <div class="views-label">
                                                                    <span class="popularity-label">🔥 TRENDING</span>
                                                                </div>
                                                                <!-- View label end -->
                                                            @endif
                                                        </div>


                                                    </div>
                                                    <div class="box-description">
                                                        <h3 class="title-index notranslate" translate="no">{{$escort->nickname}}</h3>
                                                        <div class="price">{{ format_price_dot(($escort->quickie_rates['1_hr'] ?? '0')) }}{{$escort->countries?->currency_symbol ?? '$'}}/hr, {{ format_price_dot(($escort->quickie_rates['overnight'] ?? '0')) }}{{$escort->countries?->currency_symbol ?? '$'}}/overnight</div>

                                                        <!-- @if($escort->slogan)
                                                    <p class="slogan-index">"{{$escort->slogan}}"</p>
                                                    @endif -->

                                                        <!-- <p class="location-index">{{ $escort->countries?->name }}, {{ $escort->state?->name ?? 'N/A' }}</p> -->
                                                        <p class="location-index">
                                                            {{ $escort->city?->name ? $escort->city->name . ', ' : '' }}
                                                            {{ $escort->state?->name ? $escort->state->name . ', ' : '' }}
                                                            {{ $escort->countries?->name ?? '' }}
                                                        </p>

                                                        @php
                                                        $selectedServices = App\Models\UserEscortService::where('user_id', $escort->id)
                                                        ->whereNull('selection_id')
                                                        ->pluck('service_id')
                                                        ->toArray();

                                                        $selectedSelections = App\Models\UserEscortService::where('user_id', $escort->id)
                                                        ->whereNotNull('selection_id')
                                                        ->pluck('selection_id')
                                                        ->toArray();

                                                        $selectedCategoryNames = [];

                                                        foreach ($categories as $category) {
                                                        $filteredServices = $category->services->filter(function ($service) use ($selectedServices, $selectedSelections) {
                                                        return in_array($service->id, $selectedServices) ||
                                                        $service->selections->pluck('id')->intersect($selectedSelections)->isNotEmpty();
                                                        });

                                                        if ($filteredServices->isNotEmpty()) {
                                                        $selectedCategoryNames[] = $category->name;
                                                        }
                                                        }
                                                        @endphp

                                                        @if (!empty($selectedCategoryNames))
                                                        @php
                                                        $displayedCategories = array_slice($selectedCategoryNames, 0, 2);
                                                        $moreCategories = count($selectedCategoryNames) > 2;
                                                        @endphp
                                                        <!-- <p class="services">
                                                            {{ implode(', ', $displayedCategories) }}{{ $moreCategories ? ', …' : '' }}
                                                        </p> -->
                                                        @endif
                                                    </div>
                                                    <div class="card_btn_group">
                                                        @php $whatsappNumber = $escort->phone_code . $escort->phone; @endphp
                                                        <a href="https://wa.me/{{ $whatsappNumber }}?text=Hi%20I%20found%20your%20profile%20on%20the%20site" class="profileWhatsApp" target="_blank">
                                                            <div class="btn btn-maincolor cards-btn w-100">Book Now</div>
                                                        </a>
                                                        <a href="{{ route('user.profile.show', $escort->id) }}">
                                                            <div class="btn btn-maincolor cards-btn view-prof-btn">View Profile</div>
                                                        </a>
                                                    </div>
                                                </a>
                                            </div>
                                        @endforeach
                                </div>

                            </div>
                        </div>
                    </section>
                    @endif



                        <!-- Spotlight Section End -->
                    
                    <!-- ******************************************** -->


                    <!-- ******************************************** -->

                    <!-- Top Rated Start -->
                    @if(isset($topRatedUsers) && $topRatedUsers->count())
                    <section class="five_cards topRated">
                        <div class="container-fluid">
                            <h2 class="heading mx-auto">Top-Rated</h2>

                            <!-- Owl Carousel -->
                            <div class="owl-carousel owl-theme position-relative">
                                @foreach($topRatedUsers as $escort)
                                  <div class="item product_card index-cards">
                                            <a href="{{ route('user.profile.show', $escort->id) }}">
                                                @php
                                                $authUser = Auth::guard('web')->user();
                                                @endphp
                                                <div class="top-box">

                                                    <button class="wishlistBtn heart-button" data-auth="{{ $authUser ? $authUser->id : '' }}"
                                                        data-id="{{ $escort->id }}">
                                                        @php
                                                        $user_fav = getWishlistClass($escort->id);
                                                        @endphp
                                                        <i class="{{ $user_fav == "fa-solid fa-heart text-danger" ? $user_fav:(in_array($escort->id, $favorite_users) ? 'fa-solid fa-heart text-danger' : 'fa-regular fa-heart') }}"></i>
                                                    </button>
                                                    @if($escort->is_featured)
                                                    <div class="exclusive-label exclusive-vip notranslate" translate="no">VIP</div>
                                                    @endif
                                                    @php
                                                    $createdWithinTwoWeeks = $escort->created_at >= now()->subDays(14);
                                                    @endphp
                                                    @if(!empty($escort->plan_id) && $escort->plan_end_date >= now())
                                                    <div class="corner-ribbon corner-ribbon-sm notranslate" translate="no">
                                                        <i class="fa-solid fa-fire"></i>

                                                        <span>{{$escort->plan->tag ?? "" }}</span>
                                                    </div>
                                                    @endif

                                                    <!-- @if ($escort->profile_image)
                                                <img src="{{ asset('storage/' . $escort->profile_image) }}" alt="Leora">
                                                @else
                                                <img src="{{ asset('storage/profile_image/default-profile.png') }}" alt="Slide 1">
                                                @endif -->
                                                    <div class="slider" id="slider">
                                                        <a href="{{ route('user.profile.show', $escort->id) }}">
                                                            <div class="slides custom-slides">
                                                                
                                                                <!-- <div class="slide">
                                                                    <img src="{{ config('app.img_url'). $escort->profile_image }}" alt="{{ $escort->nickname }}">
                                                                </div> -->
                                                                @if(count($escort->images) == 0)
                                                                <div class="slide">
                                                                    <img src="{{ asset('storage/profile_image/default-profile.png') }}" alt="Default profile">
                                                                </div>
                                                                @endif
                                                                @if($escort->images)
                                                                @foreach($escort->images as $image)
                                                                @if($image->is_approved == 1)
                                                                <div class="slide">
                                                                    <img src="{{ config('app.img_url').$image->file_path }}" alt="{{ $escort->nickname }}">
                                                                </div>
                                                                @endif
                                                                @endforeach
                                                                @endif
                                                            </div>
                                                        </a>
                                                    </div>


                                                    <div class="corner-ribbon corner-ribbon-sm notranslate" translate="no">
                                                        <i class="fa-solid fa-fire"></i>
                                                        <span>{{$escort->plan->tag ?? "" }}</span>
                                                    </div>
                                                    <div class="model-data-info">
                                                        <div class="tag-btn">
                                                            <!-- Age btn -->
                                                            @if (!empty($escort->displayed_age))
                                                            <p class="location-index">{{ $escort->displayed_age }} Y.O</p>
                                                            @endif
                                                            <!-- New tag btn -->
                                                            @if($createdWithinTwoWeeks)
                                                            <div class="exclusive-label exclusive-new">New</div>
                                                            @endif
                                                        </div>
                                                        <!-- rating star -->
                                                         @php
                                                        $reviews = $escort->reviewsReceived;
                                                        $average = $reviews->avg('rating');
                                                        $count = $reviews->count();
                                                        $fullStars = floor($average);
                                                        $emptyStars = 5 - $fullStars;
                                                        @endphp
                                                        @if($count > 0)
                                                        <div class="review-stars">
                                                            <div class="stars" style="color: gold;">
                                                                @if($count)
                                                                {!! str_repeat('★', $fullStars) . str_repeat('☆', $emptyStars) !!}
                                                                @else
                                                                {!! str_repeat('☆', 5) !!}
                                                                @endif
                                                            </div>
                                                            <div style="color: #e6e6e6;">{{ $count }} review{{ $count == 1 ? '' : 's' }}</div>
                                                        </div>
                                                        @endif
                                                        <!-- view label -->
                                                        @if(isset($escort->is_featured))
                                                            <div class="views-label">
                                                                <span class="popularity-label">🔥 VERY POPULAR TODAY</span>
                                                            </div>
                                                            <!-- View label end -->
                                                        @endif
                                                    </div>
                                                    @php
                                                    $now = \Carbon\Carbon::now();
                                                    $nextAvailability = null;
                                                    if (!$escort->is_online && !empty($escort->availability)) {
                                                    for ($i = 0; $i < 7; $i++) {
                                                        $checkDay=strtolower($now->copy()->addDays($i)->format('l'));
                                                        if (!empty($escort->availability[$checkDay])) {
                                                        $startTime = $escort->availability[$checkDay]['start'] ?? null;
                                                        if ($startTime) {
                                                        $nextDate = $now->copy()->startOfDay()->addDays($i)->format('l, M j');
                                                        $nextAvailability = $nextDate . ' at ' . date('g:i A', strtotime($startTime));
                                                        break;
                                                        }
                                                        }
                                                        }
                                                        }
                                                        @endphp

                                                        @if ($escort->is_online == 1)
                                                        <div class="exclusive-desc online-btn on">
                                                            <i class="fa fa-circle text-success" title="Online"></i>
                                                        </div>
                                                        @else
                                                        <div class="exclusive-desc online-btn off">
                                                            <i class="fa fa-circle" title="Offline"></i>
                                                        </div>
                                                        @endif
                                                </div>
                                                <div class="box-description">
                                                    <h3 class="title-index notranslate" translate="no">{{$escort->nickname}}</h3>
                                                    <div class="price">{{ format_price_dot(($escort->quickie_rates['1_hr'] ?? '0')) }}{{$escort->countries?->currency_symbol ?? '$'}}/hr, {{ format_price_dot(($escort->quickie_rates['overnight'] ?? '0')) }}{{$escort->countries?->currency_symbol ?? '$'}}/overnight</div>

                                                    <!-- @if($escort->slogan)
                                                <p class="slogan-index">"{{$escort->slogan}}"</p>
                                                @endif -->

                                                    <!-- <p class="location-index">{{ $escort->countries?->name }}, {{ $escort->state?->name ?? 'N/A' }}</p> -->
                                                    <p class="location-index">
                                                        {{ $escort->city?->name ? $escort->city->name . ', ' : '' }}
                                                        {{ $escort->state?->name ? $escort->state->name . ', ' : '' }}
                                                        {{ $escort->countries?->name ?? '' }}
                                                    </p>

                                                    @php
                                                    $selectedServices = App\Models\UserEscortService::where('user_id', $escort->id)
                                                    ->whereNull('selection_id')
                                                    ->pluck('service_id')
                                                    ->toArray();

                                                    $selectedSelections = App\Models\UserEscortService::where('user_id', $escort->id)
                                                    ->whereNotNull('selection_id')
                                                    ->pluck('selection_id')
                                                    ->toArray();

                                                    $selectedCategoryNames = [];

                                                    foreach ($categories as $category) {
                                                    $filteredServices = $category->services->filter(function ($service) use ($selectedServices, $selectedSelections) {
                                                    return in_array($service->id, $selectedServices) ||
                                                    $service->selections->pluck('id')->intersect($selectedSelections)->isNotEmpty();
                                                    });

                                                    if ($filteredServices->isNotEmpty()) {
                                                    $selectedCategoryNames[] = $category->name;
                                                    }
                                                    }
                                                    @endphp

                                                    @if (!empty($selectedCategoryNames))
                                                    @php
                                                    $displayedCategories = array_slice($selectedCategoryNames, 0, 2);
                                                    $moreCategories = count($selectedCategoryNames) > 2;
                                                    @endphp
                                                    <!-- <p class="services">
                                                        {{ implode(', ', $displayedCategories) }}{{ $moreCategories ? ', …' : '' }}
                                                    </p> -->
                                                    @endif
                                                </div>
                                                   <div class="card_btn_group">
                                                        @php $whatsappNumber = $escort->phone_code . $escort->phone; @endphp
                                                        <a href="https://wa.me/{{ $whatsappNumber }}?text=Hi%20I%20found%20your%20profile%20on%20the%20site" class="profileWhatsApp" target="_blank">
                                                            <div class="btn btn-maincolor cards-btn w-100">Book Now</div>
                                                        </a>
                                                        <a href="{{ route('user.profile.show', $escort->id) }}">
                                                            <div class="btn btn-maincolor cards-btn view-prof-btn">View Profile</div>
                                                        </a>
                                                    </div>
                                            </a>
                                        </div>
                                @endforeach
                            </div>
                        </div>
                    </section>
                    @endif
                    <!-- Top Rated End -->


                    <!-- ******************************************** -->







                    <!-- 
                @if($no_record)
                    <div class="alert alert-danger">No records found !!</div>
                @endif -->
                    <div class="row mt-4 mx-auto">
                        <div class="fw-divider-space pt-20 hidden-above-lg"></div>
                        <div class="col-12 text-center">
                            <div class="btn btn-maincolor">
                                <a href="{{route('model.search')}}{{ isset($city) ? "?city=".$city:"" }}">All Escorts</a>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-4 mx-auto">
                        <div class="col-12 text-justify">
                            {!! $locationSeo['data']->content ?? '' !!}
                        </div>
                    </div>




                </div>
            </div>
        </div>
    </section>
    @endsection
    @push('js')
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css" /> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.isotope/3.0.6/isotope.pkgd.min.js"></script>



    <script>
        const swiper = new Swiper('.swiper', {
            loop: true,
            // autoplay: {
            //     delay: 3000,
            // },
        });
        var $grid = $('.isotope-wrapper').isotope({
            itemSelector: '.col-sm-6',
            layoutMode: 'masonry'
        });

        // Filter on click
        $('.gallery-filters a').on('click', function(e) {
            e.preventDefault();
            var filterValue = $(this).attr('data-filter');
            $grid.isotope({
                filter: filterValue
            });

            // Active state toggle
            $('.gallery-filters a').removeClass('active selected');
            $(this).addClass('active selected');
        });
    </script>

    <script>
        function toggleHeart(button) {
            const icon = button.querySelector('i');

            // Toggle class and icon style
            button.classList.toggle('liked');
            if (icon.classList.contains('fa-regular')) {
                icon.classList.remove('fa-regular');
                icon.classList.add('fa-solid');
            } else {
                icon.classList.remove('fa-solid');
                icon.classList.add('fa-regular');
            }
        }
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sliderClasses = [
                '.featured-devils-cards-slider',
                '.featured-devils-cards-slider-two',
                '.featured-devils-cards-slider-three',
                '.featured-devils-cards-slider-four',
                '.featured-devils-cards-slider-five'
            ];

            sliderClasses.forEach(selector => {
                const sliderElement = document.querySelector(selector);
                if (sliderElement) {
                    new Swiper(selector, {
                        loop: true,
                        slidesPerView: 4,
                        slidesPerGroup: 1,
                        spaceBetween: 20,
                        centeredSlides: false,
                        allowTouchMove: true,
                        simulateTouch: true,
                        grabCursor: true,
                        touchRatio: 1,
                        touchAngle: 45,
                        navigation: {
                            nextEl: '.swiper-button-next',
                            prevEl: '.swiper-button-prev',
                        },
                        pagination: false,
                        breakpoints: {
                            320: {
                                slidesPerView: 2
                            },
                            440: {
                                slidesPerView: 2
                            },
                            768: {
                                slidesPerView: 3
                            },
                            1200: {
                                slidesPerView: 4
                            },
                        },
                        on: {
                            beforeInit: function() {
                                this.loopedSlides = this.slides.length;
                            }
                        }
                    });
                }
            });
        });
    </script>

    <script>

    </script>


    <!-- <script>
  const slider1 = document.querySelector('#slider');
  const slidesContainer = slider1.querySelector('.slides');
  const slides = slider1.querySelectorAll('.slide');
  const prevBtn = slider1.querySelector('.prev');
  const nextBtn = slider1.querySelector('.next');
  
  let index = 0;
  let startX = 0;
  let isDragging = false;
  let autoplayInterval;

  function showSlide(i) {
    if (i < 0) index = slides.length - 1;
    else if (i >= slides.length) index = 0;
    else index = i;

    slidesContainer.style.transform = `translateX(${-index * 100}%)`;
  }

  function nextSlide() {
    showSlide(index + 1);
  }

  function prevSlideFunc() {
    showSlide(index - 1);
  }

  // Buttons
  nextBtn.addEventListener('click', (e) => { 
  nextSlide(); resetAutoplay();
   e.preventDefault();
        e.stopPropagation();
   });
  prevBtn.addEventListener('click', () => { prevSlideFunc(); resetAutoplay(); });

  // Touch swipe
  slidesContainer.addEventListener('touchstart', (e) => {
    startX = e.touches[0].clientX;
    isDragging = true;
  });

  slidesContainer.addEventListener('touchend', (e) => {
    if (!isDragging) return;
    let endX = e.changedTouches[0].clientX;
    let diff = startX - endX;

    if (diff > 50) nextSlide();
    else if (diff < -50) prevSlideFunc();

    isDragging = false;
    resetAutoplay();
  });

  // Auto slideshow every 2s
  function startAutoplay() {
    autoplayInterval = setInterval(nextSlide, 2000);
  }

  function resetAutoplay() {
    clearInterval(autoplayInterval);
    startAutoplay();
  }

  startAutoplay();


// document.querySelectorAll('.product_card > a').forEach(anchor => {
//     anchor.addEventListener('click', function (e) {
//         // If the click is inside the slider nav buttons, don't follow link
//         if (e.target.closest('#slider .nav-btn')) {
//             e.preventDefault();
//         }
//     });
// });

// document.querySelectorAll('#slider .nav-btn').forEach(btn => {
//     btn.addEventListener('click', e => {
//         e.preventDefault();
//         e.stopPropagation();
//     });
// });
</script> -->


    <!-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>



   


<script>
$(document).ready(function(){
    $(".owl-carousel").owlCarousel({
        loop: true,
        margin: 20,
        nav: true,
        navText: ["<", ">"],
        dots: false,
        responsive:{
            0:{ items:2 },       // Mobile
            768:{ items:3 },     // Tablet
            1200:{ items:4     }     // Desktop
        }
    });
});
</script>


    @endpush