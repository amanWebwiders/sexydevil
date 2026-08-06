@extends('front.layout.layout')

@section('content')
<style>
    .social-icon-detail li a {
        width: 40px;
        height: 40px;
        padding: 0;
        display: flex;
        justify-content: center;
        align-items: center;

    }
</style>
<section class="main-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-4">
                <div class="agency-detail-profile-card">
                    <div class="agency-detail-modal-img">
                        <img src="{{ asset('storage/'.$agency->photo) }}" class="agencies-detail-profile-img" alt="Profile">
                    </div>
                    <div class="agency-detail-modal-desc p-3">
                        <h2 class="modal-detail-name">{{ $agency->name }}</h2>

                        <div class="meta-info meta-info-agency-detail mt-2">
                            <p>
                                <i class="fa-solid fa-location-dot"></i> {{ $agency->address ?? 'Location not available' }}
                            </p>
                            <p>
                                <i class="fa-solid fa-calendar-days"></i>
                                Active since {{ \Carbon\Carbon::parse($agency->created_at)->format('F Y') }}
                            </p>
                        </div>

                        @if(!empty($agency->email))
                        <a href="mailto:{{ $agency->email }}" class="btn btn-danger w-100 px-1" style="
    font-size: 9px;">
                            <i class="fa fa-envelope"></i> {{ $agency->email }}
                        </a>
                        @else
                        <button class="btn btn-primary w-100" disabled>
                            <i class="fa fa-envelope"></i> No Email
                        </button>
                        @endif
                        @if(!empty($agency->phone))
                        <a href="tel:{{ $agency->phone }}" class="btn btn-success w-100">
                            <i class="fa fa-phone"></i> {{ $agency->phone }}
                        </a>
                        @else
                        <button class="btn btn-success w-100" disabled>
                            <i class="fa fa-phone"></i> No Number
                        </button>
                        @endif

                        {{-- Website Button (Click to Visit) --}}
                        @if(!empty($agency->website))
                        <a href="{{ $agency->website }}" target="_blank" class="btn btn-outline-secondary w-100 text-white">
                            <i class="fa-solid fa-globe"></i> Visit Website
                        </a>
                        @else
                        <button class="btn btn-outline-secondary w-100 text-white" disabled>
                            <i class="fa-solid fa-globe"></i> No Website
                        </button>
                        @endif
                    </div>

                </div>
            </div>
            <div class="col-lg-9 col-md-8">
                <div class="agency-detail-right-content">

                    <!-- tabs start -->
                    <ul class="nav nav-tabs detail-age-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active show" id="tab01" data-toggle="tab" href="#tab01_pane" role="tab" aria-controls="tab01_pane" aria-selected="false">
                                Overview
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="tab04" data-toggle="tab" href="#tab04_pane" role="tab" aria-controls="tab04_pane" aria-expanded="true" aria-selected="true">
                                Team
                            </a>
                        </li>


                        <li class="nav-item">
                            <a class="nav-link" id="tab06" data-toggle="tab" href="#tab06_pane" role="tab" aria-controls="tab06_pane" aria-selected="false">
                                Photos
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="tab05" data-toggle="tab" href="#tab05_pane" role="tab" aria-controls="tab05_pane" aria-selected="false">
                                Videos
                            </a>
                        </li>
                        <!-- <li class="nav-item">
                            <a class="nav-link" id="tab03" data-toggle="tab" href="#tab03_pane" role="tab" aria-controls="tab03_pane" aria-selected="false">
                                Rating
                            </a>
                        </li> -->
                    </ul>

                    <div class="tab-content p-0">
                        <div class="tab-pane fade active show" id="tab01_pane" role="tabpanel" aria-labelledby="tab01">
                            <div class="">


                                <div class="card-body flex-grow-1 pt-4 p-0">
                                    <div class="mt-2 agecncy-detail-overview-desc">





                                        <h5 class="mb-1">{{ $agency->name ?? '-' }} </h5>
                                        <h6 class="mb-1">{{ $agency->headline ?? '-' }} </h6>
                                        <div class="d-flex agency-card-quality">


                                            <p class="mt-2 mb-3"><i class="fas fa-map-marker-alt text-white me-2"></i> {{ $agency->address ?? '-' }} </p>
                                        </div>
                                        @if(!empty($agency->short_desc))
                                        <p class="agencies-description mb-4">

                                            <span class="short-desc-preview">
                                                {{ Str::limit($agency->short_desc, 100) }}
                                            </span>
                                        </p>
                                        @if(strlen($agency->short_desc) > 100)
                                        <a href="javascript:void(0);" class="text-red toggle-short">Show full description</a>
                                        @endif
                                        <p class="short-desc-full d-none">
                                            {{ $agency->short_desc }}
                                        </p>
                                        @endif

                                        {{-- Long Description --}}
                                        @if(!empty($agency->long_desc))
                                        <p class="agencies-description mb-4">

                                            <span class="long-desc-preview">
                                                {{ Str::limit($agency->long_desc, 150) }}
                                            </span>
                                        </p>
                                        @if(strlen($agency->long_desc) > 150)
                                        <a href="javascript:void(0);" class="text-red toggle-long">Show full description</a>
                                        @endif
                                        <p class="long-desc-full d-none">
                                            {{ $agency->long_desc }}
                                        </p>
                                        @endif


                                        {{-- Social Media Links --}}
                                        @if($agency->telegram || $agency->facebook || $agency->instagram || $agency->linkedin)
                                        <div class="agency-social mt-3">
                                            <ul class="list-inline social-icon-detail">
                                                @if($agency->telegram)
                                                <li class="list-inline-item">
                                                    <a href="{{ $agency->telegram }}" target="_blank" class="btn btn-outline-primary rounded-circle">
                                                        <i class="fab fa-telegram"></i>
                                                    </a>
                                                </li>
                                                @endif

                                                @if($agency->facebook)
                                                <li class="list-inline-item">
                                                    <a href="{{ $agency->facebook }}" target="_blank" class="btn btn-outline-primary rounded-circle">
                                                        <i class="fab fa-facebook-f"></i>
                                                    </a>
                                                </li>
                                                @endif

                                                @if($agency->instagram)
                                                <li class="list-inline-item">
                                                    <a href="{{ $agency->instagram }}" target="_blank" class="btn btn-outline-danger rounded-circle">
                                                        <i class="fab fa-instagram"></i>
                                                    </a>
                                                </li>
                                                @endif

                                                @if($agency->linkedin)
                                                <li class="list-inline-item">
                                                    <a href="{{ $agency->linkedin }}" target="_blank" class="btn btn-outline-info rounded-circle">
                                                        <i class="fab fa-linkedin-in"></i>
                                                    </a>
                                                </li>
                                                @endif
                                            </ul>
                                        </div>
                                        @endif

                                    </div>

                                </div>




                            </div>



                        </div>


                        <div class="tab-pane fade in" id="tab04_pane" role="tabpanel" aria-labelledby="tab04">
                            <div class="card-body flex-grow-1 pt-4 p-0">
                                <div class="agency-detail-team mt-4">
                                    <div class="row">
                                        @if($teams->count())
                                        @foreach($teams as $team)
                                        <div class="col-xl-3 col-lg-4 col-md-6">
                                            <div class="ageny-team-profile-card">
                                                <img src="{{ asset('storage/'.$team->photo) }}" alt="Profile">
                                                <div class="profile-body p-3">
                                                    <h5>{{ $team->name }}</h5>
                                                    <p><i class="fa fa-user"></i> {{ $team->age }} Years</p>
                                                    <p><i class="fa fa-venus"></i> {{ $team->gender }}</p>

                                                    @php
                                                    $desc = $team->description ?? '-';
                                                    $limit = 10; // character limit
                                                    @endphp

                                                    @if(strlen($desc) > $limit)
                                                    <p class="team-desc">
                                                        <span class="desc-preview">{{ Str::limit($desc, $limit) }}</span>
                                                        <span class="desc-full d-none">{{ $desc }}</span>
                                                    </p>
                                                    <a href="javascript:void(0);" class="text-red toggle-desc">Read more</a>
                                                    @else
                                                    <p class="team-desc">{{ $desc }}</p>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>


                                        @endforeach
                                        @else
                                        <div class="alert alert-warning text-center">
                                            <i class="fa fa-exclamation-circle"></i> No Teams Found
                                        </div>
                                        @endif

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="tab03_pane" role="tabpanel" aria-labelledby="tab03">
                            <div class="card-body flex-grow-1 pt-4 p-0">
                                <div class="media flex-column">


                                    <div class="text-right mb-3 pt-5">
                                        <a href="#" class="btn btn-maincolor">
                                            <i class="fas fa-star"></i> Give Rating
                                        </a>
                                    </div>



                                    <div class="review-statistics">
                                        <p>Total score</p>
                                        <div>
                                            <div class="review-score">
                                                <span>4.0</span>
                                                <div>
                                                    <span class="score">
                                                        <div class="score-wrap">
                                                            <span class="stars-active" style="width: 80%">
                                                                <i class="fas fa-star" aria-hidden="true"></i> <i class="fas fa-star" aria-hidden="true"></i> <i class="fas fa-star" aria-hidden="true"></i> <i class="fas fa-star" aria-hidden="true"></i> <i class="fas fa-star" aria-hidden="true"></i> </span>
                                                            <span class="stars-inactive">
                                                                <i class="far fa-star" aria-hidden="true"></i> <i class="far fa-star" aria-hidden="true"></i> <i class="far fa-star" aria-hidden="true"></i> <i class="far fa-star" aria-hidden="true"></i> <i class="far fa-star" aria-hidden="true"></i> </span>
                                                        </div>
                                                    </span>
                                                    <p>1 Reviews</p>
                                                </div>
                                            </div>
                                        </div>
                                        <p><b>100%</b> think the photos are accurate</p>
                                        <p><b>100%</b> believe the agreements have been fulfilled</p>
                                        <p><b>100%</b> have indicated that advertiser is a smoker</p>
                                        <p>The average visitor gives <b>excellent for hygiene</b></p>
                                        <p>The average visitor is <b>very satisfying with the ambience</b></p>
                                    </div>


                                    <div class="top-reviews mt-5" id="reviews-tab-top-reviews">
                                        <div class="review-info mb-4">
                                            <div class="d-flex">
                                                <div class="review-member-profile"><i class="fa fa-user"></i></div>
                                                <div class="reviewer_name_review_count_badge">
                                                    <p class="reviewer_name_review_count">
                                                        <span>
                                                            <b>
                                                                <a href="/visitor/18">
                                                                    shivani agrawals
                                                                </a>
                                                            </b>
                                                        </span>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="review-description show-more">
                                            <div class="d-flex align-items-center">
                                                <p class="total-score m-0 mr-2">4.0</p>
                                                <span class="score">
                                                    <div class="score-wrap">
                                                        <span class="stars-active" style="width: 80%">
                                                            <i class="fas fa-star" aria-hidden="true"></i> <i class="fas fa-star" aria-hidden="true"></i> <i class="fas fa-star" aria-hidden="true"></i> <i class="fas fa-star" aria-hidden="true"></i> <i class="fas fa-star" aria-hidden="true"></i> </span>
                                                        <span class="stars-inactive">
                                                            <i class="far fa-star" aria-hidden="true"></i> <i class="far fa-star" aria-hidden="true"></i> <i class="far fa-star" aria-hidden="true"></i> <i class="far fa-star" aria-hidden="true"></i> <i class="far fa-star" aria-hidden="true"></i> </span>
                                                    </div>
                                                </span>
                                            </div>
                                            <span class="review-date">
                                                <i class="fas fa-clock"></i>
                                                <span>1 week ago</span>
                                            </span>

                                            <div class="review-body">
                                                fdsgsdgsdg
                                            </div>

                                            <div class="review-options">
                                                <div>
                                                    <p>Are the photos in the ad accurate?</p>
                                                    <p>Yes</p>
                                                </div>
                                                <div>
                                                    <p>Have the agreements been fulfilled?</p>
                                                    <p>Yes</p>
                                                </div>
                                                <div>
                                                    <p>Is advertiser a smoker?</p>
                                                    <p>Yes</p>
                                                </div>
                                                <div>
                                                    <p>Hygiene</p>
                                                    <p>Excellent</p>
                                                </div>
                                                <div>
                                                    <p>Ambience</p>
                                                    <p>Very satisfying</p>
                                                </div>
                                            </div>

                                        </div>

                                        <hr>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="tab05_pane" role="tabpanel" aria-labelledby="tab05">
                            <div class="card-body flex-grow-1 pt-4 p-0">
                                <div class="agency-detail-team mt-4">
                                    <div class="row">
                                        @if($agency->media->where('type','video')->count())
                                        @foreach($agency->media->where('type','video') as $media)
                                        <div class="col-xl-3 col-lg-4 col-md-6">
                                            <div class=" agency-team-video-tab">
                                                <a href="{{ asset('storage/' .  $media->file_path) }}" data-fancybox="video">
                                                    <video class="" autoplay="" muted="" loop="" playsinline="">
                                                        <source src="{{ asset('storage/'.$media->file_path) }}" type="video/mp4">
                                                    </video>
                                                </a>

                                            </div>
                                        </div>
                                        @endforeach
                                        @else
                                        <div class="no-news  py-5">
                                            <h4>No Vides uploaded</h4>
                                        </div>
                                        @endif

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="tab06_pane" role="tabpanel" aria-labelledby="tab06">
                            <div class="card-body flex-grow-1 pt-4 p-0">
                                <div class="agency-detail-team mt-4">
                                    <div class="row">
                                        @if($agency->media->where('type','image')->count())
                                        @foreach($agency->media->where('type','image') as $media)
                                        <div class="col-xl-3 col-lg-4 col-md-6">
                                            <div class="ageny-team-profile-card">
                                                <a href="{{ asset('storage/' .  $media->file_path) }}" data-fancybox="gallery">
                                                    <img src="{{ asset('storage/'.$media->file_path) }}" alt="Profile">
                                                </a>
                                            </div>
                                        </div>
                                        @endforeach
                                        @else
                                        <div class="no-news  py-5">
                                            <h4>No Images uploaded</h4>
                                        </div>
                                        @endif


                                    </div>
                                </div>
                            </div>
                        </div>



                    </div>
                    <!-- tabs end-->
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('js')
<script>
    $(document).on("click", ".toggle-desc", function() {
        let $this = $(this);
        let $card = $this.closest(".ageny-team-profile-card");

        $card.find(".desc-preview").toggleClass("d-none");
        $card.find(".desc-full").toggleClass("d-none");

        if ($this.text().trim() === "Read more") {
            $this.text("Read less");
        } else {
            $this.text("Read more");
        }
    });

    $(document).ready(function() {
        // Short Description toggle
        $(".toggle-short").on("click", function() {
            let parent = $(this).closest("div, p").parent();
            parent.find(".short-desc-full").toggleClass("d-none");
            parent.find(".short-desc-preview").toggleClass("d-none");

            if (parent.find(".short-desc-full").hasClass("d-none")) {
                $(this).text("Show full description");
            } else {
                $(this).text("Hide description");
            }
        });

        // Long Description toggle
        $(".toggle-long").on("click", function() {
            let parent = $(this).closest("div, p").parent();
            parent.find(".long-desc-full").toggleClass("d-none");
            parent.find(".long-desc-preview").toggleClass("d-none");

            if (parent.find(".long-desc-full").hasClass("d-none")) {
                $(this).text("Show full description");
            } else {
                $(this).text("Hide description");
            }
        });
    });
</script>
@endpush('js')