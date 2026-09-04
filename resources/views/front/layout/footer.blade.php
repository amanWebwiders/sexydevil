<footer class="page_footer ds top_mask_add s-pb-10 s-pt-70 s-pb-md-40 s-pt-md-85">
    <div class="container pt-3">
        <div class="row">
            <div class="divider-20 d-none d-xl-block"></div>

            <div class="col-12 text-center" data-animation="fadeInUp">
                <div class="d-flex justify-content-center flex-wrap gap-3 footer-menu mb-3 text-center">
                    <div>
                        <a href="{{route('contact-us')}}">Contact Us</a>
                    </div>
                    <div>
                        <a href="{{route('about-us')}}">About Us</a>
                    </div>
                    <div>
                        <a href="{{route('terms')}}">Terms & Conditions</a>
                    </div>
                    <div>
                        <a href="{{route('faq')}}">FAQ</a>
                    </div>
                </div>

                <!-- <div class="widget widget_social_buttons">
                    @if ($globalData->telegram_active == 1)
                        <a href="{{ $globalData->telegram }}" target="_blank" class="fa fa-telegram color-bg-icon rounded" title="telegram"></a>                    
                    @endif
                    @if ($globalData->facebook_active == 1)
                        <a href="{{ $globalData->facebook }}" target="_blank" class="fa fa-facebook color-bg-icon rounded" title="facebook"></a>                    
                    @endif
                    @if ($globalData->instagram_active == 1)
                        <a href="{{ $globalData->intagram }}" target="_blank" class="fa fa-instagram-square color-bg-icon rounded" title="instagram"></a>                    
                    @endif 
                    <a href="https://api.whatsapp.com/send/?phone={{ $globalData->whatsApp_no }}&text=hi&type=phone_number&app_absent=0" target="_blank" class="fa fa-whatsapp color-bg-icon rounded" title="whatsapp"></a>                    
                </div> -->

                <div class="top-socials">
                        @if ($globalData->telegram_active == 1)
                            <a href="{{ $globalData->telegram }}" target="_blank" rel="nofollow noopener" class="" title="telegram">
                                <i class="fa-brands fa-telegram"></i>
                            </a>                    
                        @endif
                        @if ($globalData->facebook_active == 1)
                            <a href="{{ $globalData->facebook }}" target="_blank" rel="nofollow noopener" class="" title="facebook">
                                <i class="fa-brands fa-facebook"></i>
                            </a>                    
                        @endif
                        @if ($globalData->instagram_active == 1)
                            <a href="{{ $globalData->intagram }}" target="_blank" rel="nofollow noopener" class="" title="instagram">
                                <i class="fa-brands fa-instagram"></i>
                            </a>                    
                        @endif 
                        <a href="https://api.whatsapp.com/send/?phone={{ $globalData->whatsApp_no }}&text=hi&type=phone_number&app_absent=0" target="_blank" rel="nofollow noopener" class="" title="whatsapp"><i class="fa-brands fa-whatsapp"></i></a>                    
                    </div>

                <div class="widget logo">
                    <img src="{{ asset('images/escort_logo1.png') }}" alt="img">
                </div>

                <div class="widget copyright">
                    <p>&copy; Copyright <span class="copyright_year">{{ date('Y') }}</span> All Rights Reserved</p>
                </div>
            </div>

        </div>
    </div>
</footer>


</div>
</div>

<!-- Modal -->
<div class="modal fade" id="filterModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content p-4">
            <div class="d-flex justify-content-between">
                <h5 class="modal-title">Find Escorts</h5>
                <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
            </div>
            <div class="filter-section ">
                <div class="row align-items-end filter-box">


                    <div class="row w-100 mb-3">
                        <div class="col-md-12">
                            <label class="filter-label">Escort type</label>
                            <input type="text" name="" class="form-control " id="" placeholder="Search by city or Province">
                        </div>
                        <div class="col-md-6 mt-2">
                            <label class="filter-label">Gender</label>
                            <select class="custom-select">
                                <option>All</option>
                                <option>Independent</option>
                                <option>Agency</option>
                            </select>
                        </div>

                        <div class="col-md-6 mt-2">
                            <label class="filter-label">Data type</label>
                            <select class="custom-select">
                                <option>All</option>
                                <option>Independent</option>
                                <option>Agency</option>
                            </select>
                        </div>
                    </div>

                    <div class="row w-100">
                        <div class="col-md-6 mt-2">
                            <label class="filter-label">Sex options</label>
                            <select class="custom-select">
                                <option>All</option>
                                <option>Independent</option>
                                <option>Agency</option>
                            </select>
                        </div>

                        <div class="col-md-6 mt-2">
                            <label class="filter-label">Ethnicites</label>
                            <select class="custom-select">
                                <option>All</option>
                                <option>Independent</option>
                                <option>Agency</option>
                            </select>
                        </div>
                        <div class="col-md-6 mt-2">
                            <label class="filter-label">Body Types</label>
                            <select class="custom-select">
                                <option>All</option>
                                <option>Independent</option>
                                <option>Agency</option>
                            </select>
                        </div>

                        <div class="col-md-6 mt-2">
                            <label class="filter-label">Prices</label>
                            <select class="custom-select">
                                <option>All</option>
                                <option>Independent</option>
                                <option>Agency</option>
                            </select>
                        </div>
                    </div>

                    <div class="row"></div>





                </div>
            </div>
            <div class="toggleButton mx-auto  btn btn-maincolor" data-toggle="modal" data-target="#filterModal">
                Apply filter
            </div>
        </div>
    </div>
