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
                <h3>Incoming Manually Boost Requests</h3>
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
                                    <th>Ups</th>
                                    <th>Status</th>
                                    <th>Request At</th>
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
@endsection
@push('js')
<script>
        $(function () {
            $('#users-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('admin.manually-boost-request') }}",
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
                    {data: 'ups_quantity', name: 'ups_quantity'},
                    {data: 'status', name: 'status'},
                    {data: 'request_at', name: 'request_at'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ]
            });
        });

        $(document).on('click', '.approveImage', function(){
            var id = $(this).data('id');
            var user_id = $(this).data('userid');

            var thiss = $(this);
            var is_approved = 1;
            var currentText = $(this).text();
            if(confirm('Are you sure?')) {
                $.ajax({
                    url : "{{ route('admin.manually-boost-request-action') }}",
                    method : "get",
                    data : {
                        id:id,
                       is_approved: (currentText == "Approve") ? 1 : 2,
                        user_id:user_id
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
    </script>
@endpush('js')