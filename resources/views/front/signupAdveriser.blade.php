@extends('front.layout.layout')

@section('content')


<style>
    select {
        height: 45px !important;
    }
   .phonefeild span.select2.select2-container.select2-container--default{
        width: 35% !important;
    }
    
    div#step2 input.form-control {
    height: 60px !important;
}
</style>


<main class="login-container">



    <section class="login">
        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col-lg-6 login_logo">

                    <img src="{{ asset('images/escort_logo1.png') }}" alt="">
                </div>
                <div class="col-lg-6 py-0">
                    <h1>Create Profile</h1>
                    <form class="contact-form c-mb-20 c-gutter-20" id="addUserForm" method="POST"
                        action="{{ route('user.register') }}">
                        @csrf
                        <div id="step1" style="display: block;">
                            <input type="hidden" name="type" value='2'>
                            <div class="row">
                                <!-- Name Field -->
                                <div class="form-group col-md-12">
                                    <!-- <label for="name">Name</label> -->
                                    <input type="text" class="form-control" id="name" placeholder="Enter Name (nickname)"
                                        name="name" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="dob" class="text-white mb-1">Date of Birth (18+) <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control dob" id="dob" name="dob" placeholder="Select Birth Date (dd/mm/yyyy)" required readonly="readonly">
                                </div>


                                <!-- Nationality / Country Dropdown -->
                                <div class="form-group col-md-6">
                                    <select class="form-select phone_code" name="country_id" id="country_id" required>
                                        <option value="">Select Country</option>
                                        @foreach($countryCodes as $country)
                                        <option value="{{ $country->id }}">{{ $country->country }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-12">
                                    <!-- <label for="email">Email</label> -->
                                    <input type="email" class="form-control" id="email" placeholder="Enter your email"
                                        name="email" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <!-- <label for="name">Password</label> -->
                                    <input type="password" class="form-control" id="password"
                                        placeholder="Enter your password" name="password" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <!-- <label for="password">Confirm Password</label> -->
                                    <input type="password" class="form-control" id="password_confirmation" placeholder="Confirm Password"
                                        name="password_confirmation" required>
                                </div>

                                <div class="form-group flex-row col-md-12 phonefeild">
                                  
                                        <select class="form-select mr-3 js-country-code phone_code" name="phone_code" id="phone_code" style="width: 35%;">
                                            <option value="">Select Country Code</option>
                                            @foreach($countryCodes as $country)
                                            <option value="{{ $country->code }}" {{ $country->code == '+1' ? 'selected' : '' }}>
                                                {{ $country->country }} (+{{ $country->code }})
                                            </option>
                                            @endforeach
                                        </select>
                              
                                    <div class="w-100">
                                        <input type="Number" class="form-control" placeholder="Contact Number" name="phone"
                                            id="phone">
                                    </div>
                                </div>
                                <!-- Slogan Field -->
                                <!-- <div class="form-group col-md-6">
                                    <input type="text" class="form-control" id="slogan" placeholder="Enter your slogan"
                                        name="slogan" required>
                                </div>

                                <div class="form-group col-md-6">
                                    <input type="number" class="form-control" id="rates" placeholder="Enter your rate"
                                        name="rates" required>
                                </div>

                                <div class="form-group col-md-12">
                                    <input type="text" class="form-control" id="contactMethod" name="contact_method"
                                        placeholder="Enter preferred contact method (e.g., Email)" required>
                                </div>

                                <div class="form-group col-md-12">
                                    <textarea class="form-control" id="description" rows="4" name="description"
                                        placeholder="Write a brief description" required></textarea>
                                </div> -->
                            </div>


                            <!-- Submit Button -->
                            <button type="button" class="btn btn-maincolor mx-auto" id="nextBtn">Next</button>

                        </div>
                        <div id="step2" style="display: none;">
                            <div class="row">
                                <h5 class="mx-auto mb-5 text-center">Upload Required Verification Photos</h5>
                                <div class="form-group col-md-12">
                                    <label>1. Upload a clear photo of your identification document</label>
                                    <input type="file" class="form-control" name="document_image" accept="image/png, image/jpeg, image/jpg, image/webp" required>
                                </div>
                                <div class="form-group col-md-12">
                                    <label>2. Upload a photo of yourself holding the document</label>
                                    <input type="file" class="form-control" name="holding_document_image" accept="image/png, image/jpeg, image/jpg, image/webp" required>
                                </div>
                                <div class="form-group col-md-12">
                                    <label>3. Upload a photo of yourself holding a paper with the website name and today’s date</label>
                                    <input type="file" class="form-control" accept="image/png, image/jpeg, image/jpg, image/webp" name="media" required>

                                </div>
                                <div class="form-group col-md-12">
                                    <label>4. Upload 1 or 2 recent pictures of yourself (to match your document)</label>
                                    <input type="file" class="form-control" accept="image/png, image/jpeg, image/jpg, image/webp" name="identity_photos[]" multiple required>

                                </div>
                                <div class="text-center mt-4" id="saveMediaContainer">
                                    <button type="submit" id="submit_button" class="btn btn-maincolor">Submit</button>
                                </div>
                                <!-- <div class="col-12">
                                    <div class="media-upload-section">
                                        <div class="upload-label">
                                            <i class="fas fa-cloud-upload-alt file-icon"></i>
                                            <h4>Drag & Drop Files Here</h4>
                                            <p>or click to upload</p>
                                            <input type="file" id="mediaInput" accept="image/*" name="media">
                                        </div>
                                    </div>

                                    <div class="media-grid" id="mediaGrid"></div>
                                   
                                    
                                </div> -->
                            </div>

                            <div class=" text-center">
                                <hr style="width: 60%; margin: 50px auto 30px; height: 1px; background: #fff;">
                                <p class="mx-auto">Already have an account <a href="login.php">Login</a></p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>



</main>



@endsection

@push('js')


<script>
    const today = new Date();
    const maxDobDate = new Date(today.getFullYear() - 18, today.getMonth(), today.getDate());

    flatpickr(".dob", {
        dateFormat: "d/m/Y",
        maxDate: maxDobDate,
        disableMobile: true,
        allowInput: false
    });

    $(document).ready(function() {
        $('.phone_code').select2({
            allowClear: true
        });
    });

    $('#nextBtn').on('click', function() {
        var isValid = true;

        // Validate visible fields only in Step 1
        $('#step1 :input[required]').each(function() {
            if (!$(this).val()) {
                isValid = false;
                $(this).addClass('is-invalid');
            } else {
                $(this).removeClass('is-invalid');
            }
        });

        if (!isValid) {
            Swal.fire({
                icon: 'warning',
                title: 'Required Fields',
                text: 'Please fill all required fields before proceeding.'
            });
            return;
        }

        $('#step1').hide();
        $('#step2').fadeIn();
    });

    $(document).ready(function() {
        $('#addUserForm').on('submit', function(event) {
            event.preventDefault();

            var form = $(this);
            var formData = new FormData(this);

            $.ajax({
                url: form.attr('action'),
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                beforeSend: function() {
                    $('#submit_button').prop('disabled', true).text('Processing...');
                },
                success: function(response) {
                    $('#submit_button').prop('disabled', false).text('Submit');

                    if (response.status === 1) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: response.message,
                            confirmButtonText: 'OK'
                        }).then(function() {
                            window.location.href = '{{ route("user.email-verification") }}';
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response.message
                        });
                    }
                },
                error: function(xhr) {
                    $('#submit_button').prop('disabled', false).text('Submit');
                    $('.text-danger').remove();
                    $('.form-control').removeClass('is-invalid');

                    let showStep1 = false;
                    let errorMessages = [];

                    if (xhr.responseJSON && xhr.responseJSON.errors) {
                        $.each(xhr.responseJSON.errors, function(key, value) {
                            let inputField;

                            // Handle array fields like identity_photos.0, identity_photos.1
                            if (key.startsWith('identity_photos')) {
                                inputField = $('[name="identity_photos[]"]');
                            } else {
                                inputField = $('[name="' + key + '"]');
                            }

                            inputField.addClass('is-invalid');
                            inputField.after('<span class="text-danger d-block mt-1">' + value[0] + '</span>');
                            errorMessages.push(value[0]);

                            if ($('#step1').find(inputField).length > 0) {
                                showStep1 = true;
                            }
                        });

                        if (showStep1) {
                            $('#step2').hide();
                            $('#step1').fadeIn();
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Validation Error',
                                html: errorMessages.join('<br>')
                            });
                        }
                    } else {
                        let errMsg = (xhr.responseJSON && xhr.responseJSON.message) ? xhr.responseJSON.message : 'Something went wrong. Please try again.';
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: errMsg,
                        });
                    }
                }
            });
        });
    });
</script>

@endpush