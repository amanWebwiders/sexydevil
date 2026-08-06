@extends('front.layout.layout')

@section('content')
<style>
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
        .nav-wrap .top-nav {
            top: 30px;
        }


        .nav-wrap .top-nav {
            margin-right: 5%;
        }

    }

    @media (max-width: 390px) {
        .nav-wrap .top-nav {
            margin-right: 5%;
        }

    }
</style>


<div id="canvas">

    <main class="login-container">



        <section class="login">

            <div class="container">
                <div class="row align-items-center justify-content-center position-relative">
                    <!-- <a href="{{route('user.logout')}}" data-toggle="tooltip" data-placement="top" title="Logout" class="logout"><i class="fa-solid fa-right-from-bracket"></i></a> -->

                    <div class="col-lg-6 login_logo">

                        <a href="{{route('home')}}"><img src="{{ asset('images/escort_logo1.png')}}" alt=""></a>

                    </div>
                    <div class="col-lg-6 text-center">
                        <h2 class="mx-auto mb-5 text-center">Email Verification</h2>
                        <h1 class="my-2" style="font-size: 100px;"><i class="fa-solid fa-envelope-circle-check mt-2 fs-1 text-success"></i></h1>
                        <!-- <a href="{{route('home')}}"><img src="{{ asset('images/verified.png')}}" alt=""></a> -->
                        <h6 class="mt-2 mb-4">{{ $message ?? ''}}</h6>
                        @php
                        $type = auth()->user()->type ?? 0;
                        if ($type == 1) {
                            $redirectRoute = route('user.profile');
                            $text = "Go To Profile";
                        } else if($type == 2) {
                            $redirectRoute = route('user.pricing');
                            $text = "Buy Plan";
                        } else {
                            $redirectRoute = route('user-login');
                            $text = "Login";                        
                        }
                         /*else {
                            $redirectRoute = $user->type == 1 ?  : route('user.pricing');
                        } */

                        @endphp
                        <a href="{{$redirectRoute}}" class="btn btn-maincolor mx-auto">{{ $text }}</a>
                    </div>
                </div>
            </div>

        </section>

    </main>

</div>
@endsection
@push('js')
<script>
    $(function() {
        $('[data-toggle="tooltip"]').tooltip()
    })
</script>
@endpush