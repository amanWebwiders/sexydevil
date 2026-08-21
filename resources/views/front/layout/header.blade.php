<!-- wrappers for visual page editor and boxed version of template -->
<style>
    .slogan {
        height: 40px;
    }

    .slogan img {
        height: 100%;
        object-fit: cover;
    }

    .footer-menu {
        gap: 15px;
    }


    @media screen and (max-width:767px) {
        .slogan img {
            height: 85%;

        }
    }
    .goog-te-banner-frame.skiptranslate,
    .goog-logo-link,
    .goog-te-gadget span {
        display: none !important;
    }

    #google_translate_element {
        display: none;
    }
    #goog-gt-tt {
        display: none !important;
    }
</style>
<div id="canvas">
    <div id="box_wrapper">

        <!-- template sections -->

        <div class="header_absolute ds ">


            <!-- header with two Bootstrap columns - left for logo and right for navigation and includes (search, social icons, additional links and buttons etc -->
            <header class="page_header ds justify-content-between bottom_mask_add align-items-center bottom_mask_add">
                @auth
                    @php $user = Auth::user(); @endphp

                    @if($user->user_status == 1)
                        <script>
                            window.location.href = "{{ route('user.logout') }}";
                        </script>
                    @endif
                @endauth
                <div class="container-fluid position-relative">
                    <div class="d-flex flex-column flex-md-row py-2 mb-1 justify-content-between px-3 align-items-center">
                        <p class="mb-2"><strong>Phone:</strong> <small>{{ $globalData->phone_no }}</small>,
                            <small>{{ $globalData->alter_phone_no }}</small>
                        </p>
                        <div class="language-box">
                            <div class="top-socials pt-0 mb-0">
                                @if ($globalData->telegram_active == 1)
                                    <a href="{{ $globalData->telegram }}" target="_blank" rel="nofollow noopener" class="" title="telegram">
                                        <i class="fa-brands fa-telegram"></i>
                                    </a>
                                @endif
                                @if ($globalData->facebook_active == 1)
                                    <a href="{{ $globalData->facebook }}" target="_blank" rel="nofollow noopener" class="" title="facebook">
                                        <i class="fa-brands fa-facebook"></i>
                                    </a>
                                @endif
                                @if ($globalData->instagram_active == 1)
                                    <a href="{{ $globalData->intagram }}" target="_blank" rel="nofollow noopener" class="" title="instagram">
                                        <i class="fa-brands fa-instagram"></i>
                                    </a>
                                @endif
                                <a href="https://api.whatsapp.com/send/?phone={{ $globalData->whatsApp_no }}&text=hi&type=phone_number&app_absent=0"
                                    target="_blank" rel="nofollow noopener" class="" title="whatsapp"><i class="fa-brands fa-whatsapp"></i></a>
                                <a href="mailto:{{ $globalData->email }}" class="" title="email">
                                    <i class="fa-solid fa-envelope"></i>
                                </a>
                            </div>
                            <div class="dropdown lang-btn">
                                <button type="button" class="btn dropdown-toggle" data-toggle="dropdown" id="selected-language"></button>
                                <div class="dropdown-menu lang-dropdown">
                                <a class="dropdown-item" onclick="selectLanguage('en','EN','https://flagcdn.com/gb.svg')"><img width="35" src="https://flagcdn.com/gb.svg" title="English"></a>
                                <a class="dropdown-item" onclick="selectLanguage('es','ES','https://flagcdn.com/es.svg')"><img width="35" src="https://flagcdn.com/es.svg" title="Spanish"></a>
                                <a class="dropdown-item" onclick="selectLanguage('de','DE','https://flagcdn.com/de.svg')"><img width="35" src="https://flagcdn.com/de.svg" title="German"></a>
                                </div>
                            </div> 
                            <div id="google_translate_element"></div>
                        </div>
                    </div>
                    <div class="row justify-content-between px-3 align-items-center flex-lg-nowrap">
                        <!-- Logo -->
                        <div class="logo-slogan ">
                            <div>
                                <a href="{{ route('home') }}" class="logo">
                                    <img src="{{ asset('images/escort_logo1.png') }}" alt="img">
                                </a>
                            </div>
                            <!-- <div class="slogan">
                                <p class="slogan">Hotter than hell. Sweeter than <br> heaven. Just one click away!</p>
                                <img src="{{ asset('images/sloganpng.png') }}" alt="img">
                            </div> -->


                        </div>
                        <!-- <div class="position-relative ">

                            <div class="bg-top-element d-lg-none d-block mr-4">

                                <div class="bg-top-element bg-top-element-login ">
                                    <img src="{{ asset('images/bgelement2.png') }}" alt="img">
                                </div>
                            </div>
                        </div> -->

                        <!-- Navigation/Menu -->
                        <div class="">
                            <div class="nav-wrap">
                                <nav class="top-nav">
                                    @php
                                        $user = Auth::user();
                                    @endphp

                                    {{-- Not Logged In --}}
                                    @guest
                                        <ul class="nav main-nav align-items-center">
                                            <li class="active"><a href="{{ route('home') }}">Home</a></li>
                                            <li><a href="{{route('model.search', ["city" => $city])}}">All Escorts</a></li>
                                            <li><a href="{{route('new.escorts', ["city" => $city])}}">New Escorts</a></li>
                                            <li><a href="{{route('reels', ["city" => $city])}}">Hot Stories</a></li>
                                            <li><a href="{{route('user.agencies', ["city" => $city])}}">Agencies/Sex Locations</a></li>
                                            <!-- <li><a href="#">Stories</a></li> -->
                                            <li><a href="{{ route('contact-us') }}">Contact Us</a></li>
                                            <!-- <li class="position-relative ">

                                                <div class="bg-top-element d-lg-block d-none">

                                                    <div class="bg-top-element bg-top-element-login ">
                                                        <img src="{{ asset('images/bgelement2.png') }}" alt="img">
                                                    </div>
                                            </li> -->
                                            <li class="login_out_mobile">
                                                <div class="d-flex gap-4 justify-content-center">
                                                    <a href="{{ route('user-login') }}"
                                                        class="btn btn-maincolor mr-3">Login</a>
                                                    <a href="{{ route('choose') }}" class="btn btn-maincolor">Sign up</a>
                                                </div>
                                            </li>
                                        </ul>
                                    @endguest

                                    {{-- Logged In --}}
                                    @auth


                                        {{-- Full menu only if approved, verified and plan active (for type 2) --}}
                                        @if($user->user_status == 0 && $user->email_verified_at !== null && ($user->type == 1 || ($user->type == 2 && $user->plan_id && $user->admin_status == 'approved')))
                                            <ul class="nav main-nav align-items-center">
                                                <li class="active"><a href="{{ route('home') }}">Home</a></li>
                                                <li><a href="{{route('model.search', ["city" => $city])}}">All Escorts</a></li>
                                                <li><a href="{{route('new.escorts', ["city" => $city])}}">New Escorts</a></li>
                                                <li><a href="{{route('reels', ["city" => $city])}}">Hot Stories</a></li>
                                                <li><a href="{{route('user.agencies', ["city" => $city])}}">Agencies/Sex Locations</a></li>
                                                <!-- <li><a href="#">Stories</a></li> -->
                                                <li><a href="{{ route('contact-us') }}">Contact Us</a></li>
                                                <!-- <li class="position-relative ">

                                                    <div class="bg-top-element d-lg-block d-none">

                                                        <div class="bg-top-element bg-top-element-login ">


                                                            <img src="{{ asset('images/bgelement2.png') }}" alt="img">
                                                        </div>
                                                </li> -->
                                            </ul>
                                        @else


                                            {{-- Show name regardless of status --}}
                                            <div class="welcome-msg">
                                                <h5 class="mt-0">Welcome, {{ $user->nickname }}</h5>
                                            </div>
                                        @endif
                                    @endauth
                                </nav>
                            </div>
                        </div>

                        <!-- Right side: Profile / Logout / Auth buttons -->
                        <div class="text-right">
                            @auth
                                @if(
                                        $user->user_status == 0 &&
                                        $user->email_verified_at !== null &&
                                        (
                                            $user->type == 1 ||
                                            ($user->type == 2 && $user->plan_id && $user->admin_status == 'approved')
                                        )
                                    )
                                    <!-- Profile Menu -->
                                    <nav class="top-nav profile-nav" style="justify-content: end !important;">
                                        <ul class="nav">
                                            <li class="profile">
                                                @if(isset($user->profile_image) && Storage::disk('public')->exists($user->profile_image))
                                                <a href="#" class="profile_img">
                                                    <img src="{{ config('app.img_url') . ($user->profile_image ?? 'profile_image/default-profile.png') }}"
                                                        alt="">
                                                </a>
                                                @else
                                                <a href="#" class="profile_img">
                                                    <img src="{{ asset('storage/profile_image/default-profile.png') }}"
                                                        alt="">
                                                </a>
                                                @endif
                                                <ul class="profileSub">
                                                    <li>
                                                        <a href="{{route('user.profile')}}">
                                                            <i class="fa-solid fa-pen-to-square mr-2"></i>Edit Profile
                                                        </a>
                                                    </li>

                                                    <li>
                                                        <a href="{{ route('user.logout') }}">
                                                            <i class="fa-solid fa-right-from-bracket mr-2"></i>Sign out
                                                        </a>
                                                    </li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </nav>
                                @else
                                    <!-- Simple Logout Button -->
                                    <!-- <div class="logoutbtn">
                                                        <a href="{{ route('user.logout') }}" class="btn btn-maincolor">
                                                            Logout <i class="fas fa-sign-out"></i>
                                                        </a>
                                                    </div> -->
                                    @php
                                        $redirect = null;

                                        if (is_null($user->email_verified_at)) {
                                            $redirect = route('user.email-verification');
                                        } elseif ($user->type == 2 && !$user->plan_id) {
                                            $redirect = route('user.pricing'); // plan selection page
                                        } elseif ($user->type == 2 && $user->admin_status != 'approved') {
                                            $redirect = route('user.waiting'); // create this route/view
                                        }
                                    @endphp
                                    <nav class="top-nav profile-nav" style="justify-content: end !important;">
                                        <ul class="nav ">
                                            <li class="profile">
                                                <a href="#" class="profile_img">
                                                    <img src="{{ config('app.img_url') . ($user->profile_image ?? 'profile_image/default-profile.png') }}"
                                                        alt="">
                                                </a>
                                                <ul class="profileSub">
                                                    <li>
                                                        <a href="{{ $redirect }}">
                                                            <i class="fa-solid fa-pen-to-square mr-2"></i>Edit Profile
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="{{ route('user.logout') }}">
                                                            <i class="fa-solid fa-right-from-bracket mr-2"></i>Sign out
                                                        </a>
                                                    </li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </nav>
                                @endif
                            @else
                                <!-- Guest View -->
                                <div class="gap-4 justify-content-end login_out">
                                    <a href="{{ route('user-login') }}" class="btn btn-maincolor mr-3">Login</a>
                                    <a href="{{ route('choose') }}" class="btn btn-maincolor">Sign up</a>
                                </div>
                            @endauth
                        </div>
                    </div>

                    <!-- Scroller Services items   -->
                    <!-- <div class="service-scroller-container">
                        <div class="service-scroller">
                            <div class="service-item">
                                <div class="service-icon">🚀</div>
                                <div class="service-name">Service 1</div>
                            </div>
                            <div class="service-item">
                                <div class="service-icon">💡</div>
                                <div class="service-name">Service 2</div>
                            </div>
                            <div class="service-item">
                                <div class="service-icon">🔧</div>
                                <div class="service-name">Service 3</div>
                            </div>
                            <div class="service-item">
                                <div class="service-icon">📊</div>
                                <div class="service-name">Analytics</div>
                            </div>
                            <div class="service-item">
                                <div class="service-icon">🛡️</div>
                                <div class="service-name">Security</div>
                            </div>
                            <div class="service-item">
                                <div class="service-icon">☁️</div>
                                <div class="service-name">Cloud</div>
                            </div>
                            <div class="service-item">
                                <div class="service-icon">📱</div>
                                <div class="service-name">Mobile</div>
                            </div>
                            <div class="service-item">
                                <div class="service-icon">🌐</div>
                                <div class="service-name">Web</div>
                            </div>
                            <div class="service-item">
                                <div class="service-icon">🚀</div>
                                <div class="service-name">Service 1</div>
                            </div>
                            <div class="service-item">
                                <div class="service-icon">💡</div>
                                <div class="service-name">Service 2</div>
                            </div>
                            <div class="service-item">
                                <div class="service-icon">🔧</div>
                                <div class="service-name">Service 3</div>
                            </div>
                            <div class="service-item">
                                <div class="service-icon">📊</div>
                                <div class="service-name">Analytics</div>
                            </div>
                            <div class="service-item">
                                <div class="service-icon">🛡️</div>
                                <div class="service-name">Security</div>
                            </div>
                            <div class="service-item">
                                <div class="service-icon">☁️</div>
                                <div class="service-name">Cloud</div>
                            </div>
                            <div class="service-item">
                                <div class="service-icon">📱</div>
                                <div class="service-name">Mobile</div>
                            </div>
                            <div class="service-item">
                                <div class="service-icon">🌐</div>
                                <div class="service-name">Web</div>
                            </div>
                        </div>
                    </div> -->

                    <!-- Scroller Services items end  -->

                </div>

                <!-- Header Toggler -->
                <span class="toggle_menu"><span></span></span>
            </header>
            <!-- @auth
            <div class="bg-top-element">
                @else
                <div class="bg-top-element bg-top-element-login ">
                    @endauth

                    <img src="{{ asset('images/bgelement2.png') }}" alt="img">
                </div> -->



            <style>
                .range-slider {
                    position: relative;
                    width: 100%;
                }

                .range-slider input[type=range] {
                    position: absolute;
                    width: 100%;
                    pointer-events: none;
                    -webkit-appearance: none;
                    height: 8px;
                    background: transparent;
                }

                .range-slider input[type=range]::-webkit-slider-thumb {
                    pointer-events: all;
                    width: 16px;
                    height: 16px;
                    background: #007BFF;
                    border-radius: 50%;
                    border: none;
                    -webkit-appearance: none;
                }

                .range-slider .track {
                    height: 8px;
                    background: #ddd;
                    position: relative;
                    border-radius: 5px;
                    margin-top: 20px;
                }

                .range-slider .range {
                    position: absolute;
                    height: 8px;
                    background: #007BFF;
                    top: 0;
                    border-radius: 5px;
                }
            </style>