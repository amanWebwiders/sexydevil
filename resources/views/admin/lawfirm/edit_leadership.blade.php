@extends('admin.layout.layout')
@section('content')

<style>
    input.pe-2 {
        margin-right: 5px;
        position: relative;
        top: 2px;
    }
</style>

<div id="content" class="app-content">

    <div class="d-lg-flex align-items-end mb-4">
        <h3 class="page-header mb-lg-0">
            Update Leadership
        </h3>
    </div>

    <div class="card p-4">
        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation">
                <!--<button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true"></button>-->
            </li>
        </ul>
        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab" tabindex="0">
                <!--<h3 class="mt-2 mb-4">Main Office</h3>-->
                <form method="POST" action="javascript:void(0)" id="leadershipForm" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" id="id" value="{{ $leadership['id'] }}">
                    <div class="row">
                        <div class="col-md-4 mb-4">
                            <label class="form-label">Name</label>
                            <input type="text" class="form-control" id="leadership_name" name="leadership_name" value="{{ $leadership['name'] }}">
                        </div>
                        
                         <div class="col-md-4 mb-4">
                            <label class="form-label">Email</label>
                            <input type="text" class="form-control" id="leadership_email" name="leadership_email" value="{{ $leadership['email'] }}">
                        </div>
                        
                        <div class="col-md-4 mb-4">
                            <label class="form-label">Phone</label>
                            <div class="d-flex">
                                <select id="country_code" class="form-select" name="country_code">
                                    <option value="91" {{ $leadership['country_code'] == '91' ? 'selected' : '' }}>+91</option>
                                    <option value="1" {{ $leadership['country_code'] == '1' ? 'selected' : '' }}>+1</option>
                                    <option value="7" {{ $leadership['country_code'] == '7' ? 'selected' : '' }}>+7</option>
                                </select>
                                <input type="number" class="form-control" id="leadership_phone" name="leadership_phone" value="{{ $leadership['phone'] }}">
                            </div>
                        </div>
                        
                        <div class="col-md-4 mb-4">
                            <label class="form-label">Fee</label>
                            <input type="text" class="form-control" id="leadership_fee" name="leadership_fee" value="{{ $leadership['leadership_fee'] }}">
                        </div>
                        
                        <div class="col-md-4 mb-4">
                            <label class="form-label">Address</label>
                            <input type="text" class="form-control" id="leadership_address" name="leadership_address" value="{{ $leadership['address'] }}">
                        </div>
                       
                        <div class="col-md-4 mb-4">
                            <label class="form-label">Profile Image  
                                @if(!empty($leadership['image']))
                                  <img src="{{ $leadership['image'] ? asset('storage/' . $leadership['image']) : 'NO Image' }}" alt="NO Image" width="60" style="border-radius: 50%;">
                                @endif
                            </label>
                            <input type="file" class="form-control" id="file_image" name="file_image">
                        </div>
                        
                        <div class="col-md-12 mb-12">
                            <label class="form-label">Description</label>
                            <!--<input type="text" class="form-control" id="leadership_description" name="leadership_description">-->
                            <textarea class="form-control" id="leadership_description" name="leadership_description" rows="4" cols="50"> {{ $leadership['description'] }} </textarea>
                        </div>
                       
                    </div>
                    <div class="text-end">
                         <button type="submit" class="btn ms-auto mt-3" name="updateLeadership" id="updateLeadership"><span id="profile_btn">Update</span></button>
                    </div>
                </form>
            </div>
        </div>



    </div>

@endsection
@push('js')
<script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_API_KEY') }}&libraries=places"></script>
 <script>
        $(document).ready(function() {
            initAutocomplete();
            $('#updateLeadership').click(function(event) {
                event.preventDefault();
                var formData = new FormData();
                formData.append('id', $('#id').val());
                formData.append('name', $('#leadership_name').val());
                formData.append('email', $('#leadership_email').val());
                formData.append('phone', $('#leadership_phone').val());
                formData.append('country_code', $('#country_code').val());
                formData.append('address', $('#leadership_address').val());
                formData.append('leadership_fee', $('#leadership_fee').val());
                formData.append('leadership_description', $('#leadership_description').val());
        
                var file = $('#file_image')[0].files[0];
                if (file) {
                    formData.append('file_image', file);
                }
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{ route('admin.update-leadership') }}",
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        console.log('success');
                        $('#profile_btn').prop('disabled', true);
                        $('#profile_btn').text('Processing..');
                    },
                    success: function(res) {
                        $('#profile_btn').prop('disabled', false);
                        $('#profile_btn').text('Update');
                        console.log('success response');
                        if (res.status == 1) {
                            console.log('success status');
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: res.message,
                            }).then(function() {
                                window.location.href = '{{ route('admin.leadership-list') }}';
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: res.message,
                            }).then(function() {

                            });
                        }
                    },
                    error: function(error) {
                        $('#profile_btn').prop('disabled', false);
                        $('#profile_btn').text('Update');
                        $('.text-danger').remove();
                        if (error.responseJSON && error.responseJSON.errors) {
                            for (var err in error.responseJSON.errors) {
                                if (error.responseJSON.errors.hasOwnProperty(err)) {
                                    var errorMessage = error.responseJSON.errors[err][0];
                                    $("[name='" + err + "']").after("<div class='text-danger'>" + errorMessage +
                                        "</div>");
                                }
                            }
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: error.responseJSON.message,
                            }).then(function() {

                            });
                        }
                    }
                });
               
            });

        });
        
          function initAutocomplete() {
            
            var input = document.getElementById("leadership_address");
            var autocomplete = new google.maps.places.Autocomplete(input);
            autocomplete.addListener("place_changed", function() {
                var place = autocomplete.getPlace();
                if (!place.geometry) {
                    return;
                }
                let addressComponents = place.address_components;
                let city = "",state = "",country = "",postal_code = "";
                addressComponents.forEach((component) => {
                    let types = component.types;
                    if (types.includes("locality")) {
                        city = component.long_name;
                    } else if (types.includes("administrative_area_level_1")) {
                        state = component.long_name;
                    } else if (types.includes("country")) {
                        country = component.long_name;
                    } else if (types.includes("postal_code")) {
                        postal_code = component.long_name;
                    }
                });
                // Fill other fields automatically
                console.log('city', city)
                console.log('state', state)
                console.log('postal_code', postal_code)
                document.getElementById("shopping_city").value = city;
                document.getElementById("shopping_state").value = state;
                // document.getElementById("shopping_country").value = country;
                document.getElementById("shopping_postalcode").value = postal_code;
                let countryDropdown = document.getElementById("shopping_country");
                for (let i = 0; i < countryDropdown.options.length; i++) {
                    if (countryDropdown.options[i].text.trim().toLowerCase() === country.trim().toLowerCase()) {
                        countryDropdown.value = countryDropdown.options[i].value;
                        break;
                    }
                }
            });
        }
            
        // Initialize autocomplete when the page loads
        // google.maps.event.addDomListener(window, "load", initAutocomplete);
        window.addEventListener("load", initAutocomplete);
    </script>
    @endpush('js')