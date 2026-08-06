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
            Contact Us Listing
        </h3>
    </div>

    <div class="card p-4">

        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab" tabindex="0">

                <table class="table" id="contactus_list">
                    <thead class="table-dark">
                        <tr>
                            <th>S.no</th>
                            <th class="col-2">First Name</th>
                            <th class="col-2">Last Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Message</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php use Illuminate\Support\Str; @endphp
                        @foreach($contactus as $list)
                        <tr>
                            <td>{{$list['id']}}</td>
                            <td>{{$list['first_name']}}</td>
                            <td>{{$list['last_name']}}</td>
                            <td>{{$list['email']}}</td>
                            <td>{{$list['phone']}}</td>
                            <td>{{ Str::words($list['message'], 15, '...') }}</td>

                            <td>
                                <a class="view" href="{{ route('admin.view-contactus-details', ['id' => $list['id']]) }}" title="view"><i class="fas fa-eye"></i></a>
                                <!--<a class="delete" href="javascript:void(0);" data-delete-id="{{$list['id']}}" title="delete"><i class="fas fa-trash"></i></a>-->
                                <button type="submit" class="remove delete-btn" title="Remove" data-id="{{ $list['id'] }}" style="background: none; border: none; cursor: pointer;">
                                    <i class="fas fa-trash"></i>
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
    @endsection
    @push('js')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() {
            new DataTable('#contactus_list', {
                order: [
                    [0, 'desc']
                ]
            });

            $('.delete-btn').on('click', function() {
                var button = $(this);
                var itemId = button.data('id');
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
                        $.ajax({
                            url: '{{ route("admin.delete-contact-us", ":id") }}'.replace(':id', itemId),
                            type: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                button.closest('tr').remove();
                                Swal.fire(
                                    'Deleted!',
                                    response.message || 'Record has been deleted successfully!',
                                    'success'
                                );
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
        })
    </script>
    @endpush('js')