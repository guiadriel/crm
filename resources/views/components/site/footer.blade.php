<footer>
    <div class="newsletter container">
        <h1>Fique por dentro</h1>
        <p>Não perca nenhuma das novidades que temos preparado pra você.</p>
        <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="Seu melhor email" aria-label="Recipient's username" aria-describedby="button-addon2">
            <div class="input-group-append">
                <button class="btn btn-primary" type="button" id="button-addon2">
                    <i class="material-icons">send</i>
                </button>
            </div>
        </div>
    </div>
    <div class="maplinks">
        <div class="container  text-center text-sm-left d-sm-flex justify-content-between">
            <img class='logo' src="{{asset('images/logo_white.svg')}}" alt="APP_NAME" />
            <div class='localization'>
                <strong>Taubaté</strong>
                <p>{{$siteconfig->address}}, {{$siteconfig->number}}</p>
                <p>{{$siteconfig->district}}, {{$siteconfig->city}} - {{$siteconfig->state}}</p>
                <p>{{$siteconfig->phone}}</p>
            </div>
            <div class='links'>
                <strong>Mapa do site</strong>
                <a href="#">Home</a>
                <a href="#">Escola</a>
                <a href="#">Fale Conosco</a>
                <a href="#">Contato</a>
                <a href="#">Curso</a>
            </div>
            <div class='text-center text-sm-right social-media'>
                <strong>Acompanhe nossas redes sociais</strong>
                <div class="d-flex align-items-center justify-content-center justify-content-sm-end">
                    <img src="{{asset('images/brandico_facebook.png')}}" alt="Facebook APP_NAME">
                    <img src="{{asset('images/brandico_instagram.png')}}" alt="Instagram APP_NAME">
                    <img src="{{asset('images/brandico_twitter.png')}}" alt="Twitter APP_NAME">
                </div>

            </div>
        </div>
        <p class='text-center mt-4'>Todos os direitos reservados 2020 - Desenvolvido por @guiadriel</p>
    </div>
</footer>
