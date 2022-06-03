@extends('site.index')

@section('content')
  <section class="about-us-section">
    <x-site.navbar />
  </section>

  <section class='rethink-section'>
    <div class="container ">

      <div class="row mb-4">
        <div class="col-12 col-sm-8 offset-sm-2">
          <h2 class='font-light'>Aula ao vivo</h2>
          <div class="embed-responsive embed-responsive-4by3">
            VIDEO
          </div>
        </div>
      </div>

      <div class="row mt-4 mb-4">
        <div class="col-12 col-sm-8 offset-sm-2">
          <h1 class='font-light'>Aula presencial</h1>
          <p class='font-light font-18'>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quis odio aut fugiat. Illo suscipit vel cupiditate, labore molestiae ipsa sint! Omnis ullam rerum voluptatum repudiandae doloremque, exercitationem aliquid fuga nemo facilis quasi laborum a dolorum odit nisi, molestias eveniet explicabo quam cumque asperiores consequatur voluptatem! Quae quisquam hic sunt similique iusto ad error est, ipsa sapiente id, praesentium tempora quaerat fugiat voluptates saepe maxime omnis aperiam accusamus blanditiis eaque natus architecto numquam ab repellendus! Rerum.</p>
        </div>
      </div>

      <div class="row mb-4">
        <div class="col-12 col-sm-8 offset-sm-2">
          <h1 class='font-light'>IE</h1>
          <p class='font-light font-18'>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quis odio aut fugiat. Illo suscipit vel cupiditate, labore molestiae ipsa sint! Omnis ullam rerum voluptatum repudiandae doloremque, exercitationem aliquid fuga nemo facilis quasi laborum a dolorum odit nisi, molestias eveniet explicabo quam cumque asperiores consequatur voluptatem! Quae quisquam hic sunt similique iusto ad error est, ipsa sapiente id, praesentium tempora quaerat fugiat voluptates saepe maxime omnis aperiam accusamus blanditiis eaque natus architecto numquam ab repellendus! Rerum.</p>
        </div>
      </div>

      <div class="row mt-4">
        <div class="col-12 col-sm-8 offset-sm-2">
          <h1 class='font-light'>Aula para crianças</h1>
          <div class="media">
            <img src="{{asset('images/image-rethink.png')}}" class="mr-3" alt="...">
            <div class="media-body font-18 font-light">
              Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.
            </div>
          </div>
        </div>
      </div>



    </div>
  </section>
@endsection
