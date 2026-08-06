@extends('front.layout.layout')

@section('content')
<style>

   
.bg-top-element{
    display: none;
}
</style>

<main class="login-container">



    <section class="login">

        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col-lg-6 login_logo">
                    <img src="{{ asset('images/escort_logo1.png') }}" alt="">
                </div>
                <div class="col-lg-6 ">
                    <h3 class="mb-5 text-left">Don't have an account yet?</h3>

                    <div class="radio-button-container">
                        <div class="radio-button">
                            <input type="radio" class="radio-button__input" id="radio1" name="user_type" value="member">
                            <label class="radio-button__label" for="radio1">
                                <div class="d-flex position-relative">
                                    <span class="radio-button__custom"></span>
                                    <h5 class="mt-0 mb-2 pl-4">Visit as a member</h5>
                                </div>
                                <p>As a registered visitor, you can save your favorites, leave comments and reviews. We will also keep you informed about the latest news and updates from Sexy Devil</p>
                            </label>
                        </div>

                        <div class="radio-button">
                            <input type="radio" class="radio-button__input" id="radio3" name="user_type"
                                value="advertiser">
                            <label class="radio-button__label" for="radio3">
                                <div class="d-flex position-relative">
                                    <span class="radio-button__custom"></span>
                                    <h5 class="mt-0 mb-2 pl-4">Register as an advertiser</h5>
                                </div>
                                <p>Create an account as a sex worker or sex company and bring yourself to the attention of thousands of Sexy Devil visitors every day.</p>
                            </label>
                        </div>
                    </div>

                    <button type="button" class="btn btn-maincolor mx-auto mt-2 mt-md-5"
                        onclick="handleRedirect()">Submit</button>
                </div>
            </div>
        </div>

    </section>

</main>
@endsection

<script>
function handleRedirect() {
    console.log('dsgfdhjsgfds');
    const selected = document.querySelector('input[name="user_type"]:checked');
    if (!selected) {
        alert('Please select an option.');
        return;
    }

    if (selected.value === 'member') {
        window.location.href = "{{route('signup')}}"; // Update this URL as needed
    } else if (selected.value === 'advertiser') {
        window.location.href = "{{route('user-signupadvertiser')}}"; // Update this URL as needed
    }
}
</script>