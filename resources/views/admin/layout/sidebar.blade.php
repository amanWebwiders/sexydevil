<style>
	.dropdown-menu-toggle.show .menu-icon{
    width: 1.25rem;
    height: 1.25rem;
    margin: -.25rem 0;
    position: relative;
    display: flex
;
    align-items: center;
    justify-content: center;
    font-size: 1.05rem;
    opacity: 1;
    margin-right: 1rem;
	
	}

		.dropdown-menu-toggle.show .menu-icon i{
			color: #fff !important;
		}


	
.dropdown-menu-toggle.show {
	font-weight: 600;
	color: #fff !important;
    background: #bc1212 !important;
    border-color: #bc1212 !important;
    text-decoration: none;
    position: relative;
    padding: .5rem 1.25rem;
    line-height: 1.45;
    border-radius: 0 1.25rem 1.25rem 0;
    color: var(--bs-app-sidebar-color);
    display: flex;
    align-items: center;
    /* justify-content: flex-end; */
}
.dropdown-menu-toggle .menu-icon{
    width: 1.25rem;
    height: 1.25rem;
    margin: -.25rem 0;
    position: relative;
    display: flex
;
    align-items: center;
    justify-content: center;
    font-size: 1.05rem;
    opacity: 0.25;
    margin-right: 1rem;
	
	}

.dropdown-menu-toggle:hover{
	    background: var(--bs-app-sidebar-link-hover-bg);
		text-decoration: none !important;
		color: #111;
}

.dropdown-menu-toggle
   {
	 text-decoration: none;
    position: relative;
    padding: .5rem 1.25rem;
    line-height: 1.45;
    border-radius: 0 1.25rem 1.25rem 0;
    color: var(--bs-app-sidebar-color);
    display: flex
;
    align-items: center;
   
   }