</div>
@if(!request()->route() || request()->route()->getName() !== "terms")
<div class="popup-inter-wrapper">
    <div class="popup-verification-modal">
    <div class="popup-modal-header">
        <a href="" class="popup-logo"><img src="{{ asset('images/escort_logo1.png') }}" alt="img"></a>
        <div class="popup-age-warning">ENTER ONLY IF YOU ARE OVER 18</div>
    </div>
    
    <div class="popup-modal-content">
        <div class="popup-adult-notice">
            <h3>Adults Only!</h3>
            <p>Please read carefully before continuing.</p>
            <p>This website contains adult-oriented advertising content intended exclusively for individuals who are 18 years of age or older.</p>
            
            <div class="popup-confirm-list">
                <div class="popup-confirm-item">You are at least 18 years old (or the legal age of majority in your jurisdiction).</div>
                <div class="popup-confirm-item">You understand that this platform operates as an online advertising directory only.</div>
                <div class="popup-confirm-item">You agree to the Terms and Conditions and Privacy Policy.</div>
            </div>
        </div>
        
        <div class="popup-disclaimer">
            <strong>Sexy Devil</strong> does not provide, arrange, or facilitate services or meetings of any kind. All content displayed is submitted by third parties and is intended for advertising purposes only.
        </div>
        
        <div class="popup-cookie-notice">
            This website uses cookies for functional and compliance purposes. By continuing, you consent to the use of cookies.
        </div>
        
        <div class="popup-button-group">
            <button class="popup-btn popup-btn-accept" onclick="setConsent('yes')">Accept & Continue</button>
            <button class="popup-btn popup-btn-decline" onclick="denyConsent()">Decline</button>
        </div>
        
        <div class="popup-terms-link">
            You can learn more by checking our <a href="{{ route('terms') }}">terms of usage</a>.
        </div>
    </div>
    </div>
</div>
@endif
<script src="{{ asset('js/jquery.min.js')}}"></script>

<script src="{{ asset('js/compressed.js')}}"></script>
<script src="{{ asset('js/main.js')}}"></script>
<script src="{{ asset('js/switcher.js')}}"></script>


<script src="{{ asset('js/select2.min.js')}}"></script>




