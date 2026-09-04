    @extends('front.layout.layout')


    @section('content')
    <div class="container entry" style="padding-block: 150px 50px;">
        <div class="main-row">
            <div class="search-area">
                <form method="get" action="{{ route('model.search') }}" id="searchForm">
                <label for="search">WHERE DO YOU WANT TO HAVE FUN?</label>

                <div class="search-field">                    
                    <input id="search" autocomplete="off" name="city" type="text" placeholder="Country, Regions, City" />
                    <input type="hidden" name="type" id="hiddenType" value="" />
                    <button type="button" class="icon" title="Clear" onclick="$('#search').val('')">&#10005;</button>
                    <!-- <button class="icon" title="My Location">&#9881;</button> -->
                </div>
                    <ul class="list-group shadow-sm d-none overAllCountry">
                       
                        <!-- Demy List Add Start-->
                        @foreach ($allCountry as $_allCountry)
                            <li class="list-group-item p-1">
                                <!-- Country Header -->
                                <div class="d-flex justify-content-between align-items-center country-toggle" style="cursor:pointer;">
                                    <div class="d-flex align-items-center">
                                        <span class="mr-2 text-danger font-weight-bold toggle-icon countryList">+</span>
                                        <img src="{{ $_allCountry['flag'] }}" width="35" class="mr-2">
                                        <span class="font-weight-bold selectedCountry" data-type="country" data-name="{{ $_allCountry['country'] }}">{{ $_allCountry['country'] }}</span>
                                    </div>
                                    <span class="badge badge-danger badge-pill">{{ $_allCountry['total_users'] }}</span>
                                </div>
                                <!-- States List -->
                                 @foreach ($_allCountry["states"] as $_states)
                                <ul class="states list-group d-none">
                                    <!-- State Item -->
                                    <li class="list-group-item p-1">
                                        <div class="d-flex justify-content-between align-items-center state-toggle" style="cursor:pointer;">
                                            <div>
                                                <span class="mr-2 text-primary font-weight-bold toggle-icon stateList">+</span>
                                                <span class="font-weight-bold text-dark selectedCountry" data-type="state" data-name="{{ $_states['state'] }}">{{ $_states['state'] }}</span>
                                            </div>
                                            <span class="badge badge-danger badge-pill">{{ $_states['total_users'] }}</span>
                                        </div>
                                        <!-- Cities List -->
                                        <ul class="citiesList list-group mt-2 d-none">
                                            @foreach ($_states["cities"] as $_cities)
                                            <li class="list-group-item selectedCountry" data-type="city" data-name="{{ $_cities['city'] }}">{{ $_cities['city'] }} ({{ $_cities['total_users'] }})</li>
                                            @endforeach
                                        </ul>
                                    </li>
                                    <!-- Another City End -->
                                </ul>
                                @endforeach
                            </li>
                        @endforeach
                        <!-- Demy List Add End-->

                    </ul>
                <ul id="result"></ul>
                <button type="submit" class="btn-maincolor">Let's go</button>
                </form>
            </div>
            <div class="cities">
                <h3>TOP CITIES</h3>
                <ul>
                    <li class="country-item">
                        <div class="country-name">Colombia</div>
                        <div class="city-list">
                            <a href="{{ route('home', ['city' => 'Medellín']) }}">Medellín,</a> <a href="{{ route('home', ['city' => 'Bogotá D.C']) }}">Bogotá D.C,</a> 
                            <a href="{{ route('home', ['city' => 'Cali']) }}">Cali</a>
                        </div>
                    </li>
                    <li class="country-item">
                        <div class="country-name">Spain</div>
                        <div class="city-list">
                            <a href="{{ route('home', ['city' => 'Madrid']) }}">Madrid,</a> <a href="{{ route('home', ['city' => 'Barcelona']) }}">Barcelona,</a> <a href="{{ route('home', ['city' => 'Canarias']) }}">Canarias</a>
                        </div>
                    </li>
                    <li class="country-item">
                        <div class="country-name">Netherlands</div>
                        <div class="city-list">
                            <a href="{{ route('home', ['city' => 'Amsterdam']) }}">Amsterdam,</a> <a href="{{ route('home', ['city' => 'Rotterdam']) }}">Rotterdam,</a> <a href="{{ route('home', ['city' => 'Den Haag']) }}">Den Haag</a>
                        </div>
                    </li>
                    <li class="country-item">
                        <div class="country-name">United Kingdom</div>
                        <div class="city-list">
                            <a href="{{ route('home', ['city' => 'London']) }}">London,</a> <a href="{{ route('home', ['city' => 'Manchester']) }}">Manchester,</a> <a href="{{ route('home', ['city' => 'Birmingham']) }}">Birmingham</a>
                        </div>
                    </li>
                     <li class="country-item">
                        <div class="country-name">Germany</div>
                        <div class="city-list">
                            <a href="{{ route('home', ['city' => 'Berlin']) }}">Berlin,</a> <a href="{{ route('home', ['city' => 'Hamburg']) }}">Hamburg,</a> <a href="{{ route('home', ['city' => 'Munich']) }}">Munich,</a> <a href="{{ route('home', ['city' => 'Frankfurt']) }}">Frankfurt,</a>
                        </div>
                    </li>
                    <li class="country-item">
                        <div class="country-name">United Arab Emirates</div>
                        <div class="city-list">
                            <a href="{{ route('home', ['city' => 'Dubai']) }}">Dubai,</a> <a href="{{ route('home', ['city' => 'Abu Dhabi']) }}">Abu Dhabi,</a>
                        </div>
                    </li>
                    <li class="country-item">
                        <div class="country-name">Thailand</div>
                        <div class="city-list">
                            <a href="{{ route('home', ['city' => 'Bangkok']) }}">Bangkok,</a> <a href="{{ route('home', ['city' => 'Phuket']) }}">Phuket,</a> <a href="{{ route('home', ['city' => 'Pattaya']) }}">Pattaya</a>
                        </div>
                    </li>
                    <li class="country-item">
                        <div class="country-name">Australia</div>
                        <div class="city-list">
                            <a href="{{ route('home', ['city' => 'Sydney']) }}">Sydney,</a> <a href="{{ route('home', ['city' => 'Melbourne']) }}">Melbourne,</a> <a href="{{ route('home', ['city' => 'Brisbane']) }}">Brisbane</a> <a href="{{ route('home', ['city' => 'Perth']) }}">Perth</a>
                        </div>
                    </li>
                    <!-- <li><a href="{{ route('home', ['city' => $cityCountry['city']]) }}" >{{ $cityCountry["city"] }}</a></li>
                    @foreach ($MyCity as $_city)
                        <li><a href="{{ route('home', ['city' => $_city->name]) }}" >{{ $_city->name }}</a></li>
                    @endforeach  -->
                </ul>
            </div>
            <div class="regions">
                <h3>REGIONS</h3>
                <ul>
                    <li class="regions-item"><a href="{{ route('home', ['city' => 'Europe']) }}">Europe</a></li>
                    <li class="regions-item"><a href="{{ route('home', ['city' => 'Latin America']) }}">Latin America</a></li>
                    <li class="regions-item"><a href="{{ route('home', ['city' => 'North America']) }}">North America</a></li>
                    <li class="regions-item"><a href="{{ route('home', ['city' => 'Oceania']) }}">Oceania</a></li>
                    <li class="regions-item"><a href="{{ route('home', ['city' => 'Asia']) }}">Asia</a></li> 
                    <li class="regions-item"><a href="{{ route('home', ['city' => 'Middle East']) }}">Middle East</a></li> 
                    <!-- <li><a href="{{ route('model.search') }}" >All regions</a></li>
                    @foreach ($state as $_state)
                        <li><a href="{{ route('home', ['city' => $_state->name]) }}" >{{ $_state->name }}</a></li>
                    @endforeach  -->
                </ul>
            </div>
        </div>
        <div class="row mt-4 mx-auto">
            <div class="col-12 text-justify">
                {!! $locationSeo['data']->content ?? '' !!}
            </div>
        </div>
    </div>
    @endsection

    @push('js')
    <script>
       var countries = {!! json_encode($allCountry) !!};

        /*$(document).on('keyup', '#search', function() {
            var value = $(this).val().toLowerCase().trim();
            var filtered = [];

            if (value.length > 1) {
                filtered = countries.filter(function(country) {
                    return country.country.toLowerCase().includes(value);
                });
            }

            var $result = $('#result');
            $result.empty();

            if (filtered.length > 0) {
                filtered.forEach(function(country, index) {
                    let statesHTML = '';
                    if (country.states && country.states.length > 0) {
                        statesHTML = `
                            <ul class="list-group list-group-flush mt-2 d-none" id="states-${index}">
                                ${country.states.map(state => `
                                    <li class="selectedCountry cursor-pointer pl-4" data-name="${state.state}">
                                        <i class="fas fa-angle-right text-muted"></i> 
                                        ${state.state} — <span class="text-info">${state.total_users}</span>
                                    </li>
                                `).join('')}
                            </ul>
                        `;
                    }

                    $result.append(`
                        <li >
                            <strong class="country-item cursor-pointer" data-target="#states-${index}">+</strong>
                            <span class="selectedCountry cursor-pointer" data-name="${country.country}">
                            <strong><img src="${country.flag}" width="40px"> <span>${country.country}</span></strong> 
                            <span class="badge badge-primary float-right">${country.total_users} users</span>
                            ${statesHTML}
                            </span>
                        </li>
                    `);
                });
            } else if (value.length > 0) {
                $result.append('<li class="no_result">No results found</li>');
            }
        }); */
        $(document).on('mouseleave', '.search-area', function() {
            $('.overAllCountry').addClass('d-none');
        })
        $(document).on('click', '#search', function() {
            $('.overAllCountry').removeClass('d-none');
            return false;
            var value = $(this).val().toLowerCase().trim();
            var filtered = [];
            var $result = $('#result');
            $result.empty();

            if (value.length > 3) {
                countries.forEach(function(country, index) {
                    let matchedStates = country.states.filter(function(state) {
                        return state.state.toLowerCase().includes(value);
                    });

                    // Match by country name
                    if (country.country.toLowerCase().includes(value)) {
                        filtered.push({
                            type: 'country',
                            country: country,
                            index: index
                        });
                    } 
                    // Match by state name
                    else if (matchedStates.length > 0) {
                        filtered.push({
                            type: 'state',
                            country: country,
                            states: matchedStates
                        });
                    }
                });

            if (filtered.length > 0) {
                filtered.forEach(function(item, index) {
                    if (item.type === 'country') {
                        let country = item.country;
                        let statesHTML = '';

                        if (country.states && country.states.length > 0) {
                            statesHTML = `
                                <ul class="list-group list-group-flush mt-2 d-none" id="states-${item.index}">
                                    ${country.states.map(state => `
                                        <li class="selectedCountry cursor-pointer pl-4" data-name="${state.state}">
                                            <i class="fas fa-angle-right text-muted"></i> 
                                            ${state.state} — <span class="text-info">${state.total_users}</span>
                                        </li>
                                    `).join('')}
                                </ul>
                            `;
                        }

                        $result.append(`
                            <li>
                                <strong class="country-item cursor-pointer" data-target="#states-${item.index}">+</strong>
                                <span class="selectedCountry cursor-pointer notranslate" translate="no" data-name="${country.country}">
                                    <strong>
                                    <img src="${country.flag}" width="40px"> <span>${country.country}</span>
                                    <span class="badge badge-primary float-right">${country.total_users} users</span>
                                    </strong>
                                    ${statesHTML}
                                </span>
                            </li>
                        `);
                    }  
                });

                filtered.forEach(function(item, index) { 
                    if (item.type === 'state') {
                        // Show only matching states
                        item.states.forEach(state => {
                            $result.append(`
                                <li class="selectedCountry cursor-pointer pl-4" data-name="${state.state}">
                                    ${state.state} — <span class="text-info">${state.total_users} <i class="fas fa-angle-right text-muted"></i> </span>
                                </li>
                            `);
                        });
                    }
                });
            }
            
                if (value.length > 5) {
                $.ajax({
                    url : "{{ route('getCitiesUsers') }}",
                    method : "get",
                    data : {
                    'city':value
                    },
                    dataType : 'json',
                    beforeSend : function() {
                        $('.extraCities, .no_result').remove();
                    },
                    success : function (data) {
                        if(data.status == 200) {
                            data.data.forEach(city => {
                                $result.append(`
                                    <li class="selectedCountry extraCities cursor-pointer pl-4 notranslate" translate="no" data-name="${city.name}">
                                        <i class="fas fa-angle-right text-muted"></i> 
                                        ${city.name} — <span class="text-info">${city.total_users}</span>
                                    </li>
                                `);
                            }); 
                        } else {
                            $('.no_result').remove();
                            var countryCount = $('.selectedCountry').length;
                            if(countryCount == 0)
                            $result.append('<li class="no_result">No results found</li>');
                        }
                    }
                })
                }
            }

        });

        // ✅ Toggle states list when country is clicked
        $(document).on('click', '.country-item', function() {
            var target = $(this).data('target');

            // Check if the clicked one is already open
            var isVisible = !$(target).hasClass('d-none');

            // Hide all state lists
            $('#result ul').addClass('d-none');

            // If it was not visible, show it; otherwise keep all hidden
            if (!isVisible) {
                $(target).removeClass('d-none');
            }
        });

