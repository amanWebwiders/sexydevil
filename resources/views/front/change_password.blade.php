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
                    <div class="p-5">
                        <div class="row">
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-12">
                                        <!-- tabs start -->
                                        <div class="container-fluid">
                                        <div class="col-12">
                                                <h1 class="mb-4 text-left">Change Password</h1>
                                        </div>
                                        @include('front.component.plan_notification')
                                            <form method="POST" action="javascript:void(0)" id="ChangePassword">
                                                @csrf
                                                <!-- Basic Info -->
                                                <div class="form-section row mx-0">
                                                    <!-- <h4 class="w-100">Basic Information</h4> -->
                                                    <div class="col-md-6  mb-3">
                                                        <div class="form-group">
                                                            <label>Old Password</label>
                                                            <input type="password" placeholder="Enter Old Password" class="form-control" name="current_password" id="current_password" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6  mb-3">
                                                        <div class="form-group">
                                                            <label>New Password</label>
                                                            <input type="password" placeholder="Enter New Password" class="form-control" name="password" id="password" required>

                                                        </div>
                                                    </div>

                                                    <!-- Phone -->
                                                    <div class="col-md-6 mb-3">
                                                        <div class="form-group">
                                                            <label>Confirm New Password</label>
                                                            <input type="password" placeholder="Confirm New Password" class="form-control" name="password_confirmation" id="password_confirmation" required>
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="text-center">
                                                    <button type="submit" name="change_passwoed_btn" id="change_passwoed_btn" class="btn btn-red btn-lg">Submit</button>
                                                </div>
                                            </form>
                                            <!-- Description -->



                                            <!-- Services -->


                                            <!-- tabs end-->
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
<!-- @include('front.layout.faq') -->
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
</script>
@endpush('js')