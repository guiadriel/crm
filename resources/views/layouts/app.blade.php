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
    <div id="app">

        @yield('main_sidebar', View::make('layouts.sidebar'))
        <main>
            @yield('main_navbar', View::make('layouts.navbar'))
            <section class="content mb-2">
                @yield('content')
            </section>
        </main>
    </div>
    @include('layouts.toast')

    <script>
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = (e)=> {
                    $(input).parent().find('img').attr('src', e.target.result)
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        var SPMaskBehavior = function (val) {
        return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
        },
        spOptions = {
        onKeyPress: function(val, e, field, options) {
            field.mask(SPMaskBehavior.apply({}, arguments), options);
            }
        };



        $(document).ready(function () {
            $(".mask-time").mask('00:00');
            $(".mask-date").mask('00/00/0000');
            $(".mask-date-only").mask('00/00/0000');
            $(".mask-datetime").mask('00/00/0000 00:00:00');
            $('.mask-money').mask("#.##0,00", {reverse: true});
            $(".mask-date").datepicker({
                dateFormat: 'dd/mm/yy',
                dayNames: ['Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado'],
                dayNamesMin: ['D', 'S', 'T', 'Q', 'Q', 'S', 'S', 'D'],
                dayNamesShort: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb', 'Dom'],
                monthNames: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
                monthNamesShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
                nextText: 'Próximo',
                prevText: 'Anterior'
            });

            $('.mask-day').datepicker( {
                changeMonth: false,
                changeYear: false,
                showButtonPanel: false,
                dateFormat: 'dd'
            });
            $('.mask-phone').mask(SPMaskBehavior, spOptions);

            tippy('[data-tippy-content]');
        });

    </script>
    @yield('body_scripts')
    @stack('scripts')
</body>
</html>
