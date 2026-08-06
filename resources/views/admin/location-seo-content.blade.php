@extends('admin.layout.layout')
@section('content')


    <div id="content" class="app-content">
    
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <div class="card p-4">
            <h3 class="page-header mb-3">Location SEO Content</h3>
            <form method="post" onsubmit="return AddSeoContent()" id="AddSeoContent">
                @csrf
                <div class="row">

                <div class="form-group col-md-4">
                    <label for="title">Title</label>
                    <select class="form-control" name="title" id="title" required>
                        <option value="">---Select---</option>
                        <option value="Entry Page">Entry Page</option>
                        <option value="Home">Home</option>
                        <option value="All Escorts">All Escorts</option>
                        <option value="New Escorts">New Escorts</option>
                        <option value="Agencies">Agencies</option>
                        <option value="Hot Stories">Hot Stories</option>
                    </select>
                </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="country">Country</label>
                            <select id="country" class="form-control" name="country" onchange="return fetchState($(this))" required >
                                <option value="worldwide ">Worldwide</option>
                                @foreach($countries as $country)
                                    <option value="{{ $country->id }}">{{ $country->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="state">State</label>
                            <select class="form-control" id="state" name="state" onchange="return fetchCity($(this))"></select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="city">City</label>
                            <select class="form-control" id="city" name="city"></select>
                        </div>
                    </div>
                </div>
                <div class="w-100">
                    <textarea class="form-control textarea" name="content" required></textarea>
                </div>
                <div class="w-25">
                    <button class="btn btn-primary mt-2" type="submit" id="btnSubmit">Update</button>
                </div>

            </form>
        </div>
@endsection      
@push('js')
<script src="https://cloud.tinymce.com/5/tinymce.min.js?apiKey=jaa9c6t7n255qwruis8bo6x87nxj39aqrhr4w323i4hd2f9k"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
tinymce.init({
  selector: '.textarea',
  height:480,
  plugins: [ 
        "advlist autolink lists link image charmap print preview anchor",
        "searchreplace visualblocks code fullscreen",
        "insertdatetime media table contextmenu paste"
    ],
  toolbar: "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
  setup: function (editor) {
    editor.on('change', function () {
      tinymce.triggerSave();
    });
  }
});
$(document).ready(function () {
    $('#country, #state, #city, #advertiser').select2();
    $('#country').trigger('change');
})
function fetchState(thiss) {
        var country_id = thiss.val();
        
        $.ajax({
            url: "{{ route('admin.get-states') }}?country_id=" + country_id,
            type:"get",
            dataType:'json',
            beforeSend:function(){ 
                    $("#state, #city").html("");
                    $("#state").html(`<option value=''>---select state---</option>`);
            },
            success:function(data) {
                $.each(data, function(index, item) {
                    $("#state").append(`<option value='${item.id}'>${item.name}</option>`);
                });
            }
    });
    return false;
}

function fetchCity(thiss) {
    var state_id = thiss.val();
    $.ajax({
        url: "{{ route('admin.get-cities') }}?state_id=" + state_id,
        type:"get",
        dataType:'json',
        beforeSend:function(){ 
            $("#city").html("");
        },
        success:function(data) {
            $("#city").html(`<option value=''>---select city---</option>`);
            $.each(data, function(index, item) {
                $("#city").append(`<option value='${item.id}'>${item.name}</option>`);
            });
        }
    });
    return false;
}

function AddSeoContent() {
    $.ajax({
        url: "{{ route('admin.location-seo-content') }}",
        type:"post",
        cache:false,
        contentType: false,
        processData: false,
        data: new FormData($('#AddSeoContent')[0]),
        dataType:'json',
        beforeSend:function(){ 
        },
        success:function(data) {
            if(data.status == 200) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: data.message
                }).then(() => {
                    location.reload();
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: data.message
                });
            }
        }
    });
    return false;
}
$(document).on('change', '#country, #title, #state, #city', function() {
    $.ajax({
        url: "{{ route('admin.get-location-seo-content') }}",
        type:"post",
        cache:false,
        contentType: false,
        processData: false,
        data: new FormData($('#AddSeoContent')[0]),
        dataType:'json',
        beforeSend:function(){ 
        },
        success:function(data) {
            if(data.status == 200) { 
                tinymce.get($('.textarea').attr('id')).setContent(data.data.message.content);
            } else { 
                tinymce.get($('.textarea').attr('id')).setContent("");
            }
        }
    });
});

</script> 
@endpush('js')  