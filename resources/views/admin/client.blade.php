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
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 mt-3">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Client Management</h3>
                        </div>
                      

                        <!-- End Edit Painting Modal -->

                        <table class="table table-striped display" id="UserTable">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>Name</th>
                                    <th>Email</th> 
                                    <th>Phone No</th>   
                                    <th>Action</th>                
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $index => $data)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $data->name }}</td>
                                    <td>{{ $data->email }}</td>
                                    <td>+{{ $data->country->code }} {{ $data->phone }}</td>
                                    <td>
                                <a href="{{ route('admin.client-detail', $data->id) }}" class="btn btn-info btn-sm">
                                    View
                                </a>
                            </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
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

    $(document).on('input', '.fee, .gst', function () {
        const $group = $(this).closest('.form-container'); // Adjust this selector as needed
        updateTotalForGroup($group);
    });
    $(document).ready(function() {
        new DataTable('#UserTable', {
            order: [
                [0, 'asc']
            ]
        });


        $('.delete-btn').on('click', function() {
            var button = $(this);
            var itemId = button.data('id'); // Get the ID of the item to delete

            // Show SweetAlert confirmation dialog
            Swal.fire({
                title: 'Are you sure?',
                text: `Do you really want to delete this ?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel!',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    button.prop('disabled', true).text('Deleting...');
                    // Perform the AJAX request to delete the item
                    $.ajax({
                        url: '{{ route("admin.userdelete", ":id") }}'.replace(':id', itemId), // Replace the placeholder with the item ID
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}' // CSRF token
                        },
                        success: function(response) {
                            // Handle success (e.g., remove the item from the DOM)
                            button.closest('tr').remove(); // Assumes the button is within a <tr> element
                            Swal.fire(
                                'Deleted!',
                                response.message || 'Supplier deleted successfully!',
                                'success'
                            );
                        },
                        error: function(xhr) {
                            // Handle error
                            Swal.fire(
                                'Error!',
                                'An error occurred while deleting the Supplier.',
                                'error'
                            );
                        },
                        complete: function() {
                            // Re-enable the button if needed (optional)
                            button.prop('disabled', false).text('Delete');
                        }
                    });
                }
            });
        });
        $('#addUserForm').on('submit', function(event) {
            event.preventDefault(); // Stop form's default submission

            var form = $(this);
            var formData = new FormData(this); // Handles all input data

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
                            window.location.reload(); // Reload after success
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

                    // Clear previous errors
                    $('.text-danger').text('');
                    $('.form-control').removeClass('is-invalid');

                    if (xhr.responseJSON && xhr.responseJSON.errors) {
                        var errors = xhr.responseJSON.errors;

                        $.each(errors, function(key, value) {
                            var inputField = $('[name="' + key + '"]');
                            var errorSpan = $('#' + key + 'Error');

                            if (errorSpan.length) {
                                errorSpan.text(value[0]);
                            } else {
                                inputField.after('<span class="text-danger">' + value[0] + '</span>');
                            }

                            inputField.addClass('is-invalid');
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Something went wrong. Please try again.',
                        });
                    }
                }
            });
        });
        $('.edit-User').on('click', function() {
            var userId = $(this).data('id');
            var url = '{{ route("admin.edit-user", ":id") }}'.replace(':id', userId);

            $.ajax({
                url: url,
                type: 'GET',
                success: function(response) {
                    if (response.status === 1) {
                        let data = response.data;
                        $('#edit_user_id').val(data.id);
                        $('#edit_name').val(data.name);
                        $('#edit_email').val(data.email);
                        $('#edit_phone').val(data.phone);
                        $('#edit_description').val(data.description);
                        $('#edit_occupation_id').val(data.occupation_id);
                        $('#edit_fee').val(data.fee);
                        $('#edit_gst').val(data.gst);
                        $('#edit_total').val(data.total);
                        $('#edit_location').val(data.location);
                        $('#edit_country_code_id').val(data.country_code_id);
                        if (data.image) {
                            var imageUrl = '{{ asset("storage/") }}/' + data.image;
                            $('#edit_image_preview_img').attr('src', imageUrl).show();
                        } else {
                            $('#edit_image_preview_img').hide();
                        }
                               
                        $('#editUserModal').modal('show');
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response.message
                        });
                    }
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Failed to fetch data.'
                    });
                }
            });
        });

        $('#editUserForm').on('submit', function(event) {
            event.preventDefault(); // Prevent default form submission
            var form = $(this);
            var formData = new FormData(form[0]);
            var url = '{{ route("admin.update-user", ":id") }}'.replace(':id', $('#edit_user_id').val());

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
                    $('#edit-user-btn').prop('disabled', true).text('Processing...');
                },
                success: function(response) {
                    $('#edit-user-btn').prop('disabled', false).text('Update');
                    if (response.status === 1) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: response.message
                        }).then(function() {
                            $('#editUserModal').modal('hide');
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
                    $('#edit-user-btn').prop('disabled', false).text('Update');
                    $('.text-danger').text('');
                    $('.form-control').removeClass('is-invalid');

                    if (xhr.responseJSON && xhr.responseJSON.errors) {
                        var errors = xhr.responseJSON.errors;
                        $.each(errors, function(key, value) {
                            var inputField = $('[name="' + key + '"]');
                            var errorSpan = $('#' + key + 'Error');

                            if (errorSpan.length) {
                                errorSpan.text(value[0]);
                            } else {
                                inputField.after('<span class="text-danger">' + value[0] + '</span>');
                            }

                            inputField.addClass('is-invalid');
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Something went wrong. Please try again.',
                        });
                    }
                }
            });
        });

    })
</script>
@endpush('js')