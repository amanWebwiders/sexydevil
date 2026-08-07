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
                <div class="">
                <h3 class="page-header mb-3">Contact Page Content Settings</h3>
                <form method="post" action="{{ route('admin.contact-page-content-action') }}">
                    @csrf
                    <div class="row">
                        <div class="col-sm-3 form-group" >
                            <label>Phone Number</label>
                            <input class="form-control" name="phone_no" type="text" placeholder="Enter contact number" value="{{ old('phone_no') ?? $content->phone_no }}" required/>
                        </div>
                        <div class="col-sm-3 form-group" >
                            <label>Alternate Phone Number</label>
                            <input class="form-control" name="alter_phone_no" type="text" placeholder="Enter alternate contact number" value="{{ old('alter_phone_no') ?? $content->alter_phone_no }}" required/>
                        </div>
                        <div class="col-sm-6 form-group" >
                            <label>Email</label>
                            <input class="form-control" name="email" type="email" value="{{ old('phone_no') ?? $content->email }}" placeholder="Enter email address" required/>
                        </div>
                        <div class="col-sm-6 form-group" >
                            <label>Address</label>
                            <input class="form-control" name="address" type="text" placeholder="Enter address" value="{{ old('phone_no') ?? $content->address }}" required/>
                        </div>
                        <div class="col-sm-6 form-group" >
                            <label>Telegram Url 
                                <input type="checkbox" name="telegram_active" {{ (old('telegram_active') ?? $content->telegram_active) == 1 ? "checked":"" }} value="1">
                            </label>
                            <input class="form-control" name="telegram" type="url" placeholder="Enter telegram address" value="{{ old('phone_no') ?? $content->telegram }}" />
                        </div>
                        <div class="col-sm-6 form-group" >
                            <label>Facebook Page Url <input type="checkbox" name="facebook_active" {{ (old('facebook_active') ?? $content->facebook_active) == 1 ? "checked":"" }} value="1"></label>
                            <input class="form-control" name="facebook" type="url" placeholder="Enter facebook address" value="{{ old('phone_no') ?? $content->facebook }}" />
                        </div>
                        <div class="col-sm-6 form-group" >
                            <label>Instagram Page Url <input type="checkbox" name="instagram_active" {{ (old('instagram_active') ?? $content->instagram_active) == 1 ? "checked":"" }} value="1"></label>
                            <input class="form-control" name="intagram" type="url" placeholder="Enter instagram address" value="{{ old('phone_no') ?? $content->intagram }}" />
                        </div>
                        <div class="col-sm-6 form-group" >
                            <label>Video Convert Url</label>
                            <input type="url" class="form-control" name="video_convert_url" type="url" placeholder="Enter video convert address" value="{{ old('video_convert_url') ?? $content->video_convert_url }}" />
                        </div>

                        <div class="col-sm-3 form-group" >
                            <label>WhatsApp No.</label>
                            <input class="form-control" name="whatsApp_no" type="text" placeholder="Enter whatsApp no. number" value="{{ old('phone_no') ?? $content->whatsApp_no }}" />
                        </div>
                        <div class="col-sm-12 form-group" >
                            <button type="submit" class="btn btn-primary mt-2">Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('js')
@endpush('js')