@extends('admin.layout.layout')
@section('content')
<style>
    input.pe-2 {
        margin-right: 5px;
        position: relative;
        top: 2px;
    }

    .btn {
        text-wrap-mode: nowrap;
    }
</style>

<div id="content" class="app-content">
    <section class="content">
        <div class="container-fluid">
            <div class="">
                <h3 class="">Subscribtion History</h3>
            </div>
            <div class="row">
                <div class="col-12 mt-3">
                    <div class="card card-primary p-4">






                        <!-- End Add User Modal -->




                        <!-- End Edit Painting Modal -->

                        <div class="table-responsive">
                            <table class="table  display" id="UserTable">
                                <thead class="table-dark">
                                    <tr>
                                        <th>S.No</th>
                                        <th>Transaction Id</th>
                                        <th>Full Name</th>
                                        <th>Cost</th>
                                        <th>Plan Name</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Date of Payment</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $index => $data)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>#{{ $data->transaction_id }}</td>
                                        <td>{{ $data->user->name }}</td>
                                        <td>${{ $data->amount }}</td>
                                        <td>
                                            {{ $data->plan->title }}
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($data->user->plan_start_date)->format('d M Y') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($data->user->plan_end_date)->format('d M Y') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($data->created_at)->format('d M Y h:i A') }}</td>

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


        $('.accept-btn').on('click', function() {
            var userId = $(this).data('id');
            var $button = $(this);
            var url = '{{ route("admin.users.accept", ":id") }}'; // Dynamic URL template
            url = url.replace(':id', userId); // Replace placeholder with actual user ID
            var successText = 'Are you sure you want to Approve this user?';

            $button.prop('disabled', true);

            Swal.fire({
                title: 'Are you sure?',
                text: successText,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, proceed!',
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
                                'Success!',
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

        $('.reject-btn').on('click', function() {
            var userId = $(this).data('id');
            var $button = $(this);
            var url = '{{ route("admin.users.reject", ":id") }}'; // Dynamic URL template for reject
            url = url.replace(':id', userId); // Replace placeholder with actual user ID

            // Prompt for the rejection reason
            Swal.fire({
                title: 'Are you sure?',
                text: 'Please provide a reason for rejecting this user.',
                input: 'textarea', // Use textarea for the reason
                inputPlaceholder: 'Enter reason here...',
                inputAttributes: {
                    'aria-label': 'Enter reason for rejection'
                },
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, reject!',
                cancelButtonText: 'No, cancel!',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    var reason = result.value; // Get the reason from the input

                    if (reason) { // Check if the reason is not empty
                        $button.prop('disabled', true);

                        $.ajax({
                            url: url,
                            type: 'POST',
                            data: {
                                _token: $('meta[name="csrf-token"]').attr('content'), // CSRF token
                                reason: reason // Send the reason with the request
                            },
                            success: function(response) {
                                Swal.fire(
                                    'Rejected!',
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
                        Swal.fire(
                            'Cancelled',
                            'Rejection reason is required!',
                            'info'
                        );
                    }
                } else {
                    $button.prop('disabled', false);
                }
            });
        });

    })
</script>
@endpush('js')