$(document).on('click', '.selectedCountry', function(e) {
    e.stopPropagation(); // ⛔ prevent bubbling to parent
    var selectedText = $(this).data('name');
    console.log(selectedText);
    $("#search").val(selectedText);
    $("#hiddenType").val($(this).data('type'));
    $('#result').empty();
    $('.overAllCountry').addClass('d-none');
});

$(document).on('submit', '#searchForm', function(e) {
    var searchVal = $.trim($("#search").val());
    if (!searchVal) {
        e.preventDefault();
        window.location.href = "{{ route('model.search') }}";
    } else {
        e.preventDefault();
        window.location.href = "{{ route('model.search') }}/" + encodeURIComponent(searchVal);
    }
});
    </script>

    <!-- Popup Js -->

    <script>
        $(document).on('click', '.countryList', function() {
            const currentCities = $(this).closest('li').find('.states');

            // If already visible → just hide all
            if (!currentCities.hasClass('d-none')) {
                currentCities.addClass('d-none');
                return;
            }

            // Otherwise hide all first
            $('.states').addClass('d-none');

            // Then show current
            currentCities.removeClass('d-none');
        });
        $(document).on('click', '.stateList', function() {
            const currentCities = $(this).closest('li').find('.citiesList');

            // If already visible → just hide all
            if (!currentCities.hasClass('d-none')) {
                currentCities.addClass('d-none');
                return;
            }

            // Otherwise hide all first
            $('.citiesList').addClass('d-none');

            // Then show current
            currentCities.removeClass('d-none');
        });
        
       /*  document.addEventListener('DOMContentLoaded', function() {
            const acceptBtn = document.getElementById('acceptBtn');
            const declineBtn = document.getElementById('declineBtn');
            
            acceptBtn.addEventListener('click', function() {
                const overlay = document.querySelector('.popup-inter-wrapper');
                overlay.style.display = 'none';
            });
            
            declineBtn.addEventListener('click', function() {
                overlay.style.display = 'none';
            });
        }); */
    </script>
    @endpush