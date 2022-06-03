@extends('site.index')

@section('content')
  <section class="about-us-section">
    <x-site.navbar />
  </section>

  <section class='rethink-section'>
    <div class="container ">
      <div class="row">
        <div class="col-12 col-sm-4 pl-sm-3">
          <h4 class=''>Nossa História</h4>
          <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Recusandae, suscipit quisquam quis provident dolore iure quod corrupti nisi numquam maiores distinctio at asperiores architecto vitae.</p>
          <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Recusandae, suscipit quisquam quis provident dolore iure quod corrupti nisi numquam maiores distinctio at asperiores architecto vitae.</p>
        </div>
        <div class="col-12 col-sm-6 offset-sm-1 mb-3 mb-sm-0">
          <img class='w-100' src="{{asset('images/image-rethink.png')}}" alt="">
        </div>
      </div>
    </div>
  </section>


  <x-site.mission />

  <section class='container'>
    <div class="row text-light">
      <div class="col-12 col-sm-6">
        <h2 class='text-center text-md-left title-light mb-4'>Metodologia</h2>
        <ul>
          <li class='d-flex justify-content-between align-items-center'>
            <i class="material-icons mr-3">play_circle_outline</i>
            <p class='text-light'>Lorem ipsum dolor sit amet consectetur adipisicing elit. Iusto eius nam eveniet perferendis laboriosam possimus velit accusantium, officia consectetur, quae laudantium repellendus harum quisquam temporibus?</p>
          </li>
          <li class='d-flex justify-content-between align-items-center'>
            <i class="material-icons mr-3">play_circle_outline</i>
            <p class='text-light'>Lorem ipsum dolor sit amet consectetur adipisicing elit. Iusto eius nam eveniet perferendis laboriosam possimus velit accusantium, officia consectetur, quae laudantium repellendus harum quisquam temporibus?</p>
          </li>
          <li class='d-flex justify-content-between align-items-center'>
            <i class="material-icons mr-3">play_circle_outline</i>
            <p class='text-light'>Lorem ipsum dolor sit amet consectetur adipisicing elit. Iusto eius nam eveniet perferendis laboriosam possimus velit accusantium, officia consectetur, quae laudantium repellendus harum quisquam temporibus?</p>
          </li>
        </ul>
      </div>

      <div class="col-12 col-sm-6">
        <h2 class='text-center text-md-left title-light mb-4'>Diferencial</h2>
        <ul>
          <li class='d-flex justify-content-between align-items-center'>
            <i class="material-icons mr-3">vpn_key</i>
            <p class='text-light'>Lorem ipsum dolor sit amet consectetur adipisicing elit. Iusto eius nam eveniet perferendis laboriosam possimus velit accusantium, officia consectetur, quae laudantium repellendus harum quisquam temporibus?</p>
          </li>
          <li class='d-flex justify-content-between align-items-center'>
            <i class="material-icons mr-3">vpn_key</i>
            <p class='text-light'>Lorem ipsum dolor sit amet consectetur adipisicing elit. Iusto eius nam eveniet perferendis laboriosam possimus velit accusantium, officia consectetur, quae laudantium repellendus harum quisquam temporibus?</p>
          </li>
          <li class='d-flex justify-content-between align-items-center'>
            <i class="material-icons mr-3">vpn_key</i>
            <p class='text-light'>Lorem ipsum dolor sit amet consectetur adipisicing elit. Iusto eius nam eveniet perferendis laboriosam possimus velit accusantium, officia consectetur, quae laudantium repellendus harum quisquam temporibus?</p>
          </li>
        </ul>
      </div>


    </div>
  </section>
@endsection
