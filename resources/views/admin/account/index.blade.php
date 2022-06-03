@extends('layouts.app')

@section('title', "Meus dados")

@section('content')
  <div class="container">
    <div class="row mb-4 d-flex align-items-center">
      <div class="col-auto d-flex align-items-center">
        <h4>Meus dados</h4>
      </div>
    </div>
    <form  name="update_user" id="update_user" action="{{ route('users.update', $user) }}" method="POST">
      @csrf
      {{ method_field('PUT') }}

      <div class="form-group row">
        <div class="col-12">
          <label for="username">Nome</label>
          <input type="text"
                  name="username"
                  id="username"
                  value="{{$user->name}}"
                  placeholder="Nome"
                  class="@error('username') is-invalid @enderror"
                  required>
        </div>
      </div>

      <div class="form-group row">
        <div class="col-12">
          <label for="email">Email</label>
          <input type="email"
                  name="email"
                  id="email"
                  value="{{$user->email}}"
                  placeholder="Email"
                  class="@error('email') is-invalid @enderror"
                  required>
        </div>
      </div>



    </form>
    <button type="submit" class="btn btn-primary" form="update_user">SALVAR</button>
  </div>
@endsection
