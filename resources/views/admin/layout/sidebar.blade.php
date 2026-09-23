<style>
	/* Sidebar scrollbar & container fix: smooth scroll without ugly native scrollbars */
	.app-sidebar .app-sidebar-content {
		overflow-y: auto !important;
		overflow-x: hidden !important;
		scrollbar-width: none !important;
		-ms-overflow-style: none !important;
	}
	.app-sidebar .app-sidebar-content::-webkit-scrollbar {
		display: none !important;
		width: 0 !important;
		height: 0 !important;
	}

	.dropdown-menu-toggle {
		text-decoration: none !important;
		position: relative !important;
		padding: .5rem 1rem .5rem 1.25rem !important;
		line-height: 1.45 !important;
		border-radius: 0 1.25rem 1.25rem 0 !important;
		color: var(--bs-app-sidebar-color) !important;
		display: flex !important;
		align-items: center !important;
		font-size: .8125rem !important;
		transition: all .2s ease-in-out;
	}

	.dropdown-menu-toggle::after {
		display: none !important;
	}

	.dropdown-menu-toggle .menu-icon {
		width: 1.25rem !important;
		height: 1.25rem !important;
		margin: -.25rem 0 !important;
		position: relative !important;
		display: flex !important;
		align-items: center !important;
		justify-content: center !important;
		font-size: 1.05rem !important;
		/* opacity: 0.25 !important; */
		margin-right: 0.75rem !important;
		flex-shrink: 0 !important;
	}

	.dropdown-menu-toggle .menu-text {
		flex: 1 1 auto !important;
		white-space: nowrap !important;
		overflow: hidden !important;
		text-overflow: ellipsis !important;
		font-size: .8125rem !important;
		color: var(--bs-app-sidebar-color) !important;
	}

	.dropdown-menu-toggle .menu-caret {
		margin-left: auto !important;
		display: flex !important;
		align-items: center !important;
		justify-content: center !important;
		font-size: 0.65rem !important;
		opacity: 0.5 !important;
		transition: transform 0.2s ease, opacity 0.2s ease !important;
		flex-shrink: 0 !important;
		padding-left: 0.5rem !important;
	}

	.dropdown-menu-toggle:hover {
		background: var(--bs-app-sidebar-link-hover-bg) !important;
		text-decoration: none !important;
		color: #111 !important;
	}

	.dropdown-menu-toggle.show {
		font-weight: 600 !important;
		color: #fff !important;
		background: #bc1212 !important;
		border-color: #bc1212 !important;
		border-radius: 0 1.25rem 1.25rem 0 !important;
		display: flex !important;
		align-items: center !important;
	}

	.dropdown-menu-toggle.show .menu-icon i,
	.dropdown-menu-toggle.show .menu-text,
	.dropdown-menu-toggle.show .menu-caret {
		color: #fff !important;
		opacity: 1 !important;
	}

	.dropdown-menu-toggle.show .menu-caret {
		transform: rotate(180deg) !important;
	}

	/* Sidebar dropdown inline accordion styling */
	.app-sidebar .dropdown-menu {
		position: static !important;
		transform: none !important;
		float: none !important;
		width: 100% !important;
		background: transparent !important;
		border: none !important;
		box-shadow: none !important;
		padding: 0.25rem 0 0.5rem 2.5rem !important;
		margin: 0 !important;
	}

	.app-sidebar .dropdown-menu .dropdown-item {
		padding: 0.35rem 0.75rem !important;
		color: var(--bs-app-sidebar-color, #333) !important;
		font-size: 0.85rem !important;
		font-weight: 500 !important;
		border-radius: 0 1rem 1rem 0 !important;
		transition: all 0.2s ease;
	}

	.app-sidebar .dropdown-menu .dropdown-item:hover,
	.app-sidebar .dropdown-menu .dropdown-item:focus {
		background: var(--bs-app-sidebar-link-hover-bg, rgba(0,0,0,0.05)) !important;
		color: #bc1212 !important;
	}

	.app-sidebar .dropdown-menu .dropdown-item.active {
		background: #bc1212 !important;
		color: #fff !important;
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
			<div class="menu-header"><span>Navigation</span><label class="mobile_menuw" role="button" title="Close"><i class="fa fa-times-circle" aria-hidden="true"></i></label> </div>
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
					<a class="dropdown-toggle w-100 dropdown-menu-toggle" href="#" role="button" data-bs-toggle="dropdown" data-bs-display="static">
						<span class="menu-icon"><i class="fa-brands fa-wpforms"></i></span>
						<span class="menu-text">User Management</span>
						<span class="menu-caret"><i class="fa fa-chevron-down"></i></span>
					</a>

					<ul class="dropdown-menu">
						<li><a class="dropdown-item" href="{{route('admin.incoming.advertiser')}}">Incoming Advertiser List</a></li>
						<li><a class="dropdown-item" href="{{route('admin.advertiser')}}">Approved Advertiser List</a></li>
						<li><a class="dropdown-item" href="{{route('admin.user')}}">Client List</a></li>
					</ul>
				</div>
			</div>
			<div class="menu-item">
				<div class="dropdown ">
					<a class="dropdown-toggle w-100 dropdown-menu-toggle" href="#" role="button" data-bs-toggle="dropdown" data-bs-display="static">
						<span class="menu-icon"><i class="fa-brands fa-wpforms"></i></span>
						<span class="menu-text">Translation history</span>
						<span class="menu-caret"><i class="fa fa-chevron-down"></i></span>
					</a>

					<ul class="dropdown-menu">
						<li><a class="dropdown-item" href="{{route('admin.transaction-history')}}">Subscribtion history</a></li>
						<li><a class="dropdown-item" href="{{route('admin.boost-transaction-history')}}">Boost purachse history</a></li>
					</ul>
				</div>
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
			<div class="menu-item">
				<div class="dropdown ">
					<a class="dropdown-toggle w-100 dropdown-menu-toggle" href="#" role="button" data-bs-toggle="dropdown" data-bs-display="static">
						<span class="menu-icon"><i class="fa-brands fa-wpforms"></i></span>
						<span class="menu-text">Image/Video Verification</span>
						<span class="menu-caret"><i class="fa fa-chevron-down"></i></span>
					</a>

					<ul class="dropdown-menu">
						<li><a class="dropdown-item" href="{{route('admin.image-approval')}}">Image</a></li>
						<li><a class="dropdown-item" href="{{route('admin.video-approval')}}">Video</a></li>
					</ul>
				</div>
			</div>
			<div class="menu-item {{ request()->routeIs('admin.hot-stories.*') ? 'active' : '' }}">
				<a href="{{route('admin.hot-stories.index')}}" class="menu-link">
					<span class="menu-icon"><i class="fa-solid fa-fire text-danger"></i></span>
					<span class="menu-text">Hot Stories</span>
				</a>
			</div>
			<div class="menu-item">
				<div class="dropdown ">
					<a class="dropdown-toggle w-100 dropdown-menu-toggle" href="#" role="button" data-bs-toggle="dropdown" data-bs-display="static">
						<span class="menu-icon"><i class="fa-brands fa-wpforms"></i></span>
						<span class="menu-text">Settings</span>
						<span class="menu-caret"><i class="fa fa-chevron-down"></i></span>
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