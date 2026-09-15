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
                <button type="button" class="btn btn-primary" id="addPlanBtn" data-bs-toggle="modal" data-bs-target="#addModal" data-toggle="modal" data-target="#addModal">
                    <i class="fa fa-plus me-1"></i> Add Plan
                </button>
            </div>
        </div>
        <div class="section-body">

            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-6 col-12">
                    <div class="card card-statistic-1 p-4">
                        <div>
                            <label><input type="checkbox" {{ $admin->is_show_price == 1 ? 'checked':'' }} class="priceShow"> Price Show</label>
                        </div>
                        <div class="table-responsive mt-3">
                            <table id="usersTable" class="table">
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
                                    @foreach ($data as $key => $plan)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $plan->title }}</td>
                                        <td>{{ $plan->description }}</td>
                                        <td>{{ $plan->days }}</td>
                                        <td>{{ $plan->visibility }}x</td>

                                        <td class="d-lg-flex gap-2">
                                            <button type="button" class="btn btn-danger delete-btn"
                                                data-id="{{ $plan->id }}" data-name="{{ $plan->title }}">Delete</button>
                                            <button type="button" class="btn btn-primary show-data"
                                                data-plan-id="{{ $plan->id }}">
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

        <!-- Add Plan Modal -->
        <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addModalLabel">Add Plan</h5>
                        <button type="button" class="btn-close close" data-bs-dismiss="modal" data-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="Type-update-form" method="POST" enctype="multipart/form-data"
                            action="{{ route('admin.plan.add') }}">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label">Plan Title</label>
                                <input type="text" class="form-control" name="title" required>
                                <div class="invalid-feedback title"></div>
                            </div>

                            <div class="mb-3">
                                <label for="heading" class="form-label">Plan Heading</label>
                                <input type="text" class="form-control" id="add_heading" name="heading">
                                <div class="invalid-feedback heading"></div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Plan Tag</label>
                                <input type="text" class="form-control" name="tag">
                                <div class="invalid-feedback tag"></div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Description</label>
                                <textarea class="form-control" name="description" rows="5"
                                    placeholder="Enter description" required></textarea>
                                <div class="invalid-feedback description"></div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Cost ($)</label>
                                <input type="number" class="form-control" name="cost" step="0.01" required>
                                <div class="invalid-feedback cost"></div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Number of Days</label>
                                <input type="number" class="form-control" name="days" required>
                                <div class="invalid-feedback days"></div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Appearance</label>
                                <select class="form-control form-select" name="visibility" required>
                                    <option value="1" selected>1x</option>
                                    <option value="3">3x</option>
                                    <option value="5">5x</option>
                                </select>
                                <div class="invalid-feedback visibility"></div>
                            </div>

                            <div id="add_error_message" class="text-danger mb-2"></div>

                            <div class="modal-footer p-0 pt-3">
                                <button type="submit" id="udpate_changes" class="btn btn-primary">Save Changes</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" data-dismiss="modal">Close</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>

        </div>

        <!-- Edit Plan Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Plan</h5>
                        <button type="button" class="btn-close close" data-bs-dismiss="modal" data-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="editPlanForm" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="id" id="planId">

                            <div class="mb-3">
                                <label for="title" class="form-label">Plan Title</label>
                                <input type="text" class="form-control" id="title" name="title" required>
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
                                <textarea class="form-control" id="description" name="description" rows="5"
                                    placeholder="Enter description" required></textarea>
                                <div class="invalid-feedback description"></div>
                            </div>

                            <div class="mb-3">
                                <label for="cost" class="form-label">Cost ($)</label>
                                <input type="number" class="form-control" id="cost" name="cost" step="0.01"
                                    required>
                                <div class="invalid-feedback cost"></div>
                            </div>

                            <div class="mb-3">
                                <label for="days" class="form-label">Number of Days</label>
                                <input type="number" class="form-control" id="days" name="days" required>
                                <div class="invalid-feedback days"></div>
                            </div>

                            <div class="mb-3">
                                <label for="visibility" class="form-label">Appearance</label>
                                <select class="form-control form-select" id="visibility" name="visibility" required>
                                    <option value="1">1x</option>
                                    <option value="3">3x</option>
                                    <option value="5">5x</option>
                                </select>
                                <div class="invalid-feedback visibility"></div>
                            </div>

                            <div id="edit_error_message" class="text-danger mb-2"></div>

                            <div class="modal-footer p-0 pt-3">
                                <button type="submit" id="update_plan_changes" class="btn btn-primary">Save Changes</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" data-dismiss="modal">Close</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@endsection


