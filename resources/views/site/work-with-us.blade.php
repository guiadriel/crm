@extends('site.index')

@section('content')
  <section class="about-us-section">
    <x-site.navbar />
  </section>

  <section class='rethink-section'>
    <div class="container contact-container">
      <div class="card-contact bg-secondary">
        <strong>Contato</strong>
        <ul>
          <li><i class="material-icons">room</i>
            @if(isset($siteConfig))
              {{ $siteConfig->address }}, {{$siteConfig->number}}
            @endif
          </li>
          <li><i class="material-icons">email</i>
            @if(isset($siteConfig))
              {{ $siteConfig->email }}
            @endif
          </li>
          <li><i class="material-icons">call</i>
            @if(isset($siteConfig))
              {{ $siteConfig->phone }}
            @endif
          </li>
        </ul>
      </div>
      <div class="card-form">
        <strong>Trabalhe conosco</strong>
        <p>Informe seus dados e entraremos em contato com você!</p>
        <input type="text" placeholder="Seu nome">
        <input type="email" placeholder="Seu email">
        <textarea name="" id="" cols="30" placeholder="Digite sua mensagem aqui"></textarea>
        <button class='btn btn-lg btn-light text-light bg-secondary'>Enviar</button>
      </div>
    </div>
  </section>


@endsection
