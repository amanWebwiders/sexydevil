@extends('front.layout.layout')

@section('content')




<section class="main-area">
    <div class="container-fluid">
        <div class="row">
            @include('front.component.quicklink')

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
                @include('front.component.quicklink')
            </div>


            <div class="offcanvas-backdrop" id="offcanvasBackdrop"></div>

            <!-- for mobile end  -->

            <div class="col-lg-10">



                <section class="vip favourite-list mt-4">
                    <div class="container-fluid">
                        <div class="">
                            <div class="row justify-content-between align-items-center mb-4 w-100 mx-0">
                                <h2 class="heading ">Favourite List</h2>
                                @if(!$data->isEmpty())
                                <select class="form-control orderby col-3" name="orderby" id="orderby">
                                    <option value="default" selected="">Actions</option>
                                    <option value="remove_all">Remove All Favourites</option>

                                </select>
                                @endif
                            </div>
                            <div class="featured-devils-cards row">

                                
                                    @if($data->isEmpty())
                                    <div class="text-center py-5">
                                        <h4>No Favourite User.</h4>
                                    </div>
                                    @else
                                    @foreach($data as $escort)
                                    <div class="col-lg-3 col-md-4 col-6 mb-3">
                                        <div class="product_card index-cards ">
                                            <a href="{{ route('user.profile.show', $escort->favouriteUser->id) }}">
                                                @php
                                                $authUser = Auth::guard('web')->user();
                                                @endphp
                                                <div class="top-box">

                                                    <button class="wishlistBtn heart-button" data-auth="{{ $authUser ? $authUser->id : '' }}"
                                                        data-id="{{ $escort->favouriteUser->id }}">
                                                        <i class="{{ getWishlistClass($escort->favouriteUser->id) }}"></i>
                                                    </button>
                                                    @if($escort->favouriteUser->is_boosted && $escort->favouriteUser->boost_end_date >= now())
                                                    <div class="exclusive-label exclusive-vip">VIP</div>
                                                    @endif



                                                    @if ($escort->favouriteUser->profile_image)
                                                    <img src="{{ config('app.img_url').$escort->favouriteUser->profile_image }}" alt="{{ $escort->favouriteUser->nickname }}">
                                                    @else
                                                    <img src="{{ asset('storage/profile_image/default-profile.png') }}" alt="Slide 1">
                                                    @endif


                                                    <div class="corner-ribbon corner-ribbon-sm">
                                                        <i class="fa-solid fa-fire"></i>
                                                        <span>{{$escort->favouriteUser->plan->tag}}</span>
                                                    </div>



                                                    <div class="views-label">


                                                        @php
                                                        $viewCount = $escort->favouriteUser->viewsReceived->count();
                                                        @endphp

                                                        @if ($viewCount > 1)
                                                        <i class="fa-solid fa-eye"></i> {{ $viewCount }} Views
                                                        @else
                                                        <i class="fa-solid fa-eye"></i> {{ $viewCount }} View
                                                        @endif
                                                    </div>
                                                    @php
                                                    $now = \Carbon\Carbon::now();
                                                    $nextAvailability = null;
                                                    if (!$escort->favouriteUser->is_online && !empty($escort->favouriteUser->availability)) {
                                                    for ($i = 0; $i < 7; $i++) {
                                                        $checkDay=strtolower($now->copy()->addDays($i)->format('l'));
                                                        if (!empty($escort->favouriteUser->availability[$checkDay])) {
                                                        $startTime = $escort->favouriteUser->availability[$checkDay]['start'] ?? null;
                                                        if ($startTime) {
                                                        $nextDate = $now->copy()->startOfDay()->addDays($i)->format('l, M j');
                                                        $nextAvailability = $nextDate . ' at ' . date('g:i A', strtotime($startTime));
                                                        break;
                                                        }
                                                        }
                                                        }
                                                        }
                                                        @endphp

                                                        @if ($escort->favouriteUser->is_online == 1)
                                                        <div class="exclusive-desc on">
                                                            <i class="fa fa-circle text-success" title="Online"></i>
                                                        </div>
                                                        @else
                                                        <div class="exclusive-desc off">
                                                            <i class="fa fa-circle" title="Offline"></i>
                                                        </div>
                                                        @endif




                                                </div>
                                                <div class="box-description">
                                                    <h3 class="title-index notranslate" translate="no" >{{$escort->favouriteUser->nickname}}</h3>
                                                    <div class="price">
                                                        {{ format_price_dot(($escort->favouriteUser->quickie_rates['1_hr'] ?? '0')) }}{{$escort->countries?->currency_symbol ?? '$'}}/hr, 
                                                        {{ format_price_dot(($escort->favouriteUser->quickie_rates['overnight'] ?? '0')) }}{{$escort->countries?->currency_symbol ?? '$'}}/overnight
                                                    </div>

                                                    @if($escort->favouriteUser->slogan)
                                                    <p class="slogan-index">"{{$escort->favouriteUser->slogan}}"</p>
                                                    @endif
                                                    <p class="location-index"> {{ $escort->favouriteUser->city?->name ? $escort->favouriteUser->city->name . ', ' : '' }}
                                                            {{ $escort->favouriteUser->state?->name ? $escort->favouriteUser->state->name . ', ' : '' }}
                                                            {{ $escort->favouriteUser->countries?->name ?? '' }}</p>
                                                  
                                                    @php
                                                    $selectedServices = App\Models\UserEscortService::where('user_id', $escort->favouriteUser->id)
                                                    ->whereNull('selection_id')
                                                    ->pluck('service_id')
                                                    ->toArray();

                                                    $selectedSelections = App\Models\UserEscortService::where('user_id', $escort->favouriteUser->id)
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
                                                    <p class="services">
                                                        {{ implode(', ', $displayedCategories) }}{{ $moreCategories ? ', …' : '' }}
                                                    </p>
                                                    @endif
                                                    @php
                                                    $reviews = $escort->favouriteUser->reviewsReceived;
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


                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                    @endforeach
                                    @endif




                            </div>
                        </div>
                    </div>
                </section>





            </div>
        </div>
    </div>
</section>


@endsection
@push('js')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.isotope/3.0.6/isotope.pkgd.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>

<script>
    $(document).on('change', '#orderby', function() {
        console.log('sdbfsdbfds');
        var selectedValue = $(this).val();

        if (selectedValue === 'remove_all') {
            if (!confirm("Are you sure you want to remove all favourites?")) {
                $(this).val('default'); // Reset selection if cancelled
                return;
            }

            $.ajax({
                url: "{{ route('user.removeAllFavourites') }}",
                type: "POST",
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.status === 1) {
                        toastr.success(response.message);
                        setTimeout(() => {
                            location.reload();
                        }, 1000);
                    } else {
                        toastr.error(response.message);
                    }
                },
                error: function() {
                    toastr.error("An unexpected error occurred.");
                }
            });

            $(this).val('default'); // Reset selection after action
        }
    });

    const swiper = new Swiper('.swiper', {
        loop: true,
        autoplay: {
            delay: 3000,
        },
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

<!-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script> -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

@endpush