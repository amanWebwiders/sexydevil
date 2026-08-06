<div class="col-sm-6 col-lg-4 col-lgx-3 col-xl-3 {{ $category }}">
    <div class="vertical-item item-gallery content-absolute text-center ds">

        <div class="product_card">
            <div class="position-relative">
                <button class="wishlistBtn heart-button" data-auth="{{ $authUser ? $authUser->id : '' }}"
                    data-id="{{ $escort->id }}">
                    <i class="{{ getWishlistClass($escort->id) }}"></i>
                </button>

                <a href="{{ route('user.profile.show', $escort->id) }}">
                    <div class="profile-badges">
                        <div class="badge">{{ $escort->displayed_age ?? \Carbon\Carbon::parse($escort->dob)->age }} years</div>
                        <div class="badge">{{ $escort->height_cm ?? '-' }}</div>
                    </div>

                    @if ($escort->profile_image)
                    <img src="{{ config('app.img_url') . $escort->profile_image }}" alt="{{ $escort->name }}">
                    @else
                    <img src="{{ asset('storage/profile_image/default-profile.png') }}" alt="Default">
                    @endif

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
                        <div class="exclusive-desc on"><i class="fa-solid fa-circle text-success"></i> Available Now</div>
                        @else
                        <div class="exclusive-desc off">
                            @if ($nextAvailability)
                            <i class="fa-solid fa-circle text-secondary notranslate" translate="no"></i> {{ $escort->nickname }} is off today, available on {{ $nextAvailability }}
                            @endif
                        </div>
                        @endif
                </a>
            </div>
            <a href="{{ route('user.profile.show', $escort->id) }}">
                <div class="py-3">
                    <div class="profile-name-price">
                        <div class="name notranslate" translate="no">{{ $escort->nickname }}</div>
                    </div>
                    <div class="price">{{ format_price_dot(($escort->quickie_rates['1_hr'] ?? '0')) }}{{$escort->countries?->currency_symbol ?? '$'}}/hr, {{ format_price_dot(($escort->quickie_rates['overnight'] ?? '0')) }}{{$escort->countries?->currency_symbol ?? '$'}}/overnight</div>
                    <div class="price">
                        <p class="text-left mb-0"><strong>Location:</strong>{{ $escort->city?->name ? $escort->city->name . ', ' : '' }}
                    {{ $escort->state?->name ? $escort->state->name . ', ' : '' }}
                    {{ $escort->countries?->name ?? '' }}</p>

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

                        <!-- @if (!empty($selectedCategoryNames))
                        <p class="text-left mb-0"><strong>Services:</strong> {{ implode(', ', $selectedCategoryNames) }}</p>
                        @endif -->
                    </div>

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
                </div>
            </a>
        </div>
        </a>
    </div>
</div>