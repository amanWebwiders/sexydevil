@include('admin.layout.loginhead')
<style>
    header,
    footer {
        display: none;
    }

    #canvas {
        width: 100dvw;
        height: 100dvh;
        overflow-y: auto;
        background: #000;
        display: grid;
        place-items: center;
    }
</style>

<main class="login-container">
    <!-- BEGIN login-content -->
    <section class="login p-5">
        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col">

                    <img src="{{ asset('images/escort_logo1.png')}}" alt="">
                </div>
                <div class="col">
                    <h2 class="mx-auto mb-5 text-center">Forgot Password</h2>

                    <form id="formAuthentication" onsubmit="return sendPassword()" method="post" name="login_form">
                        @csrf
                    
                        <div class="text-body text-opacity-50 text-center mb-4">
                            <!--Forgot your password-->
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email Address <span class="text-danger">*</span></label>
                            <input type="email" class="form-control form-control-lg fs-body" name="email" placeholder="" id="email" required>
                        </div>
                        <button id="forgot_btn" type="submit" class="btn btn-theme btn-lg d-block w-100 fw-semibold mb-3">
                            <span id="button-text">Send</span>
                        </button>

                    </form>
                </div>
            </div>
        </div>

    </section>
    <!-- END login-content -->
</main>



@include('admin.layout.footer')

<script>
    function sendPassword() {
        $.ajax({
            url: "{{ route('admin.send-password') }}",
            type: 'POST',
            data: new FormData($('#formAuthentication')[0]),
            dataType: 'json',
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function() {
                $('#forgot_btn').prop('disabled', true);
                $('#forgot_btn').text('Processing..');
            },
            success: function(res) {
                $('#forgot_btn').prop('disabled', false);
                $('#forgot_btn').text('Send');
                if (res.status == 1) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: res.message,
                    }).then(function() {
                        window.location.href = "{{ route('admin.dashboard') }}";
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
                $('#forgot_btn').prop('disabled', false);
                $('#forgot_btn').text('Send');
                $('.text-danger').remove();
                if (error.responseJSON && error.responseJSON.errors) {
                    for (var err in error.responseJSON.errors) {
                        if (error.responseJSON.errors.hasOwnProperty(err)) {
                            var errorMessage = error.responseJSON.errors[err][0];
                            $("[name='" + err + "']").after("<div class='text-danger'>" + errorMessage + "</div>");
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
    }
</script>