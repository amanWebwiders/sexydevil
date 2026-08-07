@extends('front.layout.layout')

@section('content')


<style>
    #dayslist input[type=checkbox],
    input[type=radio] {
        display: inline-block !important;
        margin-top: 0px;
    }

    .sidebar {
        top: 0px;
    }

    @media (max-width: 1024px) and (min-width: 767px) {
        .main-area {
            min-height: 70vh;
        }
    }

    @media only screen and (max-width:767px) {

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
            padding-inline: 0px;
        }

        .days-list {
            display: flex;
            flex-direction: column;
        }

        .timeslotinput {
            gap: 8px;
        }

        .setavailabilty-main {
            padding-block: 20px !important;
        }


    }

    .radioinputsbtn {
        gap: 15px;
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

            <div class="col-lg-10">
                <section class="ds s-pt-70 s-pb-50 s-pb-sm-50 s-py-lg-100 s-py-xl-150 c-gutter-60 content-area">
                    <div class="p-5 mx-lg-0 mx-md-0 mx-2 setavailabilty-main">
                        <div class="row">
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-12">
                                        @php
                                        $availabilityMain = $user->availability_main ?? 'appointment';
                                        $walkinTypes = json_decode($user->walkin_type) ?? []; // should be an array

                                        $isOnline = $user->is_online ?? 0;
                                        @endphp

                                        <div class="form-check days-list" id="dayslist">
                                            <label><strong>Availability Schedule:</strong></label><br>
                                            @include('front.component.plan_notification')
                                            <!-- Main Availability Options -->
                                            <div class="d-flex radioinputsbtn">
                                                <div>
                                                    <input class=" me-2" type="radio" name="availability_main" value="appointment"
                                                        onclick="toggleWalkinOptions()" {{ $availabilityMain === 'appointment' ? 'checked' : '' }}>
                                                    Available with appointment (By appointment only)
                                                </div>

                                                <div>
                                                    <input type="radio" name="availability_main" value="walk-in"
                                                        onclick="toggleWalkinOptions()" {{ $availabilityMain === 'walk-in' ? 'checked' : '' }}>
                                                    Available without appointment
                                                </div>
                                            </div>

                                            <!-- Walk-in Options -->
                                            <div class=" days-list" id="walkinOptions" style="margin-top: 10px; {{ $availabilityMain === 'walk-in' ? '' : 'display: none;' }}">
                                                <label><strong>Walk-in Options:</strong></label><br>
                                                <div class="d-flex radioinputsbtn">
                                                    <div>
                                                        <input class=" me-2 contact-method-checkbox" type="checkbox" name="walkin_type[]" value="accepted"
                                                            {{ in_array('accepted', $walkinTypes) ? 'checked' : '' }}> Walk-ins accepted
                                                    </div>

                                                    <div>
                                                        <input type="checkbox" name="walkin_type[]" value="on_demand"
                                                            {{ in_array('on_demand', $walkinTypes) ? 'checked' : '' }}> On-demand
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Online / Offline Status -->
                                            <div class="mt-2">
                                                <label><strong>Available Now (Online / Offline):</strong></label><br>
                                                <input type="hidden" name="is_online" value="0">
                                                <input type="checkbox" id="is_online" name="is_online" value="1"
                                                    {{ $isOnline ? 'checked' : '' }} onchange="updateAvailabilityStatus(this)">
                                                <span id="availabilityStatus">{{ $isOnline ? 'Online' : 'Offline' }}</span>
                                                <span id="availabilityStatusLabel" class="ms-2 badge {{ $isOnline ? 'bg-success' : 'bg-secondary' }}">
                                                    {{ $isOnline ? 'Yes' : 'No' }}
                                                </span>
                                            </div>
                                        </div>


                                        <!-- Hidden Walk-in Options -->


                                        <!-- tabs start -->
                                        @php
                                        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];

                                        @endphp

                                        <div class="">
                                            <div class="col-12">
                                                 <h1 class="mt-0 my-md-3 fs-28">Set Availability</h1>
                                            </div>
                                            <div class="mb-3">
                                                <div class="col-12">
                                                    <label class="form-label">Select Available Days:</label>
                                                </div>
                                                <div class="form-check days-list">
                                                    @foreach($days as $day)
                                                    @php $dayLower = strtolower($day); @endphp
                                                    <input class=" me-2 contact-method-checkbox" type="checkbox"
                                                        id="chk_{{ $day }}"
                                                        data-method="{{ $day }}"
                                                        {{ isset($availabilityByDay[$dayLower]) ? 'checked' : '' }}>

                                                    <label class="form-check-label mr-lg-4 mr-md-3" for="chk_{{ $day }}">{{ $day }}</label>
                                                    @endforeach
                                                </div>
                                            </div>

                                            <div id="time-slots-container">
                                                @foreach($availabilityByDay ?? [] as $day => $times)
                                                <div class="mb-3 time-slot day-slot" data-day="{{ $day }}" id="time-slot-{{ $day }}">
                                                    <div class="col-12">
                                                        <label class="form-label text-capitalize">{{ $day }} Time Slot:</label>
                                                    </div>
                                                    <div class="row mx-0 timeslotinput">
                                                        <div class="col-md-6">
                                                            @php
                                                            $allDay = isset($times['all_day']) && $times['all_day'];
                                                            @endphp
                                                            <select name="availability[{{ $day }}][start]" class="form-select start-time" {{ $allDay ? 'disabled' : '' }} required>

                                                                <option value="">Start Time</option>
                                                                @foreach (range(0, 47) as $i)
                                                                @php
                                                                // Dropdown times in 12-hour AM/PM format (e.g. 12:30 AM)
                                                                $timeValue = date('h:i A', strtotime("00:00") + $i * 30 * 60);

                                                                // Convert saved time (24-hour) to 12-hour format for comparison
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

                                            <div class="mt-4 col-12">
                                                <button type="submit" class="btn btn-maincolor" id="saveAvailabilityBtn">Save Availability</button>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>


        </div>
    </div>
</section>

@endsection
@push('js')
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

    $(document).on('change', '.contact-method-checkbox', function() {
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

    $('#saveAvailabilityBtn').on('click', function(e) {
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
            url: "{{ route('user.availability.save') }}",
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                availability: availability,
                availability_main: availability_main,
                walkin_type: walkin_type,
                is_online: is_online
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
</script>

@endpush