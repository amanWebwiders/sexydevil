@extends('front.layout.layout')

@section('content')


<style>
    .sidebar {
        top: 0px;
    }

    .select2-container {
        width: 100% !important;
    }

    .ds select {
        height: 45px;
        line-height: 45px;
    }

    .avatar-upload {
        position: relative;
        max-width: 205px;
        margin: 50px auto;
    }

    .avatar-upload .avatar-edit {
        position: absolute !important;
        right: 0;
        z-index: 1;
        top: 0;
        width: 100%;
        height: 100%;
    }

    .avatar-upload .avatar-edit input {
        opacity: 0;
        height: 100%;
        width: 100%;
    }

    .avatar-upload .avatar-edit input+label {
        display: inline-block;
        width: 34px;
        height: 34px;
        margin-bottom: 0;
        border-radius: 100%;
        background: #FFFFFF;
        border: 1px solid transparent;
        box-shadow: 0px 2px 4px 0px rgba(0, 0, 0, 0.12);
        cursor: pointer;
        font-weight: normal;
        transition: all 0.2s ease-in-out;
    }

    .avatar-upload .avatar-edit input+label:hover {
        background: #f1f1f1;
        border-color: #d6d6d6;
    }

    .avatar-upload .avatar-edit input+label:after {
        content: "\f040";
        font-family: 'FontAwesome';
        color: #757575;
        position: absolute;
        top: 10px;
        left: 0;
        right: 0;
        text-align: center;
        margin: auto;
    }

    .avatar-upload .avatar-preview {
        width: 192px;
        height: 192px;
        position: relative;
        border-radius: 100%;
        border: 6px solid #F8F8F8;
        box-shadow: 0px 2px 4px 0px rgba(0, 0, 0, 0.1);
    }

    .avatar-upload .avatar-preview>div {
        width: 100%;
        height: 100%;
        border-radius: 100%;
        background-size: cover;
        background-repeat: no-repeat;
        background-position: center;
    }



    .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
        left: auto !important;
        right: -3px;
    }

    span.select2-selection.select2-selection--multiple {
        min-height: 45px;
    }

    span.select2-selection.select2-selection--multiple.select2-selection--clearable {
        min-height: 45px;
        height: 100%;
        max-height: 100%;
        overflow: auto;
    }

    .form-check {
        padding-left: 0rem;
    }


    @media screen and (max-width:767px) {

        .col,
        .col-1,
        .col-10,
        .col-11,
        .col-12,
        .col-2,
        .col-3,
        .col-4,
        .col-5,
        .col-6,
        .col-7,
        .col-8,
        .col-9,
        .col-auto,
        .col-lg,
        .col-lg-1,
        .col-lg-10,
        .col-lg-11,
        .col-lg-12,
        .col-lg-2,
        .col-lg-3,
        .col-lg-4,
        .col-lg-5,
        .col-lg-6,
        .col-lg-7,
        .col-lg-8,
        .col-lg-9,
        .col-lg-auto,
        .col-md,
        .col-md-1,
        .col-md-10,
        .col-md-11,
        .col-md-12,
        .col-md-2,
        .col-md-3,
        .col-md-4,
        .col-md-5,
        .col-md-6,
        .col-md-7,
        .col-md-8,
        .col-md-9,
        .col-md-auto,
        .col-sm,
        .col-sm-1,
        .col-sm-10,
        .col-sm-11,
        .col-sm-12,
        .col-sm-2,
        .col-sm-3,
        .col-sm-4,
        .col-sm-5,
        .col-sm-6,
        .col-sm-7,
        .col-sm-8,
        .col-sm-9,
        .col-sm-auto,
        .col-xl,
        .col-xl-1,
        .col-xl-10,
        .col-xl-11,
        .col-xl-12,
        .col-xl-2,
        .col-xl-3,
        .col-xl-4,
        .col-xl-5,
        .col-xl-6,
        .col-xl-7,
        .col-xl-8,
        .col-xl-9,
        .col-xl-auto {
            padding-inline: 0px !important;
        }

        .col-lg-3.col-md-4.p-2.border {
            padding-inline: 10px !important;
        }
    }
