@include('admin.layout.layout')

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
            Contact Us Detail
        </h3>
    </div>

    <div class="card p-4">
        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab" tabindex="0">
               <p><strong>First Name </strong> : {{ $contactus['first_name'] }}</p>
               <p><strong>Last Name </strong> : {{ $contactus['last_name'] }}</p>
               <p><strong>Email </strong> : {{ $contactus['email'] }}</p>
               <p><strong>Phone </strong> : {{ $contactus['phone'] }}</p>
               <p><strong>Message </strong> : {{ $contactus['message'] }}</p>
                
            </div>
        </div>
    </div>
@include('admin.layout.footer')
@stack('js')