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
            Leadership Detail
        </h3>
    </div>

    <div class="card p-4">
        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab" tabindex="0">
               <p><strong>Name </strong> : {{ $leadership['name'] }}</p>
               <p><strong>Email </strong> : {{ $leadership['email'] }}</p>
               <p><strong>Phone </strong> : {{ $leadership['country_code'] }} {{ $leadership['phone'] }}</p>
               <p><strong>Address </strong> : {{ $leadership['address'] }}</p>
               <p><strong>Fee </strong> : {{ $leadership['leadership_fee'] }}</p>
               <p><strong>Description </strong> : {{ $leadership['description'] }}</p>
               <p><strong>Image </strong> : <img src="{{ $leadership['image'] ? asset('storage/' . $leadership['image']) : asset('admin/assets/img/no_image.png') }}" alt="image" width="60"></p>
               
                
            </div>
        </div>
    </div>
@endsection
@push('js')
 
@endpush('js')