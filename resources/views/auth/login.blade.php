<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'APP_NAME') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <!-- Styles -->
    <link href="{{ asset('css/login.css') }}" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('images/favicon-black/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/favicon-black/favicon-32x32.png')}}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/favicon-black/favicon-16x16.png')}}">
    <link rel="manifest" href="{{ asset('images/favicon-black/site.webmanifest')}}">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">

</head>
<body class="login">
    <div class="login-container">
        <form method="POST" action="{{ route('login') }}">
            @csrf

            <img src="{{ asset('images/logoatt.svg')}}" alt="" srcset="">

            <div class='input-field'>
                <span class="material-icons">email</span>
                <input id="email"
                    type="email"
                    class="@error('email') is-invalid @enderror login-input" name="email"
                    value="{{ old('email') }}"
                    required
                    autocomplete="email"
                    placeholder="Email"
                    autofocus>
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class='input-field'>
                <span class="material-icons" aria-owns="password">lock</span>
                <input id="password"
                   type="password"
                   class="@error('password') is-invalid @enderror login-input" name="password"
                   value="{{ old('password') }}"
                   required
                   autocomplete="current-password"
                   placeholder="Senha"
                   aria-label="lock"
                   autofocus>
            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
            </div>

            <button type="submit">
                {{ __('Entrar') }}
            </button>

            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}">
                    {{ __('Esqueci minha senha') }}
                </a>
            @endif
        </form>
    </div>
    <div class="login-image">
    </div>
</body>
</html>


