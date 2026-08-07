<!DOCTYPE html>
<html lang="en">


<head>
	<meta charset="utf-8">
	<title>{{env('APP_NAME')}}</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">
	 <meta name="csrf-token" content="{{ csrf_token() }}" />
	
	<!-- ================== BEGIN core-css ================== -->
	<link href="{{ asset('admin/assets/css/vendor.min.css')}}" rel="stylesheet">
	<link href="{{ asset('admin/assets/css/app.min.css')}}" rel="stylesheet">
	<!-- ================== END core-css ================== -->

	<link rel="icon" type="image/x-icon" href="{{ asset('images/escort_favicon.png')}}">
	
	<!-- ================== BEGIN page-css ================== -->
	<link href="{{ asset('admin/assets/plugins/jvectormap-next/jquery-jvectormap.css')}}" rel="stylesheet">
	<link href="{{ asset('admin/assets/plugins/bootstrap-daterangepicker/daterangepicker.css')}}" rel="stylesheet">
	<!-- ================== END page-css ================== -->

</head>
<body>