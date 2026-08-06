@extends('admin.layout.layout')
@section('content')

<style>
    input.pe-2 {
        margin-right: 5px;
        position: relative;
        top: 2px;
    }

    button {
        text-wrap-mode: nowrap;
    }
</style>
<div id="content" class="app-content">
    <section class="content">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h3>Plan Management</h3>
            </div>
            <div class="">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addModal">
                    Add Plan
                </button>
            </div>
        </div>
        <div class="section-body">

            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-6 col-12">
                    <div class="card card-statistic-1 p-4">
                        <div >
                            <label ><input type="checkbox" {{ $admin->is_show_price == 1 ? 'checked':'' }} class="priceShow" > Price Show</label>
                        </div>
                        <div class="table-responsive mt-3">
                            <table id="usersTable" class="table ">
                                <thead class="table-dark">
                                    <tr>
                                        <th>S.no</th>
                                        <th>Title</th>
                                        <th>Description</th>
                                        <th>Days</th>
                                        <th>Appearance</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($data as $key=>$data)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $data->title }}</td>
                                        <td>{{ $data->description }}</td>
                                        <td>{{ $data->days }}</td>
                                        <td>{{ $data->visibility }}x</td>

                                        <td class="d-lg-flex gap-2">
                                            <button class="btn btn-danger delete-btn"
                                                data-id="{{ $data->id }}">Delete</button>
                                            <button type="button" class="btn btn-primary show-data" data-toggle="modal"
                                                data-plan-id="{{ $data->id }}">
                                                Edit
                                            </button>
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
        <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addModalLabel">Add Plan</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="Type-update-form" method="POST" enctype="multipart/form-data"
                            action="{{ route('admin.plan.add') }}">
                            @csrf

                            <div class="mb-3">
                                <label>Plan Title</label>
                                <input type="text" class="form-control" name="title">
                                <div class="invalid-feedback title"></div>
                                <div id="error_message" style="color:red;"></div>
                            </div>

                            <div class="mb-3">
                                <label for="heading" class="form-label">Plan Heading</label>
                                <input type="text" class="form-control" name="heading">
                                <div id="error_message" style="color:red;"></div>
                            </div>
                            <div class="mb-3">
                                <label>Plan Tag</label>
                                <input type="text" class="form-control" name="tag">
                                <div class="invalid-feedback tag"></div>
                                <div id="error_message" style="color:red;"></div>
                            </div>
                            <div class="mb-3">
                                <label>Description</label>
                                <textarea class="form-control" name="description" rows="10"
                                    placeholder="Enter description" required></textarea>
                                <!-- <textarea class="form-control" name="description" required></textarea> -->
                                <div class="invalid-feedback description"></div>
                            </div>

                            <div class="mb-3">
                                <label>Cost ($)</label>
                                <input type="number" class="form-control" name="cost" step="0.01" required>
                                <div class="invalid-feedback cost"></div>
                            </div>

                            <div class="mb-3">
                                <label>Number of Days</label>
                                <input type="number" class="form-control" name="days" required>
                                <div class="invalid-feedback days"></div>
                            </div>
                            <div class="mb-3">
                                <label>Appearance</label>
                                <select class="form-control" name="visibility" required >
                                    <option value="1" selected >1x</option>
                                    <option value="3">3x</option>
                                    <option value="5">5x</option>
                                </select>
                            </div>

                            <div class="modal-footer p-0">
                                <button type="submit" id="udpate_changes" class="btn btn-primary">Save Changes</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>

        </div>
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Plan</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="modal-body">
                            <form id="editPlanForm" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="id" id="planId">

                                <div class="mb-3">
                                    <label for="title" class="form-label">Plan Title</label>
                                    <input type="text" class="form-control" id="title" name="title">
                                    <div class="invalid-feedback title"></div>
                                </div>
                                <div class="mb-3">
                                    <label for="heading" class="form-label">Plan Heading</label>
                                    <input type="text" class="form-control" id="heading" name="heading">
                                    <div class="invalid-feedback heading"></div>
                                </div>
                                <div class="mb-3">
                                    <label for="tag" class="form-label">Plan Tag</label>
                                    <input type="text" class="form-control" id="tag" name="tag">
                                    <div class="invalid-feedback tag"></div>
                                </div>
                                <div class="mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea class="form-control" id="description" name="description" rows="10"
                                        placeholder="Enter description" required></textarea>
                                    <div class="invalid-feedback description"></div>
                                </div>

                                <div class="mb-3">
                                    <label for="cost" class="form-label">Cost ($)</label>
                                    <input type="number" class="form-control" id="cost" name="cost" step="0.001"
                                        required>
                                    <div class="invalid-feedback cost"></div>
                                </div>

                                <div class="mb-3">
                                    <label for="days" class="form-label">Number of Days</label>
                                    <input type="number" class="form-control" id="days" name="days" required>
                                    <div class="invalid-feedback days"></div>
                                </div>
                                <div class="mb-3">
                                    <label>Appearance</label>
                                    <select class="form-control" id="visibility" name="visibility" required >
                                        <option value="1">1x</option>
                                        <option value="3">3x</option>
                                        <option value="5">5x</option>
                                    </select>
                                </div>

                                <div class="modal-footer p-0">
                                    <button type="submit" id="update_plan_changes" class="btn btn-primary">Save
                                        Changes</button>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@endsection


