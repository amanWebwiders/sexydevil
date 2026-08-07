@extends('front.layout.layout')

@section('content')
<style>
    .sidebar {
        top: 0px;
    }
</style>
<section class="main-area">
    <div class="container-fluid">
        <div class="row model_detail">
           @include('front.component.quicklink')
             <div class="d-flex d-lg-none justify-content-between col-12 px-0 mt-2 mb-4">
                <a class="open-offcanvas" data-target="#offcanvas1">Quick links <i class="fa fa-external-link" aria-hidden="true" class="canvas-icon"></i>
                </a>
                <!-- <a class="open-offcanvas" data-target="#offcanvas2">Filters <i class="fa fa-filter" aria-hidden="true" class="canvas-icon"></i></a> -->
            </div>

            <div class="offcanvas offcanvas_left" id="offcanvas1">
                <button type="button" class="close close-offcanvas" id="closeOffcanvas" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                @include('front.component.quicklink')
            </div>

            <div class="col-md-10">
                <section class="ds s-pt-70 s-pb-50 s-pb-sm-50 s-py-lg-100 s-py-xl-150 c-gutter-60 content-area">
                    <div class="p-md-5 p-0">
                        <div class="row">
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-12">
                                        <!-- tabs start -->
                                        <div class="container-fluid">
                                        <div class="col-12">
                                                <h1 class="mb-4 text-left">Boost Your Profile</h1>                                                

                                                <div class="text-justify">Top Push places your profile at the top of the list for a short time, giving you instant visibility and more attention exactly when you want it most.                                                
                                                    <div class="top-socials justify-content-start align-items-center ">
                                                        Contact us 
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
                                                    @if($BoostData['status'] == 200)  
                                                    Your boost will expire with in <button class="timeDiff btn-sm mt-4"></button> minutes.
                                                    @endif
                                                </div>
                                        </div>
                                        @include('front.component.plan_notification')
                                        <div class="col-12 mt-4">   
                                            <p>Available {{ auth()->user()->alloted_ups ?? 0 }} Ups</p> 
                                        @if(auth()->user()->alloted_ups > 0)                                   
                                      
                                         <button type="button" class="btn-sm float-left BoostMyProfileNow" title="Click here to boost your profile" >Boost Now</button>
                                        @endif
                                        <button type="button" class="btn-sm float-md-right float-left mt-3 mt-md-0 " data-toggle="modal" data-target="#exampleModal" title="Click me to request ups">Request Ups</button>
                                     
                                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="display: none;">
                                            <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Add Ups</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">×</span>
                                                </button>
                                                </div>
                                                <div class="modal-body"> 
                                                <form method="post" action="{{ route('user.manually-boost.post') }}" onsubmit="$('#btn_submit').prop('disabled',true);"> 
                                                    @csrf
                                                    <div class="col-12 mb-4 px-0">
                                                        <label>Choose Quantity</label>
                                                        <select class="form-control" required name="ups_quantity">
                                                            <option value="">Select</option>
                                                            <option value="25" {{ old('ups_quantity') == 25 ? 'selected' : '' }}>25</option>
                                                            <option value="50" {{ old('ups_quantity') == 50 ? 'selected' : '' }}>50</option>
                                                            <option value="100" {{ old('ups_quantity') == 100 ? 'selected' : '' }}>100 Popular ✨</option>
                                                            <option value="150" {{ old('ups_quantity') == 150 ? 'selected' : '' }}>150</option>
                                                            <option value="350" {{ old('ups_quantity') == 350 ? 'selected' : '' }}>350</option>
                                                            <option value="500" {{ old('ups_quantity') == 500 ? 'selected' : '' }}>500 Max 🔥</option>
                                                            <option value="1200" {{ old('ups_quantity') == 1200 ? 'selected' : '' }}>1200 ULTRA 🚀</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-12 mb-4 px-0">
                                                        <button type="submit" class="btn-maincolor py-2 mx-auto " id="btn_submit">Submit</button>
                                                    </div>
                                                </form>
                                                </div>
                                            </div>
                                            </div>
                                        </div>
                                            <!-- Description -->



                                            <!-- Services -->


                                            <!-- tabs end-->
                                                <div class="table-responsive">
                                                    @php
                                                        $any_pending = false;
                                                    @endphp
                                                    <table class="table table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th scope="col">#</th>
                                                                <th scope="col">Ups Quantity</th>
                                                                <th scope="col">Status</th>
                                                                <th scope="col">Requested At</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @forelse($manuallyBoostData as $key => $data)
                                                                    <tr>
                                                                        <th scope="row">{{ $key + 1 }}</th>
                                                                        <td>{{ $data->ups_quantity }}</td>
                                                                        <td>
                                                                            @if($data->status == 0)
                                                                                Pending
                                                                                @php
                                                                                    $any_pending = true;
                                                                                @endphp
                                                                            @elseif($data->status == 1)
                                                                                Approved
                                                                            @else
                                                                                Rejected
                                                                            @endif
                                                                        </td>
                                                                        <td>{{ date('d M, Y', strtotime($data->created_at)) }}</td>
                                                                    </tr>
                                                            @empty                                                    
                                                                <tr>
                                                                    <td colspan="4" class="text-center">No data found.</td>
                                                                </tr>
                                                            @endforelse
                                                        </tbody>
                                                    </table>
                                                    @if ($any_pending)
                                                        <p>Note : Your pending requests are under approval. Please contact to administrator for more information.</p>                                    
                                                    @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="fw-divider-space hidden-below-lg mt-20"></div>
                </section>
            </div>
        </div>
    </div>
