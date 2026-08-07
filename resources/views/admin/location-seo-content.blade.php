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

                <div class="form-group col-md-4 mb-3">
                    <label for="title">Title</label>
                    <select class="form-control" name="title" id="title" required>
                        <option value="">---Select---</option>
                        <option value="Entry Page">Entry Page</option>
                        <option value="Home">Home</option>
                        <option value="All Escorts">All Escorts</option>
                        <option value="New Escorts">New Escorts</option>
                        <option value="Active Escorts">Active Escorts</option>
                        <option value="Lowcost Escorts">Lowcost Escorts</option>
                        <option value="Recommend Escorts">Recommend Escorts</option>
                        <option value="Agencies">Agencies</option>
                        <option value="Agency Profile">Agency Profile</option>
                        <option value="Hot Stories">Hot Stories</option>
                        <option value="About Us">About Us</option>
                        <option value="Contact Us">Contact Us</option>
                        <option value="Terms & Conditions">Terms & Conditions</option>
                        <option value="Model Profile">Model Profile</option>
                    </select>
                </div>
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label for="country">Country</label>
                            <select id="country" class="form-control" name="country" onchange="return fetchState($(this))" required >
                                <option value="worldwide">Worldwide</option>
                                @foreach($countries as $country)
                                    <option value="{{ $country->id }}">{{ $country->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label for="state">State</label>
                            <select class="form-control" id="state" name="state" onchange="return fetchCity($(this))"></select>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label for="city">City</label>
                            <select class="form-control" id="city" name="city"></select>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label for="meta_title">Meta Title (Max 60 chars)</label>
                            <input type="text" class="form-control" name="meta_title" id="meta_title" maxlength="60" placeholder="Meta Title">
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label for="image_alt_text">Image ALT Text (Max 255 chars)</label>
                            <input type="text" class="form-control" name="image_alt_text" id="image_alt_text" maxlength="255" placeholder="Image ALT Text">
                        </div>
                    </div>
                    <div class="col-md-12 mb-3">
                        <div class="form-group">
                            <label for="meta_description">Meta Description (Max 160 chars)</label>
                            <textarea class="form-control" name="meta_description" id="meta_description" maxlength="160" rows="2" placeholder="Meta Description"></textarea>
                        </div>
                    </div>
                    <div class="col-md-12 mb-3">
                        <div class="form-group">
                            <label for="meta_keywords">Meta Keywords</label>
                            <textarea class="form-control" name="meta_keywords" id="meta_keywords" rows="2" placeholder="Meta Keywords"></textarea>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label for="seo_url_slug">SEO URL / Slug</label>
                            <input type="text" class="form-control" name="seo_url_slug" id="seo_url_slug" placeholder="SEO URL / Slug">
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label for="canonical_url">Canonical URL</label>
                            <input type="text" class="form-control" name="canonical_url" id="canonical_url" placeholder="Canonical URL">
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label for="robots_setting">Robots Setting (Index/No Index)</label>
                            <select class="form-control" name="robots_setting" id="robots_setting">
                                <option value="">---Select---</option>
                                <option value="index, follow">Index, Follow</option>
                                <option value="noindex, nofollow">No Index, No Follow</option>
                                <option value="index, nofollow">Index, No Follow</option>
                                <option value="noindex, follow">No Index, Follow</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <div class="form-group">
                            <label for="og_title">OG Title</label>
                            <input type="text" class="form-control" name="og_title" id="og_title" placeholder="OG Title">
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="form-group">
                            <label for="twitter_title">Twitter Title</label>
                            <input type="text" class="form-control" name="twitter_title" id="twitter_title" placeholder="Twitter Title">
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="form-group">
                            <label for="og_description">OG Description</label>
                            <textarea class="form-control" name="og_description" id="og_description" rows="2" placeholder="OG Description"></textarea>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="form-group">
                            <label for="twitter_description">Twitter Description</label>
                            <textarea class="form-control" name="twitter_description" id="twitter_description" rows="2" placeholder="Twitter Description"></textarea>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="form-group">
                            <label for="og_image">OG Image</label>
                            <input type="file" class="form-control" name="og_image" id="og_image" accept="image/*">
                            <div id="og_image_preview" class="mt-2"></div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="form-group">
                            <label for="twitter_image">Twitter Image</label>
                            <input type="file" class="form-control" name="twitter_image" id="twitter_image" accept="image/*">
                            <div id="twitter_image_preview" class="mt-2"></div>
                        </div>
                    </div>
                </div>
                <div class="w-100">
                    <label class="form-label font-weight-bold">Content</label>
                    <textarea class="form-control textarea" name="content"></textarea>
                </div>
                <div class="w-25">
                    <button class="btn btn-primary mt-3" type="submit" id="btnSubmit">Update</button>
                </div>

            </form>
        </div>
@endsection      
@push('js')
<script src="https://cloud.tinymce.com/5/tinymce.min.js?apiKey=co28qhp8nt6ngdu0nll8794xsuqln9ixriojfr2wwom92b6w"></script>
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
});

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
            if(data.status == 200 && data.data.message) { 
                tinymce.get($('.textarea').attr('id')).setContent(data.data.message.content || "");
                $('#meta_title').val(data.data.message.meta_title || "");
                $('#meta_description').val(data.data.message.meta_description || "");
                $('#image_alt_text').val(data.data.message.image_alt_text || "");
                
                $('#meta_keywords').val(data.data.message.meta_keywords || "");
                $('#seo_url_slug').val(data.data.message.seo_url_slug || "");
                $('#canonical_url').val(data.data.message.canonical_url || "");
                $('#robots_setting').val(data.data.message.robots_setting || "");
                $('#og_title').val(data.data.message.og_title || "");
                $('#og_description').val(data.data.message.og_description || "");
                $('#twitter_title').val(data.data.message.twitter_title || "");
                $('#twitter_description').val(data.data.message.twitter_description || "");
                if(data.data.message.og_image) {
                    var ogPath = data.data.message.og_image.startsWith('http') ? data.data.message.og_image : "{{ asset('') }}" + data.data.message.og_image;
                    $('#og_image_preview').html('<div class="mt-2"><img src="' + ogPath + '" style="height: 70px; border-radius: 4px; border: 1px solid #ddd;" class="img-thumbnail"><br><small class="text-muted">Current OG Image</small></div>');
                } else {
                    $('#og_image_preview').html('');
                }
                if(data.data.message.twitter_image) {
                    var twPath = data.data.message.twitter_image.startsWith('http') ? data.data.message.twitter_image : "{{ asset('') }}" + data.data.message.twitter_image;
                    $('#twitter_image_preview').html('<div class="mt-2"><img src="' + twPath + '" style="height: 70px; border-radius: 4px; border: 1px solid #ddd;" class="img-thumbnail"><br><small class="text-muted">Current Twitter Image</small></div>');
                } else {
                    $('#twitter_image_preview').html('');
                }
            } else { 
                tinymce.get($('.textarea').attr('id')).setContent("");
                $('#meta_title').val("");
                $('#meta_description').val("");
                $('#image_alt_text').val("");
                $('#meta_keywords').val("");
                $('#seo_url_slug').val("");
                $('#canonical_url').val("");
                $('#robots_setting').val("");
                $('#og_title').val("");
                $('#og_description').val("");
                $('#twitter_title').val("");
                $('#twitter_description').val("");
                $('#og_image_preview').html('');
                $('#twitter_image_preview').html('');
                $('#og_image').val('');
                $('#twitter_image').val('');
            }
        }
    });
});

</script> 
@endpush('js')  