@push('js')

<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    console.log('dshfdjhfvsd');

    $(document).ready(function() {
        // Handle form submission for adding Type
        $('#Type-update-form').on('submit', function(event) {
            console.log('dsfjsdgfhj');
            event.preventDefault(); // Prevent the default form submission

            // Clear previous error messages
            $('.invalid-feedback').empty();
            $('.form-control').removeClass('is-invalid');

            var form = $(this);
            var formData = new FormData(form[0]); // Use FormData to handle file uploads

            $.ajax({
                url: form.attr('action'), // Form action URL
                type: 'POST', // Form submission method
                data: formData, // FormData containing the file
                contentType: false, // Prevent setting Content-Type header
                processData: false, // Prevent jQuery from automatically processing the data
                beforeSend: function() {
                    $("#udpate_changes").prop("disabled", true);
                    $("#udpate_changes").text("Processing...");
                },
                success: function(response) {
                    $("#udpate_changes").prop("disabled", false);
                    $("#udpate_changes").text("Save Changes");

                    if (response.status) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: response.message,
                            confirmButtonText: 'OK'
                        }).then(function() {
                            // Disable the submit button and change its text
                            var submitButton = form.find('button[type="submit"]');
                            submitButton.prop('disabled', true).text('Added');

                            // Optionally reload the page or redirect
                            window.location
                                .reload(); // Uncomment this if you want to reload the page
                        });
                    } else {
                        $('#error_message').text(response.message);
                    }
                },
                error: function(xhr) {
                    $("#udpate_changes").prop("disabled", false);
                    $("#udpate_changes").text("Save Changes");

                    // Handle error response
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

                    $('#form-errors').show(); // Show the error container if needed
                }
            });
        });

        // Handle form submission in modal
        $('#editPlanForm').on('submit', function(event) {
            console.log('dfdsbfhdsb');
            event.preventDefault(); // Prevent the default form submission
            var planId = $(this).data('plan-id');
            console.log(planId);
            var form = $(this);


            var formData = new FormData(form[0]);
            var url = '{{ route("admin.plan.update", ":id") }}';
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

        // Handle showing data in modal
        $('.show-data').on('click', function() {

            console.log('Fetching plan data...');
            var planId = $(this).data('plan-id');
            var url = '{{ route("admin.plan.show", ":id") }}';
            url = url.replace(':id', planId);

            $.ajax({
                url: url,
                type: 'GET',
                success: function(response) {
                    if (response.status) {
                        $('#planId').val(response.data.id);
                        $('#title').val(response.data.title);
                        $('#heading').val(response.data.heading);
                        $('#cost').val(response.data.cost);
                        $('#days').val(response.data.days);
                        $('#tag').val(response.data.tag);
                        $('#description').val(response.data.description);
                        $('#visibility').val(response.data.visibility);                        
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
        $('.delete-btn').on('click', function() {
            var button = $(this);
            var itemId = button.data('id');
            var itemName = button.data('name') || 'Plan';

            Swal.fire({
                title: 'Are you sure?',
                text: `Do you really want to delete this ${itemName}?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel!',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    button.prop('disabled', true).text('Deleting...');

                    $.ajax({
                        url: '{{ route("admin.plandelete", ":id") }}'.replace(':id',
                            itemId),
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            button.closest('tr').remove();
                            Swal.fire(
                                'Deleted!',
                                response.message || 'Item deleted successfully!',
                                'success'
                            ).then(function() { // Move .then() inside Swal.fire correctly
                                $('#exampleModal').modal('hide');
                                location.reload();
                            });
                        },
                        error: function(xhr) {
                            Swal.fire(
                                'Error!',
                                'An error occurred while deleting the item.',
                                'error'
                            );
                        },
                        complete: function() {
                            button.prop('disabled', false).text('Delete');
                        }
                    });
                }
            });
        });

        $('#usersTable').DataTable({
            "paging": true,
            "searching": true,
            "lengthChange": true,
            "pageLength": 10,
            "language": {
                "search": "Search Plan:",
                "lengthMenu": "Display _MENU_ Plan per page"
            }
        });
        $('.close, .btn-secondary').on('click', function() {
            $('#exampleModal').modal('hide');
        });
        $('#exampleModal').on('hidden.bs.modal', function() {
            $(this).find('form')[0].reset(); // Reset form
            $(this).find('.invalid-feedback').hide(); // Hide validation errors
        });
    });
$(document).on('click', '.priceShow', function() {
    var is_checked = $(this).is(":checked");
    $.ajax({
        url : "{{ route('admin.priceHideShow') }}",
        method : 'post',
        data : {
            is_checked:is_checked,
            "_token": "{{ csrf_token() }}"
        }, 
        success: function(response) {
            if(response.status == 200) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: response.message,
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: response.message,
                });
            }
        }
    })
})    
</script>
@endpush('js')