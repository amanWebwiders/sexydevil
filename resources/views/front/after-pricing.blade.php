@extends('front.layout.layout')

@section('content')
    <style>
        @media (min-width: 768px) and (max-width: 1024px) {


            .nav-wrap {
                justify-content: center;
            }

        }

        .alert {
            font-size: 16px;
            padding: 15px;
            border-radius: 8px;
        }
    </style>
    <section class="ds s-pt-70 s-pt-lg-100 s-pt-xl-150 s-pb-10 s-pb-lg-40 s-pb-xl-90 c-mb-60">
        <div class="container-fluid">

            <div class="row model_detail">
                @include('front.component.quicklink')
                <div class="d-flex d-lg-none justify-content-between col-12 px-0 mt-2 mb-4">
                    <a class="open-offcanvas" data-target="#offcanvas1">Quick links <i class="fa fa-external-link"
                            aria-hidden="true" class="canvas-icon"></i>
                    </a>
                    <!-- <a class="open-offcanvas" data-target="#offcanvas2">Filters <i class="fa fa-filter" aria-hidden="true" class="canvas-icon"></i></a> -->
                </div>

                <div class="offcanvas offcanvas_left" id="offcanvas1">
                    <button type="button" class="close close-offcanvas" id="closeOffcanvas" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    @include('front.component.quicklink')
                </div>

                <div class="col-md-12 col-lg-10">
                    <section class="ds s-pt-70 s-pb-50 s-pb-sm-50 s-py-lg-100 s-py-xl-150 c-gutter-60 content-area">
                        <div class="p-5">
                            <div class="row">
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-12">
                                            <!-- tabs start -->
                                            <div class="container-fluid">
                                                <h2 class="mt-4">Membership Plan</h2>
                                                @php
                                                    $user = Auth::user();
                                                    $plan = $user->plan_id ? \App\Models\Plan::find($user->plan_id) : null;
                                                    $planEnd = $user->plan_end_date ? \Carbon\Carbon::parse($user->plan_end_date) : null;
                                                    $isExpired = $planEnd && now()->greaterThanOrEqualTo($planEnd);
                                                @endphp

                                                @if ($plan && $planEnd)
                                                    @if (!$isExpired)
                                                        <div class="alert alert-success">
                                                            <strong>Current Plan:</strong> {{ $plan->title }} <br>
                                                            <strong>Expires on:</strong> {{ $planEnd->format('d M Y') }}
                                                        </div>
                                                    @else
                                                        @include('front.component.plan_notification')
                                                    @endif
                                                @else
                                                    <div class="alert alert-warning">
                                                        @include('front.component.plan_notification')
                                                    </div>
                                                @endif

                                                <div class="row mx-0">
                                                    @foreach($data as $data)
                                                        @php
                                                            $isCurrent = Auth::user()->plan_id == $data->id && !$isExpired;
                                                        @endphp
                                                        <div class="col-xs-12 col-lg-4">


                                                            <div
                                                                class="pricing-plan box-shadow {{ $isCurrent ? 'current-plan' : '' }}">
                                                                <div class="pricing-box-detail">
                                                                    <div>
                                                                        @if($data->tag)
                                                                            <div class="exclusive-label">{{$data->tag}}</div>
                                                                        @endif
                                                                        <div class="plan-name">
                                                                            <h3>
                                                                                {{$data->title}}
                                                                            </h3>
                                                                            <p>{{$data->days}} Days plan</p>
                                                                        </div>
                                                                        @if($admindata->is_show_price == 1)
                                                                            <div class="price-wrap color-darkgrey">
                                                                                <span class="plan-sign">$</span>
                                                                                <span class="plan-price">{{$data->cost}}</span>
                                                                                <!-- <span class="plan-decimals">.95</span> -->
                                                                            </div>
                                                                        @endif
                                                                        <div class="plan-description small-text color-darkgrey">
                                                                            {{$data->heading}}
                                                                        </div>
                                                                        <div class="plan-features">
                                                                            <ul class="list-bordered">
                                                                                {{$data->description}}

                                                                            </ul>
                                                                        </div>
                                                                    </div>
                                                                    <div>
                                                                        Contact on
                                                                    </div>
                                                                    <div class="top-socials">
                                                                        @if ($globalData->telegram_active == 1)
                                                                            <a href="{{ $globalData->telegram }}" target="_blank"
                                                                                class="" title="telegram">
                                                                                <i class="fa-brands fa-telegram"></i>
                                                                            </a>
                                                                        @endif
                                                                        @if ($globalData->facebook_active == 1)
                                                                            <a href="{{ $globalData->facebook }}" target="_blank"
                                                                                title="facebook">
                                                                                <i class="fa-brands fa-facebook"></i>
                                                                            </a>
                                                                        @endif
                                                                        @if ($globalData->instagram_active == 1)
                                                                            <a href="{{ $globalData->intagram }}" target="_blank"
                                                                                title="instagram">
                                                                                <i class="fa-brands fa-instagram"></i>
                                                                            </a>
                                                                        @endif
                                                                        <a href="https://api.whatsapp.com/send/?phone={{ $globalData->whatsApp_no }}&text=hi&type=phone_number&app_absent=0"
                                                                            target="_blank" title="whatsapp">
                                                                            <i class="fa-brands fa-whatsapp"></i>
                                                                        </a>
                                                                        <a href="mailto:{{ $globalData->email }}" title="Email">
                                                                            <i class="fa-solid fa-envelope"></i>
                                                                        </a>
                                                                    </div>

                                                                </div>




                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>

                                                <div class="row mt-5 justify-content-center">
                                                    <div class="col-xs-12 col-lg-4">
                                                        <h4 class="fw-bold border-bottom pb-2 mb-4 text-center">🔥 Profile
                                                            Boost</h4>

                                                        <div class="pricing-plan box-shadow">
                                                            <div class="pricing-box-detail">
                                                                <div>
                                                                    <div class="plan-name">
                                                                        <h3>Boost Your Profile</h3>
                                                                        <p>Highlight your profile for maximum visibility</p>
                                                                    </div>
                                                                    @if($admindata->is_show_price == 1)
                                                                        <div class="price-wrap color-darkgrey">
                                                                            <span class="plan-sign">$</span>
                                                                            <span
                                                                                class="plan-price">{{ $admindata->boost_cost ?? 0 }}</span>
                                                                        </div>
                                                                    @endif

                                                                    <div class="plan-description small-text color-darkgrey">
                                                                        Boost your profile and appear on top of listings.
                                                                    </div>

                                                                    <div class="plan-features mt-3">
                                                                        <ul class="list-bordered">
                                                                            <li>Priority visibility in search</li>
                                                                            <li>Top placement on homepage</li>
                                                                            <li>Increased reach and views</li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                                @php
                                                                    $now = \Carbon\Carbon::now();
                                                                    $isBoosted = $user->is_boosted && $user->boost_end_date && $now->lt($user->boost_end_date);
                                                                @endphp
                                                                <div class="plan-button mt-4" id="boost-action">
                                                                    @if($isBoosted)
                                                                        <div class="alert alert-success">
                                                                            Your profile is boosted until
                                                                            {{ \Carbon\Carbon::parse($user->boost_end_date)->format('d M Y') }}
                                                                        </div>
                                                                    @else
                                                                        <div class="plan-button">
                                                                            <div><i>"Pay and activate your plan, contact
                                                                                    us."</i></div>
                                                                            <div class="top-socials">
                                                                                @if ($globalData->telegram_active == 1)
                                                                                    <a href="{{ $globalData->telegram }}"
                                                                                        target="_blank" class="" title="telegram">
                                                                                        <i class="fa-brands fa-telegram"></i>
                                                                                    </a>
                                                                                @endif
                                                                                @if ($globalData->facebook_active == 1)
                                                                                    <a href="{{ $globalData->facebook }}"
                                                                                        target="_blank" title="facebook">
                                                                                        <i class="fa-brands fa-facebook"></i>
                                                                                    </a>
                                                                                @endif
                                                                                @if ($globalData->instagram_active == 1)
                                                                                    <a href="{{ $globalData->intagram }}"
                                                                                        target="_blank" title="instagram">
                                                                                        <i class="fa-brands fa-instagram"></i>
                                                                                    </a>
                                                                                @endif
                                                                                <a href="https://api.whatsapp.com/send/?phone={{ $globalData->whatsApp_no }}&text=hi&type=phone_number&app_absent=0"
                                                                                    target="_blank" title="whatsapp">
                                                                                    <i class="fa-brands fa-whatsapp"></i>
                                                                                </a>
                                                                                <a href="mailto:{{ $globalData->email }}"
                                                                                    title="Email">
                                                                                    <i class="fa-solid fa-envelope"></i>
                                                                                </a>
                                                                            </div>
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>


    </section>
    <style>
        .welcome-msg {
            display: block !important;
        }

        .main-nav {
            display: none !important;
        }

        nav.top-nav.profile-nav.sf-menu {
            display: none;
        }

        .logoutbtn {
            display: block !important;
        }
    </style>
