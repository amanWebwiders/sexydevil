@extends('front.layout.layout')

@section('content')

<style>

   
.bg-top-element{
    display: none;
}
</style>
<main class="login-container">



    <section class="login">

        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col-lg-6 login_logo">

                    <a href="{{route('home')}}"><img src="{{ asset('images/escort_logo1.png') }}" alt=""></a>
                </div>
                <div class="col-lg-6">
                    <h1 class="mx-auto mb-5 text-center">Login</h1>


                    <form class="contact-form c-mb-20 c-gutter-20" method="POST" id="loginForm">
                        @csrf
                        <div class="row">
                            <div class="col-sm-12 px-0">
                                <div class="form-group w-75 mx-auto mb-3">
                                    <input type="email" name="email" class="form-control w-100" placeholder="Email address" aria-describedby="emailHelp">
                                </div>
                            </div>

                            <div class="col-sm-12 px-0">
                                <div class="form-group w-75 mx-auto mb-2">
                                    <input type="password" class="form-control" name="password" placeholder="Password">
                                </div>
                            </div>

                            <div class="col-sm-12 px-0">
                                <div class="form-group text-end mb-4">
                                    <a href="{{route('user-forgot-password')}}" class="mx-auto">Forget password?</a>
                                </div>
                            </div>

                            <button type="submit" id="loginButton" class="btn btn-maincolor mx-auto">Submit</button>
                        </div>

                        <div class="row text-center">
                            <hr style="width: 61%; margin: 50px auto 30px; height: 1px; background: #fff;">
                            <p class="mx-auto">Don't have an account <a href="{{route('choose')}}">sign up</a></p>
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
        $('#loginForm').on('submit', function(e) {
            e.preventDefault(); // Prevent the form from submitting normally

            var formData = $(this).serialize(); // Serialize the form data

            $.ajax({
                url: "{{ route('user.loginSubmit') }}", // Change this to the route that handles the login
                type: "POST",
                data: formData,
                success: function(response) {
                    if (response.status === 1) {
                        // Login success - redirect to dashboard
                        window.location.href = "{{route('home')}}";
                    } else if (response.status === 2) {
                        // Email not verified - redirect to verification page
                        window.location.href = response.redirect_url;
                    } else {
                        // Show error message
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response.message
                        });
                    }
                },
                error: function(xhr, status, error) {
                    // Handle error here
                    var errors = xhr.responseJSON.errors;
                    if (errors) {
                        var errorMessages = '';
                        for (var field in errors) {
                            errorMessages += errors[field].join('<br>');
                        }
                        Swal.fire({
                            icon: 'error',
                            title: 'Validation Error',
                            html: errorMessages
                        });
                    }
                }
            });
        });
    });
</script>
@endpush