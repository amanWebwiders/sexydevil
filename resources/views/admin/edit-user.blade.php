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
                                <form class="ajax-user-form" action="{{ route('admin.update-user', $user->id) }}" method="POST" enctype="multipart/form-data">

                                    @csrf
                                    @method('patch')
                                    <input type="hidden" value="{{$user->type}}" name="type">
                                    <input type="hidden" value="{{$user->id}}" name="id">
                                    <table class="table table-bordered">
                                        <tr>
                                            <th>Profile Image</th>
                                            <td>
                                                @if ($user->profile_image)
                                                <img src="{{ config('app.img_url') . $user->profile_image }}" alt="Profile Image" style="max-width: 150px;"><br>
                                                @endif
                                                <input type="file" name="profile_image" class="form-control mt-2">
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Full Name (same as your document)</th>
                                            <td><input type="text" name="name" value="{{ old('name', $user->name) }}" class="form-control" required></td>
                                        </tr>
                                        @if($user->type == 2)
                                        <tr>
                                            <th>Date of Birth</th>
                                            <td><input type="date" name="dob" value="{{ old('dob', $user->dob) }}" class="form-control dob" required></td>
                                        </tr>
                                        <tr>
                                            <th>Nationality</th>
                                            <td> <select class="form-select phone_code" name="nationality" id="nationality">
                                                    <option value="">Select Nationality</option>
                                                    @foreach($nationality as $nationality)
                                                    <option value="{{ $nationality->name }}" {{ $user->nationality == $nationality->name ? 'selected' : '' }}>{{ $nationality->name }}</option>
                                                    @endforeach
                                                </select></td>
                                        </tr>
                                        @endif
                                        <tr>
                                            <th>Email</th>
                                            <td><input type="email" name="email" value="{{ old('email', $user->email) }}" class="form-control" required></td>
                                        </tr>
                                        <tr>
                                            <th>Phone Code</th>
                                            <td><select class="form-select phone_code" name="phone_code" id="phone_code">
                                                    <option value="">Select Code</option>
                                                    @foreach($countryCodes as $country)
                                                    <option value="{{ $country->code }}" {{ $user->phone_code == $country->code ? 'selected' : '' }}>
                                                        {{ $country->country }} (+{{ $country->code }})
                                                    </option>
                                                    @endforeach
                                                </select></td>
                                        </tr>
                                        <tr>
                                            <th>Phone Number</th>
                                            <td><input type="text" name="phone" value="{{ old('phone', $user->phone) }}" class="form-control" required></td>
                                        </tr>
                                        @if($user->type == 2)
                                        <tr>
                                            <th>Plan Name</th>
                                            <td><input type="text" name="plan_title" value="{{ $user->plan->title ?? '' }}" class="form-control"></td>
                                        </tr>
                                        <tr>
                                            <th>Plan Start Date</th>
                                            <td><input type="date" name="plan_start_date" value="{{ old('plan_start_date', $user->plan_start_date) }}" class="form-control"></td>
                                        </tr>
                                        <tr>
                                            <th>Plan End Date</th>
                                            <td><input type="date" name="plan_end_date" value="{{ old('plan_end_date', $user->plan_end_date) }}" class="form-control"></td>
                                        </tr>
                                        @endif
                                        <tr>
                                            <th>Identification document</th>
                                            <td>
                                                @if ($user->document_image)
                                                <a href="{{ config('app.img_url'). $user->document_image }}" target="_blank">
                                                    <img src="{{ config('app.img_url'). $user->document_image }}" style="max-width: 150px;">
                                                </a><br>
                                                @endif
                                                <input type="file" name="document_image" class="form-control mt-2">
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Holding the document</th>
                                            <td>
                                                @if ($user->holding_document_image)
                                                <a href="{{ config('app.img_url'). $user->holding_document_image }}" target="_blank">
                                                    <img src="{{ config('app.img_url'). $user->holding_document_image }}" style="max-width: 150px;">
                                                </a><br>
                                                @endif
                                                <input type="file" name="holding_document_image" class="form-control mt-2">
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Holding a paper with website name and today’s date</th>
                                            <td>
                                                @if ($user->verify_age_document)
                                                <a href="{{ config('app.img_url'). $user->verify_age_document }}" target="_blank">
                                                    <img src="{{ config('app.img_url'). $user->verify_age_document }}" style="max-width: 150px;">
                                                </a><br>
                                                @endif
                                                <input type="file" name="verify_age_document" class="form-control mt-2">
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Recent Pictures Of Yourself</th>
                                            <td>
                                                @if ($user->identity_photos)
                                                @foreach (json_decode($user->identity_photos, true) as $photo)
                                                <img src="{{ config('app.img_url'). $photo }}" style="max-width: 150px; margin-right: 10px;">
                                                @endforeach
                                                @endif
                                                <input type="file" name="identity_photos[]" class="form-control mt-2" multiple>
                                            </td>
                                        </tr>
                                    </table>

                                    <button type="submit" class="btn btn-success mt-3">Save Changes</button>
                                </form>

                                <a href="{{ url()->previous() ?? route('admin.user') }}" class="btn btn-primary mt-3">Back</a>
                            </div>




                            <!-- Personal Details Tab -->
                            <div class="tab-pane fade" id="personal" role="tabpanel" aria-labelledby="personal-tab">
                                <form class="ajax-user-form" action="{{ route('admin.update-user', $user->id) }}" method="POST" enctype="multipart/form-data">

                                    @csrf
                                    @method('patch')
                                    <input type="hidden" value="{{$user->type}}" name="type">
                                    <input type="hidden" value="{{$user->id}}" name="id">
                                    <table class="table table-bordered">

                                        <tr>
                                            <th>Nickname</th>
                                            <td>
                                                <input type="text" name="nickname" class="form-control" value="{{ $user->nickname }}">
                                            </td>
                                        </tr>

                                        <tr>
                                            <th>Displayed Age</th>
                                            <td>
                                                <input type="number" name="displayed_age" class="form-control" value="{{ $user->displayed_age ?? \Carbon\Carbon::parse($user->dob)->age }}">
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Slogan</th>
                                            <td>
                                                <input type="text" name="slogan" class="form-control" value="{{ $user->slogan }}">
                                            </td>
                                        </tr>


                                        <tr>
                                            <th>Description</th>
                                            <td>
                                                <textarea name="description" class="form-control">{{ $user->description }}</textarea>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Country</th>
                                            <td>
                                                <select name="country_id" class="form-control phone_code" id="country_id" onchange="getStates(this.value)">
                                                    @foreach($countries as $country)
                                                    <option value="{{ $country->id }}" {{ $user->country_id == $country->id ? 'selected' : '' }}>
                                                        {{ $country->name }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>State</th>
                                            <td>
                                                <!-- {{ $user->state->name ?? '-' }} -->
                                                <select class="form-select phone_code" name="state_id" id="state_id" onchange="getCities(this.value)" data-selected="{{ $user->state_id }}">
                                                    <option value="">Select state</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>City</th>
                                            <td>
                                                <select class="form-select phone_code" name="city_id" id="city_id" data-selected="{{ $user->city_id }}">
                                                    <option value="">Select city</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Ethnicity</th>
                                            <td>
                                                <select name="ethnicity_id" class="form-control phone_code" id="ethnicity_id">
                                                    @foreach($ethnicity as $ethnicity)
                                                    <option value="{{ $ethnicity->id }}" {{ $user->ethnicity_id == $ethnicity->id ? 'selected' : '' }}>
                                                        {{ $ethnicity->name }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Body Type</th>
                                            <td>
                                                <select class="form-select" name="body_type_id">
                                                    <option value="">Select Body Type</option>
                                                    @foreach($bodyType as $item)
                                                    <option value="{{ $item->id }}" {{ $user->body_type_id == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Incall/Outcall</th>
                                            <td>
                                                <select class="form-select" name="incall_outcall">
                                                    <option value="1" {{ $user->outcall == 1 ? 'selected' : '' }}>incall</option>
                                                    <option value="0" {{ $user->outcall == 0 ? 'selected' : '' }}>outcall</option>
                                                    <option value="2" {{ $user->outcall == 2 ? 'selected' : '' }}>outcall + incall</option>
                                                </select>
                                            </td>
                                        </tr>
                                        @php
                                        $methods = ['WhatsApp', 'SMS', 'Telegram', 'Phone', 'Email', 'LINE', 'Signal'];
                                        $userContacts = json_decode($user->contact_methods ?? '{}', true);

                                        $hasContacts = count($userContacts ?? []) > 0;
                                        @endphp

                                        <tr>
                                            <th>Contact Methods</th>
                                            <td>
                                                <div class="row mx-0">
                                                    @foreach($methods as $method)
                                                    @php
                                                    $isChecked = $hasContacts ? (!empty($userContacts[$method])) : ($method === 'Phone');
                                                    $value = $userContacts[$method] ?? '';
                                                    @endphp
                                                    <div class="col-lg-6 mb-2">
                                                        <div class="form-check">
                                                            <input class="form-check-input me-2 contact-method-checkbox" type="checkbox"
                                                                id="chk_{{ $method }}"
                                                                data-method="{{ $method }}"
                                                                {{ $isChecked ? 'checked' : '' }}>

                                                            <label class="form-check-label me-2" for="chk_{{ $method }}">{{ $method }}</label>

                                                            <input type="text"
                                                                name="contact_methods[{{ $method }}]"
                                                                class="form-control form-control-sm contact-input"
                                                                placeholder="Enter {{ $method }} info"
                                                                value="{{ $value }}"
                                                                style="display: {{ $isChecked ? 'block' : 'none' }};">
                                                        </div>
                                                    </div>
                                                    @endforeach
                                                </div>
                                            </td>

                                        </tr>
                                        <tr>
                                            <th>Sex Location</th>
                                            <td>
                                                <select class="form-select" name="sex_location">
                                                    <option value="">Select Location Type</option>
                                                    <option value="Sex house" {{ $user->sex_location == 'Sex house' ? 'selected' : '' }}>Sex house</option>
                                                    <option value="Nightclub" {{ $user->sex_location == 'Nightclub' ? 'selected' : '' }}>Nightclub</option>
                                                    <option value="Massage House" {{ $user->sex_location == 'Massage House' ? 'selected' : '' }}>Massage House</option>
                                                    <option value="Agency" {{ $user->sex_location == 'Agency' ? 'selected' : '' }}>Agency</option>
                                                    <option value="Independent" {{ $user->sex_location == 'Independent' ? 'selected' : '' }}>Independent</option>
                                                </select>
                                            </td>
                                        </tr>
                                        @php
                                        $blockedCountryIds = json_decode($user->blocked_countries ?? '[]', true);
                                        $blockedCountries = $countryCodes->whereIn('id', $blockedCountryIds);
                                        @endphp

                                        <tr>
                                            <th>Block Specific Countries</th>
                                            <td>
                                                <select class="form-select select2-multiple" name="blocked_countries[]" multiple>
                                                    @foreach($countryCodes as $country)
                                                    <option value="{{ $country->id }}"
                                                        {{ in_array($country->id, json_decode($user->blocked_countries ?? '[]', true)) ? 'selected' : '' }}>
                                                        {{ $country->country }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </td>
                                        </tr>

                                        <tr>
                                            <th>Languages</th>
                                            <td>
                                                <select class="form-select select2-multiple" name="languages[]" multiple>
                                                    @foreach($language as $lang)
                                                    <option value="{{ $lang->id }}"
                                                        {{ in_array($lang->id, json_decode($user->languages ?? '[]', true)) ? 'selected' : '' }}>
                                                        {{ $lang->name }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Sexual Orientation</th>
                                            <td><select class="form-select" name="sexual_orientation">
                                                    <option value="">Select</option>
                                                    <option value="Heterosexual" {{ $user->sexual_orientation == 'Heterosexual' ? 'selected' : '' }}>Heterosexual</option>
                                                    <option value="Homosexual" {{ $user->sexual_orientation == 'Homosexual' ? 'selected' : '' }}>Homosexual</option>
                                                    <option value="Bisexual" {{ $user->sexual_orientation == 'Bisexual' ? 'selected' : '' }}>Bisexual</option>
                                                    <option value="Pansexual" {{ $user->sexual_orientation == 'Pansexual' ? 'selected' : '' }}>Pansexual</option>
                                                    <option value="Other" {{ $user->sexual_orientation == 'Other' ? 'selected' : '' }}>Other</option>
                                                </select></td>
                                        </tr>
                                        <tr>
                                            <th>Hair Color</th>
                                            <td> <select class="form-select" name="hair_color_id">
                                                    <option value="">Select Hair Color</option>
                                                    @foreach($hairColor as $item)
                                                    <option value="{{ $item->id }}" {{ $user->hair_color_id == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Hair Length</th>
                                            <td><select class="form-select" name="hair_length_id">
                                                    <option value="">Select Hair Length</option>
                                                    @foreach($hairLength as $item)
                                                    <option value="{{ $item->id }}" {{ $user->hair_length_id == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                                                    @endforeach
                                                </select></td>
                                        </tr>
                                        <tr>
                                            <th>Hair Type</th>
                                            <td><select class="form-select" name="hair_type_id">
                                                    <option value="">Select Hair Type</option>
                                                    @foreach($hairType as $item)
                                                    <option value="{{ $item->id }}" {{ $user->hair_type_id == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                                                    @endforeach
                                                </select></td>
                                        </tr>
                                        <tr>
                                            <th>Eye Color</th>
                                            <td><select class="form-select" name="eye_color_id">
                                                    <option value="">Select Eye Color</option>
                                                    @foreach($eyeColor as $item)
                                                    <option value="{{ $item->id }}" {{ $user->eye_color_id == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                                                    @endforeach
                                                </select></td>
                                        </tr>

                                        <tr>
                                            <th>Tattoos</th>
                                            <td><select class="form-select" name="tattoo">
                                                    <option value="">Select Option</option>
                                                    <option value="yes" {{ $user->tattoo == 'yes' ? 'selected' : '' }}>Yes</option>
                                                    <option value="no" {{ $user->tattoo == 'no' ? 'selected' : '' }}>No</option>
                                                </select></td>
                                        </tr>
                                        <tr>
                                            <th>Piercings</th>
                                            <td><select class="form-select" name="piercing">
                                                    <option value="">Select Option</option>
                                                    <option value="yes" {{ $user->piercing == 'yes' ? 'selected' : '' }}>Yes</option>
                                                    <option value="no" {{ $user->piercing == 'no' ? 'selected' : '' }}>No</option>
                                                </select></td>
                                        </tr>
                                        <tr>
                                            <th>Smoking</th>
                                            <td> <select class="form-select" name="smoking">
                                                    <option value="">Select Option</option>
                                                    <option value="yes" {{ $user->smoking == 'yes' ? 'selected' : '' }}>Yes</option>
                                                    <option value="no" {{ $user->smoking == 'no' ? 'selected' : '' }}>No</option>
                                                </select></td>
                                        </tr>
                                        <tr>
                                            <th>PubicHair</th>
                                            <td><select class="form-select" name="pubic_hair_id">
                                                    <option value="">Select Option</option>
                                                    @foreach($pubicHair as $item)
                                                    <option value="{{ $item->id }}" {{ $user->pubic_hair_id == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                                                    @endforeach
                                                </select></td>
                                        </tr>
                                        <tr>
                                            <th>Height (cm)</th>
                                            <td> <input type="number" class="form-control" name="height_cm" value="{{ $user->height_cm }}" min="50" max="220">
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Weight (kg)</th>
                                            <td><select class="form-select" name="weight_kg">
                                                    <option value="">Select Weight</option>
                                                    @for ($i = 30; $i <= 150; $i++)
                                                        <option value="{{ $i }}" {{ $user->weight_kg == $i ? 'selected' : '' }}>{{ $i }} kg</option>
                                                        @endfor
                                                </select></td>
                                        </tr>


                                        <tr>
                                            <th>Shoe Size</th>
                                            <td> <select class="form-control" name="shoe_size">
                                                    <option value="">Select Shoe Size</option>
                                                    @for ($i = 24; $i <= 46; $i++)
                                                        <option value="{{ $i }}" {{ $user->shoe_size == $i ? 'selected' : '' }}>{{ $i }}</option>
                                                        @endfor
                                                </select></td>
                                        </tr>

                                        <tr>
                                            <th>Breast Size</th>
                                            <td>
                                                @php
                                                $breastSizes = [
                                                'A - Natural', 'A - Enhanced',
                                                'B - Natural', 'B - Enhanced',
                                                'C - Natural', 'C - Enhanced',
                                                'D - Natural', 'D - Enhanced',
                                                'DD - Natural', 'DD - Enhanced',
                                                'E+ - Natural', 'E+ - Enhanced'
                                                ];

                                                $selectedSizes = json_decode($user->breast_size ?? '[]', true);
                                                @endphp

                                                <select class="form-select select2-multiple" name="breast_size[]" multiple>
                                                    @foreach($breastSizes as $size)
                                                    <option value="{{ $size }}" {{ in_array($size, $selectedSizes) ? 'selected' : '' }}>
                                                        {{ $size }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>OnlyFans</th>
                                            <td>
                                                <input type="url" class="form-control" name="onlyfans_link" value="{{ $user->onlyfans_link }}" placeholder="https://onlyfans.com/yourname">
                                            </td>
                                        </tr>

                                        <tr>
                                            <th>Instagram</th>
                                            <td>
                                                <input type="url" class="form-control" name="instagram_link" value="{{ $user->instagram_link }}" placeholder="https://instagram.com/yourname">

                                            </td>
                                        </tr>

                                        <tr>
                                            <th>Telegram</th>
                                            <td>
                                                <input type="url" class="form-control" name="telegram_link" value="{{ $user->telegram_link }}" placeholder="https://t.me/yourusername">

                                            </td>
                                        </tr>

                                        <tr>
                                            <th>TikTok</th>
                                            <td>
                                                <input type="url" class="form-control" name="tiktok_link" value="{{ $user->tiktok_link }}" placeholder="https://www.tiktok.com/@yourusername">

                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Services</th>
                                            <td>
                                                @foreach ($categories as $category)
                                                <h6 class="fw-bold mt-2">{{ $category->name }}</h6>
                                                <div class="d-flex flex-wrap gap-2">
                                                    @foreach ($category->services as $service)
                                                    <div class="col-12 mb-1 p-2 border">
                                                        @if ($service->selections->isEmpty())
                                                        {{-- Service with NO selections --}}
                                                        <div class="form-check">
                                                            <input type="checkbox"
                                                                class="form-check-input"
                                                                name="services[{{ $service->id }}]"
                                                                id="service-{{ $service->id }}"
                                                                value="1"
                                                                {{ in_array($service->id, $selectedServices ?? []) ? 'checked' : '' }}>
                                                            <label class="form-check-label fw-bold" for="service-{{ $service->id }}">
                                                                {{ $service->name }}
                                                            </label>
                                                        </div>
                                                        @else
                                                        @php
                                                        $isRadioGroup = $service->selections->first()->input_type === 'radio';
                                                        $radioGroupName = $isRadioGroup ? 'selections_group[' . $service->id . ']' : null;
                                                        @endphp
                                                        {{-- Service WITH selections --}}
                                                        <div class="fw-bold">{{ $service->name }}</div>
                                                        <div class="ms-3">
                                                            @foreach ($service->selections as $selection)
                                                            <div class="form-check">
                                                                <input
                                                                    type="{{ $selection->input_type === 'radio' ? 'radio' : 'checkbox' }}"
                                                                    class="form-check-input"
                                                                    name="{{ $selection->input_type === 'radio' ? $radioGroupName : 'selections[' . $selection->id . ']' }}"
                                                                    id="selection-{{ $selection->id }}"
                                                                    value="{{ $selection->id }}"
                                                                    {{ in_array($selection->id, $selectedSelections ?? []) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="selection-{{ $selection->id }}">
                                                                    {{ $selection->name }}
                                                                </label>
                                                            </div>
                                                            @endforeach
                                                        </div>
                                                        @endif
                                                    </div>
                                                    @endforeach
                                                </div>
                                                @endforeach
                                            </td>


                                        </tr>




                                    </table>
                                    <button type="submit" class="btn btn-success mt-3">Save Changes</button>
                                </form>
                                <a href="{{ url()->previous() ?? route('admin.user') }}" class="btn btn-primary mt-3">Back</a>

                            </div>
                            <div class="tab-pane fade" id="photos" role="tabpanel" aria-labelledby="photos-tab">
                                <form method="POST" id="EditProfile" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" value="{{ $user->id }}" name="id">

                                    <table class="table table-bordered">
                                        <tr>
                                            <th>Add Photos</th>
                                            <td>
                                                <input type="file" name="images[]" id="image" accept="image/*" multiple class="choose_photo">
                                                <span class="text-danger" id="imageError"></span>

                                                <!-- New image preview -->
                                                <div class="form-group mt-3 d-flex flex-wrap gap-2" id="image-preview-container"></div>
                                            </td>
                                        </tr>

                                        <tr>
                                            <th>Uploaded Images</th>
                                            <td>
                                                <div id="existing-photos" class="d-flex flex-wrap gap-2">
                                                    @if ($uploadedPhotos->isNotEmpty())
                                                    @foreach ($uploadedPhotos as $photo)
                                                    <div class="position-relative d-inline-block me-2 mb-2 uploaded-images" data-photo-id="{{ $photo->id }}">
                                                        <a href="{{ config('app.img_url'). $photo->file_path }}" data-lightbox="document">
                                                            <img src="{{ config('app.img_url'). $photo->file_path }}" width="100" class="border rounded">
                                                        </a>
                                                        <span class="remove-existing text-danger" data-id="{{ $photo->id }}" style="cursor: pointer; position: absolute; top: 0; right: 5px; font-size: 20px;">&times;</span>
                                                    </div>
                                                    @endforeach
                                                    @else
                                                    <span class="text-muted">No Images uploaded</span>
                                                    @endif
                                                </div>
                                                <input type="hidden" name="removed_images" id="removedImages">
                                            </td>
                                        </tr>
                                    </table>

                                    <button type="submit" class="btn btn-success mt-3" id="uploadBtn" disabled>Save Changes</button>
                                </form>

                                <a href="{{ url()->previous() ?? route('admin.user') }}" class="btn btn-primary mt-3">Back</a>

                            </div>
                            <div class="tab-pane fade" id="videos" role="tabpanel" aria-labelledby="videos-tab">
                                <form method="POST" id="VideoUploadForm" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" value="{{ $user->id }}" name="id">

                                    <table class="table table-bordered">
                                        <tr>
                                            <th>Add Videos</th>
                                            <td>
                                                <input type="file" name="videos[]" id="videoInput" accept="video/*" multiple>
                                                <span class="text-danger" id="videoError"></span>

                                                <!-- New video preview -->
                                                <div class="form-group mt-3 d-flex flex-wrap gap-2" id="video-preview-container"></div>
                                            </td>
                                        </tr>

                                        <tr>
                                            <th>Uploaded Videos</th>
                                            <td>
                                                <div id="existing-videos" class="d-flex flex-wrap gap-2">
                                                    @if ($uploadedVideos->isNotEmpty())
                                                    @foreach ($uploadedVideos as $video)
                                                    <div class="position-relative d-inline-block me-2 mb-2 uploaded-videos" data-video-id="{{ $video->id }}">
                                                        <a href="{{ config('app.img_url'). $video->file_path }}" class="glightbox" data-type="video">
                                                            <video width="110" height="110" class="border rounded">
                                                                <source src="{{ config('app.img_url'). $video->file_path }}" type="video/mp4">
                                                                Your browser does not support the video tag.
                                                            </video>
                                                        </a>
                                                        <span class="remove-video-existing text-danger bg-white px-1"
                                                            data-id="{{ $video->id }}"
                                                            style="cursor: pointer; position: absolute; top: 0; right: 5px; font-size: 20px;">
                                                            &times;
                                                        </span>
                                                    </div>
                                                    @endforeach
                                                    @else
                                                    <span class="text-muted">No Videos uploaded</span>
                                                    @endif
                                                </div>

                                                <input type="hidden" name="removed_videos" id="removedVideos">
                                            </td>
                                        </tr>
                                    </table>

                                    <button type="submit" class="btn btn-success mt-3" id="uploadVideoBtn" disabled>Save Changes</button>
                                </form>

                                <a href="{{ url()->previous() ?? route('admin.user') }}" class="btn btn-primary mt-3">Back</a>
                            </div>

                            <div class="tab-pane fade" id="availablity" role="tabpanel" aria-labelledby="availablity-tab">
                                <form id="availabilityForm" method="POST" action="{{ route('admin.availability.save') }}">

                                    @csrf
                                    <input type="hidden" name="user_id" value="{{ $user->id }}">

                                    <h5 class="mb-3"><strong>Edit Availability</strong></h5>

                                    @php
                                    $availabilityMain = $user->availability_main ?? 'appointment';
                                    $walkinTypes = json_decode($user->walkin_type) ?? [];
                                    $isOnline = $user->is_online ?? 0;
                                    $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
                                    @endphp

                                    <!-- Availability Mode -->
                                    <div class="mb-3">
                                        <label><strong>Availability Mode:</strong></label><br>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="availability_main" value="appointment"
                                                onclick="toggleWalkinOptions()" {{ $availabilityMain === 'appointment' ? 'checked' : '' }}>
                                            <label class="form-check-label">Available with appointment</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="availability_main" value="walk-in"
                                                onclick="toggleWalkinOptions()" {{ $availabilityMain === 'walk-in' ? 'checked' : '' }}>
                                            <label class="form-check-label">Available without appointment</label>
                                        </div>
                                    </div>

                                    <!-- Walk-in Options -->
                                    <div id="walkinOptions" style="{{ $availabilityMain === 'walk-in' ? '' : 'display: none;' }}">
                                        <label><strong>Walk-in Options:</strong></label><br>
                                        <div class="form-check form-check-inline">
                                            <input type="checkbox" class="form-check-input me-1 contactsss-method-checkbox"
                                                name="walkin_type[]" value="accepted"
                                                {{ in_array('accepted', $walkinTypes) ? 'checked' : '' }}>

                                            <label class="form-check-label">Walk-ins accepted</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" name="walkin_type[]" value="on_demand"
                                                {{ in_array('on_demand', $walkinTypes) ? 'checked' : '' }}>
                                            <label class="form-check-label">On-demand</label>
                                        </div>
                                    </div>

                                    <!-- Online Toggle -->
                                    <div class="mt-3">
                                        <label><strong>Available Now:</strong></label><br>
                                        <input type="hidden" name="is_online" value="0">
                                        <input type="checkbox" id="is_online" name="is_online" value="1"
                                            {{ $isOnline ? 'checked' : '' }} onchange="updateAvailabilityStatus(this)">
                                        <span id="availabilityStatus">{{ $isOnline ? 'Online' : 'Offline' }}</span>
                                        <span id="availabilityStatusLabel" class="ms-2 badge {{ $isOnline ? 'bg-success' : 'bg-secondary' }}">
                                            {{ $isOnline ? 'Yes' : 'No' }}
                                        </span>
                                    </div>

                                    <!-- Weekly Schedule -->
                                    <hr>
                                    <h5 class="mt-4 mb-3">Weekly Schedule</h5>
                                    <div class="form-check mb-3">
                                        @foreach($days as $day)
                                        @php $dayLower = strtolower($day); @endphp
                                        <input type="checkbox" class="form-check-input me-1 contactsss-method-checkbox" id="chk_{{ $day }}"
                                            name="availability[]" value="{{ $day }}" data-method="{{ $day }}"
                                            {{ isset($availabilityByDay[$dayLower]) ? 'checked' : '' }}>
                                        <label class="form-check-label me-3" for="chk_{{ $day }}">{{ $day }}</label>
                                        @endforeach
                                    </div>

                                    <div id="time-slots-container">
                                        @foreach($availabilityByDay ?? [] as $day => $times)
                                        <div class="mb-3 time-slot day-slot" data-day="{{ $day }}" id="time-slot-{{ $day }}">
                                            <label class="form-label text-capitalize">{{ $day }} Time Slot:</label>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    @php
                                                    $allDay = isset($times['all_day']) && $times['all_day'];
                                                    @endphp
                                                    <select name="availability[{{ $day }}][start]" class="form-select start-time" {{ $allDay ? 'disabled' : '' }} required>
                                                        <option value="">Start Time</option>
                                                        @foreach (range(0, 47) as $i)
                                                        @php
                                                        $timeValue = date('h:i A', strtotime("00:00") + $i * 30 * 60);
                                                        $savedStart = isset($times['start']) ? date('h:i A', strtotime($times['start'])) : '';
                                                        @endphp
                                                        <option value="{{ $timeValue }}" {{ $timeValue == $savedStart ? 'selected' : '' }}>
                                                            {{ $timeValue }}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <select name="availability[{{ $day }}][end]" class="form-select end-time" {{ $allDay ? 'disabled' : '' }} required>
                                                        <option value="">End Time</option>
                                                        @foreach (range(0, 47) as $i)
                                                        @php
                                                        $timeValue = date('h:i A', strtotime("00:00") + $i * 30 * 60);
                                                        $savedEnd = isset($times['end']) ? date('h:i A', strtotime($times['end'])) : '';
                                                        @endphp
                                                        <option value="{{ $timeValue }}" {{ $timeValue == $savedEnd ? 'selected' : '' }}>
                                                            {{ $timeValue }}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="row mt-2">
                                                    <div class="col-12">
                                                        <div class="form-check">
                                                            <input class="form-check-input all-day-checkbox" type="checkbox" id="all_day_{{ $day }}" {{ $allDay ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="all_day_{{ $day }}">All Day</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>

                                    <button type="submit" id="saveAvailabilityBtn" class="btn btn-success mt-4">Save Changes</button>
                                </form>

                                <a href="{{ url()->previous() ?? route('admin.user') }}" class="btn btn-primary mt-3">Back</a>
                            </div>

                            <!-- Rates Tab -->
                            <div class="tab-pane fade" id="rate" role="tabpanel" aria-labelledby="rate-tab">
                                <h5 class="mb-3"><strong>Quickie Service Settings</strong></h5>
                                <form id="quickieForm" method="POST" action="{{ route('admin.rate.save') }}">
                                    @csrf
                                    <input type="hidden" name="user_id" value="{{ $user->id }}">
                                    <div class="p-5 mx-lg-0 mx-md-0 mx-2 setavailabilty-main">
                                        <div class="row">
                                            <!-- Toggle Quickie Service -->
                                            <div class="mb-4 col-12">
                                                <label><strong>Offer Quickie Service?</strong></label><br>
                                                <div class="d-flex radioinputsbtn">
                                                    <div class="d-flex chkboxbtns me-3">
                                                        <input type="radio" name="quickie_enabled" value="1" onclick="toggleQuickieSection(true)" {{ old('quickie_enabled', $user->quickie_enabled) == 1 ? 'checked' : '' }}> Yes
                                                    </div>
                                                    <div class="d-flex chkboxbtns">
                                                        <input type="radio" name="quickie_enabled" value="0" onclick="toggleQuickieSection(false)" {{ old('quickie_enabled', $user->quickie_enabled) == 0 ? 'checked' : '' }}> No
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div id="quickieRatesSection">
                                            <div class="row">
                                                <div class="mb-2 col-6" id="quickiePriceWrapper">
                                                    <label for="price">Price:</label>
                                                    <input type="number" min="0" class="form-control" name="quickie_price" value="{{ old('quickie_price', $user->quickie_price ?? '') }}">
                                                </div>
                                                <!-- Currency Selector -->
                                                <div class="mb-3 col-6">
                                                    <label for="quickie_currency"><strong>Select Currency:</strong></label>
                                                    <select name="quickie_currency" id="quickie_currency" class="form-select">
                                                        @foreach($currency as $currency)
                                                        <option value="{{$currency}}" {{ old('quickie_currency', $user->quickie_currency) == $currency ? 'selected' : '' }}>{{$currency}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                @php
                                                $durations = ['30_min' => '30 Minutes', '1_hr' => '1 Hour', '90_min' => '90 Minutes', '2_hr' => '2 Hours', '3_hr' => '3 Hours','24h' => '24 Hours'];
                                                @endphp

                                                @foreach ($durations as $key => $label)
                                                <div class="mb-2 col-6">
                                                    <label for="quickie_{{ $key }}">{{ $label }}:</label>
                                                    <input type="number" step="0.01" min="0" class="form-control" name="quickie_rates[{{ $key }}]"
                                                        value="{{ old('quickie_rates.' . $key, $user->quickie_rates[$key] ?? '') }}">
                                                </div>
                                                @endforeach

                                                <!-- Overnight Price -->
                                                <div class="mb-2 col-6">
                                                    <label for="quickie_overnight_price">Overnight Price:</label>
                                                    <input type="number" step="0.01" min="0" class="form-control" name="quickie_rates[overnight]" value="{{ old('quickie_rates.overnight', $user->quickie_rates['overnight'] ?? '') }}">
                                                </div>

                                                <!-- Overnight Hours -->
                                                <div class="mb-2 col-6">
                                                    <label for="quickie_overnight_hours">Overnight Duration (in hours):</label>
                                                    <select class="form-select" id="quickie_overnight_hours" name="quickie_overnight_hours">
                                                        @for ($i = 1; $i <= 12; $i++)
                                                            <option value="{{ $i }}" {{ old('quickie_overnight_hours', $user->quickie_overnight_hours ?? '') == $i ? 'selected' : '' }}>
                                                            {{ $i }} {{ Str::plural('hour', $i) }}
                                                            </option>
                                                            @endfor
                                                    </select>
                                                </div>

                                                <!-- Payment Method -->
                                                <div class="mb-2 col-6">
                                                    @php
                                                    $selectedMethods = old('payment_method', json_decode($user->payment_method, true) ?? []);
                                                    @endphp
                                                    <label for="payment_method"><strong>Select Payment Method(s):</strong></label>
                                                    <select name="payment_method[]" id="payment_method" class="form-select select2-multiple" multiple>
                                                        <option value="cash" {{ in_array('cash', $selectedMethods) ? 'selected' : '' }}>Cash</option>
                                                        <option value="transfer" {{ in_array('transfer', $selectedMethods) ? 'selected' : '' }}>Transfer</option>
                                                        <option value="crypto" {{ in_array('crypto', $selectedMethods) ? 'selected' : '' }}>Crypto</option>
                                                        <option value="card terminal" {{ in_array('card terminal', $selectedMethods) ? 'selected' : '' }}>Card Terminal</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Save Button -->
                                        <div class="row">
                                            <div class="mt-4 col-12">
                                                <button type="submit" class="btn btn-maincolor" id="saveQuickieSettings">Save</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
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
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        console.log('sdfnsdkjf');
        const input = document.getElementById('quickie_overnight_hours');
        console.log(input);
        input.addEventListener('input', function() {
            if (parseInt(this.value) > 12) {
                this.value = 12;
            } else if (parseInt(this.value) < 1) {
                this.value = 1;
            }
        });
    });
    document.querySelectorAll('.contact-method-checkbox').forEach(function(checkbox) {
        checkbox.addEventListener('change', function() {
            const method = this.dataset.method;
            const input = this.closest('.form-check').querySelector('.contact-input');
            input.style.display = this.checked ? 'block' : 'none';
            if (!this.checked) input.value = '';
        });
    });

    function getStates(countryId, callback) {
        if (!countryId) {
            $('#state_id').html('<option value="">Select state</option>');
            $('#city_id').html('<option value="">Select city</option>');
            return;
        }

        let url = `{{ route('getstates', ':id') }}`.replace(':id', countryId);

        $.ajax({
            url: url,
            type: 'GET',
            success: function(res) {
                let selectedStateId = $('#state_id').data('selected');
                let options = '<option value="">Select state</option>';
                res.forEach(state => {
                    options += `<option value="${state.id}" ${selectedStateId == state.id ? 'selected' : ''}>${state.name}</option>`;
                });
                $('#state_id').html(options);

                if (typeof callback === 'function') {
                    callback(selectedStateId);
                }
            }
        });
    }

    function getCities(stateId, callback) {
        console.log(stateId);
        if (!stateId) {
            $('#city_id').html('<option value="">Select city</option>');
            return;
        }

        let url = `{{ route('getcities', ':id') }}`.replace(':id', stateId);

        $.ajax({
            url: url,
            type: 'GET',
            success: function(res) {
                let selectedCityId = $('#city_id').data('selected');
                let options = '<option value="">Select city</option>';
                res.forEach(city => {
                    options += `<option value="${city.id}" ${selectedCityId == city.id ? 'selected' : ''}>${city.name}</option>`;
                });
                $('#city_id').html(options);

                if (typeof callback === 'function') {
                    callback();
                }
            }
        });
    }

    // Call on page load if country is preselected

    $(document).ready(function() {
        const countryId = $('#country_id').val();
        if (countryId) {
            getStates(countryId, function(stateId) {
                if (stateId) {
                    getCities(stateId);
                }
            });
        }
        $('.phone_code').select2({
            allowClear: true
        });
        $('.select2-multiple').select2({
            placeholder: "Select options",
            allowClear: true,
            width: '100%'
        });
        $('.ajax-user-form').on('submit', function(e) {
            e.preventDefault();

            let form = $(this)[0];
            let formData = new FormData(form);
            let $submitBtn = $(this).find('button[type="submit"]');

            $.ajax({
                url: form.action,
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    $submitBtn.prop('disabled', true).text('Saving...');
                },
                success: function(response) {
                    if (response.status === 1) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.message || 'User updated successfully.',
                            confirmButtonColor: '#3085d6'
                        }).then(() => {
                            window.location.reload();
                        });
                    } else {
                        alert(response.message || 'Something went wrong.');
                        $submitBtn.prop('disabled', false).text('Save Changes');
                    }

                },
                error: function(xhr) {
                    $submitBtn.prop('disabled', false).text('Save Changes');

                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        let message = '';
                        $.each(errors, function(key, value) {
                            message += value[0] + '\n';
                        });
                        alert(message);
                    } else {
                        alert('An error occurred while updating the user.');
                    }
                }
            });
        });

    });

    let removedImageIds = [];

    $(document).on('click', '.remove-existing', function() {
        const id = $(this).data('id');

        Swal.fire({
            title: "Are you sure?",
            text: "Do you really want to delete this image?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.isConfirmed) {
                // Send AJAX request to update database
                $.ajax({
                    url: "{{ route('admin.photo.delete') }}",
                    type: "POST",
                    data: {
                        _token: '{{ csrf_token() }}',
                        image_id: id
                    },
                    success: function(response) {
                        // Track removed ID and update hidden input
                        removedImageIds.push(id);
                        $('#removedImages').val(removedImageIds.join(','));

                        // Remove from UI
                        $(`[data-photo-id="${id}"]`).remove();

                        // Show fallback message if no photos left
                        if ($('#existing-photos').find('[data-photo-id]').length === 0) {
                            $('#existing-photos').html('<p class="text-muted">No photo is uploaded.</p>');
                        }

                        Swal.fire(
                            'Deleted!',
                            'Image deleted successfully.',
                            'success'
                        );
                    },
                    error: function(xhr) {
                        Swal.fire(
                            'Error!',
                            'Failed to delete image. Please try again.',
                            'error'
                        );
                    }
                });
            }
        });
    });


    let previewImages = []; // Holds all selected files
    let imageIndex = 0; // Unique index for each image

    $('#image').on('change', function(e) {
        const files = e.target.files;

        if (files.length > 0) {
            $('#uploadBtn').prop('disabled', false);
        }

        Array.from(files).forEach((file) => {
            previewImages.push(file);

            const reader = new FileReader();
            const currentIndex = imageIndex; // Capture index before it increments

            reader.onload = function(e) {
                const preview = $(`
                <div class="position-relative d-inline-block me-2 mb-2" data-index="${currentIndex}">
                    <img src="${e.target.result}" width="100" class="border rounded">
                    <span class="position-absolute top-0 end-0 text-danger bg-white px-1 remove-preview" data-index="${currentIndex}" style="cursor: pointer;">&times;</span>
                </div>
            `);
                $('#image-preview-container').append(preview);
            };
            reader.readAsDataURL(file);
            imageIndex++; // Increment after assigning
        });

        // Reset input to allow same file re-selection again if needed
        $('#image').val('');
    });

    // Remove selected image
    $(document).on('click', '.remove-preview', function() {
        const index = $(this).data('index');

        // Mark the div for this image index and remove it from array
        previewImages[index] = null; // Mark as null to keep indices aligned
        $(this).parent().remove();

        // Disable button if no valid image remains
        if (!previewImages.some(file => file !== null)) {
            $('#uploadBtn').prop('disabled', true);
        }
    });


    $('#EditProfile').on('submit', function(e) {
        e.preventDefault();

        const formData = new FormData();
        previewImages.forEach((file) => {
            if (file !== null) {
                formData.append('images[]', file);
            }
        });
        formData.append('_token', '{{ csrf_token() }}');
        const userId = $('input[name="id"]').val();
        formData.append('id', userId);
        $.ajax({
            url: "{{ route('admin.photos.upload') }}",
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            beforeSend: function() {
                $('#uploadBtn').prop('disabled', true).text('Uploading...');
            },
            success: function(response) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: 'Photos uploaded successfully!',
                    confirmButtonColor: '#3085d6'
                }).then(() => {
                    location.reload();
                });
            },
            error: function(xhr) {
                Swal.fire({
                    icon: 'error',
                    title: 'Upload Failed',
                    text: 'Failed to upload photos. Please try again.',
                    confirmButtonColor: '#d33'
                });

                $('#uploadBtn').prop('disabled', false).text('Upload Photos');
            }
        });
    });
    let removedVideoIds = [];

    $(document).on('click', '.remove-video-existing', function() {
        const id = $(this).data('id');

        Swal.fire({
            title: 'Delete this video?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                // Show loading state
                Swal.fire({
                    title: 'Deleting...',
                    text: 'Please wait',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                // AJAX call to delete from DB
                $.ajax({
                    url: "{{ route('admin.video.delete') }}",
                    type: "POST",
                    data: {
                        _token: '{{ csrf_token() }}',
                        video_id: id
                    },
                    success: function(response) {
                        removedVideoIds.push(id);
                        $('#removedVideos').val(removedVideoIds.join(','));

                        $(`[data-video-id="${id}"]`).remove();

                        if ($('#existing-videos').find('[data-video-id]').length === 0) {
                            $('#existing-videos').html('<p class="text-muted">No Video is uploaded.</p>');
                        }

                        Swal.fire({
                            icon: 'success',
                            title: 'Deleted!',
                            text: 'Video has been removed.',
                            timer: 1500,
                            showConfirmButton: false
                        });

                        // Optional: refresh UI after delay
                        setTimeout(() => location.reload(), 1500);
                    },
                    error: function() {
                        Swal.fire('Error!', 'Failed to delete video. Please try again.', 'error');
                    }
                });
            }
        });
    });

    let previewVideos = [];
    let videoIndex = 0;

    // Enable preview and track selected videos
    $('#videoInput').on('change', function(e) {
        const files = e.target.files;
        let isValid = true;

        Array.from(files).forEach((file) => {
            if (file.size > 5 * 1024 * 1024) {
                isValid = false;
            }
        });

        if (!isValid) {
            $('#videoError').text('Each video must be 5MB or smaller.');
            $('#uploadVideoBtn').prop('disabled', true);
            this.value = '';
            return;
        }

        $('#videoError').text('');
        $('#uploadVideoBtn').prop('disabled', false);

        Array.from(files).forEach((file) => {
            const currentIndex = videoIndex;
            previewVideos.push(file);

            const reader = new FileReader();
            reader.onload = function(event) {
                const videoPreview = $(`
                <div class="position-relative d-inline-block me-2 mb-2" data-index="${currentIndex}">
                    <video width="110" height="110" controls class="border rounded">
                        <source src="${event.target.result}" type="${file.type}">
                        Your browser does not support the video tag.
                    </video>
                    <span class="position-absolute top-0 end-0 text-danger bg-white px-1 remove-video" data-index="${currentIndex}" style="cursor:pointer;">&times;</span>
                </div>
            `);
                $('#video-preview-container').append(videoPreview);
            };
            reader.readAsDataURL(file);

            videoIndex++;
        });

        $('#videoInput').val('');
    });


    // Remove selected video
    $(document).on('click', '.remove-video', function() {
        const index = $(this).data('index');
        previewVideos[index] = null;
        $(this).parent().remove();

        if (!previewVideos.some(file => file !== null)) {
            $('#uploadVideoBtn').prop('disabled', true);
        }
    });


    // Submit via AJAX
    $('#VideoUploadForm').on('submit', function(e) {
        e.preventDefault();

        const formData = new FormData();
        previewVideos.forEach(file => {
            if (file !== null) {
                formData.append('videos[]', file);
            }
        });
        formData.append('_token', '{{ csrf_token() }}');
        const userId = $('input[name="id"]').val();
        formData.append('id', userId);
        $.ajax({
            url: "{{ route('admin.videos.upload') }}", // <-- Ensure this route exists
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            beforeSend: function() {
                $('#uploadVideoBtn').prop('disabled', true).text('Uploading...');
            },
            success: function(response) {
                Swal.fire('Success', response.message, 'success');
                location.reload();
            },
            error: function() {
                Swal.fire('Error', 'Failed to upload videos.', 'error');
                $('#uploadVideoBtn').prop('disabled', false).text('Upload Videos');
            }
        });
    });
</script>
<script>
    function toggleWalkinOptions() {
        const selected = document.querySelector('input[name="availability_main"]:checked').value;
        const walkinDiv = document.getElementById('walkinOptions');

        if (selected === 'walk-in') {
            walkinDiv.style.display = 'block';
        } else {
            walkinDiv.style.display = 'none';
            // Optional: Uncheck the walk-in checkboxes when switching back
            walkinDiv.querySelectorAll('input[type="checkbox"]').forEach(cb => cb.checked = false);
        }
    }

    // Run on page load in case "walk-in" is preselected
    window.onload = toggleWalkinOptions;
</script>

<script>
    $(document).on('change', '.all-day-checkbox', function() {
        const container = $(this).closest('.time-slot');
        const isChecked = $(this).is(':checked');

        const startSelect = container.find('.start-time');
        const endSelect = container.find('.end-time');

        if (isChecked) {
            startSelect.val('').prop('disabled', true);
            endSelect.val('').prop('disabled', true);
        } else {
            startSelect.prop('disabled', false);
            endSelect.prop('disabled', false);
        }
    });
    const generateTimeOptions = () => {
        const times = [];
        const start = new Date();
        start.setHours(0, 0, 0, 0);
        for (let i = 0; i < 48; i++) {
            const time = new Date(start.getTime() + i * 30 * 60 * 1000);
            const label = time.toLocaleTimeString([], {
                hour: '2-digit',
                minute: '2-digit'
            });
            times.push(label);
        }
        return times;
    };

    const timeOptions = generateTimeOptions();

    $(document).on('change', '.contactsss-method-checkbox', function() {
        const day = $(this).data('method').toLowerCase();
        const container = $('#time-slots-container');
        if ($(this).is(':checked')) {
            if ($(`#time-slot-${day}`).length === 0) {
                const timeSlotHTML = `
                <div class="mb-3 time-slot day-slot" data-day="${day}" id="time-slot-${day}">
                  <div class="col-12">
                    <label class="form-label text-capitalize">${day} Time Slot:</label>
                    </div>
                    <div class="row mx-0 timeslotinput">
                        <div class="col-md-6">

                            <select name="availability[${day}][start]" class="form-select start-time" required>
                                <option value="">Start Time</option>
                                ${timeOptions.map(t => `<option value="${t}">${t}</option>`).join('')}
                            </select>
                        </div>
                       <div class="col-md-6">
                            <select name="availability[${day}][end]" class="form-select end-time" required>
                                <option value="">End Time</option>
                                ${timeOptions.map(t => `<option value="${t}">${t}</option>`).join('')}
                            </select>
                       </div>
                        <div class="row mt-2">
                        <div class="col-12">
                            <div class="form-check">
                                <input class="form-check-input all-day-checkbox" type="checkbox" id="all_day_${day}">
                                <label class="form-check-label" for="all_day_${day}">All Day</label>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
            `;
                container.append(timeSlotHTML);
            }
        } else {
            $(`#time-slot-${day}`).remove();
        }
    });

    $('#availabilityForm').on('submit', function(e) {


        e.preventDefault();

        const availability = {};
        let valid = true;
        $('.day-slot').each(function() {
            const day = $(this).data('day'); // e.g., 'tuesday'
            const isAllDay = $(this).find(`#all_day_${day}`).is(':checked');

            let start = null;
            let end = null;
            if (!isAllDay) {
                start = $(this).find('.start-time').val();
                end = $(this).find('.end-time').val();

                const parseTime = timeStr => {
                    const [time, modifier] = timeStr.split(' ');
                    let [hours, minutes] = time.split(':');
                    hours = parseInt(hours);
                    minutes = parseInt(minutes);
                    if (modifier === 'PM' && hours !== 12) hours += 12;
                    if (modifier === 'AM' && hours === 12) hours = 0;
                    return {
                        hours,
                        minutes
                    };
                };

                if (start && end) {
                    const startTime = parseTime(start);
                    const endTime = parseTime(end);

                    if (
                        endTime.hours < startTime.hours ||
                        (endTime.hours === startTime.hours && endTime.minutes <= startTime.minutes)
                    ) {
                        valid = false;
                        Swal.fire({
                            icon: 'error',
                            title: 'Invalid Time',
                            text: `End time must be after start time for ${day.charAt(0).toUpperCase() + day.slice(1)}.`,
                        });
                        return false; // exit each loop
                    }
                } else {
                    // Require start and end only if not all day
                    valid = false;
                    Swal.fire({
                        icon: 'warning',
                        title: 'Missing Time',
                        text: `Please select both start and end time for ${day.charAt(0).toUpperCase() + day.slice(1)}.`,
                    });
                    return false;
                }
            }

            if (!availability[day]) availability[day] = [];
            availability[day].push({
                start: start,
                end: end,
                all_day: isAllDay ? 1 : 0
            });
        });
        if (!valid) return;
        const availability_main = $('input[name="availability_main"]:checked').val();
        const walkin_type = [];
        $('input[name="walkin_type[]"]:checked').each(function() {
            walkin_type.push($(this).val());
        });
        const is_online = $('#is_online').is(':checked') ? 1 : 0;
        $.ajax({
            url: "{{ route('admin.availability.save') }}",
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                availability: availability,
                availability_main: availability_main,
                walkin_type: walkin_type,
                is_online: is_online,
                user_id: '{{ $user->id }}'
            },
            beforeSend: function() {
                $('#saveAvailabilityBtn').text('Saving...').prop('disabled', true);
            },
            success: function(response) {
                Swal.fire('Success', response.message, 'success');
                $('#saveAvailabilityBtn').text('Save Availability').prop('disabled', false);
                window.location.reload();
            },
            error: function() {
                Swal.fire('Error', 'Something went wrong.', 'error');
                $('#saveAvailabilityBtn').text('Save Availability').prop('disabled', false);
            }
        });
    });
    $('#quickieForm').on('submit', function(e) {
        console.log('sdkjfdskjf');
        e.preventDefault();
        const saveButton = document.getElementById('saveQuickieSettings');
        saveButton.disabled = true;
        saveButton.textContent = 'Saving...';

        const formData = new FormData(this);

        $.ajax({
            url: "{{ route('admin.rate.save') }}",
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                Swal.fire('Success', response.message, 'success');
                window.location.reload();
            },
            error: function() {
                Swal.fire('Error', 'Something went wrong.', 'error');
                saveButton.disabled = false;
                saveButton.textContent = 'Save';
            }
        });
    });
</script>
<script>
    function toggleQuickieSection(show) {
        const section = document.getElementById('quickiePriceWrapper');
        section.style.display = show ? 'block' : 'none';
    }

    $(document).ready(function() {
        toggleQuickieSection(document.querySelector('input[name="quickie_enabled"]:checked')?.value == 1);


    });

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