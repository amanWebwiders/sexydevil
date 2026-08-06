@extends('admin.layout.layout')
@section('content')
<style>
    input.pe-2 {
        margin-right: 5px;
        position: relative;
        top: 2px;
    }
    .btn{
        text-wrap-mode: nowrap;
    }
</style>

<div id="content" class="app-content">
    <section class="content">
        <div class="container-fluid">
            <div class="">
                <h3 class="">Client Management</h3>
            </div>
            <div class="row">
                <div class="col-12 mt-3">
                    <div class="card card-primary p-4">
                        <!-- End Add User Modal -->
                        <!-- End Edit Painting Modal -->

                        <div class="table-responsive">
                            <table class="table display" id="UserTable">
                                <thead class="table-dark">
                                    <tr>
                                        <th style="display: none;">S.No</th>
                                        <th>ID</th>
                                        <th>Full Name</th>
                                        <th>Email</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $index => $data)
                                    <tr>
                                        <td style="display: none;">{{ $index + 1 }}</td>
                                        <td>#{{ $data->unique_user_id }}</td>
                                        <td>{{ $data->name }}</td>
                                        <td>{{ $data->email }}</td>

                                        <td class="d-lg-flex gap-2">
                                            @if($data->user_status == 0)
                                            <button class="btn btn-warning block-btn" data-id="{{ $data->id }}">Block</button>
                                            @elseif($data->user_status == 1)
                                            <button class="btn btn-success unblock-btn" data-id="{{ $data->id }}">Unblock</button>
                                            @endif
                                            <button class="btn btn-danger delete-btn" data-id="{{ $data->id }}">Delete</button>
                                            <a href="{{ route('admin.userdetail', $data->id) }}" class="btn btn-primary">View</a>
                                            <!-- <button type="button" class="btn btn-primary show-data" data-toggle="modal"
                                                data-plan-id="{{ $data->id }}">
                                                Edit
                                            </button> -->
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editPlanForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="id" id="planId">
                    <input type="hidden" name="type" value="1">
                    <div class="mb-3">
                        <label for="name" class="form-label">Full Name</label>
                        <input type="text" class="form-control" id="name" name="name">
                        <div class="invalid-feedback name"></div>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" readonly>
                        <div class="invalid-feedback email"></div>
                    </div>

                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone</label>
                        <div class="d-flex gap-2">
                            <select class="form-select me-2" name="phone_code" id="phone_code" style="max-width: 30%;">
                                <option value="">Code</option>
                                @foreach($countryCodes as $country)
                                <option value="{{ $country->id }}" {{ $country->code == '+1' ? 'selected' : '' }}>
                                    {{ $country->country }} (+{{ $country->code }})
                                </option>
                                @endforeach
                            </select>
                            <input type="number" class="form-control" placeholder="Contact Number" name="phone" id="phone">
                        </div>
                        <div class="invalid-feedback phone"></div>
                    </div>

                   
                    <div class="modal-footer p-0">
                        <button type="submit" id="update_plan_changes" class="btn btn-primary">Save Changes</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
@endsection
@push('js')

