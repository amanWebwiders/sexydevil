@extends('front.layout.layout')

@section('content')
    <section class="main-area">
        <div class="container-fluid">
            <div class="row">
                @include('front.component.category_sidebar')
                <div class="col-lg-10">
                    <section class="s-pt-80 s-pb-30 s-pb-md-70 s-pt-md-90 s-pb-xl-120 s-pt-xl-180">
                        @include('front.component.filters')
                    </section>
                    @php
                        $isNewEscorts = request()->routeIs('new.escorts');
                    @endphp
                    @if($isNewEscorts)
                        <h1 class="heading"><span>New</span> Escorts</h1>

                        <h2 class="heading">They’re new, hot as hell, and ready to make you sin. Meet the latest additions to
                            the Sexy Devil experience — each one freshly summoned for your pleasure.</h2>
                    @else
                        <h1 class="heading"><span>All</span> Escorts</h1>
                    @endif
                    <div class="row featured-devils-cards resultsContainer" id="resultsContainer">
                        @include('partials.model_cards')
                    </div>

                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 text-justify locationSeoContent">
                    {!! $locationSeoContent['data']->content ?? "" !!}
                </div>
            </div>            
        </div>
    </section>
@endsection
@push('js')
<script>
    window.window.isLoading = false;
</script>
@endpush
@push('js')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.isotope/3.0.6/isotope.pkgd.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>

    <script>
        $(document).ready(function () {
            function getOrderByFromRoute(page) {
                const pathname = window.location.pathname;

                if (pathname.includes('/new-escorts')) {
                    return {
                        orderBy: 'created_at',
                        direction: 'desc'
                    };
                } else if (pathname.includes('/recommend-escorts')) {
                    return {
                        orderBy: 'top3status',
                        direction: 'desc'
                    };
                } else if (pathname.includes('/active-escorts')) {
                    return {
                        orderBy: 'last_active',
                        direction: 'desc'
                    };
                } else if (pathname.includes('/lowcost-escorts')) {
                    return {
                        orderBy: 'average_quickie_rate',
                        direction: 'asc'
                    };
                } else if (pathname.includes('/model-search')) {
                    return {
                        orderBy: 'id',
                        direction: 'desc'
                    };
                }

                return {
                    orderBy: 'id',
                    direction: 'desc'
                };
            }

            let page = 2; //parseInt($('#currentPage').val()) + 1;
            let lastPage = parseInt($('#lastPage').val());
            //let window.isLoading = false;
            $(window).scroll(function () {
                //console.log(isLoading);
                if (isLoading) return;

                // Check if user is near the bottom (200px before)
                if ($(window).scrollTop() + $(window).height() + 700 >= $(document).height()) {
                    //if (page <= lastPage) {
                    window.isLoading = true;

                    let filterData = $('#filterForm').serializeArray(); // if using filters
                    filterData.push({
                        name: 'page',
                        value: page
                    });

                    filterData.push({
                        name: 'submit_country',
                        value: '{{ $all_request["country_id"] ?? "" }}'
                    });
                    filterData.push({
                        name: 'submit_city_id',
                        value: '{{ $all_request["city_id"] ?? "" }}'
                    });
                    filterData.push({
                        name: 'submit_state_id',
                        value: '{{ $all_request["state_id"] ?? "" }}'
                    });
                    let order = getOrderByFromRoute(page);
                    // filterData.push({
                    //     name: 'orderBy',
                    //     value: order.orderBy
                    // });
                    // filterData.push({
                    //     name: 'orderDirection',
                    //     value: order.direction
                    // });


                    $.ajax({
                        url: "{{ $url }}", // Replace with your actual route
                        type: "post",
                        data: filterData,
                        dataType: 'json',
                        beforeSend: function () {
                            //$('#resultsContainer').append('<div class="text-center" id="loader"><p>Loading...</p></div>');
                            $('.emptyCard').remove();
                            //$(".locationSeoContent").html("");
                        },
                        success: function (data) {
                            //  $('#resultsContainer').html('');
                            $(".locationSeoContent").html(data.content !== null ? data.content : '');
                            if (data.code == 400) {
                                page = data.page;
                                window.isLoading = true;
                                // No more results
                                //$(window).off('scroll'); // Stop infinite scroll
                            } else {
                                $('#resultsContainer').append(data.list);
                                page = data.page;
                                $('#currentPage').val(page);
                                initSwiper();
                                $('#loader').remove();
                                window.isLoading = false;
                            }
                        },
                        error: function () {
                            $('#loader').remove();
                            //alert('Error loading more escorts.');
                            window.isLoading = false;
                        }
                    });
                    //}
                }
            });
        });
        function initSwiper() {    
            document.querySelectorAll(".slider").forEach(function (slider) {

                // ❌ Skip if already initialized
                if (slider.dataset.sliderInit === "1") {
                    return;
                }

                let slidesContainer = slider.querySelector(".slides");
                if (!slidesContainer) return;

                let slides = slidesContainer.querySelectorAll(".slide");
                let index = 0;
                let total = slides.length;

                slidesContainer.style.transform = "translateX(0%)";

                // Clear old interval if exists
                if (slider.sliderInterval) {
                    clearInterval(slider.sliderInterval);
                }

                // Start slider
                slider.sliderInterval = setInterval(() => {
                    index = (index + 1) % total;
                    slidesContainer.style.transform = `translateX(-${index * 100}%)`;
                }, 3000);

                // ✅ Mark slider as initialized
                slider.dataset.sliderInit = "1";
            });
        } 
        var $grid = $('.isotope-wrapper').isotope({
            itemSelector: '.col-sm-6',
            layoutMode: 'masonry'
        });

        // Filter on click
        $('.gallery-filters a').on('click', function (e) {
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