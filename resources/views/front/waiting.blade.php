@extends('front.layout.layout')

@section('content')

<style>
    /* header,
    footer {
        display: none;
    } */

    /* #canvas {
        width: 100dvw;
        height: 100dvh;
        overflow-y: auto;
        background: #000;
        display: grid;
        place-items: center;
    } */
    .login {
    padding-top: 165px;
   
}

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


<main class="login-container">



    <section class="login px-5">

        <div class="container">
            <div class="row align-items-center justify-content-center position-relative">
                <a href="{{route('user.logout')}}" data-toggle="tooltip" data-placement="top" title="Logout" class="logout"><i class="fa-solid fa-right-from-bracket"></i></a>

                <div class="col">
                    <img src="{{ asset('images/escort_logo1.png')}}" alt="">
                </div>
                <div class="col">
                    <h1 class="mx-auto text-center">Please Wait</h1>
                    <span class=" mb-3 text-center d-block mx-auto">Important alert!</span>


                    <form class="contact-form c-mb-20 c-gutter-20" method="post" action="">
                        <div class="row">
                            <div class="col-12">
                                <div class="alert alert-warning text-center mt-4" role="alert">
                                    <strong>Account under review:</strong> Your profile is currently being verified by our admin team. This process typically takes 2–3 days. You’ll be notified once approved. Thank you for your patience!
                                </div>
                                <div class="text-center mt-4" id="saveMediaContainer">
                                    <a href="{{route('user.pricing')}}" class="btn btn-maincolor">Ok</a>
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
<script>
    $(function() {
        $('[data-toggle="tooltip"]').tooltip()
    })
</script>