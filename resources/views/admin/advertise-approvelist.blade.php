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
                <h3 class="-">Approve Advertiser</h3>
            </div>
            <div class="row">
                <div class="col-12 mt-3">
                    <div class="table-responsive">
                            <table class="table display" id="UserTable" style="width: 1300px;">
                                <thead class="table-dark">
                                    <tr>
                                        <th style="display: none;">S.No</th>
                                        <th>ID</th>
                                        <th>Full Name</th>
                                        <th>Email</th>
                                        <th>Age</th>
                                        <th>Phone Number</th>
                                        <th>Nationality</th>
                                        <th style="width:100px">Plan</th>                                        
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $index => $_data)
                                    <tr>
                                        <td style="display: none;">{{ $index + 1 }}</td>
                                        <td>#{{ $_data->unique_user_id }}</td>
                                        <td>{{ $_data->name }}</td>
                                        <td>{{ $_data->email }}</td>
                                        <td>
                                            {{ \Carbon\Carbon::parse($_data->dob)->age }} Y
                                        </td>
                                        <td>
                                            +{{ $_data->phone_code }} {{ $_data->phone }}
                                        </td>
                                         <td>{{ $_data->nationality->country ?? '-' }}</td>
                                        <td>
                                            @if(isset($_data->plan_end_date) && $_data->plan_end_date < now())
                                            <label class="badge badge-danger" >Expired</label>
                                            @else
                                            {{ $_data->plan->title ?? '-' }}<br>
                                                {{ $_data->plan_start_date ?? '-' }}<br>
                                                {{ $_data->plan_end_date ?? '-' }}
                                            @endif
                                        </td>
                                        <td class="d-lg-flex gap-1 flex-wrap">
                                            @if($_data->user_status == 0)
                                            <button class="btn btn-sm btn-warning block-btn" data-id="{{ $_data->id }}">Block</button>
                                            @elseif($_data->user_status == 1)
                                            <button class="btn btn-sm btn-success unblock-btn" data-id="{{ $_data->id }}">Unblock</button>
                                            @endif
                                            <button class="btn btn-sm btn-danger delete-btn" data-id="{{ $_data->id }}">Delete</button>
                                            <a href="{{ route('admin.userdetail', $_data->id) }}" class="btn btn-sm btn-primary">View</a>
                                            <a href="{{ route('admin.edit-user', $_data->id) }}" class="btn btn-sm btn-info text-white">Edit</a>
                                            <button class="btn btn-sm btn-secondary password-btn" data-id="{{ $_data->id }}" data-name="{{ $_data->name }}" data-email="{{ $_data->email }}" title="Manage Password">
                                                <i class="fa-solid fa-key"></i> Password
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


        // Delegated Block button
        $(document).on('click', '.block-btn', function() {
            var userId = $(this).data('id');
            var $button = $(this);
            var url = '{{ route("admin.users.block", ":id") }}'.replace(':id', userId);

            Swal.fire({
                title: 'Block Profile?',
                text: 'Are you sure you want to block this advertiser profile?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, Block!',
                cancelButtonText: 'Cancel',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    $button.prop('disabled', true);
                    $.ajax({
                        url: url,
                        type: 'POST',
                        data: {
                            _token: $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            Swal.fire('Blocked!', response.message, 'success').then(() => {
                                location.reload();
                            });
                        },
                        error: function(xhr) {
                            console.error(xhr.responseText);
                            Swal.fire('Error!', 'Something went wrong while blocking.', 'error');
                        }
                    }).always(function() {
                        $button.prop('disabled', false);
                    });
                }
            });
        });

        // Delegated Unblock button
        $(document).on('click', '.unblock-btn', function() {
            var userId = $(this).data('id');
            var $button = $(this);
            var url = '{{ route("admin.users.unblock", ":id") }}'.replace(':id', userId);

            Swal.fire({
                title: 'Unblock Profile?',
                text: 'Are you sure you want to unblock this advertiser profile?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Yes, Unblock!',
                cancelButtonText: 'Cancel',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    $button.prop('disabled', true);
                    $.ajax({
                        url: url,
                        type: 'POST',
                        data: {
                            _token: $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            Swal.fire('Unblocked!', response.message, 'success').then(() => {
                                location.reload();
                            });
                        },
                        error: function(xhr) {
                            console.error(xhr.responseText);
                            Swal.fire('Error!', 'Something went wrong while unblocking.', 'error');
                        }
                    }).always(function() {
                        $button.prop('disabled', false);
                    });
                }
            });
        });

        // Delegated Delete button
        $(document).on('click', '.delete-btn', function() {
            var userId = $(this).data('id');
            var $button = $(this);
            var url = '{{ route("admin.users.delete", ":id") }}'.replace(':id', userId);

            Swal.fire({
                title: 'Delete Profile Permanently?',
                text: 'This will permanently delete this profile, all uploaded photos, videos, and associated records. This action cannot be undone!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                confirmButtonText: 'Yes, Delete Permanently!',
                cancelButtonText: 'Cancel',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    $button.prop('disabled', true);
                    Swal.fire({
                        title: 'Deleting...',
                        text: 'Cleaning up profile assets and data...',
                        allowOutsideClick: false,
                        didOpen: () => { Swal.showLoading(); }
                    });

                    $.ajax({
                        url: url,
                        type: 'POST',
                        data: {
                            _token: $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            Swal.fire('Deleted!', response.message, 'success').then(() => {
                                location.reload();
                            });
                        },
                        error: function(xhr) {
                            console.error(xhr.responseText);
                            var msg = 'Something went wrong while deleting profile.';
                            if (xhr.responseJSON && xhr.responseJSON.message) {
                                msg = xhr.responseJSON.message;
                            }
                            Swal.fire('Error!', msg, 'error');
                        }
                    }).always(function() {
                        $button.prop('disabled', false);
                    });
                }
            });
        });
    });
</script>

@include('admin.component.password_modal')
@endpush('js')