<!-- Add this JavaScript -->
<script>
    function sanitizeNumber(input) {
        return parseInt(String(input).replace(/[.,]/g, ''), 10);
    }

    function initSlider() {
        $(".slider-wrapper").each(function() {
            const $wrapper = $(this);
            const $min = $wrapper.find(".range-min");

            console.log($min);
            const $max = $wrapper.find(".range-max");
            const $minOutput = $wrapper.find(".min-output"); // raw value for backend
            console.log($minOutput);
            const $maxOutput = $wrapper.find(".max-output"); // raw value for backend
            const $minDisplay = $wrapper.find(".min-display"); // formatted shown value
            const $maxDisplay = $wrapper.find(".max-display"); // formatted shown value
            const $rangeHighlight = $wrapper.find("#range-highlight");

            if (!$min.length || !$max.length || !$minOutput.length || !$maxOutput.length || !$rangeHighlight.length) {
                console.warn("Slider elements not found");
                return;
            }

            function formatNumber(number) {
                return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            }

            function updateSlider() {
                let minVal = parseInt($min.val());
                console.log(minVal);
                let maxVal = parseInt($max.val());

                $('.min-output-val').val(minVal);
                $('.max-output-val').val(maxVal);
                // Fallbacks
                if (isNaN(minVal)) minVal = parseInt($min.attr("min"));
                if (isNaN(maxVal)) maxVal = parseInt($max.attr("max"));

                // Save raw values (for sending to backend)
                $minOutput.val(minVal);
                $maxOutput.val(maxVal);

                // Show formatted numbers
                $minOutput.val(formatNumber(minVal)).attr("data-raw", minVal);
                $maxOutput.val(formatNumber(maxVal)).attr("data-raw", maxVal);

                // Adjust visual range highlight
                const rangeMin = parseInt($min.attr("min"));
                const rangeMax = parseInt($max.attr("max"));
                const rangeWidth = rangeMax - rangeMin;

                const left = ((Math.min(minVal, maxVal) - rangeMin) / rangeWidth) * 100;
                const right = ((Math.max(minVal, maxVal) - rangeMin) / rangeWidth) * 100;

                $rangeHighlight.css({
                    left: `${left}%`,
                    width: `${right - left}%`
                });
            }

            $min.on("input", updateSlider);
            $max.on("input", updateSlider);
            updateSlider();
        });
    }


    //         const mediaSection = document.querySelector('.media-upload-section');
    //         const mediaInput = document.getElementById('mediaInput');
    //         const mediaGrid = document.getElementById('mediaGrid');

    //         // Handle click on upload section
    //         mediaSection.addEventListener('click', () => mediaInput.click());

    //         // Handle drag and drop
    //         mediaSection.addEventListener('dragover', (e) => {
    //             e.preventDefault();
    //             mediaSection.style.borderColor = '#ff4444';
    //         });

    //         mediaSection.addEventListener('dragleave', () => {
    //             mediaSection.style.borderColor = '#ff4444';
    //         });

    //         mediaSection.addEventListener('drop', (e) => {
    //             e.preventDefault();
    //             mediaSection.style.borderColor = '#ff4444';
    //             handleFiles(e.dataTransfer.files);
    //         });

    //         // Handle file input
    //         mediaInput.addEventListener('change', (e) => handleFiles(e.target.files));

    //         function handleFiles(files) {
    //             for (const file of files) {
    //                 const reader = new FileReader();

    //                 reader.onload = (e) => {
    //                     createMediaCard(file, e.target.result);
    //                 };

    //                 if (file.type.startsWith('image/')) {
    //                     reader.readAsDataURL(file);
    //                 } else {
    //                     createMediaCard(file);
    //                 }
    //             }
    //         }

    //         function createMediaCard(file, previewUrl) {
    //             const mediaItem = document.createElement('div');
    //             mediaItem.className = 'media-item';

    //             const fileType = file.type.split('/')[0];
    //             const fileSize = (file.size / 1024 / 1024).toFixed(2) + ' MB';

    //             mediaItem.innerHTML = `
    //     ${previewUrl ? 
    //         `<img src="${previewUrl}" class="media-preview" alt="${file.name}">` : 
    //         `<div class="d-flex flex-column align-items-center p-3">
    //             <i class="${getFileIcon(fileType)} file-icon"></i>
    //             <span class="text-white">${fileType.toUpperCase()}</span>
    //         </div>`
    //     }
    //     <div class="media-info">
    //         <h6 class="text-truncate">${file.name}</h6>
    //         <small>${fileSize}</small>
    //     </div>
    //     <button class="delete-btn" onclick="this.parentElement.remove()">
    //         <i class="fas fa-times"></i>
    //     </button>
    // `;

    //             mediaGrid.appendChild(mediaItem);
    //         }

    //         function getFileIcon(type) {
    //             const icons = {
    //                 image: 'fas fa-file-image',
    //                 video: 'fas fa-file-video',
    //                 audio: 'fas fa-file-audio',
    //                 application: 'fas fa-file-pdf',
    //                 text: 'fas fa-file-alt'
    //             };
    //             return icons[type] || 'fas fa-file';
    //         }


    //         document.getElementById('mediaUpload').addEventListener('change', function(event) {
    //             const files = event.target.files;
    //             const previewContainer = document.getElementById('mediaPreview');
    //             const saveButtonContainer = document.getElementById('saveMediaContainer');

    //             previewContainer.innerHTML = ''; // Clear previous previews

    //             if (files.length > 0) {
    //                 saveButtonContainer.style.display = 'block';
    //             } else {
    //                 saveButtonContainer.style.display = 'none';
    //             }

    //             Array.from(files).forEach(file => {
    //                 if (file.type.startsWith('image/')) {
    //                     const reader = new FileReader();
    //                     reader.onload = function(e) {
    //                         const col = document.createElement('div');
    //                         col.className = 'col-md-3 col-sm-4 col-6 preview-tile';
    //                         col.innerHTML = `<img src="${e.target.result}" alt="Preview" class="img-fluid">`;
    //                         previewContainer.appendChild(col);
    //                     };
    //                     reader.readAsDataURL(file);
    //                 }
    //             });
    //         });
