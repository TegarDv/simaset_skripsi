<!DOCTYPE html>
<html lang="id" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="ie=chrome">
    {{-- <link rel="icon" href=""> --}}
    <link rel="stylesheet" href="{{ asset('assets/bootstrap-5.3.1-dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/bootstrap-icons-1.10.5/font/bootstrap-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fontawesome-free-6.4.2-web/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/select2-4.1.0-rc.0/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/select2-bootstrap-5-theme-1.3.0/select2-bootstrap-5-theme.min.css') }}">
    @yield('custom_css')
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <title>@yield('title')</title>
</head>
<body>
    @extends('navbar')
    <br><br><br><br>
    @yield('content')
    @extends('footer')
    <script src="{{ asset('assets/bootstrap-5.3.1-dist/js/bootstrap.bundle.js') }}"></script>
    <script src="{{ asset('assets/select2-4.1.0-rc.0/dist/js/select2.min.js') }}"></script>
    @yield('custom_script')
</body>
</html>