@if($results->isEmpty())
<!-- <div class="py-5 emptyCard"> -->
    <!-- <h4>No models found matching your criteria.</h4> -->
    <!-- <img src="https://assets-v2.lottiefiles.com/a/e3936204-1e5d-11f0-8bdf-631b718aee0e/fllttJHLCV.gif" class="w-50"
        alt="">
</div> -->
@else

<style>
    .exclusive-label.exclusive-vip {
        left: auto;
        right: 20px;
        width: fit-content;
        top: 70px;
    }


    .exclusive-desc {
        bottom: 10px;
        right: 10px;
        padding: 7px;
    }

    .all-model-card .exclusive-label.exclusive-new {
    position: absolute;
    left: 10px;
    bottom: 40px;
    z-index: 2;
}

.popularity-label.hot-icon {
    position: absolute;
    bottom: 10px;
    left: 10px;
    z-index: 2;
    background: #00000073;
    padding: 5px;
    font-size: 12px;
    font-weight: bold;
    letter-spacing: 1px;
}

@media screen and (max-width:786px) {

.top-box.model-img-box{
        height: 300px;
        min-height: 300px;
        background-color: #8080806e;
}

.box-description{
    padding: 0.5rem;
}
    
}




</style>

@foreach($results as $escort)
@php
$authUser = Auth::guard('web')->user();
@endphp
<div class="col-lg-3 col-md-4 col-6 mb-3">
    <div class="product_card index-cards all-model-card">
        <a href="{{ route('user.profile.show', $escort->id) }}">
            @php
            $authUser = Auth::guard('web')->user();
            @endphp
            <div class="top-box model-img-box">

                <button class="wishlistBtn heart-button" data-auth="{{ $authUser ? $authUser->id : '' }}"
                    data-id="{{ $escort->id }}">
                    <!-- <i class="{{ getWishlistClass($escort->id) }}"></i> -->
                    <i class="{{ in_array($escort->id, $favorite_users) ? 'fa-solid fa-heart text-danger' : 'fa-regular fa-heart' }}"></i>
                </button>
                @if(isset($escort->is_featured))
                <div class="exclusive-label exclusive-vip notranslate" translate="no">VIP</div>
                @endif 

                <div class="slider" id="slider">
                    <a href="{{ route('user.profile.show', $escort->id) }}">
                        <div class="slides custom-slides">
                            
                            <!-- <div class="slide">
                                <img src="{{ config('app.img_url') . $escort->profile_image }}"
                                    alt="{{ $escort->nickname }}">
                            </div> -->
                            @if(count($escort->images) == 0)
                            <div class="slide">
                                <img src="{{ asset('storage/profile_image/default-profile.png') }}"
                                    alt="{{ $escort->nickname ?? ($seoImageAlt ?? 'SexyDevil Escort') }}">
                            </div>
                            @endif
                            @if($escort->images)
                            @foreach($escort->images as $image)
                            @if($image->is_approved == 1)
                            <div class="slide">
                                <img src="{{ config('app.img_url').$image->file_path }}" alt="{{ $escort->nickname ?? ($seoImageAlt ?? 'SexyDevil Escort') }}">
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
                @php
                $createdWithinTwoWeeks = $escort->created_at >= now()->subDays(14);
                @endphp
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
                    <!-- View label start -->   
                    @if(isset($escort->is_featured))
                        @php
                        $trending = ["🔥 VERY POPULAR TODAY", "🔥 TRENDING"];

                        // Pick any one random trending item
                        $random = $trending[array_rand($trending)];
                        @endphp
                        <div class="views-label">
                            <span class="popularity-label">{{ $random }}</span>
                        </div>
                        <!-- View label end -->
                    @endif
                </div> 
                @php
                $now = \Carbon\Carbon::now();
                $nextAvailability = null;
                if (!$escort->is_online && !empty($escort->availability)) {
                for ($i = 0; $i < 7; $i++) { $checkDay=strtolower($now->copy()->addDays($i)->format('l'));
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
                <h3 class="title-index mb-1 notranslate" translate="no">{{$escort->nickname}}</h3>
                <div class="price">{{ format_price_dot(($escort->quickie_rates['1_hr'] ?? '0')) }}
                {{$escort->countries?->currency ?? 'USD'}}/hr, {{ format_price_dot(($escort->quickie_rates['overnight'] ?? '0')) }}{{$escort->countries?->currency ?? 'USD'}}/overnight</div>

                <!-- @if($escort->slogan)
                <p class="slogan-index">"{{ \Illuminate\Support\Str::limit($escort->slogan, 30) }}...."</p>
                @endif -->
                <p class="location-index mb-1">
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
                $filteredServices = $category->services->filter(function ($service) use ($selectedServices,
                $selectedSelections) {
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
</div>

@endforeach

@endif