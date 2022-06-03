<nav class="navbar navbar-expand-lg border-bottom border-dark">
  <div class="container">
    <a class="navbar-brand" href="{{ url('/')}}">
        <img class='brand-logo' src="{{asset('images/logo_letter_white.png')}}" alt="">
    </a>
    <button class="custom-toggler navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarCollapse">
        <ul class="navbar-nav ml-auto d-flex align-items-center">
            <li class="nav-item {{ Route::currentRouteNamed('site.home') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('site.home')}}">Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item {{ Route::currentRouteNamed('site.aboutus') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('site.aboutus')}}">Escola</a>
            </li>
            <li class="nav-item {{ Route::currentRouteNamed('site.ie') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('site.ie')}}">IE</a>
            </li>
            <li class="nav-item {{ Route::currentRouteNamed('site.courses') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('site.courses')}}">Cursos</a>
            </li>
            <li class="nav-item {{ Route::currentRouteNamed('site.workwithus') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('site.workwithus') }}">Trabalhe conosco</a>
            </li>
            <li class="nav-item {{ Route::currentRouteNamed('site.contact') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('site.contact') }}">Contato</a>
            </li>
        </ul>
    </div>
  </div>
</nav>
