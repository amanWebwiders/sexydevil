@extends('front.layout.layout')

@section('content')


<style>
    .logout {
        position: absolute;
        top: 0px;
        right: 0px;
    }

    .logout i {
        font-size: 20px;
        color: var(--primary-color);
    }

    @media (min-width: 768px) and (max-width: 1024px) {


        .nav-wrap {
            justify-content: center;
        }
    }

    .welcome-msg {
        white-space: nowrap;
    }

    @media (min-width: 768px) and (max-width: 1024px) {

        .nav-wrap {
            justify-content: center;
        }

    }

    @media (max-width: 1024px) {
        .toggle_menu {
            display: none;
        }

    }

    @media (max-width: 767px) {
        .top-nav {
            top: 30px;
        }


           .nav-wrap .top-nav {
        margin-right: 0;
        left: 56%;
        transform: translateX(-50%);
    }

    }


      

    nav.top-nav.profile-nav {
        right: 20px !important;
    }


</style>


<main class="login-container">



    <section class="login">

        <div class="container">
            <div class="row align-items-center justify-content-center position-relative">
                <!-- <a href="{{route('user.logout')}}" data-toggle="tooltip" data-placement="top" title="Logout" class="logout"><i class="fa-solid fa-right-from-bracket"></i></a> -->

                <div class="col-lg-6 login_logo">
                    <a href="{{route('home')}}"><img src="{{ asset('images/escort_logo1.png')}}" alt=""></a>
                </div>
                <div class="col-lg-6">
                    <!-- <h2 class="mx-auto text-center">Welcome, {{ $user->name }}!</h2> -->
                    <!-- <span class=" mb-3 text-center d-block mx-auto">Important alert!</span> -->


                    <form class="contact-form c-mb-20 c-gutter-20" method="post" action="">
                        <div class="row">
                            <div class="col-12">
                                <div class="alert alert-warning text-center mt-4" role="alert">
                                    <strong>Please verify your email:</strong> {{ $user->email }}<br>
                                    If you don’t receive the email within a few minutes, please check your Spam or Junk folder.

                                </div>
                                <div class="text-center mt-4" id="saveMediaContainer">
                                    <button id="resendBtn" class="btn btn-maincolor">Resend</button>
                                </div>
                            </div>
                        </div>


                    </form>
                </div>
            </div>
        </div>

    </section>

</main>

@endsection

@push('js')

<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.5.0/dist/sweetalert2.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.5.0/dist/sweetalert2.all.min.js"></script>

<script>
    $(function() {
        $('[data-toggle="tooltip"]').tooltip()
    })
    //   setInterval(function() {
    //     location.reload();
    // }, 10000);
    document.getElementById('resendBtn').addEventListener('click', function() {
        // Disable the button to prevent multiple clicks
        const resendBtn = document.getElementById('resendBtn');
        resendBtn.disabled = true;
        resendBtn.innerHTML = 'Resending...'; // Optional: Change button text

        fetch("{{ route('resend-verification') }}", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    "Content-Type": "application/json"
                }
            })
            .then(response => response.json())
            .then(data => {
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: data.message,
                    confirmButtonText: 'OK'
                });
                // Re-enable the button after a successful response (optional)
                resendBtn.disabled = false;
                resendBtn.innerHTML = 'Resend Email'; // Reset the button text
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Something went wrong! Please try again.',
                    confirmButtonText: 'OK'
                });
                // Re-enable the button after an error (optional)
                resendBtn.disabled = false;
                resendBtn.innerHTML = 'Resend Email'; // Reset the button text
            });
    });
</script>


@endpush