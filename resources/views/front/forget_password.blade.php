@include('front.layout.loginheader')

<style>
    header,
    footer {
        display: none;
    }

    #canvas{
	width: 100dvw;
	height: 100dvh;
	overflow-y: auto;
	background: #000;
	display: grid;
	place-items: center;
}
</style>


<main class="login-container">



    <section class="login p-5">

        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col">
                <img src="{{ asset('images/escort_logo1.png') }}" alt="">
                </div>
                <div class="col">
                    <h1 class="mx-auto mb-5 text-center">Forget Password</h1>


                    <form form id="formAuthentication" onsubmit="return sendPassword()" method="post" name="login_form" class="contact-form c-mb-20 c-gutter-20">
                        @csrf
                        <div class="row">
                            <div class="col-sm-12 px-0">
                                <div class="form-group w-75 mx-auto mb-3">
                                    <input type="email" class="form-control w-100" id="exampleInputEmail1" placeholder="Email address" aria-describedby="emailHelp" name="email" required>
                                </div>
                            </div>

                            <button id="forgot_btn" type="submit" class="btn btn-maincolor mx-auto">Submit</button>
                        </div>

                        <div class=" text-center">
                            <hr style="width: 70%; margin: 50px auto 30px; height: 1px; background: #fff;">
                            <p class="mx-auto">Back to <a href="{{route('user-login')}}">login</a></p>
                        </div>


                    </form>
                </div>
            </div>
        </div>

    </section>

</main>



@include('front.layout.footer')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function sendPassword() {
        $.ajax({
            url: "{{ route('user.send-password') }}",
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
                        window.location.href = '{{route("user-login")}}';
                    });
                }else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: res.message,
                    }).then(function() {
                        
                    });
                }
            },error: function(error) {
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