@endsection
@push('js')
    <script>
        $(document).on('click', '.buy-plan-btn', function (e) {
            e.preventDefault();

            const button = $(this);
            button.prop('disabled', true).text('Processing...'); // Disable and change text

            const planId = button.data('plan-id');
            const token = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                url: "{{ route('user.purchase.plan') }}",
                type: "POST",
                data: {
                    _token: token,
                    plan_id: planId
                },
                success: function (response) {
                    if (response.status === 1) {
                        alert(response.message);
                        if (response.redirect) {
                            window.location.href = response.redirect;
                        }
                    } else {
                        alert(response.message);
                        button.prop('disabled', false).text('Buy now'); // Re-enable on failure
                    }
                },
                error: function () {
                    alert("Something went wrong. Please try again.");
                    button.prop('disabled', false).text('Buy now'); // Re-enable on error
                }
            });
        });
        $(document).ready(function () {
            $('#boostNowBtn').click(function (e) {
                e.preventDefault();

                Swal.fire({
                    title: 'Boost Profile?',
                    text: "Do you want to boost your profile and appear on top listings?",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#28a745',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, Boost it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('user.boost.activate') }}",
                            method: "POST",
                            data: {
                                _token: "{{ csrf_token() }}"
                            },
                            success: function (response) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Boosted!',
                                    text: 'Your profile is boosted until ' + response.boost_end_date,
                                    confirmButtonColor: '#28a745'
                                });

                                $('#boost-action').html(`
                                <div class="alert alert-success mt-3">
                                    Your profile is boosted until ${response.boost_end_date}.
                                </div>
                            `);
                            },
                            error: function (xhr) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops!',
                                    text: 'Failed to boost. Please try again later.',
                                    confirmButtonColor: '#d33'
                                });
                            }
                        });
                    }
                });
            });
        });

    </script>
@endpush