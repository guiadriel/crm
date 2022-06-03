<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {!! SEO::generate() !!}

    <script defer src="{{ asset('js/app.js') }}"></script>

    {{-- <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/favicon.png')}}"> --}}
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('images/favicon-black/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/favicon-black/favicon-32x32.png')}}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/favicon-black/favicon-16x16.png')}}">
    <link rel="manifest" href="{{ asset('images/favicon-black/site.webmanifest')}}">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">


    <link href="{{ asset('css/site.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    @yield('head_scripts')
    @yield('head_styles')
</head>
<body>
    @yield('content')

    <x-site.footer />
</body>
</html>
