@extends('front.layout.layout')

@section('content')

<style>
    @media screen and (min-width:991px) and (max-width:1024px) {
   .main-sec-contact{
    min-height: 70vh;
   }     
    }
</style>
<section class="main-sec-contact top_mask_add background-contact s-py-70 s-pt-md-100 s-pb-md-95 s-pt-xl-150 s-pb-xl-185 c-gutter-30">
    <div class="container">
        <h1 class="mt-5 mb-40 text-uppercase">Contact us</h1>
        <div class="row">
            <div class="col-lg-5 col-xl-4" data-animation="scaleAppear">
                <!-- <span class="color-main font-main fs-24 text-uppercase">modelia</span> -->
                <div class="media mb-20">
                    <h5 class="fs-20 mb-0 min-w-100">Phone:</h5>
                    <div class="media-body ml-0 d-flex flex-column">
                        <span>{{ $globalData->phone_no }}</span>
                        <span>{{ $globalData->alter_phone_no }}</span>
                    </div>
                </div>
                <div class="media mb-20">
                    <h5 class="fs-20 mb-0 min-w-100">Email:</h5>
                    <div class="media-body ml-0 d-flex flex-column">
                        <span><a href="mailto:{{ $globalData->email }}" class="__cf_email__" data-cfemail="660b0902030a0f0726031e070b160a034805090b">{{ $globalData->email }}</a></span>
                    </div>
                </div>
                <div class="media mb-20">
                    <h5 class="fs-20 mb-0 min-w-100">Address:</h5>
                    <div class="media-body pr-lg-4 ml-0 d-flex flex-column">
                        <span>{{ $globalData->address }}</span>
                    </div>
                </div>
            </div>
            <!--.col-* -->
            <div class="fw-divider-space hidden-above-lg mt-20"></div>
            <div class="col-lg-7 col-xl-8" data-animation="scaleAppear">
                <form class="contact-form c-mb-20 c-gutter-20" id="addTeamUpdateDataForm" onsubmit="return addTeamUpdateData()" enctype='multipart/form-data'>
                @csrf
                    <div class="row">
                        <div class="col-md-6 mb-2 px-md-1">
                            <div class="form-group">
                                <input type="text" name="full_name" class="form-control" placeholder="full name" required>
                                <div class="invalid-feedback" id="full_nameError"></div>

                            </div>
                        </div>
                        <div class="col-md-6 mb-2 px-md-1">
                            <div class="form-group">
                                <input type="email" name="email" class="form-control" placeholder="email address" required>
                                <div class="invalid-feedback" id="emailError"></div>

                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-2 px-md-1">
                            <div class="form-group">
                                <input type="tel" name="phone" class="form-control" placeholder="phone number">
                                <div class="invalid-feedback" id="phoneError"></div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-2 px-md-1">
                            <div class="form-group">
                                <input type="text" name="city" class="form-control" placeholder="your city">
                                <div class="invalid-feedback" id="cityError"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-2 px-md-1">
                            <div class="form-group">
                                <textarea rows="6" cols="45" name="message" class="form-control" placeholder="your message"></textarea>
                                <button type="submit" id="submitBtn" class="btn-submit"><i class="fa fa-paper-plane"></i></button>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
            <!--.col-* -->
        </div>
    </div>
</section>


@endsection
@push('js')
<script>
    function addTeamUpdateData() {
    $.ajax({
        url: "{{ route('user.contact.store') }}",
        type: 'POST',
        data: new FormData($('#addTeamUpdateDataForm')[0]),
        dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        beforeSend: function() {
            $('#submitBtn').prop('disabled', true).text('Processing...');
            // Clear previous error messages
            $('.invalid-feedback').text('');
            $('.input-field').removeClass('is-invalid');
        },
        success: function(res) {
            $('#submitBtn').prop('disabled', false).text('Send');
            if (res.status === 1) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: res.message,
                }).then(() => {
                    window.location.reload();
                    $('#addContentModal').modal('hide');
                });
            }
        },
        error: function(xhr) {
            $('#submitBtn').prop('disabled', false).text('Send');
            if (xhr.status === 422) {
                var errors = xhr.responseJSON.errors;
                $.each(errors, function(key, value) {
                    var inputField = $('[name="' + key + '"]');
                    inputField.addClass('is-invalid');
                    $('#' + key + 'Error').text(value[0]);
                });
            } else {
                // Handle other errors
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An unexpected error occurred.',
                });
            }
        }
    });

    return false;
}

</script>
@endpush('js')