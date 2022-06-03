@extends('site.index')

@section('content')
  <section class='home-section'>
    <x-site.navbar />

    <div id="carouselExampleFade" class="carousel slide carousel-fade" data-ride="carousel">
      <div class="carousel-inner container pt-4">
        <div class="carousel-item active">
          <div class='d-flex flex-column flex-sm-row d-sm-flex align-items-center justify-content-sm-between justify-content-center'>
            <div class="text-light">
              <h1 class='title-light text-center text-sm-left'>SITE</h1>
              <p class='p-light text-center text-sm-left mb-4 mb-sm-0'>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Minus, adipisci?</p>
            </div>
            <img src="{{ asset('images/group_images.png')}}" class="w-75 w-sm-auto" alt="SITE">
          </div>

        </div>
      </div>
      <a class="carousel-control-prev" href="#" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
      </a>
      <a class="carousel-control-next" href="#" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
      </a>
    </div>

  </section>
  <section class='video-section'>
    <div class="container">
      <h1 class='title-light text-center text-sm-left'>Type of title</h1>
      <div class="row">
        <div class="col-12 col-sm-7">
          <p class='p-light'>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Tenetur officiis molestiae ab incidunt tempora, iusto voluptas hic temporibus adipisci, blanditiis exercitationem repellat inventore, deleniti ratione?</p>
        </div>
      </div>

      <div class="row">
        <div class="col-12 col-sm-8 offset-sm-2">
          <div class="embed-responsive embed-responsive-4by3">
            VIDEO
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class='rethink-section'>
    <div class="container ">
      <div class="row">
        <div class="col-12 col-sm-6 offset-sm-1 mb-3 mb-sm-0">
          <img class='w-100' src="{{asset('images/image-rethink.png')}}" alt="">
        </div>
        <div class="col-12 col-sm-4 pl-sm-3">
          <h4 class=''>Repense sua forma de pensar</h4>
          <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Recusandae, suscipit quisquam quis provident dolore iure quod corrupti nisi numquam maiores distinctio at asperiores architecto vitae.</p>
          <button class='btn btn-lg btn-primary'>Saiba mais</button>
        </div>
      </div>
    </div>
  </section>

  <x-site.mission/>
@endsection
