<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc.">
		<meta name="author" content="Coderthemes">
		<meta name="csrf-token" content="{{ csrf_token() }}">

		<link rel="shortcut icon" href="assets/images/favicon_1.ico">

		<title>@yield('title')</title>
        <link href="{{asset('assets/admin/css/admin.css')}}" rel="stylesheet" type="text/css" />

		@stack('styles');
	</head>

	<body class="fixed-left">

		<!-- Begin page -->
		<div id="wrapper">

			<!-- Top Bar Start -->
			@include('admin.sections.header')
			<!-- Top Bar End -->


			<!-- ========== Left Sidebar Start ========== -->

			@include('admin.sections.navigation')
			<!-- Left Sidebar End -->

			<!-- ============================================================== -->
			<!-- Start right Content here -->
			<!-- ============================================================== -->
			<div class="content-page">
				<!-- Start content -->
				<div class="content">
					@yield('content')
				</div>
				@include('admin.sections.footer')
			</div>

		</div>
		<!-- END wrapper -->

        <script>
            var resizefunc = [];
        </script>

        <!-- jQuery  -->
                <script src="{{asset('assets/admin/js/jquery.min.js')}}"></script>
                @stack('scripts');

				<script src="{{asset('assets/admin/js/spa.js')}}"></script>
		        <script src="{{asset('assets/admin/js/admin.js')}}"></script>
	</body>
</html>
