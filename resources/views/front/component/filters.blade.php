<style>
    .range-slider input[type=range] {
        top: 0;
    }

    .min-output,
    .max-output {
        height: 45px !important;
        padding: 6px 2px 6px 12px !important;
    }

    .range-slider-output {
        gap: 15px;
    }

    .range-slider {
        margin-inline: 10px;
    }

    .range-slider .track {
        margin-top: 0px !important;
    }
</style>
<div class="filter-section d-none d-lg-block">
    <form method="post" id="filterForm" action="{{ route('model.search', ["city" => $city ?? ""]) }}">
        @csrf
    <div class="filter-box filter-section" data-search-url="{{ route('model.search') }}">

        <div class="row ">

            <!-- Visible Filters -->



            <div class="col-lg-12 mb-3">

                <div class="form-group">

                    <label class="filter-label">Search</label>

                    <input type="text" name="name" value="{{ request('name') }}" class="form-control" placeholder="Search by Name">

                </div>

            </div>



            <div class="col-lg-3 mb-3">
                <label class="filter-label">Country</label>
                
                <select id="filter_country" class="custom-select country-flag-select" name="country_id">
                    <option value="">Select Country</option>
                    
                    @foreach($country ?? [] as $countri)
                    <option value="{{ $countri['id'] }}" data-flag="{{ asset('images/flags/' . strtolower(emojiToCountryCode($countri['emoji'])) . '.svg') }}" 
                    {{ (request('country_id') == $countri['id'] || (!request('country_id') && $countri['id'] == 48)) ? 'selected' : '' }}>
                        {{ $countri['country'] }} ({{ $countri['total_users'] }})
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="col-lg-3 mb-3">
                <label class="filter-label">State</label>
                <select class="custom-select filter_state select2-state" name="state_id" data-selected="{{ old('state_id', request('state_id', $selectedStateId ?? '')) }}">
                    <option value="">Select State</option>
                </select>
            </div>

            <div class="col-lg-3 mb-3">
                <label class="filter-label">City</label>
                <select class="custom-select filter_city select2-city" name="city_id" data-selected="{{ old('city_id', request('city_id', $selectedCityId ?? '')) }}">
                    <option value="">Select City</option>
                </select>
            </div>





            {{-- <div class="col-lg-3 slider-wrapper mb-3">
                <div class="d-flex gap-3 align-items-center">
                    <span>Min<strong class="currency-symbol"></strong> <span class="min-display"></span></span>
                    <div class="range-slider">
                        <div class="track"></div>
                        <div class="range" id="range-highlight"></div>
                        <input type="range" class="range-min" min="0" max="1000000" value="0" step="1">
                        <input type="range" class="range-max" min="0" max="1000000" value="1000000" step="1">
                    </div>
                    <span>Max<strong class="currency-symbol"></strong> <span class="max-display"></span></span>
                </div>
                <div class="d-flex justify-content-between mt-1 range-slider-output">
                    <input type="text" class="min-output" readonly data-raw="">
                    <input type="text" class="max-output" readonly data-raw="">
                    <input type="hidden" class="min-output-val" value="">
                     <input type="hidden" class="max-output-val" value="">
                </div>
            </div> --}}


            <div class="col-lg-3 mb-3">

                <label class="filter-label">Gender</label>

                <select class="custom-select" name="gender">

                    <option value="">Select Gender</option>

                    @foreach($gender as $gender)
                    <option value="{{ $gender->id }}" @if(request('gender') == $gender->id) selected @endif>
                        {{ $gender->name }}
                    </option>
                    @endforeach

                </select>

            </div>



            <!-- <div class="col-lg-3 mb-3">

                <label class="filter-label">Videocall</label>

                <select class="custom-select" name="videocall">

                    <option value="">Select</option>

                    <option>Yes</option>

                    <option>No</option>

                </select>

            </div> -->



            <div class="col-lg-3 mb-3">

                <label class="filter-label">Hotel and private home visits</label>

                <select class="custom-select" name="outcall">

                    <option value="">Select</option>

                    <option value="yes" @if (request('outcall') == 'yes') selected @endif>Yes</option>                    
                    <option value="no" @if (request('outcall') == 'no') selected @endif>No</option>

                </select>

            </div>



            <div class="col-lg-3 mb-3">

                <label class="filter-label">With own private place</label>

                <select class="custom-select" name="incall">

                    <option value="">Select</option>

                    <option value="yes" @if (request('incall') == 'yes') selected @endif>Yes</option>

                    <option value="no" @if (request('incall') == 'no') selected @endif>No</option>

                </select>

            </div>
              <div class="col-lg-3 mb-3">
                <label class="filter-label">Service Category</label>
                <select class="custom-select select2-multiple" id="categorySelect" name="category[]">
                    <option value="">Select Service Category</option>
                    @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-lg-3 mb-3">
                <label class="filter-label">Sub Category</label>
                <select class="custom-select subCategorySelect select2-multiple" name="sub_category[]">
                    <option value="">Select Sub Category</option>
                    {{-- This will be filled dynamically --}}
                </select>
            </div>

        </div>



        <!-- Hidden Filters -->

        <div class="row moreFilters" id="moreFilters">
            <div class="col-lg-3 mb-3">
                <label class="filter-label">Age</label>
                <select class="custom-select" name="age">
                    <option value="">Select Age</option>
                    @for ($i = 18; $i <= 70; $i++)
                        <option value="{{ $i }}">{{ $i }}</option>
                        @endfor
                </select>
            </div>

            <div class="col-lg-3 mb-3">
                <label class="filter-label">Weight</label>
                <select class="custom-select" name="weight_range">
                    <option value="">Select Weight Range</option>
                    <option value="under_45">Under 45kg</option>
                    <option value="45_55">45–55kg</option>
                    <option value="55_65">55–65kg</option>
                    <option value="65_75">65–75kg</option>
                    <option value="over_75">Over 75kg</option>
                </select>
            </div>

            <div class="col-lg-3 mb-3">
                <label class="filter-label">Height</label>
                <select class="custom-select" name="height_range">
                    <option value="">Select Height Range</option>
                    <option value="under_150">Under 150 cm</option>
                    <option value="150_160">150–160 cm</option>
                    <option value="160_170">160–170 cm</option>
                    <option value="170_180">170–180 cm</option>
                    <option value="over_180">Over 180 cm</option>
                </select>
            </div>


            <div class="col-lg-3 mb-3">
                @php
                $breastSizes = [
                'A - Natural', 'A - Enhanced',
                'B - Natural', 'B - Enhanced',
                'C - Natural', 'C - Enhanced',
                'D - Natural', 'D - Enhanced',
                'DD - Natural', 'DD - Enhanced',
                'E+ - Natural', 'E+ - Enhanced'
                ];

                @endphp
                <label class="filter-label">Breast Size</label>

                <select class="custom-select select2-multiple" name="breast_size[]" multiple>
                    <option value="">Select Breast Size</option>
                    @foreach($breastSizes as $size)
                    <option value="{{ $size }}">
                        {{ $size }}
                    </option>
                    @endforeach

                </select>

            </div>
            <div class="col-lg-3 mb-3">

                <label class="filter-label">Eye Color</label>

                <select class="custom-select" name="eye_color_id">

                    <option value="">Select Eye Color</option>

                    @foreach($eyeColor as $item)
                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                    @endforeach

                </select>

            </div>
            <div class="col-lg-3 mb-3">

                <label class="filter-label">Pubic Hair</label>

                <select class="custom-select" name="pubic_hair_id">

                    <option value="">Select Pubic Hair</option>

                    @foreach($pubicHair as $item)
                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                    @endforeach

                </select>

            </div>
            <div class="col-lg-3 mb-3">

                <label class="filter-label">Service Provider Type</label>

                <select class="custom-select" name="sex_location">

                    <option value="">Select Service Provider Type</option>


                    <option value="Sex house">Sex house</option>
                    <option value="Nightclub">Nightclub</option>
                    <option value="Massage House">Massage House</option>
                    <option value="Agency">Agency</option>
                    <option value="Independent">Independent</option>
                </select>

            </div>
            <div class="col-lg-3 mb-3">

                <label class="filter-label">Body Type</label>

                <select class="custom-select" name="body_type_id">

                    <option value="">Select Body Type</option>

                    @foreach($bodyType as $item)
                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                    @endforeach

                </select>

            </div>


            <div class="col-lg-3 mb-3">

                <label class="filter-label">Hair Type</label>

                <select class="custom-select" name="hair_type">

                    <option value="">Select Hair</option>

                    @foreach($hairType as $item)
                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                    @endforeach

                </select>

            </div>



            <div class="col-lg-3 mb-3">

                <label class="filter-label">Hair Color</label>

                <select class="custom-select" name="hair_color">

                    <option value="">Select Color</option>

                    @foreach($hairColor as $item)
                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                    @endforeach
                </select>

            </div>



            <div class="col-lg-3 mb-3">

                <label class="filter-label">Nationality</label>

                <select class="custom-select" name="nationality">

                    <option value="">Select Nationality</option>

                    @foreach($nationality as $nationality)
                    <option value="{{ $nationality->name }}">{{ $nationality->name }}</option>
                    @endforeach

                </select>

            </div>



            <div class="col-lg-3 mb-3">

                <label class="filter-label">Ethnicity</label>

                <select class="custom-select" name="ethnicity">

                    <option value="">Select Ethnicity</option>

                    @foreach($ethnicity as $ethnicity)
                    <option value="{{ $ethnicity->id }}">{{ $ethnicity->name }}</option>
                    @endforeach

                </select>

            </div>



            <div class="col-lg-3 mb-3">

                <label class="filter-label">Language</label>

                <select class="custom-select select2-multiple" name="language[]" multiple>

                    <option value="">Select Language</option>

                    @foreach($language as $lang)
                    <option value="{{ $lang->id }}">
                        {{ $lang->name }}
                    </option>
                    @endforeach

                </select>

            </div>



            <div class="col-lg-3 mb-3">

                <label class="filter-label">Tattoos</label>

                <select class="custom-select" name="tattoo">
                    <option value="">Select Option</option>
                    <option value="yes">Yes</option>
                    <option value="no">No</option>
                </select>

            </div>



            <div class="col-lg-12 mb-2">

                <h4>Preferences:</h4>

            </div>



            <div class="col-lg-3 mb-3">

                <label class="filter-label">Piercing</label>

                <select class="custom-select" name="piercing">
                    <option value="">Select Option</option>
                    <option value="yes">Yes</option>
                    <option value="no">No</option>
                </select>

            </div>



            <div class="col-lg-3 mb-3">

                <label class="filter-label">Orientation</label>

                <select class="custom-select" name="sexual_orientation">
                    <option value="">Select</option>
                    <option value="Heterosexual">Heterosexual</option>
                    <option value="Homosexual">Homosexual</option>
                    <option value="Bisexual">Bisexual</option>
                    <option value="Pansexual">Pansexual</option>
                    <option value="Other">Other</option>
                </select>

            </div>



            <div class="col-lg-3 mb-3">

                <label class="filter-label">Payment Methods</label>

                <select name="payment_method[]" id="payment_method" class="custom-select select2-multiple" multiple>

                    <option value="">Select</option>
                    <option value="cash">Cash</option>
                    <option value="transfer">Transfer</option>
                    <option value="crypto">Crypto</option>
                    <option value="card terminal">Card Terminal</option>

                </select>

            </div>



            <!-- Tattoos, piercing, orientation  -->

        </div>



        <!-- Show More Button -->

        <div class="col-12 text-center mt-3 px-2">
            <div class="row mx-0 justify-content-between">
                <div class="d-flex flex-wrap justify-content-center gap-3">
                    <button class="btn btn-maincolor mr-2" id="clearBtn" type="button">Clear filter</button>
                    <button class="btn btn-maincolor  searchBtn" id="searchBtn" type="button">Search</button>
                    <button class="btn btn-maincolor ml-2" id="toggleFiltersBtn" type="button">
                    Show More Filters
                </button>
                </div>
            </div>
        </div>

    </div>
    </form>
</div>

@push('js')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<script>
$(document).ready(function() {
    function formatCountry (state) {
        if (!state.id) {
            return state.text;
        }
        var flagUrl = $(state.element).data('flag');
        if(flagUrl) {
            var $state = $(
                '<span><img src="' + flagUrl + '" class="img-flag" style="width:20px; margin-right:6px; vertical-align:middle;" /> ' + state.text + '</span>'
            );
            return $state;
        }
        return state.text;
    };

    $('.country-flag-select').select2({
        templateResult: formatCountry,
        templateSelection: formatCountry,
        minimumResultsForSearch: 10,
        width: '100%'
    });

    // Add Select2 for State and City with search enabled
    $('.select2-state').select2({
        placeholder: "Select State",
        allowClear: true,
        minimumResultsForSearch: 0,
        width: '100%'
    });
    $('.select2-city').select2({
        placeholder: "Select City",
        allowClear: true,
        minimumResultsForSearch: 0,
        width: '100%'
    });
});
</script>
@endpush