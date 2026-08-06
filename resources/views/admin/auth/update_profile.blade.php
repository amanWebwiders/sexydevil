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
            Update Your Profile
        </h3>
    </div>

    <div class="card p-4">
        <!-- <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Profile</button>
            </li>
        </ul> -->
        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active form-container" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab" tabindex="0">
                <!-- <h3 class="mt-2 mb-4">Update Your Profile</h3> -->
                <form method="POST" action="javascript:void(0)" id="EditProfile" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-12 mb-4">
                            <label class="form-label">Name</label>
                            <input type="text" class="form-control" id="profile_name" name="name" value="{{ auth()->guard('admin')->user()->name }}" required>
                        </div>
                        <div class="col-md-12 mb-4">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" id="profile_email" name="email" value="{{ auth()->guard('admin')->user()->email }}" {{ auth()->guard('admin')->user()->type === 1 ? 'readonly' : '' }} required>
                        </div>

                        <div class="col-md-12 mb-4">
                            <label class="form-label">Profile Image</label>
                            <input type="file" class="form-control" id="file_image" name="file_image" accept="image/*">

                            <img class="mt-3"
                                id="current_profile_image"
                                src="{{ auth()->guard('admin')->user()->image 
                                    ? asset('storage/' . auth()->guard('admin')->user()->image) 
                                    : asset('images/escort_logo1.png') }}"
                                alt="Profile"
                                style="max-width:120px; max-height:120px; border-radius:50%; object-fit:cover;">

                        </div>
                        <div class="col-md-12 mb-2 mt-5">
                            <h5 class="fw-bold">Profile Boost Setting</h5>
                        </div>

                        <div class="col-md-6 mb-4">
                            <label class="form-label">Boost No of Days</label>
                            <input type="number" class="form-control" name="boost_days" value="{{ old('boost_days', auth()->guard('admin')->user()->boost_days) }}" min="0">
                        </div>

                        <div class="col-md-6 mb-4">
                            <label class="form-label">Boost Cost ($)</label>
                            <input type="number" step="0.01" class="form-control" name="boost_cost" value="{{ old('boost_cost', auth()->guard('admin')->user()->boost_cost) }}" min="0">
                        </div>

                        @php $user = auth('admin')->user(); @endphp

                        @if($user->type === 1)
                        <div class="col-md-2 mb-4">
                            <label class="form-label">Country Code</label>
                            <select
                                class="form-select"
                                name="country_code_id"
                                required>
                                <option value="">Select Code</option>
                                @foreach($countryCodes as $cc)
                                <option
                                    value="{{ $cc->id }}"
                                    {{ $user->country_code_id == $cc->id ? 'selected' : '' }}>
                                    {{ $cc->country }} ({{ $cc->code }})
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 mb-4">
                            <label class="form-label">Phone</label>
                            <input
                                type="text"
                                class="form-control"
                                name="phone"
                                value="{{ $user->phone }}"
                                required>
                        </div>
                        <div class="col-md-12 mb-4">
                            <label class="form-label">Description</label>
                            <textarea
                                class="form-control"
                                name="description"
                                rows="2">{{ $user->description }}</textarea>
                        </div>
                        <div class="col-md-12 mb-4">
                            <label class="form-label">Occupation</label>
                            <select class="form-select" name="occupation_id" disabled>
                                <option value="">Select Occupation</option>
                                @foreach($occupations as $occupation)
                                <option
                                    value="{{ $occupation->id }}"
                                    {{ $user->occupation_id == $occupation->id ? 'selected' : '' }}>
                                    {{ $occupation->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-12 mb-4">
                            <label class="form-label">Fee($)</label>
                            <input
                                type="number"
                                step="0.01"
                                class="form-control fee"
                                name="fee"
                                value="{{ $user->fee }}" readonly>
                        </div>
                        <!-- <div class="col-md-12 mb-4">
                            <label class="form-label">GST</label>
                            <input
                                type="number"
                                step="0.01"
                                class="form-control gst"
                                name="gst"
                                value="{{ $user->gst }}">
                        </div>
                        <div class="col-md-12 mb-4">
                            <label class="form-label">Total($)</label>
                            <input
                                type="number"
                                step="0.01"
                                class="form-control total"
                                name="total"
                                value="{{ $user->total }}" readonly>
                        </div> -->
                        <div class="col-md-12 mb-4">
                            <label class="form-label">Location</label>
                            <input
                                type="text"
                                class="form-control"
                                name="location"
                                value="{{ $user->location }}">
                        </div>
                        @endif
                    </div>
                    <div class="text-end">
                        <button type="submit" class="btn ms-auto mt-3 text-white" name="updateprofile_btn" id="updateprofile_btn">Update</button>
                    </div>
                </form>
            </div>

        </div>



    </div>

    @endsection
    @push('js')
    <script>
        //     function updateTotalForGroup($group) {
        //     const fee = parseFloat($group.find('.fee').val()) || 0;
        //     const gst = parseFloat($group.find('.gst').val()) || 0;
        //     const total = fee + gst;
        //     $group.find('.total').val(total.toFixed(2));
        // }

        // $(document).on('input', '.fee, .gst', function () {
        //     const $group = $(this).closest('.form-container'); // Adjust this selector as needed
        //     updateTotalForGroup($group);
        // });
        $(document).ready(function() {

            $('#EditProfile').on('submit', function(event) {
                event.preventDefault();

                const form = this;
                const $btn = $('#updateprofile_btn');
                const formData = new FormData(form);

                $.ajax({
                    url: "{{ route('admin.profile-update') }}",
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
                            console.log('sdfvsdh');
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