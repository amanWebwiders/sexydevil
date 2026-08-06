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
            Change Your Password
        </h3>
    </div>

    <div class="card p-4">
        <!-- <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Change Password</button>
            </li>
        </ul> -->
        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab" tabindex="0">
                <!-- <h3 class="mt-2 mb-4">Change Your Password</h3> -->
                <form method="POST" action="javascript:void(0)" id="ChangePassword">
                    @csrf
                    <div class="row">
                        <div class="col-md-4 mb-4">
                            <label class="form-label">Old Password</label>
                            <input type="password" class="form-control" id="old_password" name="old_password" required>
                        </div>
                        <div class="col-md-4 mb-4">
                            <label class="form-label">New Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="col-md-4 mb-4">
                            <label class="form-label">Confirm Password</label>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                        </div>
                      
                    </div>
                    <div class="text-end">
                        <button type="submit" class="btn ms-auto mt-3 text-white" name="change_passwoed_btn" id="change_passwoed_btn">Submit</button>
                    </div>
                </form>
            </div>
            
        </div>



    </div>

@endsection
@push('js')

 <script>
        $(document).ready(function() {
        
            $('#change_passwoed_btn').click(function(event) {
                event.preventDefault();

                var old_password = $('#old_password').val();
                var password = $('#password').val();
                var password_confirmation = $('#password_confirmation').val();

                console.log('old_password', old_password);
                console.log('password', password);
                console.log('password_confirmation', password_confirmation);
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{ route('admin.change-password') }}",
                    type: 'POST',
                    data: {
                        old_password: old_password,
                        password: password,
                        password_confirmation: password_confirmation,
                    },
                    dataType: 'json',
                    beforeSend: function() {
                        $('#change_passwoed_btn').prop('disabled', true);
                        $('#change_passwoed_btn').text('Processing..');
                    },
                    success: function(res) {
                        $('#change_passwoed_btn').prop('disabled', false);
                        $('#change_passwoed_btn').text('Update');
                        if (res.status == 1) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: res.message,
                            }).then(function() {
                                window.location.reload();
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: res.message,
                            }).then(function() {

                            });
                        }
                    },
                    error: function(error) {
                        $('#change_passwoed_btn').prop('disabled', false);
                        $('#change_passwoed_btn').text('Update');
                        $('.text-danger').remove();
                        if (error.responseJSON && error.responseJSON.errors) {
                            for (var err in error.responseJSON.errors) {
                                if (error.responseJSON.errors.hasOwnProperty(err)) {
                                    var errorMessage = error.responseJSON.errors[err][0];
                                    $("[name='" + err + "']").after("<div class='text-danger'>" + errorMessage +
                                        "</div>");
                                }
                            }
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: error.responseJSON.message,
                            }).then(function() {

                            });
                        }
                    }
                });
                return false;
            });

        });
    </script>
    @endpush('js')