@extends('site.index')

@section('content')
  <section class="about-us-section">
    <x-site.navbar />
  </section>

   <section class='rethink-section'>
    <div class="container ">
      <div class="row mb-4">
        <div class="col-12 col-sm-4 pl-sm-3">
          <h4 class=''>IE</h4>
          <h5 class='font-light'>O que é?</h5>
          <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Recusandae, suscipit quisquam quis provident dolore iure quod corrupti nisi numquam maiores distinctio at asperiores architecto vitae.</p>
          <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Recusandae, suscipit quisquam quis provident dolore iure quod corrupti nisi numquam maiores distinctio at asperiores architecto vitae.</p>
        </div>
        <div class="col-12 col-sm-6 offset-sm-1 mb-3 mb-sm-0">
          <img class='w-100' src="{{asset('images/image-rethink.png')}}" alt="">
        </div>
      </div>

      <div class="row mb-4">
        <div class="col-12 col-sm-6 mb-3 mb-sm-0">
          <img class='w-100' src="{{asset('images/image-rethink.png')}}" alt="">
        </div>

        <div class="col-12 col-sm-4 pl-sm-3">
          <h5 class='font-light'>Quanto tempo?</h5>
          <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Recusandae, suscipit quisquam quis provident dolore iure quod corrupti nisi numquam maiores distinctio at asperiores architecto vitae.</p>
          <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Recusandae, suscipit quisquam quis provident dolore iure quod corrupti nisi numquam maiores distinctio at asperiores architecto vitae.</p>
        </div>
      </div>

      <div class="row">
        <div class="col-12 col-sm-4 pl-sm-3">
          <h5 class='font-light'>Quem pode fazer?</h5>
          <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Recusandae, suscipit quisquam quis provident dolore iure quod corrupti nisi numquam maiores distinctio at asperiores architecto vitae.</p>
          <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Recusandae, suscipit quisquam quis provident dolore iure quod corrupti nisi numquam maiores distinctio at asperiores architecto vitae.</p>
        </div>

        <div class="col-12 col-sm-6 offset-sm-1 mb-3 mb-sm-0">
          <img class='w-100' src="{{asset('images/image-rethink.png')}}" alt="">
        </div>
      </div>

    </div>
  </section>

@endsection