</style>
<div class="overlay_menu"></div>
<div id="sidebar" class="app-sidebar">
	<!-- BEGIN scrollbar -->
	<div class="app-sidebar-content" data-scrollbar="true" data-height="100%">
		<!-- BEGIN menu -->
		<div class="menu">
			<div class="menu-profile">
				<a href="javascript:;" class="menu-profile-link" data-bs-toggle="dropdown">
					<div class="menu-profile-cover with-shadow"></div>
					@if(auth('admin')->check() && auth('admin')->user()->type == 0)
					<div class="menu-profile-image">
						<div class="menu-profile-img" style="background-image: url(assets/img/user/user.jpg)"></div>
					</div>
					@else
					@php
					$admin = auth('admin')->user();

					$profileUrl = $admin && $admin->image
					? asset('storage/' . $admin->image)
					: asset('assets/img/user/user.jpg');
					@endphp
					<div class="menu-profile-image">
						<div class="menu-profile-img" style="background-image: url('{{ $profileUrl }}')"></div>
					</div>
					@endif
					<div class="menu-profile-info">
						<div class="d-flex align-items-center">
							<div class="flex-grow-1 fw-bold">Administrator</div>
						</div>
						<small><span class="__cf_email__" data-cfemail="25505640574b444840654446464a504b510b464a48">[email&#160;protected]</span></small>
					</div>
				</a>
				<div class="dropdown-menu dropdown-menu-end me-lg-3 mt-1 w-200px">
					<a class="dropdown-item d-flex align-items-center" href=" "><i class="far fa-user fa-fw fa-lg me-3"></i> Profile</a>

					<a class="dropdown-item d-flex align-items-center" href=" "><i class="fa fa-sliders fa-fw fa-lg me-3"></i> Settings</a>
					<div class="dropdown-divider"></div>
					<a class="dropdown-item d-flex align-items-center" href=" "><i class="fa fa-arrow-right-from-bracket fa-fw fa-lg me-3"></i> Logout</a>
				</div>
			</div>
			<div class="menu-header"><span>Navigation</span><label class="mobile_menuw"><i class="fa fa-times-circle" aria-hidden="true"></i></label> </div>
			<div class="menu-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
				<a href="{{route('admin.dashboard')}}" class="menu-link">
					<span class="menu-icon"><i class="fa fa-qrcode"></i></span>
					<span class="menu-text">Dashboard</span>
				</a>
			</div>
			<div class="menu-item {{ request()->routeIs('admin.contact-list') ? 'active' : '' }}">
				<a href="{{route('admin.contact-list')}}" class="menu-link">
					<span class="menu-icon"><i class="fa-brands fa-wpforms"></i></span>
					<span class="menu-text">Contact List</span>
				</a>
			</div>

			<div class="menu-item {{ request()->routeIs('admin.plan') ? 'active' : '' }}">
				<a href="{{route('admin.plan')}}" class="menu-link">
					<span class="menu-icon"><i class="fa-brands fa-wpforms"></i></span>
					<span class="menu-text">Plan Management</span>
				</a>
			</div>
			<div class="menu-item">
			<div class="dropdown ">
				<a class=" dropdown-toggle w-100 dropdown-menu-toggle" href="#" role="button" data-bs-toggle="dropdown">
					<span class="menu-icon"><i class="fa-brands fa-wpforms"></i></span>
					User Management
				</a>

				<ul class="dropdown-menu">
					<li><a class="dropdown-item" href="{{route('admin.incoming.advertiser')}}">Incoming Advertiser List</a></li>
					<li><a class="dropdown-item" href="{{route('admin.advertiser')}}">Approved Advertiser List</a></li>
					<li><a class="dropdown-item" href="{{route('admin.user')}}">Client List</a></li>
				</ul>
			</div>
			<div class="dropdown ">
				<a class=" dropdown-toggle w-100 dropdown-menu-toggle" href="#" role="button" data-bs-toggle="dropdown">
					<span class="menu-icon"><i class="fa-brands fa-wpforms"></i></span>
					Translation history 
				</a>

				<ul class="dropdown-menu">
					<li><a class="dropdown-item" href="{{route('admin.transaction-history')}}">Subscribtion history</a></li>
					<li><a class="dropdown-item" href="{{route('admin.boost-transaction-history')}}">Boost purachse history</a></li>
				</ul>
			</div>
			<div class="menu-item {{ request()->routeIs('admin.agencies.index') ? 'active' : '' }}">
				<a href="{{route('admin.agencies.index')}}" class="menu-link">
					<span class="menu-icon"><i class="fa-brands fa-wpforms"></i></span>
					<span class="menu-text">Agency</span>
				</a>
			</div>
			<div class="menu-item {{ request()->routeIs('admin.boost.index') ? 'active' : '' }}">
				<a href="{{route('admin.boost.index')}}" class="menu-link">
					<span class="menu-icon"><i class="fa-brands fa-wpforms"></i></span>
					<span class="menu-text">Boost Profiles</span>
				</a>
			</div>
			<div class="menu-item {{ request()->routeIs('admin.manually-boost-request') ? 'active' : '' }}">
				<a href="{{route('admin.manually-boost-request')}}" class="menu-link">
					<span class="menu-icon"><i class="fa-brands fa-wpforms"></i></span>
					<span class="menu-text">Manually Boost request</span>
				</a>
			</div>
			<div class="dropdown ">
				<a class=" dropdown-toggle w-100 dropdown-menu-toggle" href="#" role="button" data-bs-toggle="dropdown">
					<span class="menu-icon"><i class="fa-brands fa-wpforms"></i></span>Image/Video Verification
				</a>

				<ul class="dropdown-menu">
					<li><a class="dropdown-item" href="{{route('admin.image-approval')}}">Image</a></li>
					<li><a class="dropdown-item" href="{{route('admin.video-approval')}}">Video</a></li>
				</ul>
			</div>
			<div class="menu-item {{ request()->routeIs('admin.faqs.*') ? 'active' : '' }}">
				<a href="{{route('admin.faqs.index')}}" class="menu-link">
					<span class="menu-icon"><i class="fa-solid fa-circle-question"></i></span>
					<span class="menu-text">FAQ Management</span>
				</a>
			</div>
			<div class="dropdown ">
				<a class=" dropdown-toggle w-100 dropdown-menu-toggle" href="#" role="button" data-bs-toggle="dropdown">
					<span class="menu-icon"><i class="fa-brands fa-wpforms"></i></span>Settings
				</a>

				<ul class="dropdown-menu">
					<li><a class="dropdown-item" href="{{route('admin.terms-conditions')}}">Terms & Conditions</a></li>
					<li><a class="dropdown-item" href="{{route('admin.privacy-policy')}}">Privacy Policy</a></li>
					<li><a class="dropdown-item" href="{{route('admin.contact-page-content')}}">Content Page</a></li>
					<li><a class="dropdown-item" href="{{route('admin.location-seo-content')}}">Location SEO Content</a></li>
					<li><a class="dropdown-item" href="{{route('admin.faqs.index')}}">FAQ Management</a></li>
				</ul>
			</div>
		</div>

		<!-- @if(auth('admin')->check() && auth('admin')->user()->type == 0)
                    <div class="menu-item {{ request()->routeIs('admin.occupation') ? 'active' : '' }}">
                      <a href="{{route('admin.occupation')}}" class="menu-link">
                           <span class="menu-icon"><i class="fa-brands fa-wpforms"></i></span>
                            <span class="menu-text">Occupation Management</span>
                      </a>
                    </div>

					<div class="menu-item {{ request()->routeIs('admin.user') ? 'active' : '' }}">
                      <a href="{{route('admin.user')}}" class="menu-link">
                           <span class="menu-icon"><i class="fa-brands fa-wpforms"></i></span>
                            <span class="menu-text">Supplier Management</span>
                      </a>
                    </div>
					
					<div class="menu-item {{ request()->routeIs('admin.contact-list') ? 'active' : '' }}">
                      <a href="{{route('admin.contact-list')}}" class="menu-link">
                           <span class="menu-icon"><i class="fa-brands fa-wpforms"></i></span>
                            <span class="menu-text">Contact List</span>
                      </a>
                    </div>
                    @endif -->
		<!--<div class="menu-item">-->
		<!--    <a href="javascript:void(0);" class="menu-link">-->
		<!--        <span class="menu-icon"><i class="fa-solid fa-square-plus"></i></span>-->
		<!--        <span class="menu-text">Add Form</span>-->
		<!--    </a>-->
		<!--</div>-->
		<!-- <div class="menu-item">
						<a href="analytics.html" class="menu-link">
							<span class="menu-icon"><i class="fa fa-chart-bar"></i></span>
							<span class="menu-text">Analytics</span>
						</a>
					</div>
					<div class="menu-item has-sub">
						<a href="#" class="menu-link">
							<span class="menu-icon">
								<i class="fa fa-envelope-open-text"></i>
							</span>
							<span class="menu-text">Email</span>
							<span class="menu-caret"><b class="caret"></b></span>
						</a>
						<div class="menu-submenu">
							<div class="menu-item">
								<a href="email_inbox.html" class="menu-link">
									<span class="menu-text">Inbox</span>
								</a>
							</div>
							<div class="menu-item">
								<a href="email_compose.html" class="menu-link">
									<span class="menu-text">Compose</span>
								</a>
							</div>
							<div class="menu-item">
								<a href="email_detail.html" class="menu-link">
									<span class="menu-text">Detail</span>
								</a>
							</div>
						</div>
					</div> -->

	</div>
	<!-- END menu -->

</div>
<!-- END scrollbar -->
</div>