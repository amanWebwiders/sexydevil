
<div id="app" class="app">
		<!-- BEGIN #header -->
		<div id="header" class="app-header" >
			<!-- BEGIN desktop-toggler -->
			<!-- <div class="desktop-toggler">
				<button type="button" class="menu-toggler" data-toggle-class="app-sidebar-collapsed" data-toggle-target=".app">
					<span class="bar"></span>
					<span class="bar"></span>
				</button>
			</div> -->
			<!-- END desktop-toggler -->
			
			<!-- BEGIN mobile-toggler -->
			<div class="mobile-toggler">
				<button type="button" class="menu-toggler" data-toggle-class="app-sidebar-mobile-toggled" data-toggle-target=".app">
					<span class="bar"></span>
					<span class="bar"></span>
				</button>
			</div>
			<!-- END mobile-toggler -->
				
			<!-- BEGIN brand -->
			<div class="brand">
				<a href=" " class="brand-logo">
					<img src="{{ asset('images/escort_logo1.png') }}" alt="">
					
				</a>
			</div>
			<!-- END brand -->
			
			<!-- BEGIN menu -->
			<div class="menu">
				<!--div class="menu-item dropdown">
					<a href="index-2.html" data-toggle-class="app-header-menu-search-toggled" data-toggle-target=".app" class="menu-link">
						<div class="menu-icon"><i class="bi bi-search nav-icon"></i></div>
					</a>
				</div-->
				
				<div class="menu-item dropdown dropdown-mobile-full">
					<a href="#" data-bs-toggle="dropdown" data-bs-display="static" class="menu-link">
						<div class="menu-img online">
						@if(auth('admin')->check() && auth('admin')->user()->type == 0)
						@php
								$admin = auth('admin')->user();
								
								$profileUrl = $admin && $admin->image
									? asset('storage/' . $admin->image)
									: asset('images/escort_logo1.png');
							@endphp
							<span class="menu-img-bg" style="background-image: url('{{ $profileUrl }}')"></span>
							@else
							@php
								$admin = auth('admin')->user();
								
								$profileUrl = $admin && $admin->image
									? asset('storage/' . $admin->image)
									: asset('assets/img/user/user.jpg');
							@endphp
							<span class="menu-img-bg" style="background-image: url('{{ $profileUrl }}')"></span>
							@endif
						</div>
						<div class="menu-text d d-none"><span class="__cf_email__" data-cfemail="7a0f091f08141b171f3a1b1919150f140e54191517">[email&#160;protected]</span></div>
					</a>
					<div class="dropdown-menu dropdown-menu-end me-lg-3 mt-1 w-200px">
					@auth('admin')
						<div class="dropdown-header text-center">
						<strong>{{ auth('admin')->user()->name }}</strong><br>
						<small class="text-muted">{{ auth('admin')->user()->occupation ? auth('admin')->user()->occupation->name : '' }}</small>
						</div>
						<div class="dropdown-divider"></div>
					@endauth
						<a class="dropdown-item d-flex align-items-center" href="{{route('admin.edit-profile')}}"><i class="far fa-user fa-fw fa-lg me-3"></i> Profile</a>
						<!--a class="dropdown-item d-flex align-items-center" href="email_inbox.html"><i class="far fa-envelope fa-fw fa-lg me-3"></i> Inbox</a>
						<a class="dropdown-item d-flex align-items-center" href="calendar.html"><i class="far fa-calendar fa-fw fa-lg me-3"></i> Calendar</a-->
						<a class="dropdown-item d-flex align-items-center" href="{{route('admin.update-password')}}"><i class="fa fa-sliders fa-fw fa-lg me-3"></i> Change Password</a>
						<div class="dropdown-divider"></div>
						<a class="dropdown-item d-flex align-items-center" href="{{route('admin.logout')}}"><i class="fa fa-arrow-right-from-bracket fa-fw fa-lg me-3"></i> Logout</a>
					</div>
				</div>
			</div>
			<!-- END menu -->
			
			<!-- BEGIN menu-search -->
			<form class="menu-search" method="POST" name="header_search_form">
				<div class="menu-search-container">
					<div class="menu-search-icon"><i class="bi bi-search"></i></div>
					<div class="menu-search-input">
						<input type="text" class="form-control form-control-lg" placeholder="Search menu...">
					</div>
					<div class="menu-search-icon">
						<a href="#" data-toggle-class="app-header-menu-search-toggled" data-toggle-target=".app"><i class="bi bi-x-lg"></i></a>
					</div>
				</div>
			</form>
			<!-- END menu-search -->
		</div>
		<!-- END #header -->
	<?php
        $current_page = basename($_SERVER['PHP_SELF']);
    ?>	
		<!-- BEGIN #sidebar -->
	     @include('admin.layout.sidebar')
		<!-- END #sidebar -->
			
		<!-- BEGIN mobile-sidebar-backdrop -->
		<button class="app-sidebar-mobile-backdrop" data-toggle-target=".app" data-toggle-class="app-sidebar-mobile-toggled"></button>
		<!-- END mobile-sidebar-backdrop -->