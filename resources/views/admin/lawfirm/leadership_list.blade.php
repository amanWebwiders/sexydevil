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
            Leadership Listing
        </h3>
        <!--<div class="text-end">-->
        <!--    <a href="#" class="btn ms-auto mt-3">Add Leadership</a>-->
        <!--</div>-->
        <div class="ms-auto">
			<a href="{{ route("admin.add-leadership") }}" class="btn btn-theme fw-semibold fs-13px"><i class="fa fa-plus fa-fw me-1"></i> Add Leadership</a>
		</div>
    </div>

    <div class="card p-4">

        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab" tabindex="0">
             
                <table class="table" id="leadership-list">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col">S.no</th>
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Phone</th>
                            <th scope="col">address</th>
                            <th scope="col">Image</th>
                            <th scope="col">Fee</th>
                            <!--<th scope="col">Description</th>-->
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php use Illuminate\Support\Str; @endphp
                        @foreach($leadership as $list)
                            <tr>
                                <td>{{$list['id']}}</td>
                                <td>{{$list['name']}}</td>
                                <td>{{$list['email']}}</td>
                                <td>{{ $list['country_code'] }}{{$list['phone']}}</td>
                                <td>{{$list['address']}}</td>
                                <td><img src="{{ $list['image'] ? asset('storage/' . $list['image']) : asset('admin/assets/img/no_image.png') }}" alt="image" width="60"></td>
                                <td>{{$list['leadership_fee']}}</td>
                                <!--<td>{{ Str::words($list['description'], 15, '...') }}</td>-->
                               
                                <td>
                                  <a class="view" href="{{ route('admin.view-leadership-details', ['id' => $list['id']]) }}" title="view"><i class="fas fa-eye"></i></a>
                                  <a class="edit" href="{{ route('admin.edit-leadership', ['id' => $list['id']]) }}" title="edit"><i class="fas fa-edit"></i></a>
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
@endsection
@push('js')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
  <script>
    
    $(document).ready(function () {
        new DataTable('#leadership-list', {
            order: [[0, 'desc']]
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
                        url: '{{ route("admin.delete-leadership", ":id") }}'.replace(':id', itemId),
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