const overlay = document.querySelector('.popup-inter-wrapper');
function setConsent(value) {
    let days = 30; // cookie valid for 30 days
    let date = new Date();
    date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));

    document.cookie = "user_consent=" + value +
        "; expires=" + date.toUTCString() +
        "; path=/; SameSite=Lax";

    // Hide confirmation box after click
    overlay.style.display = 'none';

    console.log("Consent saved:", value);
}

function getCookie(name) {
    let value = "; " + document.cookie;
    let parts = value.split("; " + name + "=");
    if (parts.length === 2) return parts.pop().split(";").shift();
}

window.onload = function () {
    if (getCookie('user_consent')) {
        overlay.style.display = 'none';
    } else {
        overlay.style.display = 'flex';
    }
};
function denyConsent() {
    // Redirect to an external site or show a message
    window.location.href = "https://www.google.com";
}
</script>

</script>



<script>
    function toggleMenu() {
        const nav = document.getElementById("mainNav");
        nav.classList.toggle("active");
    }
</script>

<script>
    $('.profile_img').on('click', function() {
        $('.profileSub').toggleClass('active');
    });
</script>


<script src="{{ asset('js/popper.min.js')}}"></script>
<!-- FontAwesome for Stars -->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script> -->
<script src="{{ asset('js/swiper-bundle.min.js')}}"></script>
<script src="{{ asset('js/gsap.min.js')}}"></script>
<script src="{{ asset('js/sweetalert2@11.js')}}"></script>
<script src="{{ asset('js/bootstrap.min.js')}}"></script>
<script src="{{ asset('js/flatpickr.js')}}"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<script src="{{ asset('js/toastr.min.js')}}"></script>
<!-- JS -->
<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui/dist/fancybox.umd.js"></script>
<!-- Owl Carousel JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
@if(Session::has('success'))
    <script>
        toastr.options = {
            "closeButton" : true,
            "progressBar" : true
        }
        toastr.success("{{ session('success') }}");
    </script>
@endif
@if(Session::has('error'))
    <script>
        Swal.fire({
            title: 'Error!',
            text: '{{ session("error") }}',
            icon: 'error',
            confirmButtonText: 'OK'
        })
    </script>
