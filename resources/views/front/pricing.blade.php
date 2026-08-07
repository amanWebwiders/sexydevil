@extends('front.layout.layout')

@section('content')
<style>
   

</style>
<section class="ds s-pt-70 s-pt-lg-100 s-pt-xl-150 s-pb-10 s-pb-lg-40 s-pb-xl-90 c-mb-60">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <!-- tabs start -->

                <h1>Choose Plan</h1>
                <div class="row">
                    @foreach($data as $data)
                    @php
                    $isCurrent = Auth::user()->plan_id == $data->id;
                    @endphp
                    <div class="col-xs-12 col-lg-4">


                        <div class="pricing-plan box-shadow {{ $isCurrent ? 'current-plan' : '' }}">
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
                                <div class="plan-button">
                                    <div><i>"Pay and activate your plan, contact us."</i></div>
                                    <div class="top-socials">
                                        @if ($globalData->telegram_active == 1)
                                            <a href="{{ $globalData->telegram }}" target="_blank" class="" title="telegram">
                                                <i class="fa-brands fa-telegram"></i>
                                            </a>                   
                                        @endif
                                        @if ($globalData->facebook_active == 1)
                                            <a href="{{ $globalData->facebook }}" target="_blank" title="facebook">
                                                <i class="fa-brands fa-facebook"></i>
                                            </a>                    
                                        @endif
                                        @if ($globalData->instagram_active == 1)
                                            <a href="{{ $globalData->intagram }}" target="_blank" title="instagram">
                                                <i class="fa-brands fa-instagram"></i>
                                            </a>                    
                                        @endif 
                                        <a href="https://api.whatsapp.com/send/?phone={{ $globalData->whatsApp_no }}&text=hi&type=phone_number&app_absent=0" target="_blank" title="whatsapp">
                                            <i class="fa-brands fa-whatsapp"></i>
                                        </a>      
                                        <a href="mailto:{{ $globalData->email }}" title="Email">
                                            <i class="fa-solid fa-envelope"></i>
                                        </a>  
                                    </div>
                                    <a href="{{ route('user.profile') }}" class="text-danger mt-3">Skip</a>
                                </div>

                            </div>




                        </div>
                    </div>
                    @endforeach
                </div>
                

            </div>
        </div>
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
    $(document).on('click', '.buy-plan-btn', function(e) {
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
            success: function(response) {
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
            error: function() {
                alert("Something went wrong. Please try again.");
                button.prop('disabled', false).text('Buy now'); // Re-enable on error
            }
        });
    });
</script>
@endpush