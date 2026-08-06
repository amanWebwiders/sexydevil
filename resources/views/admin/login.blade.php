@include('admin.layout.loginhead')

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



    <section class="login p-md-5">

        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col-md-6">
                    
                <img src="{{ asset('images/escort_logo1.png') }}" alt="">
                </div>
                <div class="col-md-6">
                    <h2 class="mx-auto mb-5 text-center">Login</h2>


                    <form class="contact-form c-mb-20 c-gutter-20" id="formAuthentication" onsubmit="return adminLogin()" method="post" name="login_form">
                     @csrf
                        <div class="row">
                            <div class="col-sm-12 px-0">
                                <div class="form-group w-75 mx-auto mb-3">
                                    <input type="email" class="form-control w-100" name="email" id="email" placeholder="Email address" aria-describedby="emailHelp">
                                </div>
                            </div>

                            <div class="col-sm-12 px-0">
                                <div class="form-group w-75 mx-auto mb-2">
                                    <input type="password" class="form-control" placeholder="Password" id="password" name="password">
                                </div>
                            </div>

                            <div class="col-sm-12 px-0">
                                <div class="form-group text-end mb-4">
                                    <a href="{{route('admin.forgot-password')}}" class="mx-auto">Forget password?</a>
                                </div>
                            </div>

                            <button id="login_btn" type="submit" class="btn btn-maincolor mx-auto">Submit</button>
                        </div>

                       


                    </form>
                </div>
            </div>
        </div>

    </section>

</main>



@include('admin.layout.footer')

<script>
console.log('dfgdhjsfs');
    function adminLogin() {
        $.ajax({
            url: "{{ route('admin.do-login') }}",
            type: 'POST',
            data: new FormData($('#formAuthentication')[0]),
            dataType: 'json',
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function() {
                $('#login_btn').prop('disabled', true);
                $('#button-text').html('processing...');
                // $('#loader').show();
            },
            success: function(res) {
                
                $('#login_btn').prop('disabled', false);
                $('#button-text').html('Login');
                // $('#loader').hide();
    
                if (res.status == 1) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: res.message,
                        timer: 2000,
                    }).then(function() {
                        window.location.href = '{{ route('admin.dashboard') }}';
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
                $('#login_btn').prop('disabled', false);
                $('#button-text').text('Login');
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