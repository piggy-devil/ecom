<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<title>Stack Developers online Shopping cart</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
	<meta name="author" content="">

	<!-- Front style -->
	<link id="callCss" rel="stylesheet" href="{{ url('frontend/themes/css/front.min.css') }}" media="screen" />
	<link href="{{ url('frontend/themes/css/base.css') }}" rel="stylesheet" media="screen" />
	<!-- Front style responsive -->
	<link href="{{ url('frontend/themes/css/front-responsive.min.cs') }}s" rel="stylesheet" />
	<link href="{{ url('frontend/themes/css/font-awesome.css') }}" rel="stylesheet" type="text/css">
	<!-- Google-code-prettify -->
	<link href="{{ url('frontend/themes/js/google-code-prettify/prettify.css') }}" rel="stylesheet" />
	<!-- fav and touch icons -->
	<link rel="shortcut icon" href="{{ url('frontend/themes/images/ico/favicon.ico') }}">
	<link rel="apple-touch-icon-precomposed" sizes="144x144" href="{{ url('frontend/themes/images/ico/apple-touch-icon-144-precomposed.png') }}">
	<link rel="apple-touch-icon-precomposed" sizes="114x114" href="{{ url('frontend/themes/images/ico/apple-touch-icon-114-precomposed.png') }}">
	<link rel="apple-touch-icon-precomposed" sizes="72x72" href="{{ url('frontend/themes/images/ico/apple-touch-icon-72-precomposed.png') }}">
	<link rel="apple-touch-icon-precomposed" href="{{ url('frontend/themes/images/ico/apple-touch-icon-57-precomposed.png') }}">
	<style type="text/css" id="enject"></style>
</head>

<body>
	@include('layouts.frontend.header')
	<!-- Header End====================================================================== -->
	@include('front.banners.home_page_banner')
	<div id="mainBody">
		<div class="container">
			<div class="row">
				<!-- Sidebar ================================================== -->
				@include('layouts.frontend.sidebar')
				<!-- Sidebar end=============================================== -->
				@yield('content')
			</div>
		</div>
	</div>
	<!-- Footer ================================================================== -->
	@include('layouts.frontend.footer')
	<!-- Placed at the end of the document so the pages load faster ============================================= -->
	<script type="text/javascript" src="{{ asset('frontend/themes/js/jquery.js') }}"></script>
	<script type="text/javascript" src="{{ asset('frontend/themes/js/front.min.js') }}"></script>
	<script src="{{ asset('frontend/themes/js/google-code-prettify/prettify.js') }}"></script>

	<script src="{{ asset('frontend/themes/js/front.js') }}"></script>
	<script src="{{ asset('frontend/themes/js/jquery.lightbox-0.5.js') }}"></script>

</body>

</html>