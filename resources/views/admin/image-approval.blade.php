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
                <h3>Image Approval</h3>
            </div>
             
        </div>
        <div class="section-body">

            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-6 col-12">
                    <div class="card card-statistic-1 p-4">
                        
                        <div class="table-responsive mt-3">
                            <table class="table table-bordered" id="users-table">
                            <thead>
                                <tr>
                                    <th>Sl. No.</th>
                                    <th>Name</th>
                                    <th>Image</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        </table>
                        </div>
                </div>

            </div>

        </div>

    </div>
 </section>
</div>
<!-- The Modal -->
<div class="modal" id="myModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Image Reject</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <!-- Modal body -->
      <form id="rejectForm" onsubmit="return rejectImage()" method="post">
            <div class="modal-body">
                        <input type="hidden" name="image_id" id="image_id">
                        <div class="form-group">
                            <img id="image_preview" src="" alt="Image Preview" style="max-width: 25%;margin-bottom: 15px;">
                        </div>
                        <div class="form-group">
                            <label for="reason">Reason for Rejection:</label>
                            <textarea class="form-control" id="reason" placeholder="Reason for rejection" name="reason" required></textarea>
                        </div>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-info" >Submit</button>
            </div>
        </form>

    </div>
  </div>
</div>



@endsection
@push('js')
<script>
        $(function () {
            $('#users-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('admin.image-approval') }}",
                    type: "POST",
                    data: function (d) {
                        // You can send additional parameters here if needed
                        d._token = "{{ csrf_token() }}"; // very important for POST in Laravel
                    }
                },
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false}, // 👈 add this
                    {
                        data: null, // no direct field — we'll combine name + email manually
                        name: 'name',
                        render: function (data, type, row) {
                            return `<strong>${row.name}</strong><br><small>${row.email}</small>`;
                        }
                    },
                    {data: 'image', name: 'image'},
                    {data: 'status', name: 'status'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ]
            });
        });

        $(document).on('click', '.approveImage', function(){
            var id = $(this).data('id');
            var thiss = $(this);
            var is_approved = 1;
            var currentText = $(this).text();
            if(confirm('Are you sure?')) {
                $.ajax({
                    url : "{{ route('admin.image-approval-action') }}",
                    method : "get",
                    data : {
                        id:id,
                       is_approved:is_approved
                    },
                    beforeSend : function () {
                        thiss.text("Process ......");
                        thiss.prop('disabled', true);
                    }, 
                    success : function(data) {
                        thiss.text("Submit");
                        thiss.prop('disabled', false);
                        if(data.status == 200) {
                            $('#users-table').DataTable().ajax.reload(null, false);
                            Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                text: data.message
                            })
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: data.message
                            });
                        }
                    }
                })
            }
        })

    $(document).on('click', '.rejectImage', function(){
            var id = $(this).data('id');
            $('#image_id').val(id);
            $('#myModal').modal('toggle');
            var imageUrl = $(this).data('image');
            $('#image_preview').attr('src', imageUrl);
            $("#reason").val('');
        })
        function rejectImage() {
            var id = $('#image_id').val();
            var reason = $('#reason').val();
            var thiss = $('#rejectForm button[type="submit"]');
            var is_approved = 2;
            $.ajax({
                url : "{{ route('admin.image-approval-action') }}",
                method : "post",
                data : {
                    id:id,
                    is_approved:is_approved,
                    reason:reason,
                    _token: "{{ csrf_token() }}"
                },
                beforeSend : function () {
                    thiss.text("Process ......");
                    thiss.prop('disabled', true);
                }, 
                success : function(data) {
                    thiss.text("Submit");
                    thiss.prop('disabled', false);
                    if(data.status == 200) {                        
                        $('#users-table').DataTable().ajax.reload(null, false);
                        $('#myModal').modal('hide');
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: data.message
                        })
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: data.message
                        });
                    }
                }
            })
            return false; // Prevent form submission
        }
    </script>
@endpush('js')