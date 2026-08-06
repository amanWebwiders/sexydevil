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
           Occupation
        </h3>
    </div>

    <div class="card p-4">

        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab" tabindex="0">
                <!-- <h3 class="mt-2 mb-4">Update User Type Management(Occupation)</h3> -->
                <form method="POST" action="javascript:void(0)" id="EditOccupation" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-4 mb-2">
                            <label class="form-label">Name</label>
                        </div>
                    </div>
                    @foreach ($data as $data)
                    <div class="row occupation-data" data-id="{{ $data->id }}">
                        <div class="col-md-4 mb-2">
                            <input type="text" class="form-control" id="name" name="name[]" value="{{ $data->name }}" required>
                        </div>

                    </div>
                    @endforeach
                    <div class="text-end">
                        <button type="submit" class="btn ms-auto mt-3" name="update_btn" id="update_btn">Update</button>
                    </div>
                </form>
            </div>

        </div>



    </div>

    @endsection
    @push('js')
    <script>
        $('#update_btn').click(function(event) {
            event.preventDefault();
            var occupationData = [];
            $(".occupation-data").each(function() {
                var row = $(this);
                var id = row.data('id');
                var name = row.find("input[name='name[]']").val();
                

                occupationData.push({
                    id: id,
                    name: name,
                });
            });

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ route('admin.storeOccupation') }}",
                type: 'POST',
                data: {
                    occupations: occupationData
                },
                dataType: 'json',
                beforeSend: function() {
                    $('#update_btn').prop('disabled', true);
                    $('#button-text').hide();
                    $('#loader').show();
                },
                success: function(res) {
                    $('#update_btn').prop('disabled', false);
                    $('#button-text').show();
                    $('#loader').hide();
                    if (res.status == 1) {
                            console.log('success status');
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: res.message,
                            }).then(function() {
                                window.location.href = "{{ route('admin.occupation') }}";
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
                    $('#update_btn').prop('disabled', false);
                    $('#button-text').show();
                    $('#loader').hide();
                    if (error.responseJSON && error.responseJSON.errors) {
                        $('.text-danger').remove();
                        $.each(error.responseJSON.errors, function(field, messages) {
                            var match = field.match(/names\.(\d+)\.name/);
                            if (match) {
                                var index = match[1];
                                var inputField = $("input[name='gender_name[]']")
                                    .eq(index);

                                if (inputField.length > 0) {
                                    inputField.next(".text-danger").remove();
                                    inputField.after("<div class='text-danger'>" +
                                        messages[0] + "</div>");
                                } else {
                                    console.warn('No input field found for index:',
                                        index);
                                }
                            } else {
                                console.warn('No matching input field for field:',
                                    field);
                            }
                        });
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

        });
    </script>
    @endpush