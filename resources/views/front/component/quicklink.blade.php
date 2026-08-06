<style>

</style>
 
 <div class="col-lg-2   d-none d-lg-block">
    <div class="sidebar mb-0">
 <div class="quick-links ">
         <h5 class="quick-links-title">
             Quick links
         </h5>
         <div class="transformable">

             <ul>
                 <li class="{{ request()->routeIs('user.profile') ? 'active' : '' }}" class="active">
                     <a href="{{route('user.profile')}}" d="">
                         Edit profile
                     </a>
                 </li>
                 <li class="{{ request()->routeIs('user.update-password') ? 'active' : '' }}">
                     <a href="{{route('user.update-password')}}" d="">
                         Change Password
                     </a>
                 </li>
                 <li class="{{ request()->routeIs('user.photo') ? 'active' : '' }}">
                     <a href="{{ route('user.photo')}}">
                         Photos
                     </a>
                 </li>
                 @if (auth()->user()->type == 2)
                    <li class="{{ request()->routeIs('user.video') ? 'active' : '' }}">
                        <a href="{{ route('user.video')}}">
                            Videos
                        </a>
                    </li>                 
                    <li class="{{ request()->routeIs('user.availabilities') ? 'active' : '' }}">
                        <a href="{{ route('user.availabilities')}}">
                            Availability
                        </a>
                    </li>
                    <li class="{{ request()->routeIs('user.rate') ? 'active' : '' }}">
                        <a href="{{ route('user.rate')}}">
                            Rates
                        </a>
                    </li>
                    <li class="{{ request()->routeIs('user.pricing-af') ? 'active' : '' }}">
                        <a href="{{ route('user.pricing-af')}}">
                            Membership Plan
                        </a>
                    </li>
                 @endif


                  <li class="{{ request()->routeIs('user.favouriteList') ? 'active' : '' }}">
                     <a href="{{ route('user.favouriteList')}}">
                         My Favourite List
                     </a>
                 </li>
                 @if (auth()->user()->type == 2)
                    <li class="{{ request()->routeIs('user.manually-boost') ? 'active' : '' }}">
                        <a href="{{ route('user.manually-boost')}}">
                            Manually Boost
                        </a>
                    </li>
                    <li class="{{ request()->routeIs('user.newsStories') ? 'active' : '' }}">
                        <a href="{{ route('user.newsStories')}}">
                            News/Stories
                        </a>
                    </li>
                 @endif
             </ul>


         </div>
     </div>
    </div>
    

     <div>
     <!-- <img src="{{ asset('images/sidebarelement.png') }}" alt="img"> -->
</div>
 </div>