@endif
<script>
    $(document).ready(function() {
        initSlider();
        $('.select2-multiple').select2({
            placeholder: "Select options",
            allowClear: true,
            width: '100%'
        });
        $('.moreFilters').addClass('d-none');
        $(document).on('click', '#toggleFiltersBtn', function() {

            console.log('fshjfsdfvsdvf');
            $('.moreFilters').toggleClass('d-none');

            if ($('.moreFilters').hasClass('d-none')) {
                $(this).text('Show More Filters');
            } else {
                $(this).text('Hide Filters');
            }
        });

        $(document).on('change', '.range-slider', function() {
            initSlider();
        });
        $(document).on('click', '#clearBtn', function() {
            // Clear all inputs

            $('.filter-section').find('input[type="text"], input[type="number"], input[type="range"]').val('');
            $('.filter-section').find('select').prop('selectedIndex', 0);

            // If using custom selects (like Select2), trigger change
            $('.filter-section').find('select').trigger('change');

            // Optional: Reset range slider highlight
            $('#range-highlight').css({
                left: '0%',
                right: '0%'
            });

            // Optional: Clear range output
            $('.range-min').val(0);
            $('.range-max').val(0);
            $('.min-output').val('0').attr('data-raw', 0);
            $('.max-output').val('0').attr('data-raw', 0);
            $('.min-output-val').val(0);
            $('.max-output-val').val(0);
        });

        // Search Button
        $(document).on('click', '#searchBtn', function(e) {
            e.preventDefault();

            let filters = {};
            // Collect all inputs/selects
            $('.filter-box').find('input, select').each(function() {
                let name = $(this).attr('name') || $(this).attr('id');
                if (name) {
                    filters[name] = $(this).val();
                }
            });

            let min = $('.min-output-val').val();
            let max = $('.max-output-val').val();
            console.log(min, max);

            filters['price_min'] = min || 0;
            filters['price_max'] = max || 0;
            filters['is_filter_click'] = 1;
            filters._token = '{{ csrf_token() }}';
            const queryString = new URLSearchParams(filters).toString();
            const currentPath = window.location.pathname;
            const modelPageURL = "{{ route('model.search') }}";

            // If current page is NOT the model search page
            if (!currentPath.includes('/model')) {
                // Redirect to model page with query parameters
                //window.location.href = modelPageURL + '?' + queryString;
                $(this).closest('form').submit();
            } else {
                // Already on model page – make AJAX call
                $.ajax({
                    url: modelPageURL,
                    method: "post",
                    data: filters,
                    dataType : 'json',
                    beforeSend: function() {
                        $('#searchBtn').prop('disabled', true).text('Searching...');
                        $('.resultsContainer').html('<div class="text-center py-5">Loading...</div>');
                        $('.emptyCard').remove();
                    },
                    success: function(response) {
                        window.isLoading = false;
                        $('.resultsContainer').html(response.list);
                        // Update browser URL without reload
                        //history.pushState(null, '', modelPageURL + '?' + queryString);
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                        alert('Something went wrong. Please try again.');
                    },
                    complete: function() {
                        $('#searchBtn').prop('disabled', false).text('Search');
                    }
                });
            }
        });
        $(document).on('change', '#categorySelect', function() {
            var categoryId = $(this).val();



            if (categoryId) {
                $('.subCategorySelect').empty();
                var url = "{{ route('getsubcategory', ':id') }}".replace(':id', categoryId);

                $.get(url, function(data) {
                    let options = '<option value="">Select Sub Category</option>';
                    data.forEach(subcategory => {
                        console.log(subcategory);
                        options += `<option value="${subcategory.id}">${subcategory.name}</option>`;
                    });
                    $('.subCategorySelect').append(options);
                    $('.subCategorySelect').trigger('change');
                });
            }
        });

        console.log('jQuery version:', $.fn.jquery);

        // Country change
        $(document).on('change', '#filter_country', function() {
            var countryId = $(this).val();

            if (countryId) {
                var url = "{{ route('getstates', ':id') }}".replace(':id', countryId)+ '?with_users=1';
                $('.filter_state').empty();
                $.get(url, function(data) {
                    let options = '<option value="">Select State</option>';
                    data.forEach(state => {
                        console.log(state);
                        options += `<option value="${state.id}">${state.name} (${state.users_count})</option>`;
                    });
                    $('.filter_state').append(options);
                    $('.filter_state').trigger('change');
                });
                // Load currency on change
                const currencyUrl = "{{ route('getcurrency', ':id') }}".replace(':id', countryId);

                $.get(currencyUrl, function(currency) {
                    console.log(currency.currency.currency);
                    const symbol = currency.currency.currency || '';

                    $('.min-output').val($('.range-min').val());
                    $('.max-output').val($('.range-max').val());
                    $('.min-output-val').val($('.range-min').val());
                    $('.max-output-val').val($('.range-max').val());

                    // Update currency next to "Min" and "Max" labels
                    $('.currency-symbol').text('(' + symbol + ')');
                });
            }

        });



        // State change
        $(document).on('change', '.filter_state', function() {
            var stateId = $(this).val();

            if (stateId) {
                $('.filter_city').empty();
                var url = "{{ route('getcities', ':id') }}".replace(':id', stateId)+ '?with_users=1';

                $.get(url, function(data) {
                    let options = '<option value="">Select City</option>';
                    data.forEach(city => {
                        options += `<option value="${city.id}">${city.name}</option>`;
                    });
                    $('.filter_city').html(options);
                });
            }
        });

        // Preload states and cities (for edit form)
        const countryId = $('#filter_country').val();
        const selectedStateId = $('.filter_state').data('selected');
        const selectedCityId = $('.filter_city').data('selected');

        if (countryId) {
            var url = "{{ route('getstates', ':id') }}".replace(':id', countryId);
            $.get(url, function(data) {
                $('.filter_state').empty();
                let options = '<option value="">Select State</option>';
                data.forEach(state => {
                    options += `<option value="${state.id}" ${state.id == selectedStateId ? 'selected' : ''}>${state.name}</option>`;
                });
                $('.filter_state').html(options);
                $('.filter_state').trigger('change'); // this triggers loading cities below
                $('.filter_state').trigger('loaded'); // ✅ Add this trigger
            });


            const currencyUrl = "{{ route('getcurrency', ':id') }}".replace(':id', countryId);

            $.get(currencyUrl, function(currency) {
                console.log(currency.currency.currency);
                const symbol = currency.currency.currency || '';

                $('.min-output').val($('.range-min').val());
                $('.max-output').val($('.range-max').val());

                // Update currency next to "Min" and "Max" labels
                $('.currency-symbol').text('(' + symbol + ')');
            });
        }

        // Handle city preload after state loads
        $('.filter_state').on('loaded', function() {
            var stateId = $(this).val();
            const selectedCityId = $('#filter_city').data('selected');
            if (stateId) {
                var url = "{{ route('getcities', ':id') }}".replace(':id', stateId);
                $.get(url, function(data) {
                    $('.filter_city').empty();
                    let options = '<option value="">Select City</option>';
                    data.forEach(city => {
                        options += `<option value="${city.id}" ${city.id == selectedCityId ? 'selected' : ''}>${city.name}</option>`;
                    });
                    $('.filter_city').html(options);
                });
            }
        });
    });
    $(document).ready(function() {
        $("#countryDropdown").on("click", ".filter-option", function() {
            var countryId = $(this).data("value");
            var $cityDropdown = $("#cityDropdown");

            // Show loading state
            $cityDropdown.html('<div class="filter-option">Loading...</div>');

            // AJAX request to get cities for selected country
            $.ajax({
                url: "{{ route('getcitiesCountry', ':id') }}".replace(':id', countryId),
                method: "GET",
                dataType: "json",
                success: function(cities) {
                    $cityDropdown.empty(); // Clear old options

                    if (cities.length === 0) {
                        $cityDropdown.append('<div class="filter-option">No cities found</div>');
                        return;
                    }

                    $.each(cities, function(index, city) {
                        $cityDropdown.append(
                            '<div class="filter-option" data-value="' + city.id + '">' + city.name + '</div>'
                        );
                    });
                },
                error: function() {
                    $cityDropdown.html('<div class="filter-option">Error loading cities</div>');
                }
            });
        });
    });
