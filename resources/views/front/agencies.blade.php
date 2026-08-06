@extends('front.layout.layout')

@section('content')
<style>
  .btn {
    margin-bottom: 0;
  }
  .page-item.active .page-link {
    background-color: #bc1212; /* red (Bootstrap danger) */
    border-color: #bc1212;
    color: #fff !important;
}

.page-link {
    background-color: #fff;
    border: 1px solid #dee2e6;
    color: #000;
}

.page-link:hover {
    background-color: #f8f9fa;
    color: #000;
}
</style>



<section class="main-area">
  <div class="container">

    <h2 class="text-center mb-4">Agencies</h2>

    @if($agencies->count())
        @foreach($agencies as $agency)
            <div class="agencies-profile-card p-3 mb-3">
                <div class="row">
                    <div class="col-md-3 ">
                        <div class="agency-model-img">
                            @if($agency->photo)
                                <img src="{{ asset('storage/'.$agency->photo) }}" class="agencies-profile-img" alt="Profile">
                            @else
                                <img src="{{ asset('images/default-agency.png') }}" class="agencies-profile-img" alt="No Image">
                            @endif
                        </div>
                    </div>

                    <div class="col-md-9">
                        <div class="card-body flex-grow-1 p-0">
                            <div class="d-md-flex justify-content-between align-items-center">
                                <h5 class="mb-1 mt-md-0 mt-3">{{ $agency->name }}</h5>
                            </div>

                            <p class="my-2 text-muted">{{ $agency->headline ?? '-' }}</p>
                            <div class="d-flex agency-card-quality">
                                <p class="mt-2 mb-3"><i class="fa-solid fa-location-dot me-2"></i> {{ $agency->address ?? '-' }} </p>
                            </div>

                            <p class="agencies-description mb-4">
                                 {{ \Illuminate\Support\Str::limit($agency->short_desc ?? '-', 200, '...') }}
                            </p>

                            <div class="d-md-flex justify-content-between align-items-center">
                                <div class="mb-md-0 mb-2">
                                    <button class="btn btn-light btn-sm px-3 py-2 agency-video-img-icon">
                                        <i class="fa-solid fa-video"></i>
                                        {{ $agency->media->where('type', 'video')->count() }}
                                    </button>
                                    <button class="btn btn-light btn-sm px-3 py-2 agency-video-img-icon">
                                        <i class="fa fa-image"></i> {{ $agency->media->where('type', 'image')->count() }}
                                    </button>
                                </div>
                                <a href="{{ route('user.agency-detail', $agency->id) }}" class="btn btn-success">
                                    <i class="fa fa-user"></i> View Profile
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

        {{-- Pagination --}}
        <div class="mt-4 d-flex justify-content-center pagination-main">
            {{ $agencies->links('pagination::bootstrap-5') }}
        </div>
    @else
        <div class="alert alert-warning text-center">
            <i class="fa fa-exclamation-circle"></i> No Agencies Found
        </div>
    @endif
    <div class="row">
        <div class="col-lg-12 text-justify locationSeoContent">
            {!! $locationSeoContent['data']->content ?? "" !!}
        </div>
    </div>
  </div>
</section>



@endsection

@push('js')
@endpush('js')