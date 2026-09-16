<div class="col-lg-2  d-none d-lg-block">
    <div class="sidebar mb-0">


        <div class="quick-links">

            <h5 class="quick-links-title">

                Quick links

            </h5>

            <div class="transformable">

                <ul>

                    <li><a href="{{ !empty($city) ? route('active.escorts', ['city' => $city]) : route('active.escorts') }}">active now</a></li>

                    <li><a href="{{ !empty($city) ? route('recommend.escorts', ['city' => $city]) : route('recommend.escorts') }}">recommend escorts</a></li>

                    <li><a href="{{ !empty($city) ? route('lowcost.escorts', ['city' => $city]) : route('lowcost.escorts') }}">low-cost</a></li>

                    <li><a href="{{route('about-us')}}">About us</a></li>
                    
                    <li><a href="{{route('user.favouriteList')}}">favorites </a></li>
                    


                </ul>

            </div>

        </div>
    </div>
    <div>
        <!-- <img src="{{ asset('images/sidebarelement.png') }}" alt="img"> -->
    </div>




</div>