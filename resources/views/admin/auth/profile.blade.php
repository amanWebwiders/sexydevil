@extends('admin.layout.layout')
@section('content')

<!-- BEGIN #content -->
		<div id="content" class="app-content p-0">
			<!-- BEGIN profile -->
			 <div class="ms-auto">
				<a href="{{route('admin.edit-profile')}}" class="btn btn-theme fw-semibold fs-13px"><i class="fa fa-plus fa-fw me-1"></i> Edit Profile</a>
			</div>
			<div class="profile">
			   
				<!-- BEGIN profile-container -->
				<div class="profile-container">
					<!-- BEGIN profile-sidebar -->
					<div class="profile-sidebar w-100">
						<div class="desktop-sticky-top">
							<div class="profile-img" style="width:300px; height:21.5rem">
							    @php
                                    $image = auth()->guard('admin')->user()->image;
                                @endphp
								<img src="{{ $image ? asset('storage/' . $image) : asset('images/escort_logo1.png') }}" alt="">
							</div>
							<!-- profile info -->
							<h4>{{ auth()->guard('admin')->user()->name }}</h4>
							<div class="mb-3 text-body text-opacity-50 fw-bold mt-n2">{{ auth()->guard('admin')->user()->email }}</div>
							<p>
								Principal UXUI Design & Brand Architecture for Droplet. Creator of SeanTheme.
								Bringing the world closer together. Studied Computer Science and Psychology at Harvard University.
							</p>
							<div class="mb-1">
								<i class="fa fa-map-marker-alt fa-fw text-body text-opacity-50"></i> New York, NY
							</div>
							<div class="mb-3">
								<i class="fa fa-link fa-fw text-body text-opacity-50"></i> seantheme.com/droplet
							</div>
					
							
					</div>
				</div>
				<!-- END profile-container -->
			</div>
			<!-- END profile -->
		</div>
		<!-- END #content -->
    
@endsection
@push('js')
@endpush('js')