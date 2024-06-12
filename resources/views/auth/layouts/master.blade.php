<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('Title')</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('Admin/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('Admin/dist/css/all.min.css') }}">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="{{ asset('Admin/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('Admin/dist/css/adminlte.min.css') }}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ asset('Admin/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <!-- Customized Main Css -->
    <link rel="stylesheet" href="{{ asset('Admin/dist/css/style-sign.css') }}">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
    @yield('Css')

    @yield('Content')

    <script src="{{ asset('Admin/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('Admin/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('Admin/dist/js/main.js') }}"></script>

    @yield('Js')
</body>