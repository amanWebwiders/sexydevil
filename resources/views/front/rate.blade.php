@extends('front.layout.layout')

@section('content')


    <style>
        #dayslist input[type=checkbox],
        input[type=radio] {
            display: block !important;
            margin-top: 0px;
        }

        .sidebar {
            top: 0px;
        }

        .radioinputsbtn {
            gap: 15px;
        }

        input.form-control {
            height: 60px;
            letter-spacing: 2px;
        }

        .chkboxbtns {
            gap: 5px;
        }

        .select2-container {
            width: 100% !important;
        }

        .ds select {
            height: 45px;
            line-height: 45px;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
            left: auto !important;
            right: -3px;
        }

        span.select2-selection.select2-selection--multiple {
            min-height: 45px;
        }

        span.select2-selection.select2-selection--multiple.select2-selection--clearable {
            min-height: 45px;
            height: 100%;
            max-height: 100%;
            overflow: auto;
        }

        @media (max-width: 1024px) and (min-width: 767px) {
            .main-area {
                min-height: 70vh;
            }
        }


        @media only screen and (max-width:767px) {

            .col,
            .col-1,
            .col-10,
            .col-11,
            .col-12,
            .col-2,
            .col-3,
            .col-4,
            .col-5,
            .col-6,
            .col-7,
            .col-8,
            .col-9,
            .col-auto,
            .col-lg,
            .col-lg-1,
            .col-lg-10,
            .col-lg-11,
            .col-lg-12,
            .col-lg-2,
            .col-lg-3,
            .col-lg-4,
            .col-lg-5,
            .col-lg-6,
            .col-lg-7,
            .col-lg-8,
            .col-lg-9,
            .col-lg-auto,
            .col-md,
            .col-md-1,
            .col-md-10,
            .col-md-11,
            .col-md-12,
            .col-md-2,
            .col-md-3,
            .col-md-4,
            .col-md-5,
            .col-md-6,
            .col-md-7,
            .col-md-8,
            .col-md-9,
            .col-md-auto,
            .col-sm,
            .col-sm-1,
            .col-sm-10,
            .col-sm-11,
            .col-sm-12,
            .col-sm-2,
            .col-sm-3,
            .col-sm-4,
            .col-sm-5,
            .col-sm-6,
            .col-sm-7,
            .col-sm-8,
            .col-sm-9,
            .col-sm-auto,
            .col-xl,
            .col-xl-1,
            .col-xl-10,
            .col-xl-11,
            .col-xl-12,
            .col-xl-2,
            .col-xl-3,
            .col-xl-4,
            .col-xl-5,
            .col-xl-6,
            .col-xl-7,
            .col-xl-8,
            .col-xl-9,
            .col-xl-auto {
                padding-inline: 0px;
            }

            .days-list {
                display: flex;
                flex-direction: column;
            }

            .timeslotinput {
                gap: 8px;
            }

            .setavailabilty-main {
                padding-block: 20px !important;
            }


        }
    </style>

    <section class="main-area">
        <div class="container-fluid">
            <div class="row model_detail">
                @include('front.component.quicklink')
                <div class="col-lg-10">
                    <section class="ds s-pt-70 s-pb-50 s-pb-sm-50 s-py-lg-100 s-py-xl-150 c-gutter-60 content-area">
                        <div class="p-5 mx-lg-0 mx-md-0 mx-2 setavailabilty-main">
                            <h1 class="mb-4 text-left fs-28">Set Rates</h1>




                            <div class="row">
                                <div class="mb-4 col-12">
                                    <label><strong>Offer Quickie Service?</strong></label><br>
                                    @include('front.component.plan_notification')
                                    <div class="d-flex radioinputsbtn">
                                        <div class="d-flex chkboxbtns">
                                            <input type="radio" name="quickie_enabled" value="1"
                                                onclick="toggleQuickieSection(true)" {{ old('quickie_enabled', $user->quickie_enabled) == 1 ? 'checked' : '' }}> Yes
                                        </div>
                                        <div class="d-flex chkboxbtns">
                                            <input type="radio" name="quickie_enabled" value="0"
                                                onclick="toggleQuickieSection(false)" {{ old('quickie_enabled', $user->quickie_enabled) == 0 ? 'checked' : '' }}> No
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div id="quickieRatesSection">
                                <div class="row">
                                    <div class="mb-2 col-md-6" id="quickiePriceWrapper">
                                        <label for="price">Price:</label>
                                        <input type="number" min="0" class="form-control" id="quickie_price"
                                            name="quickie_price"
                                            value="{{ old('quickie_price', $user->quickie_price ?? '') }}">
                                    </div>
                                    <div class="mb-2 col-md-6">
                                        <label for="quickie_currency"><strong>Currency:</strong></label>
                                        <input name="quickie_currency" id="quickie_currency" value="{{ $user->countries?->currency_symbol ?? '$' }} " class="form-control" readonly >                                         
                                    </div>

                                    @php
                                        $durations = ['30_min' => '30 Minutes', '1_hr' => '1 Hour', '90_min' => '90 Minutes', '2_hr' => '2 Hours', '3_hr' => '3 Hours', '24h' => '24 Hours'];
                                    @endphp

                                    @foreach ($durations as $key => $label)
                                        <div class="mb-2 col-md-6">
                                            <label for="quickie_{{ $key }}">{{ $label }}:</label>
                                            <input type="number" step="0.01" min="0" class="form-control"
                                                name="quickie_rates[{{ $key }}]"
                                                value="{{ old('quickie_rates.' . $key, $user->quickie_rates[$key] ?? '') }}">
                                        </div>
                                    @endforeach

                                    <div class="mb-2 col-md-6">
                                        <label for="quickie_overnight_hours">Overnight Duration (in hours):</label>
                                        <select class="form-select" id="quickie_overnight_hours"
                                            name="quickie_overnight_hours">
                                            @for ($i = 1; $i <= 12; $i++)
                                                <option value="{{ $i }}" {{ old('quickie_overnight_hours', $user->quickie_overnight_hours ?? '') == $i ? 'selected' : '' }}>
                                                    {{ $i }} {{ Str::plural('hour', $i) }}
                                                </option>
                                            @endfor
                                        </select>
                                    </div>

                                    <div class="mb-2 col-md-6">
                                        <label for="quickie_overnight_price">Overnight Price:</label>
                                        <input type="number" step="0.01" min="0" class="form-control"
                                            name="quickie_rates[overnight]"
                                            value="{{ old('quickie_rates.overnight', $user->quickie_rates['overnight'] ?? '') }}">
                                    </div>


                                    <div class="mb-2 col-md-6">
                                        @php
                                            $selectedMethods = old('payment_method', json_decode($user->payment_method, true) ?? []);

                                        @endphp
                                        <label for="payment_method"><strong>Select Payment Method(s):</strong></label>
                                        <select name="payment_method[]" id="payment_method"
                                            class="form-select select2-multiple" multiple>


                                            <option value="cash" {{ in_array('cash', old('payment_method', $selectedMethods ?? [])) ? 'selected' : '' }}>Cash</option>
                                            <option value="transfer" {{ in_array('transfer', old('payment_method', $selectedMethods ?? [])) ? 'selected' : '' }}>Transfer</option>
                                            <option value="crypto" {{ in_array('crypto', old('payment_method', $selectedMethods ?? [])) ? 'selected' : '' }}>Crypto</option>
                                            <option value="card terminal" {{ in_array('card terminal', old('payment_method', $selectedMethods ?? [])) ? 'selected' : '' }}>Card Terminal</option>

                                        </select>
                                    </div>

                                </div>
                            </div>



                            <div class="row">
                                <div class="mt-4 col-12">

                                    <button type="button" class="btn btn-maincolor" id="saveQuickieSettings">Save</button>
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
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const input = document.getElementById('quickie_overnight_hours');

            input.addEventListener('input', function () {
                if (parseInt(this.value) > 12) {
                    this.value = 12;
                } else if (parseInt(this.value) < 1) {
                    this.value = 1;
                }
            });
        });
        $(document).ready(function () {

            $('.select2-multiple').select2({
                placeholder: "Select options",
                allowClear: true,
                width: '100%'
            });
        });

        function toggleQuickieSection(show) {
            const section = document.getElementById('quickiePriceWrapper');
            section.style.display = show ? 'block' : 'none';

        }

        // If page reloads with validation error and "yes" was selected, ensure it's visible
        document.addEventListener("DOMContentLoaded", function () {
            const isEnabled = document.querySelector('input[name="quickie_enabled"]:checked')?.value;
            toggleQuickieSection(isEnabled == 1);
        });
        document.addEventListener('DOMContentLoaded', function () {
            const saveButton = document.getElementById('saveQuickieSettings');
            if (saveButton) {
                saveButton.addEventListener('click', function () {
                    saveButton.disabled = true;
                    saveButton.textContent = 'Saving...';
                    // Get the value of "Offer Quickie Service?" radio button
                    const quickieEnabled = document.querySelector('input[name="quickie_enabled"]:checked').value;

                    let postData = {
                        quickie_enabled: quickieEnabled,
                        _token: '{{ csrf_token() }}' // Include CSRF token for Laravel
                    };

                    // If quickie service is enabled, collect the other data
                    if (quickieEnabled) {
                        const quickieCurrency = document.getElementById('quickie_currency').value;
                        const selectElement = document.getElementById('payment_method');
                        const paymentmethod = Array.from(selectElement.selectedOptions).map(option => option.value);

                        const quickieprice = document.getElementById('quickie_price').value;
                        const quickieOvernightHours = document.querySelector('select[name="quickie_overnight_hours"]').value;


                        let quickieRates = {};
                        const durationKeys = ['30_min', '1_hr', '90_min', '2_hr', '3_hr', 'overnight', '24h'];
                        durationKeys.forEach(key => {
                            const input = document.querySelector(`input[name="quickie_rates[${key}]"]`);
                            if (input) {
                                quickieRates[key] = input.value;
                            }
                        });

                        postData = {
                            ...postData, // Keep quickie_enabled and _token
                            quickie_currency: quickieCurrency,
                            payment_method: paymentmethod,
                            quickie_rates: quickieRates,
                            quickie_price: quickieprice,
                            quickie_overnight_hours: quickieOvernightHours
                        };
                    }

                    // AJAX call using jQuery
                    $.ajax({
                        url: "{{ route('user.rate.save') }}", // **IMPORTANT: Replace with your actual API endpoint**
                        type: 'POST',
                        data: postData,
                        success: function (response) {
                            // Handle success response
                            Swal.fire('Success', response.message, 'success');
                            window.location.reload();
                        },
                        error: function (xhr, status, error) {
                            // Handle error response
                            Swal.fire('Error', 'Something went wrong.', 'error');
                            saveButton.disabled = false;
                            saveButton.textContent = 'Save';
                            // If you added a spinner, remove it here
                            // You can parse xhr.responseText for more specific error messages
                        }
                    });
                });
            }


        });
    </script>
@endpush