<!DOCTYPE html>
<html class="no-js">

<head>
    <title>{{env('APP_NAME')}}</title>
    <meta charset="utf-8">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{ asset('css/animations.css')}}">
    <link rel="stylesheet" href="{{ asset('css/font-awesome.css')}}">
    <link rel="stylesheet" href="{{ asset('css/main.css')}}" class="color-switcher-link">
    <script src="{{ asset('js/vendor/modernizr-custom.js')}}"></script>
    <link rel="icon" type="image/x-icon" href="{{ asset('images/escort_favicon.png')}}">


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">

</head>
<style>
    .bg-top-element{
        right: 265px;
    }
</style>

<body>


    <!-- wrappers for visual page editor and boxed version of template -->
    <div id="canvas">
        <div id="box_wrapper">

            <!-- template sections -->

            <div class="header_absolute ds ">


                <!-- header with two Bootstrap columns - left for logo and right for navigation and includes (search, social icons, additional links and buttons etc -->
                <header class="page_header ds justify-content-between bottom_mask_add align-items-center bottom_mask_add">
                    <div class="container-fluid">
                        <div class="row align-items-center">
                            <div class="col-md-2">
                                <a href="login_index.php" class="logo">
                                    <img src="images/escort_logo.png" alt="img">
                                </a>
                            </div>
                            <div class="col-md-7">
                                <div class="nav-wrap">

                                    <!-- main nav start -->
                                    <nav class="top-nav">
                                        <ul class="nav ">

                                        <li class="active">
												<a href="index.php">Home</a>
											</li>

											<li class="">
												<a href="models.php">All escorts</a>
											</li>

											<li>
												<a href="models.php">New escorts</a>
											</li>
											<li>
												<a href="agency.php">Agencies/sex locations</a>
											</li>

											<li>
												<a href="model_detail.php">Stories</a>
											</li>


                                        </ul>


                                    </nav>
                                    <!-- eof main nav -->

                                    <!--hidding includes on small devices. They are duplicated in topline-->

                                </div>
                            </div>
                            <div class="col-md-3">

                                <div class="nav-wrap">

                                    <!-- main nav start -->
                                    <nav class="top-nav profile-nav" style="justify-content: end !important;">
                                        <ul class="nav ">

                                            <li class=" profile">
                                                <a href="index.php"><img src="images/team/face_1.jpg" alt=""></a>
                                                <ul>
                                                <li>
                                                    <a href="edit_profile.php"><i class="fa-solid fa-pen-to-square mr-2"></i>Edit Profile</a>
                                                </li>
                                                <li>
                                                    <a href="login.php"><i class="fa-solid fa-right-from-bracket mr-2"></i>Sign out</a>
                                                </li>
                                            </ul>

                                            </li>

                                            

                                        </ul>


                                    </nav>


                                </div>




                            </div>
                        </div>
                    </div>
                    <!-- header toggler -->
                    <span class="toggle_menu"><span></span></span>
                </header>