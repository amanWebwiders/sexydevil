<!DOCTYPE html>
<html class="no-js">

<head>
@php
    $seoObj = $locationSeoContent['data'] ?? $locationSeo['data'] ?? null;
    $metaTitle = !empty($seoObj->meta_title) ? $seoObj->meta_title : ($pageTitle ?? env('APP_NAME', 'SexyDevil'));
    $metaDescription = !empty($seoObj->meta_description) ? $seoObj->meta_description : '';
    $seoImageAlt = !empty($seoObj->image_alt_text) ? $seoObj->image_alt_text : env('APP_NAME', 'SexyDevil Escorts');
    
    $metaKeywords = !empty($seoObj->meta_keywords) ? $seoObj->meta_keywords : '';
    $canonicalUrl = !empty($seoObj->canonical_url) ? $seoObj->canonical_url : ($seoCanonicalUrl ?? url()->current());
    $robotsSetting = !empty($seoObj->robots_setting) ? $seoObj->robots_setting : 'index, follow';
    
    $ogTitle = !empty($seoObj->og_title) ? $seoObj->og_title : $metaTitle;
    $ogDescription = !empty($seoObj->og_description) ? $seoObj->og_description : $metaDescription;
    $ogImage = !empty($seoObj->og_image) ? asset($seoObj->og_image) : ($seoOgImage ?? asset('images/escort_logo1.png'));
    
    $twitterTitle = !empty($seoObj->twitter_title) ? $seoObj->twitter_title : $metaTitle;
    $twitterDescription = !empty($seoObj->twitter_description) ? $seoObj->twitter_description : $metaDescription;
    $twitterImage = !empty($seoObj->twitter_image) ? asset($seoObj->twitter_image) : $ogImage;
@endphp
	<title>{{ $metaTitle }}</title>
	<meta charset="utf-8">
	<meta name="google" content="notranslate">
	<meta name="description" content="{{ $metaDescription }}">
@if($metaKeywords)
	<meta name="keywords" content="{{ $metaKeywords }}">
@endif
	<meta name="robots" content="{{ $robotsSetting }}">
	<link rel="canonical" href="{{ $canonicalUrl }}">

	<!-- Open Graph Tags -->
	<meta property="og:type" content="website" />
	<meta property="og:title" content="{{ $ogTitle }}" />
	<meta property="og:description" content="{{ $ogDescription }}" />
	<meta property="og:url" content="{{ $canonicalUrl }}" />
	<meta property="og:image" content="{{ $ogImage }}" />

	<!-- Twitter Card Tags -->
	<meta name="twitter:card" content="summary_large_image" />
	<meta name="twitter:title" content="{{ $twitterTitle }}" />
	<meta name="twitter:description" content="{{ $twitterDescription }}" />
	<meta name="twitter:image" content="{{ $twitterImage }}" />

	@stack('seo')
	<meta name="format-detection" content="telephone=no">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" href="{{ asset('css/bootstrap.min.css')}}">
	<link rel="stylesheet" href="{{ asset('css/animations.css')}}">
	<link rel="stylesheet" href="{{ asset('css/font-awesome.css')}}">
	<link rel="stylesheet" href="{{ asset('css/main.css')}}" class="color-switcher-link">
	<script src="{{ asset('js/vendor/modernizr-custom.js')}}"></script>
	<link rel="icon" type="image/x-icon" href="{{ asset('images/escort_favicon.png')}}">

	<meta name="csrf-token" content="{{ csrf_token() }}">

	<link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />

      <!-- CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui/dist/fancybox.css" />

	  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />


	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />


	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

	<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />


	<!-- owl -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" integrity="sha512-utbXrZ1P0xZ4M7V+G6x7pT6lZsN67d5V8Vt0RsmvVnXgO4c9V+6H1Y9CQ/KxwBfDkPvR1rSj7wZ6aLks+W1h6g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css" integrity="sha512-0c9T6VbCKQ07v30t2h2GZ0y/++Rn/9mW4S8n/X1pNJJxTVd8FhuP6F+oAq0tCjYpQxg8U4Z9r+P9OtkC2s3rQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

	  

</head>

<body>