</style>
<section class="main-area">
    <div class="container-fluid">
        <div class="row model_detail">
            @include('front.component.quicklink')
            <div class="d-flex d-lg-none justify-content-between col-12 px-0 mt-2 mb-4">
                <a class="open-offcanvas" data-target="#offcanvas1">Quick links <i class="fa fa-external-link" aria-hidden="true" class="canvas-icon"></i>
                </a>
                <!-- <a class="open-offcanvas" data-target="#offcanvas2">Filters <i class="fa fa-filter" aria-hidden="true" class="canvas-icon"></i></a> -->
            </div>

            <div class="offcanvas offcanvas_left" id="offcanvas1">
                <button type="button" class="close close-offcanvas" id="closeOffcanvas" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                @include('front.component.quicklink')
            </div>

            <div class="col-lg-10 col-md-12">
                <section class="ds s-pt-70 s-pb-50 s-pb-sm-50 s-py-lg-100 s-py-xl-150 c-gutter-60 content-area">



                    <div class="container-lg-fluid py-4 editprof-container">
                        <div class="row mx-0 px-md-2">
                            <div class="col-12">
                                <h1 class="mb-4 text-left">Edit Profile</h1>
                            </div>
                            @include('front.component.plan_notification')
                            <form method="POST" action="javascript:void(0)" id="EditProfile" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="type" value="{{Auth::user()->type}}">
                                <!-- Basic Info -->

                                <div class="avatar-upload text-center mb-4">
                                    <div class="avatar-edit position-relative">
                                        <!-- <input type="file" id="imageUpload" name="file_image" accept=".png, .jpg, .jpeg" /> -->
                                        <!-- <label for="imageUpload" class="position-absolute" style="top: 0; right: 0; cursor: pointer;">
                                                                <i class="fas fa-pencil-alt"></i>
                                                            </label> -->
                                    </div>
                                    <div class="avatar-preview mx-auto" style="width: 120px; height: 120px; border-radius: 50%; overflow: hidden; border: 2px solid #ccc;">
                                        <div id="imagePreview"
                                            style="width: 100%; height: 100%; background-size: cover; background-position: center center; background-image: url('{{ config('app.img_url'). (Auth::user()->profile_image ?? 'profile_image/default-profile.png') }}');">
                                        </div>
                                    </div>
                                </div>


                                <div class="form-section row mx-0">
                                    <div class="col-md-6  mb-3  ">
                                        <div class="form-group">
                                            <label>Unique ID : {{ Auth::user()->unique_user_id }}</label>
                                        </div>                                        
                                </div>
                                <div class="form-section row mx-0">
                                    <!-- <h4 class="w-100">Basic Information</h4> -->
                                    <div class="col-md-6  mb-3  ">
                                        <div class="form-group">
                                            <label>Name</label>
                                            <input type="text" class="form-control" value="{{ Auth::user()->name }}" name="name" placeholder="full name" readonly />
                                        </div>
                                    </div>
                                    <div class="col-md-6  mb-3  ">
                                        <div class="form-group">
                                            <label>Email</label>
                                            <input type="email" class="form-control" name="email" value="{{ Auth::user()->email }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-6  mb-3  ">
                                        <div class="form-group">
                                            <label>Phone Code</label>
                                            <select class="form-select phone_code" name="phone_code" id="phone_code">
                                                <option value="">Select Code</option>
                                                @foreach($countryCodes as $country)
                                                <option value="{{ $country->code }}" {{ Auth::user()->phone_code == $country->code ? 'selected' : '' }}>
                                                    {{ $country->country }} (+{{ $country->code }})
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Phone -->
                                    <div class="col-md-6  mb-3  ">
                                        <div class="form-group">
                                            <label>Phone <span class="text-danger">(This will be used for contact with you!!)</span></label>
                                            <input type="number" class="form-control" name="phone" value="{{ Auth::user()->phone }}">
                                        </div>
                                    </div>

                                    <div class="col-md-6  mb-3  ">
                                        <div class="form-group">
                                            <label>Nickname</label>
                                            <input type="text" class="form-control" name="nickname" value="{{ Auth::user()->nickname }}">
                                        </div>
                                    </div>
                                    @if(Auth::user()->type == 2)
                                    <div class="col-md-6  mb-3  ">
                                        <div class="form-group">
                                            <label>Date of Birth</label>
                                            <input type="date" class="form-control dob" id="dob" name="dob"
                                                value="{{ Auth::user()->dob }}"
                                                placeholder="Date of Birth (You must be 18+)" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-6  mb-3  ">
                                        @php
                                        $dob = Auth::user()->dob;
                                        $defaultAge = $dob ? \Carbon\Carbon::parse($dob)->age : '';
                                        @endphp

                                        <div class="form-group">
                                            <label>Displayed Age <small>(Once only, 18–80)</small></label>
                                            <select name="displayed_age" id="displayed_age" class="form-control">
                                                <option value="">Select Age</option>
                                                @for ($i = 18; $i <= 80; $i++)
                                                    <option value="{{ $i }}" {{ (Auth::user()->displayed_age ?? $defaultAge) == $i ? 'selected' : '' }}>
                                                    {{ $i }}
                                                    </option>
                                                    @endfor
                                            </select>
                                        </div>

                                    </div>
                                    <div class="col-md-6  mb-3  ">
                                        <div class="form-group">
                                            <label>Country</label>
                                            <select class="form-select phone_code" name="country_id" id="country_id" onchange="getStates(this.value)">
                                                <option value="" disabled >Select Country</option>
                                                @foreach($countries as $counties)
                                                <option value="{{ $counties->id }}" {{ Auth::user()->country_id == $counties->id ? 'selected' : 'disabled' }}>{{ $counties->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6  mb-3  ">
                                        <div class="form-group">
                                            <label>State</label>
                                            <select class="form-select phone_code" name="state_id" id="state_id" onchange="getCities(this.value)" data-selected="{{ Auth::user()->state_id }}">
                                                <option value="">Select state</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6  mb-3  ">
                                        <div class="form-group">
                                            <label>City</label>
                                            <select class="form-select phone_code" name="city_id" id="city_id" data-selected="{{ Auth::user()->city_id }}">
                                                <option value="">Select city</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6  mb-3  ">
                                        <div class="form-group">
                                            <label>Slogan</label>
                                            <input type="text" class="form-control" name="slogan" value="{{ Auth::user()->slogan }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6  mb-3  ">
                                        <div class="form-group">
                                            <label>Nationality</label>
                                            <select class="form-select phone_code" name="nationality" id="nationality">
                                                <option value="">Select Nationality</option>
                                                @foreach($nationality as $nationality)
                                                <option value="{{ $nationality->name }}" {{ Auth::user()->nationality == $nationality->name ? 'selected' : '' }}>{{ $nationality->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6  mb-3  ">
                                        <div class="form-group">
                                            <label>Ethnicity</label>
                                            <select class="form-select phone_code" name="ethnicity_id" id="ethnicity_id">
                                                <option value="">Select Ethnicity</option>
                                                @foreach($ethnicity as $ethnicity)
                                                <option value="{{ $ethnicity->id }}" {{ Auth::user()->ethnicity_id == $ethnicity->id ? 'selected' : '' }}>{{ $ethnicity->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6  mb-3  ">
                                        <div class="form-group">
                                            <label>Gender</label>
                                            <select class="form-select" name="gender_id" id="gender">
                                                <option value="">Select Gender</option>
                                                @foreach($gender as $gender)
                                                <option value="{{ $gender->id }}" {{ Auth::user()->gender_id == $gender->id ? 'selected' : '' }}>
                                                    {{ $gender->name }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-section col-12 mb-3">
                                        <label>Description</label>
                                        <div class="form-group">
                                            <textarea class="form-control" rows="5" name="description" value="{{ Auth::user()->description }}" placeholder="Enter detailed description...">{{ Auth::user()->description }}</textarea>
                                        </div>
                                    </div>
                                    <!-- Body Type -->
                                    <div class="col-md-6  mb-3  ">
                                        <label>Body Type</label>
                                        <select class="form-select" name="body_type_id">
                                            <option value="">Select Body Type</option>
                                            @foreach($bodyType as $item)
                                            <option value="{{ $item->id }}" {{ Auth::user()->body_type_id == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6  mb-3  ">
                                        <div class="form-group">
                                            <label>Service Location</label>
                                            <select class="form-select" name="incall_outcall">
                                                <option value="1" {{ Auth::user()->outcall == 1 ? 'selected' : '' }}>In my place</option>
                                                <option value="0" {{ Auth::user()->outcall == 0 ? 'selected' : '' }}>Hotel and private home visits</option>
                                                <option value="2" {{ Auth::user()->outcall == 2 ? 'selected' : '' }}>In my place + Hotel and private home visits</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Contact Method -->
                                    <!-- <div class="col-md-12 mb-3">
                                                        <div class="form-group">
                                                            <label>Contact Method</label>
                                                            <select class="form-select" name="social_contact_method">
                                                                <option value="">Select Contact Method</option>
                                                                <option value="WhatsApp" {{ Auth::user()->social_contact_method == 'WhatsApp' ? 'selected' : '' }}>WhatsApp</option>
                                                                <option value="SMS" {{ Auth::user()->social_contact_method == 'SMS' ? 'selected' : '' }}>SMS</option>
                                                                <option value="Telegram" {{ Auth::user()->social_contact_method == 'Telegram' ? 'selected' : '' }}>Telegram</option>
                                                                <option value="Email" {{ Auth::user()->social_contact_method == 'Email' ? 'selected' : '' }}>Email</option>
                                                                <option value="Phone" {{ Auth::user()->social_contact_method == 'Phone' ? 'selected' : '' }}>Phone Number</option>
                                                            </select>
                                                            <input type="text" class="form-control mt-2" name="contact_detail" placeholder="Enter Contact Info" value="{{ Auth::user()->contact_detail }}">
                                                        </div>
                                                    </div> -->
                                    @php
                                    $methods = ['WhatsApp', 'SMS', 'Telegram', 'Phone', 'Email', 'LINE', 'Signal'];
                                    $userContacts = json_decode(Auth::user()->contact_methods ?? '{}', true);
                                    $hasContacts = count($userContacts ?? []) > 0;
                                    @endphp

                                    <div class="col-md-12 mb-3">
                                        <label class="d-block">Contact Methods</label>

                                        <div class="row mx-0 contactmentodui">
                                            @foreach($methods as $method)
                                            <div class="col-lg-3 col-md-4 mb-2  ">
                                                <div class="form-check">
                                                    @php
                                                    $isChecked = $hasContacts ? (!empty($userContacts[$method])) : ($method === 'Phone');
                                                    $value = $userContacts[$method] ?? '';
                                                    @endphp

                                                    <input class="form-check-input me-2 contact-method-checkbox" type="checkbox"
                                                        id="chk_{{ $method }}"
                                                        data-method="{{ $method }}"
                                                        {{ $isChecked ? 'checked' : '' }}>

                                                    <label class="form-check-label me-2 notranslate" translate="no" for="chk_{{ $method }}">{{ $method }}</label>

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
                                    </div>



                                    <!-- Sex Location -->
                                    <div class="col-md-6  mb-3  ">
                                        <div class="form-group">
                                            <label>Type Of Service Provider</label>
                                            <select class="form-select" name="sex_location">
                                                <option value="">Select Type</option>
                                                <option value="Sex house" {{ Auth::user()->sex_location == 'Sex house' ? 'selected' : '' }}>Sex house</option>
                                                <option value="Nightclub" {{ Auth::user()->sex_location == 'Nightclub' ? 'selected' : '' }}>Nightclub</option>
                                                <option value="Massage House" {{ Auth::user()->sex_location == 'Massage House' ? 'selected' : '' }}>Massage House</option>
                                                <option value="Agency" {{ Auth::user()->sex_location == 'Agency' ? 'selected' : '' }}>Agency</option>
                                                <option value="Independent" {{ Auth::user()->sex_location == 'Independent' ? 'selected' : '' }}>Independent</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Block Specific Countries -->
                                    <div class="col-md-6  mb-3  ">
                                        <div class="form-group">
                                            <label>Block Specific Countries</label>
                                            <select class="form-select select2-multiple" name="blocked_countries[]" multiple>
                                                @foreach($countryCodes as $country)
                                                <option value="{{ $country->id }}"
                                                    {{ in_array($country->id, json_decode(Auth::user()->blocked_countries ?? '[]', true)) ? 'selected' : '' }}>
                                                    {{ $country->country }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6  mb-3  ">
                                        <div class="form-group">
                                            <label>Languages</label>
                                            <select class="form-select select2-multiple" name="languages[]" multiple>
                                                @foreach($language as $lang)
                                                <option value="{{ $lang->id }}"
                                                    {{ in_array($lang->id, json_decode(Auth::user()->languages ?? '[]', true)) ? 'selected' : '' }}>
                                                    {{ $lang->name }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>


                                    <!-- Orientation Sexual -->
                                    <div class="col-md-6  mb-3  ">
                                        <div class="form-group">
                                            <label>Orientation Sexual</label>
                                            <select class="form-select" name="sexual_orientation">
                                                <option value="">Select</option>
                                                <option value="Heterosexual" {{ Auth::user()->sexual_orientation == 'Heterosexual' ? 'selected' : '' }}>Heterosexual</option>
                                                <option value="Homosexual" {{ Auth::user()->sexual_orientation == 'Homosexual' ? 'selected' : '' }}>Homosexual</option>
                                                <option value="Bisexual" {{ Auth::user()->sexual_orientation == 'Bisexual' ? 'selected' : '' }}>Bisexual</option>
                                                <option value="Pansexual" {{ Auth::user()->sexual_orientation == 'Pansexual' ? 'selected' : '' }}>Pansexual</option>
                                                <option value="Other" {{ Auth::user()->sexual_orientation == 'Other' ? 'selected' : '' }}>Other</option>
                                            </select>
                                        </div>
                                    </div>




                                    <!-- Hair Color -->
                                    <div class="col-md-6  mb-3  ">
                                        <label>Hair Color</label>
                                        <select class="form-select" name="hair_color_id">
                                            <option value="">Select Hair Color</option>
                                            @foreach($hairColor as $item)
                                            <option value="{{ $item->id }}" {{ Auth::user()->hair_color_id == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Hair Length -->
                                    <div class="col-md-6  mb-3  ">
                                        <label>Hair Length</label>
                                        <select class="form-select" name="hair_length_id">
                                            <option value="">Select Hair Length</option>
                                            @foreach($hairLength as $item)
                                            <option value="{{ $item->id }}" {{ Auth::user()->hair_length_id == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Hair Type -->
                                    <div class="col-md-6  mb-3  ">
                                        <label>Hair Type</label>
                                        <select class="form-select" name="hair_type_id">
                                            <option value="">Select Hair Type</option>
                                            @foreach($hairType as $item)
                                            <option value="{{ $item->id }}" {{ Auth::user()->hair_type_id == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Eye Color -->
                                    <div class="col-md-6  mb-3  ">
                                        <label>Eye Color</label>
                                        <select class="form-select" name="eye_color_id">
                                            <option value="">Select Eye Color</option>
                                            @foreach($eyeColor as $item)
                                            <option value="{{ $item->id }}" {{ Auth::user()->eye_color_id == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Tattoos / Piercings / Smoking -->
                                    <div class="col-md-6  mb-3  ">
                                        <label>Tattoos</label>
                                        <select class="form-select" name="tattoo">
                                            <option value="">Select Option</option>
                                            <option value="yes" {{ Auth::user()->tattoo == 'yes' ? 'selected' : '' }}>Yes</option>
                                            <option value="no" {{ Auth::user()->tattoo == 'no' ? 'selected' : '' }}>No</option>
                                        </select>
                                    </div>

                                    <div class="col-md-6  mb-3  ">
                                        <label>Piercings</label>
                                        <select class="form-select" name="piercing">
                                            <option value="">Select Option</option>
                                            <option value="yes" {{ Auth::user()->piercing == 'yes' ? 'selected' : '' }}>Yes</option>
                                            <option value="no" {{ Auth::user()->piercing == 'no' ? 'selected' : '' }}>No</option>
                                        </select>
                                    </div>

                                    <div class="col-md-6  mb-3  ">
                                        <label>Smoking</label>
                                        <select class="form-select" name="smoking">
                                            <option value="">Select Option</option>
                                            <option value="yes" {{ Auth::user()->smoking == 'yes' ? 'selected' : '' }}>Yes</option>
                                            <option value="no" {{ Auth::user()->smoking == 'no' ? 'selected' : '' }}>No</option>
                                        </select>
                                    </div>

                                    <!-- Pubic Hair -->
                                    <div class="col-md-6  mb-3  ">
                                        <label>Pubic Hair</label>
                                        <select class="form-select" name="pubic_hair_id">
                                            <option value="">Select Option</option>
                                            @foreach($pubicHair as $item)
                                            <option value="{{ $item->id }}" {{ Auth::user()->pubic_hair_id == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6  mb-3  ">
                                        <div class="form-group">
                                            <label>Height (cm)</label>
                                            <input type="number" class="form-control" name="height_cm" value="{{ Auth::user()->height_cm }}" min="50" max="220">
                                        </div>
                                    </div>


                                    <!-- Weight -->
                                    <div class="col-md-6  mb-3  ">
                                        <div class="form-group">
                                            <label>Weight (kg)</label>
                                            <select class="form-select" name="weight_kg">
                                                <option value="">Select Weight</option>
                                                @for ($i = 30; $i <= 150; $i++)
                                                    <option value="{{ $i }}" {{ Auth::user()->weight_kg == $i ? 'selected' : '' }}>{{ $i }} kg</option>
                                                    @endfor
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Shoe Size -->
                                    <div class="col-md-6  mb-3  ">
                                        <div class="form-group">
                                            <label>Shoe Size</label>
                                            <select class="form-control" name="shoe_size">
                                                <option value="">Select Shoe Size</option>
                                                @for ($i = 24; $i <= 46; $i++)
                                                    <option value="{{ $i }}" {{ Auth::user()->shoe_size == $i ? 'selected' : '' }}>{{ $i }}</option>
                                                    @endfor
                                            </select>
                                        </div>
                                    </div>


                                    <!-- Breast Size -->
                                    @php
                                    $breastSizes = [
                                    'A - Natural', 'A - Enhanced',
                                    'B - Natural', 'B - Enhanced',
                                    'C - Natural', 'C - Enhanced',
                                    'D - Natural', 'D - Enhanced',
                                    'DD - Natural', 'DD - Enhanced',
                                    'E+ - Natural', 'E+ - Enhanced'
                                    ];

                                    $selectedSizes = json_decode(Auth::user()->breast_size ?? '[]', true);
                                    @endphp

                                    <div class="col-md-6  mb-3  ">
                                        <div class="form-group">
                                            <label>Breast Size (Natural/Enhanced)</label>
                                            <select class="form-select select2-multiple" name="breast_size[]" multiple>
                                                @foreach($breastSizes as $size)
                                                <option value="{{ $size }}" {{ in_array($size, $selectedSizes) ? 'selected' : '' }}>
                                                    {{ $size }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>


                                    <!-- <div class="col-md-6 mb-3">
                                                        <div class="form-group">
                                                            <label>Rate</label>
                                                            <input type="number" class="form-control" name="rates" value="{{ Auth::user()->rates }}">
                                                        </div>
                                                    </div> -->


                                    <!-- Cum & Body Play -->
                                    <div class="col-md-6  mb-3  ">
                                        <label>OnlyFans Link</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fab fa-onlyfans"></i></span>
                                            <input type="url" class="form-control" name="onlyfans_link" value="{{ Auth::user()->onlyfans_link }}" placeholder="https://onlyfans.com/yourname">
                                        </div>
                                    </div>

                                    <div class="col-md-6  mb-3  ">
                                        <label>Instagram Link</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fab fa-instagram"></i></span>
                                            <input type="url" class="form-control" name="instagram_link" value="{{ Auth::user()->instagram_link }}" placeholder="https://instagram.com/yourname">
                                        </div>
                                    </div>

                                    <div class="col-md-6  mb-3  ">
                                        <label>Telegram Link</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fab fa-telegram"></i></span>
                                            <input type="url" class="form-control" name="telegram_link" value="{{ Auth::user()->telegram_link }}" placeholder="https://t.me/yourusername">
                                        </div>
                                    </div>

                                    <div class="col-md-6  mb-3  ">
                                        <label>TikTok Link</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fab fa-tiktok"></i></span>
                                            <input type="url" class="form-control" name="tiktok_link" value="{{ Auth::user()->tiktok_link }}" placeholder="https://www.tiktok.com/@yourusername">
                                        </div>
                                    </div>

                                    <div class="col-12 mt-5">
                                        <h3>Services</h3>

                                        @foreach ($categories as $category)


                                        <h5 class="mt-4">{{ $category->name }}</h5>
                                        <div class="d-flex flex-wrap gap-2 w-100">
                                            @foreach ($category->services as $service)
                                            <div class="col-lg-3 col-md-4 p-2 border">
                                                @if ($service->selections->isEmpty())
                                                {{-- Service with NO selections --}}
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input"
                                                        name="services[{{ $service->id }}]"
                                                        id="service-{{ $service->id }}"
                                                        value="1"
                                                        {{ in_array($service->id, $selectedServices ?? []) ? 'checked' : '' }}>
                                                    <label class="form-check-label fw-bold" for="service-{{ $service->id }}">
                                                        {{ $service->name }}
                                                    </label>
                                                </div>
                                                @else
                                                {{-- Service with selections --}}
                                                <strong>{{ $service->name }}</strong>
                                                <div class="ms-3">
                                                    @php
                                                    $isRadioGroup = $service->selections->first()->input_type === 'radio';
                                                    $radioGroupName = $isRadioGroup ? 'selections_group[' . $service->id . ']' : null;
                                                    @endphp

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
















                                        @endif

                                        <!-- Height -->



                                    </div>
                                </div>
                                <div class="text-center my-2">
                                    <button type="submit" id="updateprofile_btn" class="btn btn-red btn-lg">Submit</button>
                                </div>
                            </form>
                        </div>

                    </div>


                    <div class="fw-divider-space hidden-below-lg mt-20"></div>
                </section>
            </div>
        </div>
    </div>
</section>

@endsection
@push('js')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
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
    });
</script>

<script>
    function showComingSoon() {
        alert('Coming Soon');
    }
    $(document).ready(function() {

        $('.select2-multiple').select2({
            placeholder: "Select options",
            allowClear: true,
            width: '100%'
        });
    });
    $(document).ready(function() {
        $('.phone_code').select2({
            allowClear: true
        });
    });
    $(document).ready(function() {

        $('#EditProfile').on('submit', function(event) {
            event.preventDefault();

            const form = this;
            const $btn = $('#updateprofile_btn');
            const formData = new FormData(form);

            $.ajax({
                url: "{{ route('user.update-profile') }}",
                type: 'POST',
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                processData: false,
                contentType: false,

                beforeSend: function() {
                    $btn.prop('disabled', true).text('Processing…');
                },

                success: function(res) {
                    $btn.prop('disabled', false).text('Update');

                    if (res.status == 1) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: res.message,
                        }).then(function() {
                            window.location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: res.message,
                        });
                    }
                },

                error: function(xhr) {
                    $btn.prop('disabled', false).text('Update');

                    // Remove old error messages
                    $('.text-danger').remove();

                    if (xhr.responseJSON && xhr.responseJSON.errors) {
                        $.each(xhr.responseJSON.errors, function(field, messages) {
                            const $input = $("[name='" + field + "']");
                            $input.after("<div class='text-danger'>" + messages[0] + "</div>");
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: xhr.responseJSON?.message || 'Something went wrong.',
                        });
                    }
                }
            });
        });

    });
</script>
@endpush('js')