</script>
<script>
    // $(function() {
    //     $('#openOffcanvas').on('click', function() {
    //         $('#myOffcanvas').addClass('show');
    //         $('#offcanvasBackdrop').fadeIn();
    //     });

    //     $('#closeOffcanvas, #offcanvasBackdrop').on('click', function() {
    //         $('#myOffcanvas').removeClass('show');
    //         $('#offcanvasBackdrop').fadeOut();
    //     });
    // });

    $(function() {
        var currentCanvas = null;

        $('.open-offcanvas').on('click', function() {
            var target = $(this).data('target');
            currentCanvas = $(target);
            currentCanvas.addClass('show');
            $('#offcanvasBackdrop').fadeIn();
        });

        $('.close-offcanvas, #offcanvasBackdrop').on('click', function() {
            if (currentCanvas) {
                currentCanvas.removeClass('show');
                $('#offcanvasBackdrop').fadeOut();
                currentCanvas = null;
            }
        });
    });
</script>





<script>
    //set video duration
    const videos = document.querySelectorAll(".story__slide video");
    videos.forEach((video) => {
        $(video)
            .parent(".story__slide")
            .attr("data-swiper-autoplay", video.duration * 1000);
    });

    const slider = new Swiper(".story__slider", {
        speed: 1,
        watchSlidesProgress: true,
        loop: true,
        autoplay: {
            delay: 15000,
            disableOnInteraction: false
        },
        slidesPerView: 1,
        navigation: {
            nextEl: ".story__next",
            prevEl: ".story__prev"
        },
        pagination: {
            el: ".story__pagination",
            renderBullet: function(index, className) {
                return (
                    '<div class="' +
                    className +
                    '"> <div class="swiper-pagination-progress"></div> </div>'
                );
            }
        },
        on: {
            autoplayTimeLeft(swiper, time, progress) {
                let currentSlide = document.querySelectorAll(".story__slider .swiper-slide")[
                    swiper.activeIndex
                ];
                let currentBullet = document.querySelectorAll(
                    ".story__slider .swiper-pagination-progress"
                )[swiper.realIndex];
                let fullTime = currentSlide.dataset.swiperAutoplay ?
                    parseInt(currentSlide.dataset.swiperAutoplay) :
                    swiper.params.autoplay.delay;

                let percentage =
                    Math.min(
                        Math.max(parseFloat((((fullTime - time) * 100) / fullTime).toFixed(1)), 0),
                        100
                    ) + "%";

                gsap.set(currentBullet, {
                    width: percentage
                });
            },
            transitionEnd(swiper) {
                let allBullets = $(".story__slider .swiper-pagination-progress");
                let bulletsBefore = allBullets.slice(0, swiper.realIndex);
                let bulletsAfter = allBullets.slice(swiper.realIndex, allBullets.length);
                if (bulletsBefore.length) {
                    gsap.set(bulletsBefore, {
                        width: "100%"
                    });
                }
                if (bulletsAfter.length) {
                    gsap.set(bulletsAfter, {
                        width: "0%"
                    });
                }

                let activeSlide = document.querySelectorAll(".story__slider .swiper-slide")[
                    swiper.realIndex
                ];
                if (activeSlide.querySelector("video")) {
                    activeSlide.querySelector("video").currentTime = 0;
                }
            }
        }
    });
