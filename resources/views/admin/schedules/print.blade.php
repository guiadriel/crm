<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'Laravel'))</title>

    <!-- Scripts -->

    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script defer src="{{ asset('js/app.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.3.2/main.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.3.2/locales-all.min.js"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    {{-- <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/favicon.png')}}"> --}}
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('images/favicon-black/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/favicon-black/favicon-32x32.png')}}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/favicon-black/favicon-16x16.png')}}">
    <link rel="manifest" href="{{ asset('images/favicon-black/site.webmanifest')}}">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.3.2/main.min.css">

    @yield('head_scripts')
    @yield('head_styles')

    <livewire:styles />
    <livewire:scripts />
    @livewireCalendarScripts
</head>
<body>
    <div id="app" class="p-2 d-block">
        <div class="row d-block">
            <div class="col-auto">
                <button class="btn btn-primary d-flex align-items-center" onclick="generateImage()">
                    <i class="material-icons" data-action="move-next">insert_photo</i> EXPORTAR IMAGEM
                </button>
            </div>
        </div>
        <livewire:schedules.calendar :full="true" />
    </div>

    @yield('body_scripts')
    @stack('scripts')
</body>
</html>