<script>
    function updateTotalForGroup($group) {
        const fee = parseFloat($group.find('.fee').val()) || 0;
        const gst = parseFloat($group.find('.gst').val()) || 0;
        const total = fee + gst;
        $group.find('.total').val(total.toFixed(2));
    }

    $(document).on('input', '.fee, .gst', function() {
        const $group = $(this).closest('.form-container'); // Adjust this selector as needed
        updateTotalForGroup($group);
    });
    $(document).ready(function() {
        new DataTable('#UserTable', {
            order: [
                [0, 'asc']
            ]
        });


        $('.block-btn').on('click', function() {
            var userId = $(this).data('id');
            var $button = $(this);
            var url = '{{ route("admin.users.block", ":id") }}'; // Dynamic URL template for block
            url = url.replace(':id', userId); // Replace placeholder with actual user ID
            var blockText = 'Are you sure you want to block this client?';

            $button.prop('disabled', true);

            Swal.fire({
                title: 'Are you sure?',
                text: blockText,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, block!',
                cancelButtonText: 'No, cancel!',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: url,
                        type: 'POST',
                        data: {
                            _token: $('meta[name="csrf-token"]').attr('content') // CSRF token
                        },
                        success: function(response) {
                            Swal.fire(
                                'Blocked!',
                                response.message,
                                'success'
                            ).then(() => {
                                location.reload(); // Optionally reload the page
                            });
                        },
                        error: function(xhr) {
                            console.log(xhr.responseText);
                            Swal.fire(
                                'Error!',
                                'Something went wrong.',
                                'error'
                            );
                        }
                    }).always(function() {
                        $button.prop('disabled', false);
                    });
                } else {
                    $button.prop('disabled', false);
                }
            });
        });

        // Unblock button click event
        $('.unblock-btn').on('click', function() {
            var userId = $(this).data('id');
            var $button = $(this);
            var url = '{{ route("admin.users.unblock", ":id") }}'; // Dynamic URL template for unblock
            url = url.replace(':id', userId); // Replace placeholder with actual user ID
            var unblockText = 'Are you sure you want to unblock this client?';

            $button.prop('disabled', true);

            Swal.fire({
                title: 'Are you sure?',
                text: unblockText,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, unblock!',
                cancelButtonText: 'No, cancel!',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: url,
                        type: 'POST',
                        data: {
                            _token: $('meta[name="csrf-token"]').attr('content') // CSRF token
                        },
                        success: function(response) {
                            Swal.fire(
                                'Unblocked!',
                                response.message,
                                'success'
                            ).then(() => {
                                location.reload(); // Optionally reload the page
                            });
                        },
                        error: function(xhr) {
                            console.log(xhr.responseText);
                            Swal.fire(
                                'Error!',
                                'Something went wrong.',
                                'error'
                            );
                        }
                    }).always(function() {
                        $button.prop('disabled', false);
                    });
                } else {
                    $button.prop('disabled', false);
                }
            });
        });

        $('.delete-btn').on('click', function() {
            var userId = $(this).data('id');
            var $button = $(this);
            var url = '{{ route("admin.users.delete", ":id") }}'; // Dynamic URL template for reject
            url = url.replace(':id', userId); // Replace placeholder with actual user ID

            // Prompt for the rejection reason

            $button.prop('disabled', true);

            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'), // CSRF token

                },
                success: function(response) {
                    Swal.fire(
                        'Deleted!',
                        response.message,
                        'success'
                    ).then(() => {
                        location.reload(); // Optionally reload the page
                    });
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                    Swal.fire(
                        'Error!',
                        'Something went wrong.',
                        'error'
                    );
                }
            }).always(function() {
                $button.prop('disabled', false);
            });


        });
        $('.show-data').on('click', function() {

            console.log('Fetching plan data...');
            var planId = $(this).data('plan-id');
            var url = '{{ route("admin.edit-user", ":id") }}';
            url = url.replace(':id', planId);

            $.ajax({
                url: url,
                type: 'GET',
                success: function(response) {
                    if (response.status) {
                        $('#planId').val(response.data.id);
                        $('#name').val(response.data.name);
                        $('#email').val(response.data.email);
                        $('#phone').val(response.data.phone);
                        $('#phone_code').val(response.data.phone_code); // Make sure this matches the <option value="{{ $country->id }}">

                        $('#exampleModal').modal('show');
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response.message
                        });
                    }

                },
                error: function(xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Failed to fetch data'
                    });
                }
            });

        });
        $('#editPlanForm').on('submit', function(event) {
            console.log('dfdsbfhdsb');
            event.preventDefault(); // Prevent the default form submission
            var planId = $(this).data('plan-id');
            console.log(planId);
            var form = $(this);

            var formData = new FormData(form[0]);
            var url = '{{ route("admin.update-user", ":id") }}';
            url = url.replace(':id', $('#planId').val());

            $.ajax({
                url: url,
                type: 'post',
                headers: {
                    'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                },

                data: formData,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    form.find('button[type="submit"]').prop("disabled", true).text("Saving...");
                },
                success: function(response) {
                    if (response.status) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: response.message
                        }).then(function() {
                            $('#exampleModal').modal('hide');
                            location.reload();
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
                    var errors = xhr.responseJSON.errors;

                    // Display error messages next to the relevant fields
                    $.each(errors, function(key, value) {
                        var inputField = $('input[name="' + key +
                            '"], textarea[name="' + key + '"], select[name="' +
                            key + '"]');
                        var errorFeedback = inputField.siblings('.invalid-feedback');
                        errorFeedback.text(value[0]);
                        inputField.addClass(
                            'is-invalid'); // Add the 'is-invalid' class to the input
                    });
                },
                complete: function() {
                    form.find('button[type="submit"]').prop("disabled", false).text(
                        "Save changes");
                }
            });
        });
    })
</script>
@endpush('js')