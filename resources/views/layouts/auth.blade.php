<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc.">
		<meta name="author" content="Coderthemes">
		<meta name="csrf-token" content="{{ csrf_token() }}">

		<link rel="shortcut icon" href="assets/images/favicon_1.ico">

		<title>@yield('title')</title>

{{--        <link href="{{asset('assets/admin/css/admin.css')}}" rel="stylesheet" type="text/css" />--}}
        <link rel="stylesheet" href="{{asset('assets/auth/css/auth.css')}}">
        @stack('styles')

	</head>

	<body>
    <div class="account-pages"></div>
    <div class="clearfix"></div>
    <div class="wrapper-page">
        @yield('content')

    </div>

    </body>
    @stack('scripts')
</html>
