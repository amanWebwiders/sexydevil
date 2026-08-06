@extends('front.layout.layout')

@section('content')

<style>

    select {
        height: 45px !important;
    }
    span.select2.select2-container.select2-container--default{
        width: 35% !important;
    }
    .bg-top-element{
        display: none;
    }

    #addUserForm .select2-container--default .select2-selection--single {
        background-color: #fff;
        border: 1px solid #aaa;
        border-radius: 4px;
        font-size: 12px;
    }

    .select2-container--default .select2-results>.select2-results__options {
        max-height: 200px;
        overflow-y: auto;
        font-size: 12px;
    }

    .select2-search--dropdown .select2-search__field {
        padding: 4px;
        width: 100%;
        box-sizing: border-box;
        height: 30px;
    }
</style>


<main class="login-container">



    <section class="login ">

        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col-lg-6 login_logo">
                    <img src="{{ asset('images/escort_logo1.png') }}" alt="">
                </div>
                <div class="col-lg-6">
                    <h2 class="mx-auto mb-5 text-center">Sign Up</h2>

                    <form class="contact-form c-mb-20 c-gutter-20" id="addUserForm" method="POST"
                        action="{{ route('user.register') }}">
                        @csrf
                        <input type="hidden" name="type" value='1'>
                        <div class="row">
                            <div class="col-md-12 mb-3 px-0">
                                <div class="form-group w-75 mx-auto mb-0">
                                    <input type="Text" class="form-control w-100"
                                        placeholder="Name" aria-describedby="emailHelp" name="name">
                                </div>
                            </div>

                            <div class="col-md-12 mb-3 px-0">
                                <div class="form-group w-75 mx-auto mb-0 flex-row">
                                    <select class="form-select mr-3 phone_code" name="phone_code" id="phone_code"
                                        style="max-width: 30%;">
                                        <option value="">Code</option>
                                        @foreach($countryCodes as $country)
                                        <option value="{{ $country->code }}" {{ $country->code == '+1' ? 'selected' : '' }}>
                                           {{ $country->country }} (+{{ $country->code }})
                                        </option>
                                        @endforeach

                                    </select>
                                <div class="w-100">
                                       <input type="Number" class="form-control" placeholder="Contact Number"
                                        name="phone" id="phone">
                                 </div>
                                </div>
                            </div>

                            <div class="col-md-12 mb-3 px-0">
                                <div class="form-group w-75 mx-auto mb-0">
                                    <input type="email" class="form-control w-100"
                                        placeholder="Email address" aria-describedby="emailHelp" name="email">
                                </div>
                            </div>



                            <div class="col-md-12 mb-3 px-0">
                                <div class="form-group w-75 mx-auto mb-0">
                                    <input type="password" class="form-control" placeholder="Password" name="password">
                                </div>
                            </div>
                            <div class="col-md-12 mb-3 px-0">
                                <div class="form-group w-75 mx-auto mb-0">
                                    <input type="password" class="form-control" placeholder="Confirm Password"
                                        name="password_confirmation">
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group mx-auto form-check w-75 pl-0 mb-3">
                                    <input type="checkbox" class="form-check-input" id="termsCheckbox" name="terms">
                                    <label class="form-check-label" for="termsCheckbox">
                                        I agree to the <a href="/terms-and-conditions" target="_blank">Terms and
                                            Conditions</a>
                                    </label>
                                </div>
                            </div>


                            <button type="submit" id="submit_button" class="btn btn-maincolor mx-auto">Submit</button>
                        </div>

                        <div class=" text-center">
                            <hr style="width: 60%; margin: 50px auto 30px; height: 1px; background: #fff;">
                            <p class="mx-auto">Already have an account <a href="{{route('user-login')}}">Login</a></p>
                        </div>


                    </form>
                </div>
            </div>
        </div>

    </section>

</main>


@endsection

@push('js')

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
        $(document).ready(function() {
        $('.phone_code').select2({
          
            allowClear: true
        });
    });
    $(document).ready(function() {
        $('#addUserForm').on('submit', function(event) {
            event.preventDefault();
            console.log("Form submit intercepted");

            if (!$('#termsCheckbox').is(':checked')) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Terms Required',
                    text: 'Please accept the Terms and Conditions before continuing.',
                });
                return;
            }

            var form = $(this);
            var formData = new FormData(this);

            $.ajax({
                url: form.attr('action'),
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                beforeSend: function() {
                    $('#submit_button').prop('disabled', true).text('Processing...');
                },
                success: function(response) {
                    $('#submit_button').prop('disabled', false).text('Submit');

                    if (response.status === 1) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: response.message,
                            confirmButtonText: 'OK'
                        }).then(function() {
                            window.location.href = '{{ route("user.email-verification") }}';
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response.message
                        });
                    }
                },
                error: function(xhr) {
                    $('#submit_button').prop('disabled', false).text('Submit');
                    $('.text-danger').remove();
                    $('.form-control').removeClass('is-invalid');

                    if (xhr.responseJSON && xhr.responseJSON.errors) {
                        $.each(xhr.responseJSON.errors, function(key, value) {
                            var inputField = $('[name="' + key + '"]');
                            inputField.addClass('is-invalid');
                            inputField.after('<span class="text-danger">' + value[0] + '</span>');
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Something went wrong. Please try again.',
                        });
                    }
                }
            });
        });
    });
</script>
@endpush