</script>

<script>
    document.querySelector('.toggle_menu').addEventListener('click', function() {
        document.querySelector('.main-nav').classList.toggle('active');
    });
</script>



<script>
    // Radio-style Button logic
    $('.option-btn').click(function() {
        const group = $(this).data('group');

        // Ensure the correct button gets the 'active' class and others are cleared
        $(`.option-btn[data-group="${group}"]`).removeClass('active');
        $(this).addClass('active');

        calculateScore();
    });

    // Character Count
    $('#experienceText').on('input', function() {
        $('#charCount').text($(this).val().length);
    });

    // Rating Stars manual click
    $('#ratingStars i').click(function() {
        const rating = $(this).data('value');

        // Remove 'selected' class from all stars before adding to the selected ones
        $('#ratingStars i').removeClass('selected');

        $('#ratingStars i').each(function() {
            if ($(this).data('value') <= rating) {
                $(this).addClass('selected');
            }
        });

        calculateScore(); // Optional: Call calculateScore if rating impacts the score calculation
    });

    // Auto Calculate Score
    function calculateScore() {
        let score = 0;

        // Check if 'Yes' is selected in the agreements group
        if ($('.option-btn[data-group="agreements"].active').text() === 'Yes') score += 1;

        // Check if 'Yes' is selected in the photos group
        if ($('.option-btn[data-group="photos"].active').text() === 'Yes') score += 1;

        // Check for ambience and hygiene selections and adjust score
        const ambience = $('.option-btn[data-group="ambience"].active').text();
        const hygiene = $('.option-btn[data-group="hygiene"].active').text();

        if (ambience === "Excellent") score += 2;
        else if (ambience === "Very satisfied") score += 1;

        if (hygiene === "Excellent") score += 2;
        else if (hygiene === "Very satisfied") score += 1;

        // Calculate final score as a rating
        const finalScore = Math.min(Math.round((score / 6) * 5), 5);

        // Update the rating stars based on the final score
        $('#ratingStars i').removeClass('selected');
        $('#ratingStars i').each(function() {
            if ($(this).data('value') <= finalScore) {
                $(this).addClass('selected');
            }
        });
    }

    $(document).on('click', '.wishlistBtn', function(e) { // Use event delegation
        e.preventDefault();
        var favourite_user_id = $(this).data('id');

        var authId = $(this).data('auth');

        var btn = $(this);

        var icon = btn.find("i");



        var csrfToken = $('meta[name="csrf-token"]').attr('content'); // CSRF token



        $.ajax({

            url: "{{ route('user.wishlistSubmit') }}",

            type: 'POST',

            data: {

                favourite_user_id: favourite_user_id,

                user_id: authId,

                _token: csrfToken

            },

            success: function(response) {
                console.log(response);
                if (response.status === 1) {
                    toastr.success(response.message);

                    if (icon.hasClass("fa-regular")) {
                        icon.removeClass("fa-regular").addClass("fa-solid text-danger");
                    } else {
                        icon.removeClass("fa-solid text-danger").addClass("fa-regular");
                    }

                } else {
                    toastr.error(response.message);

                    // 🚨 Redirect if login is required
                    if (response.redirect) {
                        window.location.href = response.redirect;
                        return;
                    }
                }
            },

            error: function(xhr) {

                let response = xhr.responseJSON;

                if (response && response.errors) {

                    toastr.error(response.errors.join("\n"));

                } else {

                    toastr.error("An unexpected error occurred.");

                }

            }

        });

        return false;
    });
    document.querySelectorAll('.slider').forEach(slider => {
        const slidesContainer = slider.querySelector('.slides');
        const slides = slider.querySelectorAll('.slide');
        const prevBtn = slider.querySelector('.prev');
        const nextBtn = slider.querySelector('.next');

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
        if (nextBtn) {
            nextBtn.addEventListener('click', e => {
                e.preventDefault();
                e.stopPropagation();
                nextSlide();
                resetAutoplay();
            });
        }

        if (prevBtn) {
            prevBtn.addEventListener('click', e => {
                e.preventDefault();
                e.stopPropagation();
                prevSlideFunc();
                resetAutoplay();
            });
        }

        // Touch swipe
        slidesContainer.addEventListener('touchstart', e => {
            startX = e.touches[0].clientX;
            isDragging = true;
        });

        slidesContainer.addEventListener('touchend', e => {
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
    });
</script>

<script src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
<script type="text/javascript">
  function googleTranslateElementInit() {
    new google.translate.TranslateElement(
      {
        pageLanguage: 'en',
        includedLanguages: 'en,es,de', // English, Spanish, German
      },
      'google_translate_element'
    );
  }
    function translateFlag(lang) {
        var select = document.querySelector("select.goog-te-combo");
        console.log("Translating to:", select);
        if (select) {
            select.value = lang;
            select.dispatchEvent(new Event("change"));
        }
    }
    // when flag clicked
    function selectLanguage(code, name, icon) {
        translateFlag(code);

        document.getElementById("selected-language").innerHTML =
            `<img src="${icon}" width="20" style="vertical-align:middle"> ${name}`;

        // Save language
        localStorage.setItem("site_language", JSON.stringify({ code, name, icon }));
    }

    // load saved language
    document.addEventListener("DOMContentLoaded", function () {
        let saved = localStorage.getItem("site_language");
        if (saved) {
            saved = JSON.parse(saved);

            // replace selected language button
            document.getElementById("selected-language").innerHTML =
                `<img src="${saved.icon}" width="20" style="vertical-align:middle"> ${saved.name}`;

            // apply translation automatically
            setTimeout(() => {
                translateFlag(saved.code);
            }, 800);
        } else {
            selectLanguage('en','EN','https://flagcdn.com/gb.svg');
        }
    });
  setInterval(() => {
    $('.skiptranslate').each(function (index) {
        let saved = localStorage.getItem("site_language");
        var lang = 'en';
        if (saved) {
            saved = JSON.parse(saved);
            lang = saved.code;
        }
        if(index == 0) { $(this).hide() }
    })
  }, 200);
  setInterval(() => {
        let saved = localStorage.getItem("site_language");
        var lang = 'en';
        if (saved) {
            saved = JSON.parse(saved);
            lang = saved.code;
        }
          //href="https://wa.me/573228655190?text=Hi%20I%20found%20your%20profile%20on%20the%20site"
        let myMsg = lang === 'es' ? 'Hola, he visto tu perfil en Sexy Devil Escorts.' : lang === 'de' ? 'Hallo, ich habe dein Profil auf Sexy Devil Escorts gesehen.' : 'Hi, I’ve seen your profile on Sexy Devil Escorts.';
        // Encode message for URL
        let encodedMsg = encodeURIComponent(myMsg);

        // Get current WhatsApp number from href
        let $waBtn = $('.profileWhatsApp');
        console.log("ffff to:", $waBtn.length);
        if($waBtn.length == 0) {
            return;
        }
        $waBtn.each(function() {
            let baseUrl = $(this).attr('href').split('?')[0];
            // Update href
            $(this).attr('href', baseUrl + '?text=' + encodedMsg);
        });
    }, 3000);
// Handle Play Button Click
document.addEventListener('click', function (e) {

    // Play button clicked
    if(e.target.hasAttribute('preload')){
        e.preventDefault();   // prevent inline play
        e.stopPropagation();
        return;
    }
    if (e.target.closest('.play-btn')) {

        const wrapper = e.target.closest('.video-wrapper');
        const video = wrapper.querySelector('video');
        const playBtn = wrapper.querySelector('.play-btn');

        // Pause all other videos
        document.querySelectorAll('video').forEach(v => {
            if (v !== video) v.pause();
        });

        video.play();
    }

    // Click directly on video
    if (e.target.tagName === 'VIDEO') {

        const video = e.target;

        if (video.paused) {
            video.play();
        } else {
            video.pause();
        }
    }

});


// When video plays
document.addEventListener('play', function (e) {
    if(e.target.hasAttribute('preload')){
        e.preventDefault();   // prevent inline play
        e.stopPropagation();
        return;
    }
    if (e.target.tagName === 'VIDEO') {

        const wrapper = e.target.closest('.video-wrapper');
        const playBtn = wrapper.querySelector('.play-btn');

        playBtn.style.display = 'none';

        // Pause others
        document.querySelectorAll('video').forEach(v => {
            if (v !== e.target) v.pause();
        });
    }
}, true);


// When video pauses
document.addEventListener('pause', function (e) {
    if(e.target.hasAttribute('preload')){
        e.preventDefault();   // prevent inline play
        e.stopPropagation();
        return;
    }
    if (e.target.tagName === 'VIDEO') {

        const wrapper = e.target.closest('.video-wrapper');
        const playBtn = wrapper.querySelector('.play-btn');

        playBtn.style.display = 'flex';
    }
}, true);

   
</script>
</body>
</html>