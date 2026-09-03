@extends('front.layout.layout')

@section('content')
<div class="container py-5" style="min-height: 70vh;">
    <div class="header text-center mb-4">
        <div class="logo fs-2 fw-bold text-white">Sexy Devil</div>
        <div class="tagline text-muted">The World's Most Exclusive Erotic Platform</div>
    </div>

    <!-- Collapsible FAQ Accordion Component -->
    @include('front.component.faq_accordion')

    <div class="text-center mt-5">
        <p class="text-muted mb-2">Still have questions?</p>
        <a href="{{ route('contact-us') }}" class="btn btn-maincolor px-4 py-2">
            <i class="fa-solid fa-envelope me-2"></i> Contact Support
        </a>
    </div>
</div>
@endsection
