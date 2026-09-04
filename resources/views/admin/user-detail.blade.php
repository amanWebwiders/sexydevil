@extends('admin.layout.layout')
@section('content')

<style type="text/css">
    .change_form {
        display: none;
    }

    .change_form.show {
        display: flex;
    }

    input.pe-2 {
        margin-right: 5px;
        position: relative;
        top: 2px;
    }
</style>
<div id="content" class="app-content">
    <section class="content">
        <div class="container-fluid">
            <nav aria-label="breadcrumb">
                <h3 class="card-title">User Detail</h3>
            </nav>

            <div class="mt-4">
                <div class="card mx-0">
                    <!-- Header with Tabs -->
                    <div class="card-header px-4 py-3 border-bottom">
                        <ul class="nav nav-pills card-header-pills" id="profileTab" role="tablist">
                            <li class="nav-item">
                                <button class="nav-link active" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab">
                                    Personal Detail
                                </button>
                            </li>
                            @if($user->type == 2)
                            <li class="nav-item">
                                <button class="nav-link" id="personal-tab" data-bs-toggle="tab" data-bs-target="#personal" type="button" role="tab">
                                    Additional Detail
                                </button>
                            </li>

                            <li class="nav-item">
                                <button class="nav-link" id="photos-tab" data-bs-toggle="tab" data-bs-target="#photos" type="button" role="tab">
                                    Photos
                                </button>
                            </li>

                            <li class="nav-item">
                                <button class="nav-link" id="videos-tab" data-bs-toggle="tab" data-bs-target="#videos" type="button" role="tab">
                                    Video
                                </button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link" id="availablity-tab" data-bs-toggle="tab" data-bs-target="#availablity" type="button" role="tab">
                                    Availablity
                                </button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link" id="rate-tab" data-bs-toggle="tab" data-bs-target="#rate" type="button" role="tab">
                                    Rate
                                </button>
                            </li>
                            @if($user->type == 2 && $user->admin_status == "approved")
                                <li class="nav-item">
                                    <button class="nav-link" id="plan-tab" data-bs-toggle="tab" data-bs-target="#plan" type="button" role="tab">Plan</button>
                                </li>
                            @endif
                            @endif
                        </ul>
                    </div>


                    <!-- Tab Contents -->
                    <div class="card-body p-4 border-bottom">
                        <div class="tab-content" id="profileTabContent">
                            <!-- User Profile Tab -->
                            <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                <table class="table table-bordered">
                                    <tr>
                                        <th>Profile Image</th>
                                        <td>
                                            @if ($user->profile_image)
                                            <img src="{{ config('app.img_url') . $user->profile_image }}" alt="Profile Image" style="max-width: 150px;">
                                            @else
                                            <img src="{{ asset('storage/profile_image/default-profile.png') }}" alt="Profile Image" style="max-width: 150px;">
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Unique ID</th>
                                        <td>{{ $user->unique_user_id }}</td>
                                    </tr>
                                    <tr>
                                        <th>Full Name(same as your document)</th>
                                        <td>{{ $user->name }}</td>
                                    </tr>
                                    @if($user->type == 2)
                                    <tr>
                                        <th>Age</th>
                                        <td>
                                            {{ \Carbon\Carbon::parse($user->dob)->age }} years
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Nationality</th>
                                        <td>{{ $user->nationality ?? '-' }}</td>
                                    </tr>
                                    @endif

                                    <tr>
                                        <th>Email</th>
                                        <td>
                                            {{ $user->email }}

                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Phone Number</th>
                                        <td>
                                            +{{ $user->country->code }} {{ $user->phone }}
                                        </td>
                                    </tr>
                                    @if($user->type == 2)
                                    <tr>

                                        <th>Plan Name</th>
                                        <td>
                                            {{ $user->plan->title ?? '-'}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Plan Start Date</th>
                                        <td>
                                            {{ $user->plan_start_date ? \Carbon\Carbon::parse($user->plan_start_date)->format('F d, Y') : '-' }}

                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Plan End Date</th>
                                        <td>
                                            {{ $user->plan_end_date ? \Carbon\Carbon::parse($user->plan_end_date)->format('F d, Y') : '-' }}

                                        </td>
                                    </tr>

                                    <!-- <tr>
                                        <th>Slogan</th>
                                        <td>
                                            {{ $user->slogan }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Rates</th>
                                        <td>
                                            {{ $user->rates }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Contact Method</th>
                                        <td>
                                            {{ $user->contact_method }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Description</th>
                                        <td>
                                            {{ $user->description }}
                                        </td>
                                    </tr> -->
                                    <tr>
                                        <th>Identification document</th>
                                        <td>
                                            @if ($user->document_image)
                                            <a href="{{ config('app.img_url') . $user->document_image }}" data-lightbox="document" data-title="Identification Document">
                                                <img src="{{ config('app.img_url') . $user->document_image }}" alt="ID Document" style="max-width: 150px; border: 1px solid #ccc; padding: 4px;">
                                            </a>
                                            @else
                                            <span>No document uploaded</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Holding the document</th>
                                        <td>
                                            @if ($user->holding_document_image)
                                            <a href="{{ config('app.img_url'). $user->holding_document_image }}" data-lightbox="document" data-title="Identification Document">
                                                <img src="{{ config('app.img_url'). $user->holding_document_image }}" alt="ID Document" style="max-width: 150px; border: 1px solid #ccc; padding: 4px;">
                                            </a>
                                            @else
                                            <span>No document uploaded</span>
                                            @endif
                                        </td>
                                    </tr>

                                    <tr>
                                        <th>Holding a paper with the website name and today’s date</th>
                                        <td>
                                            @if ($user->verify_age_document)
                                            <a href="{{ config('app.img_url') . $user->verify_age_document }}" data-lightbox="document" data-title="Identification Document">
                                                <img src="{{ config('app.img_url') . $user->verify_age_document }}" alt="ID Document" style="max-width: 150px; border: 1px solid #ccc; padding: 4px;">
                                            </a>
                                            @else
                                            <span>No document uploaded</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Recent Pictures Of Yourself (to match your passport)</th>
                                        <td>
                                            @if ($user->identity_photos)
                                            @foreach (json_decode($user->identity_photos, true) as $photo)
                                            <a href="{{ config('app.img_url') . $photo }}" data-lightbox="document" data-title="Identification Photo">
                                                <img src="{{ config('app.img_url') . $photo }}" alt="ID Photo" style="max-width: 150px; border: 1px solid #ccc; padding: 4px; margin-right: 10px;">
                                            </a>
                                            @endforeach
                                            @else
                                            <span>No document uploaded</span>
                                            @endif
                                        </td>
                                    </tr>


                                    @endif




                                </table>
                                <a href="{{ url()->previous() ?? route('admin.user') }}" class="btn btn-primary mt-3">Back</a>

                            </div>

                            <!-- Personal Details Tab -->
                            <div class="tab-pane fade" id="personal" role="tabpanel" aria-labelledby="personal-tab">

                                <table class="table table-bordered">

                                    <tr>
                                        <th>Nickname</th>
                                        <td>{{ $user->nickname }}</td>
                                    </tr>

                                    <tr>
                                        <th>Displayed Age</th>
                                        <td>
                                            {{ $user->displayed_age ?? \Carbon\Carbon::parse($user->dob)->age }} years
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Slogan</th>
                                        <td>
                                            {{ $user->slogan }}
                                        </td>
                                    </tr>


                                    <tr>
                                        <th>Description</th>
                                        <td>
                                            {{ $user->description }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Country</th>
                                        <td>
                                            {{ $user->countries->name  ?? '-' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>State</th>
                                        <td>
                                            {{ $user->state->name ?? '-' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>City</th>
                                        <td>
                                            {{ $user->city->name ?? '-' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Ethnicity</th>
                                        <td>
                                            {{ $user->ethnicity->name ?? '-'}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Body Type</th>
                                        <td>
                                            {{ $user->bodyType->name ??'' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Incall/Outcall</th>
                                        <td>
                                            {{ $user->incall_outcall == 1 ? 'Incall' : ($user->incall_outcall == 0 ? 'Outcall' : ($user->incall_outcall == 2 ? 'Outcall + Incall' : '')) }}
                                        </td>
                                    </tr>
                                    @php
                                    $contactMethods = json_decode($user->contact_methods ?? '{}', true);
                                    @endphp

                                    <tr>
                                        <th>Contact Methods</th>
                                        <td>
                                            @if (!empty($contactMethods))
                                            <ul class="list-unstyled mb-0">
                                                @foreach($contactMethods as $method => $value)
                                                @if(!empty($value))
                                                <li><strong>{{ $method }}:</strong> {{ $value }}</li>
                                                @endif
                                                @endforeach
                                            </ul>
                                            @else
                                            <em>No contact methods provided.</em>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Sex Location</th>
                                        <td>
                                            {{ $user->sex_location }}
                                        </td>
                                    </tr>
                                    @php
                                    $blockedCountryIds = json_decode($user->blocked_countries ?? '[]', true);
                                    $blockedCountries = $countryCodes->whereIn('id', $blockedCountryIds);
                                    @endphp

                                    <tr>
                                        <th>Block Specific Countries</th>
                                        <td>
                                            @if ($blockedCountries->isNotEmpty())
                                            <ul class="list-unstyled mb-0">
                                                @foreach($blockedCountries as $country)
                                                <li>{{ $country->country }}</li>
                                                @endforeach
                                            </ul>
                                            @else
                                            <em>No countries blocked.</em>
                                            @endif
                                        </td>
                                    </tr>
                                    @php
                                    $selectedLanguageIds = json_decode($user->languages ?? '[]', true);
                                    $selectedLanguages = $language->whereIn('id', $selectedLanguageIds);
                                    @endphp

                                    <tr>
                                        <th>Languages</th>
                                        <td>
                                            @if ($selectedLanguages->isNotEmpty())
                                            <ul class="list-unstyled mb-0">
                                                @foreach($selectedLanguages as $lang)
                                                <li>{{ $lang->name }}</li>
                                                @endforeach
                                            </ul>
                                            @else
                                            <em>No languages selected.</em>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Sexual Orientation</th>
                                        <td>{{ $user->sexual_orientation ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Hair Color</th>
                                        <td>{{ $user->haircolor->name ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Hair Length</th>
                                        <td>{{ $user->hairLength->name ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Hair Type</th>
                                        <td>{{ $user->hairType->name ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Eye Color</th>
                                        <td>{{ $user->eyeColor->name ?? '-' }}</td>
                                    </tr>

                                    <tr>
                                        <th>Tattoos</th>
                                        <td>{{ ucfirst($user->tattoo) ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Piercings</th>
                                        <td>{{ ucfirst($user->piercing) ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Smoking</th>
                                        <td>{{ ucfirst($user->smoking) ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>PubicHair</th>
                                        <td>{{ $user->pubicHair->name ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Height (cm)</th>
                                        <td>{{ $user->height_cm ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Weight (kg)</th>
                                        <td>{{ $user->weight_kg ? $user->weight_kg . ' kg' : '-' }}</td>
                                    </tr>


                                    <tr>
                                        <th>Shoe Size</th>
                                        <td>{{ $user->shoe_size ?? '-' }}</td>
                                    </tr>

                                    <tr>
                                        <th>Breast Size</th>
                                        <td>
                                            @php
                                            $breastSizes = json_decode($user->breast_size ?? '[]', true);
                                            @endphp

                                            {{ !empty($breastSizes) ? implode(', ', $breastSizes) : '-' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>OnlyFans</th>
                                        <td>
                                            @if (!empty($user->onlyfans_link))
                                            <a href="{{ $user->onlyfans_link }}" target="_blank">{{ $user->onlyfans_link }}</a>
                                            @else
                                            -
                                            @endif
                                        </td>
                                    </tr>

                                    <tr>
                                        <th>Instagram</th>
                                        <td>
                                            @if (!empty($user->instagram_link))
                                            <a href="{{ $user->instagram_link }}" target="_blank">{{ $user->instagram_link }}</a>
                                            @else
                                            -
                                            @endif
                                        </td>
                                    </tr>

                                    <tr>
                                        <th>Telegram</th>
                                        <td>
                                            @if (!empty($user->telegram_link))
                                            <a href="{{ $user->telegram_link }}" target="_blank">{{ $user->telegram_link }}</a>
                                            @else
                                            -
                                            @endif
                                        </td>
                                    </tr>

                                    <tr>
                                        <th>TikTok</th>
                                        <td>
                                            @if (!empty($user->tiktok_link))
                                            <a href="{{ $user->tiktok_link }}" target="_blank">{{ $user->tiktok_link }}</a>
                                            @else
                                            -
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Services</th>
                                        <td>
                                            @foreach ($categories as $category)
                                            @php
                                            // Filter services that are selected or have selected selections
                                            $filteredServices = $category->services->filter(function ($service) use ($selectedServices, $selectedSelections) {
                                            return in_array($service->id, $selectedServices) ||
                                            $service->selections->pluck('id')->intersect($selectedSelections)->isNotEmpty();
                                            });
                                            @endphp

                                            @if ($filteredServices->isNotEmpty())
                                            <strong>{{ $category->name }}</strong>
                                            <ul class="mb-2">
                                                @foreach ($filteredServices as $service)
                                                <li>
                                                    {{ $service->name }}

                                                    {{-- Check if this service has selections --}}
                                                    @if ($service->selections->isNotEmpty())
                                                    <ul>
                                                        @foreach ($service->selections as $selection)
                                                        @if (in_array($selection->id, $selectedSelections))
                                                        <li>
                                                            {{ $selection->name }}
                                                            <!-- <span class="badge bg-success">Selected</span> -->
                                                        </li>
                                                        @endif
                                                        @endforeach
                                                    </ul>
                                                   
                                                   
                                                    @endif
                                                </li>
                                                @endforeach
                                            </ul>
                                            @endif
                                            @endforeach
                                        </td>

                                    </tr>




                                </table>
                                <a href="{{ url()->previous() ?? route('admin.user') }}" class="btn btn-primary mt-3">Back</a>

                            </div>
                            <div class="tab-pane fade" id="photos" role="tabpanel" aria-labelledby="photos-tab">

                                <table class="table table-bordered">




                                    <tr>
                                        <th>Uploaded Images</th>
                                        <td>
                                            @if ($uploadedPhotos->isNotEmpty())
                                            @foreach ($uploadedPhotos as $photo)
                                            <a href="{{ config('app.img_url').$photo->file_path }}" data-lightbox="document" data-title="Images">
                                                <img src="{{ config('app.img_url').$photo->file_path }}" alt="Images" style="max-width: 150px; border: 1px solid #ccc; padding: 4px;">
                                            </a>
                                            @endforeach
                                            @else
                                            <span>No Images uploaded</span>
                                            @endif
                                        </td>
                                    </tr>







                                </table>
                                <a href="{{ url()->previous() ?? route('admin.user') }}" class="btn btn-primary mt-3">Back</a>

                            </div>
                            <div class="tab-pane fade" id="videos" role="tabpanel" aria-labelledby="videos-tab">

                                <table class="table table-bordered">

                                    <tr>
                                        <th>Uploaded Videos</th>
                                        <td>
                                            @if ($uploadedVideos->isNotEmpty())
                                            @foreach ($uploadedVideos as $video)
                                            <a href="{{ config('app.img_url'). $video->file_path }}" class="glightbox" data-type="video">
                                                <video width="110" height="110" class="border rounded">
                                                    <source src="{{ config('app.img_url'). $video->file_path }}" type="video/mp4">
                                                    Your browser does not support the video tag.
                                                </video>
                                            </a>

                                            @endforeach
                                            @else
                                            <span>No Videos is uploaded</span>
                                            @endif
                                        </td>
                                    </tr>




                                </table>
                                <a href="{{ url()->previous() ?? route('admin.user') }}" class="btn btn-primary mt-3">Back</a>

                            </div>
                            <div class="tab-pane fade" id="availablity" role="tabpanel" aria-labelledby="availablity-tab">
                                <h5 class="mb-3"><strong>General Availability Info</strong></h5>
                                <ul class="list-group mb-4">
                                    <li class="list-group-item">
                                        <strong>Availability Mode:</strong>
                                        {{ $user->availability_main === 'walk-in' ? 'Available without appointment' : 'Available with appointment (By appointment only)' }}
                                    </li>

                                    @if($user->availability_main === 'walk-in')
                                    @php
                                    $walkinTypes = is_array($user->walkin_type) ? $user->walkin_type : json_decode($user->walkin_type, true);
                                    @endphp
                                    <li class="list-group-item">
                                        <strong>Walk-in Options:</strong>
                                        {{ !empty($walkinTypes) ? implode(', ', array_map('ucwords', $walkinTypes)) : 'N/A' }}
                                    </li>
                                    @endif

                                    <li class="list-group-item">
                                        <strong>Available Now:</strong>
                                        <span class="badge {{ $user->is_online ? 'bg-success' : 'bg-secondary' }}">
                                            {{ $user->is_online ? 'Online' : 'Offline' }}
                                        </span>
                                    </li>
                                </ul>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Day</th>
                                            <th>Start Time</th>
                                            <th>End Time</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($availabilities as $availability)
                                        <tr>
                                            <td>{{ ucfirst($availability->day) }}</td>
                                            @if($availability->all_day || empty($availability->start_time))
                                                <td colspan="2" class="text-center font-weight-bold">All day</td>
                                            @else
                                                <td>{{ date('h:i A', strtotime($availability->start_time)) }}</td>
                                                <td>{{ date('h:i A', strtotime($availability->end_time)) }}</td>
                                            @endif
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="3" class="text-center">No availability set</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>

                                <a href="{{ url()->previous() ?? route('admin.user') }}" class="btn btn-primary mt-3">Back</a>
                            </div>
                            <!-- Rates Tab -->
                            <div class="tab-pane fade" id="rate" role="tabpanel" aria-labelledby="rate-tab">
                                <h5 class="mb-3"><strong>Quickie Service Settings</strong></h5>

                                <!-- Quickie Service Details (Read-Only) -->
                                <div class="p-5 mx-lg-0 mx-md-0 mx-2 setavailabilty-main">
                                    <div class="row">
                                        <!-- Display if Quickie Service is enabled or not -->
                                        <div class="mb-3">
                                            <strong>Offer Quickie Service:</strong>
                                            <span>{{ $user->quickie_enabled ? 'Yes' : 'No' }}</span>
                                        </div>

                                        @if($user->quickie_enabled)
                                        <!-- If Quickie Service is enabled, show the values -->
                                         <div class="mb-3">
                                            <strong>Price:</strong>
                                            <span>{{ $user->quickie_price ?? 'N/A' }}</span>
                                        </div>
                                        @endif
                                        <div class="mb-3">
                                            <strong>Currency:</strong>
                                            <span>{{ $user->quickie_currency ?? 'N/A' }}</span>
                                        </div>

                                        @php
                                        $durations = ['30_min' => '30 Minutes', '1_hr' => '1 Hour', '90_min' => '90 Minutes', '2_hr' => '2 Hours', '3_hr' => '3 Hours'];
                                        @endphp

                                        @foreach ($durations as $key => $label)
                                        <div class="mb-2">
                                            <strong>{{ $label }}:</strong>
                                            <span>${{ $user->quickie_rates[$key] ?? 'N/A' }}</span>
                                        </div>
                                        @endforeach

                                        <div class="mb-2">
                                            <strong>Overnight Price:</strong>
                                            <span>{{ $user->quickie_rates['overnight'] ?? 'N/A' }}</span>
                                        </div>

                                        <div class="mb-2">
                                            <strong>Overnight Duration (in hours):</strong>
                                            <span>{{ $user->quickie_overnight_hours ?? 'N/A' }}</span>
                                        </div>
                                        @php
                                        $methods = is_array($user->payment_method)
                                        ? $user->payment_method
                                        : json_decode($user->payment_method, true);
                                        @endphp

                                        <div class="mb-2">
                                            <strong>Payment Method:</strong>
                                            <span>
                                                {{ !empty($methods) ? implode(', ', $methods) : 'N/A' }}
                                            </span>
                                        </div>

                                        
                                    </div>

                                    <!-- Back Button -->
                                    <a href="{{ url()->previous() ?? route('admin.user') }}" class="btn btn-primary mt-3">Back</a>
                                </div>
                            </div>
                            @if($user->type == 2 && $user->admin_status == "approved")
                            <div class="tab-pane fade" id="plan" role="tabpanel" aria-labelledby="plan-tab" >
                                    <h5 class="mb-3"><strong>Membership Plan</strong></h5>
                                    @php
                                    $plan = $user->plan_id ? \App\Models\Plan::find($user->plan_id) : null;
                                    $planEnd = $user->plan_end_date ? \Carbon\Carbon::parse($user->plan_end_date) : null;
                                    $isExpired = $planEnd && now()->greaterThanOrEqualTo($planEnd);
                                    @endphp

                                    @if ($plan && $planEnd)
                                        @if (!$isExpired)
                                        <div class="alert alert-success">
                                            <strong>Current Plan:</strong> {{ $plan->title }} <br>
                                            <strong>Expires on:</strong> {{ $planEnd->format('d M Y') }}
                                        </div> 
                                        @endif
                                    @endif

                                    <div class="row">
                                        @foreach($plans as $data)
                                        @php
                                        $isCurrent = $user->plan_id == $data->id && !$isExpired;
                                        @endphp
                                        <div class="col-xs-12 col-lg-4">


                                            <div class="pricing-plan box-shadow {{ $isCurrent ? 'current-plan' : '' }}">
                                                <div class="pricing-box-detail">
                                                    <div>
                                                        @if($data->tag)
                                                        <div class="exclusive-label mt-2">{{$data->tag}}</div>
                                                        @endif
                                                        <div class="plan-name">
                                                            <h3>
                                                                {{$data->title}}
                                                            </h3>
                                                            <p>{{$data->days}} Days plan</p>
                                                        </div>
                                                        <div class="price-wrap color-darkgrey">
                                                            <span class="plan-sign">$</span>
                                                            <span class="plan-price">{{$data->cost}}</span>
                                                            <!-- <span class="plan-decimals">.95</span> -->
                                                        </div>
                                                        <div class="plan-description small-text color-darkgrey">
                                                            {{$data->heading}}
                                                        </div>
                                                        <div class="plan-features">
                                                            <ul class="list-bordered">
                                                                <li>{{$data->description}}</li>
                                                            </ul>
                                                        </div>
                                                    </div> 
                                                </div>
                                                <div class="plan-button">
                                                    <button class="btn btn-maincolor buy-plan-btn" data-plan-id="{{ $data->id }}">Activate now</button>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                            </div>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@endsection
@push('js')
<link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/css/lightbox.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/js/lightbox.min.js"></script>

<script>
$(document).on('click', '.buy-plan-btn', function(e) {
    e.preventDefault();

    const button = $(this);
    button.prop('disabled', true).text('Processing...'); // Disable and change text

    const planId = button.data('plan-id');
    const token = $('meta[name="csrf-token"]').attr('content');

    $.ajax({
        url: "{{ route('admin.purchase.plan') }}",
        type: "POST",
        data: {
            _token: token,
            plan_id: planId,
            user_id : '{{ $user->id }}'
        },
        beforeSend : function(){
            button.prop('disabled', true).text('Process ....');
        },
        success: function(response) {
            button.prop('disabled', false).text('Activate now'); // Re-enable on failure
            if (response.status === 200) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: response.message,
                }).then(function() {
                    location.reload();                        
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: response.message,
                })
            }
        }
    });
});
</script>
@endpush