</section>
@endsection

@push('js')
<script>
     function showComingSoon() {
        alert('Coming Soon');
    }
    $(document).ready(function() {

        $('#change_passwoed_btn').click(function(event) {
            event.preventDefault();

            var current_password = $('#current_password').val();
            var password = $('#password').val();
            var password_confirmation = $('#password_confirmation').val();

            console.log('current_password', current_password);
            console.log('password', password);
            console.log('password_confirmation', password_confirmation);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ route('user.change-password') }}",
                type: 'POST',
                data: {
                    current_password: current_password,
                    password: password,
                    password_confirmation: password_confirmation,
                },
                dataType: 'json',
                beforeSend: function() {
                    $('#change_passwoed_btn').prop('disabled', true);
                    $('#change_passwoed_btn').text('Processing..');
                },
                success: function(res) {
                    $('#change_passwoed_btn').prop('disabled', false);
                    $('#change_passwoed_btn').text('Update');
                    if (res.status == 1) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: res.message,
                        }).then(function() {
                            window.location.href = '{{ route("user.profile") }}';
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: res.message,
                        }).then(function() {

                        });
                    }
                },
                error: function(error) {
                    $('#change_passwoed_btn').prop('disabled', false);
                    $('#change_passwoed_btn').text('Update');
                    $('.text-danger').remove();
                    if (error.responseJSON && error.responseJSON.errors) {
                        for (var err in error.responseJSON.errors) {
                            if (error.responseJSON.errors.hasOwnProperty(err)) {
                                var errorMessage = error.responseJSON.errors[err][0];
                                $("[name='" + err + "']").after("<div class='text-danger'>" + errorMessage +
                                    "</div>");
                            }
                        }
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: error.responseJSON.message,
                        }).then(function() {

                        });
                    }
                }
            });
            return false;
        });

    });
    $('.BoostMyProfileNow').click(function(){
        Swal.fire({
            title: 'Are you sure?',
            text: "You want to boost your profile now for 15 minutes!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#000000',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, boost it!'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "{{ route('user.boost-my-profile') }}";
            }
        })
    });    
</script>
@if($BoostData['status'] == 200)
<script>
    var endTime = new Date('{{ $BoostData['data']->boosted_to }}').getTime();
    function updateDifference() {
        let now = getISTTime();
        let diff = endTime - now; // remaining time

        if (diff <= 0) {
            $(".timeDiff").text("00:00:00");
            return;
        }

        let hours = Math.floor((diff / (1000 * 60 * 60)) % 24);
        let minutes = Math.floor((diff / (1000 * 60)) % 60);
        let seconds = Math.floor((diff / 1000) % 60);

        // Pad with 0
        hours   = String(hours).padStart(2, '0');
        minutes = String(minutes).padStart(2, '0');
        seconds = String(seconds).padStart(2, '0');

        $(".timeDiff").text(minutes + ":" + seconds);
    }

    // initial call
    updateDifference();

    // update every second
    setInterval(updateDifference, 1000);
    function getISTTime() {
        return new Date(
            new Date().toLocaleString("en-US", { timeZone: "{{ config('app.timezone') }}" })
        ).getTime();
    }

</script>
@endif
@endpush('js')