@push('js')
<script>
    $(document).ready(function() {
        // Initialize DataTable safely
        if (!$.fn.DataTable.isDataTable('#usersTable')) {
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
        }

        // Open Add Plan Modal (supports both BS5 data attributes and direct click)
        $(document).on('click', '#addPlanBtn, [data-bs-target="#addModal"], [data-target="#addModal"]', function(e) {
            e.preventDefault();
            $('#addModal').modal('show');
        });

        // Close/Dismiss modals manually if needed
        $(document).on('click', '[data-bs-dismiss="modal"], [data-dismiss="modal"], .btn-close, .close', function() {
            $('#addModal').modal('hide');
            $('#exampleModal').modal('hide');
        });

        // Reset Add Modal on hidden
        $('#addModal').on('hidden.bs.modal', function() {
            var form = $(this).find('form');
            if (form.length) form[0].reset();
            $(this).find('.invalid-feedback').hide().empty();
            $(this).find('.form-control, .form-select').removeClass('is-invalid');
            $('#add_error_message').empty();
            $('#udpate_changes').prop('disabled', false).text('Save Changes');
        });

        // Reset Edit Modal on hidden
        $('#exampleModal').on('hidden.bs.modal', function() {
            var form = $(this).find('form');
            if (form.length) form[0].reset();
            $(this).find('.invalid-feedback').hide().empty();
            $(this).find('.form-control, .form-select').removeClass('is-invalid');
            $('#edit_error_message').empty();
            $('#update_plan_changes').prop('disabled', false).text('Save Changes');
        });

        // Delegated form submission for adding Plan
        $(document).on('submit', '#Type-update-form', function(event) {
            event.preventDefault();

            var form = $(this);
            form.find('.invalid-feedback').empty().hide();
            form.find('.form-control, .form-select').removeClass('is-invalid');
            $('#add_error_message').empty();

            var submitBtn = form.find('button[type="submit"]');
            var formData = new FormData(form[0]);

            $.ajax({
                url: form.attr('action'),
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    submitBtn.prop("disabled", true).text("Saving...");
                },
                success: function(response) {
                    submitBtn.prop("disabled", false).text("Save Changes");

                    if (response.status) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: response.message || 'Plan added successfully!',
                            confirmButtonText: 'OK'
                        }).then(function() {
                            $('#addModal').modal('hide');
                            window.location.reload();
                        });
                    } else {
                        $('#add_error_message').text(response.message || 'Failed to add plan.');
                    }
                },
                error: function(xhr) {
                    submitBtn.prop("disabled", false).text("Save Changes");

                    if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
                        var errors = xhr.responseJSON.errors;
                        $.each(errors, function(key, value) {
                            var inputField = form.find('[name="' + key + '"]');
                            var errorFeedback = inputField.siblings('.invalid-feedback');
                            if (errorFeedback.length) {
                                errorFeedback.text(value[0]).show();
                            }
                            inputField.addClass('is-invalid');
                        });
                    } else {
                        var msg = (xhr.responseJSON && xhr.responseJSON.message) ? xhr.responseJSON.message : 'An error occurred while adding the plan.';
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: msg
                        });
                    }
                }
            });
        });

        // Delegated form submission for updating Plan
        $(document).on('submit', '#editPlanForm', function(event) {
            event.preventDefault();

            var form = $(this);
            form.find('.invalid-feedback').empty().hide();
            form.find('.form-control, .form-select').removeClass('is-invalid');
            $('#edit_error_message').empty();

            var submitBtn = form.find('button[type="submit"]');
            var formData = new FormData(form[0]);
            var url = '{{ route("admin.plan.update", ":id") }}'.replace(':id', $('#planId').val());

            $.ajax({
                url: url,
                type: 'POST',
                headers: {
                    'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                },
                data: formData,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    submitBtn.prop("disabled", true).text("Saving...");
                },
                success: function(response) {
                    submitBtn.prop("disabled", false).text("Save Changes");

                    if (response.status) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: response.message || 'Plan updated successfully!'
                        }).then(function() {
                            $('#exampleModal').modal('hide');
                            window.location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: response.message || 'Failed to update plan.'
                        });
                    }
                },
                error: function(xhr) {
                    submitBtn.prop("disabled", false).text("Save Changes");

                    if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
                        var errors = xhr.responseJSON.errors;
                        $.each(errors, function(key, value) {
                            var inputField = form.find('[name="' + key + '"]');
                            var errorFeedback = inputField.siblings('.invalid-feedback');
                            if (errorFeedback.length) {
                                errorFeedback.text(value[0]).show();
                            }
                            inputField.addClass('is-invalid');
                        });
                    } else {
                        var msg = (xhr.responseJSON && xhr.responseJSON.message) ? xhr.responseJSON.message : 'An error occurred while updating the plan.';
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: msg
                        });
                    }
                }
            });
        });

        // Delegated click for showing edit modal data
        $(document).on('click', '.show-data', function(e) {
            e.preventDefault();
            var planId = $(this).data('plan-id');
            var url = '{{ route("admin.plan.show", ":id") }}'.replace(':id', planId);

            $.ajax({
                url: url,
                type: 'GET',
                success: function(response) {
                    if (response.status && response.data) {
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
                            title: 'Error!',
                            text: response.message || 'Could not load plan details.'
                        });
                    }
                },
                error: function(xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Failed to fetch plan data.'
                    });
                }
            });
        });

        // Delegated click for delete button (works across pagination/filtering)
        $(document).on('click', '.delete-btn', function(e) {
            e.preventDefault();
            var button = $(this);
            var itemId = button.data('id');
            var itemName = button.data('name') || 'Plan';

            Swal.fire({
                title: 'Are you sure?',
                text: `Do you really want to delete "${itemName}"?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    button.prop('disabled', true).text('Deleting...');

                    $.ajax({
                        url: '{{ route("admin.plandelete", ":id") }}'.replace(':id', itemId),
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Deleted!',
                                text: response.message || 'Plan deleted successfully!'
                            }).then(function() {
                                window.location.reload();
                            });
                        },
                        error: function(xhr) {
                            button.prop('disabled', false).text('Delete');
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: (xhr.responseJSON && xhr.responseJSON.message) ? xhr.responseJSON.message : 'An error occurred while deleting the item.'
                            });
                        }
                    });
                }
            });
        });

        // Price Show toggle
        $(document).on('change', '.priceShow', function() {
            var is_checked = $(this).is(":checked");
            $.ajax({
                url: "{{ route('admin.priceHideShow') }}",
                method: 'POST',
                data: {
                    is_checked: is_checked,
                    "_token": "{{ csrf_token() }}"
                },
                success: function(response) {
                    if (response.status == 200) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: response.message,
                            timer: 1500,
                            showConfirmButton: false
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: response.message,
                        });
                    }
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Failed to update price visibility setting.',
                    });
                }
            });
        });
    });
</script>
@endpush