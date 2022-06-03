@extends('layouts.app')

@section('title', "Editar usuário [$user->email]")

@section('content')
  <div class="container">
    <div class="row mb-4 d-flex align-items-center">
      <div class="col-auto d-flex align-items-center">
        <a href="{{ route('users.index')}}" class='btn btn-primary'>VOLTAR</a>
        <span class='pl-3'>Editar usuário</span>
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
        <div class="col-6">
          <label for="email">Email</label>
          <input type="email"
                  name="email"
                  id="email"
                  value="{{$user->email}}"
                  placeholder="Email"
                  class="@error('email') is-invalid @enderror"
                  required>
        </div>
        <div class="col-4">
          <label for="password">Senha</label>
          <input id="password"
                   type="password"
                   class="@error('password') is-invalid @enderror" name="password"
                   autocomplete="current-password"
                   placeholder="Senha"
                   aria-label="lock"
                   autofocus>
        </div>
        <div class="col-2 d-flex align-items-end">
          <button form="reset_password" type="submit" class='btn btn-info text-light'>RESETAR SENHA</button>
        </div>
      </div>


      <div class="row mb-2">
        <div class="col-auto">
          <div class="card">
            <div class="card-body">
              @foreach ($roles as $role)
                <div class="custom-control custom-checkbox d-inline">
                  <input
                    type="checkbox"
                    class="custom-control-input"
                    name="roles[]"
                    id="customCheck{{$role->id}}"
                    value="{{$role->id}}"
                    @if($user->roles->pluck('id')->contains($role->id))
                      checked
                    @endif
                  >
                  <label class="custom-control-label" for="customCheck{{$role->id}}">{{$role->name}}</label>
                </div>
              @endforeach
            </div>
          </div>

        </div>
      </div>

    </form>
    <button type="submit" class="btn btn-primary" form="update_user">SALVAR</button>
    @include('admin.users._delete', ['large' => true])
  </div>

  <form name="reset_password"
        id="reset_password"
        action="{{ route('users.reset', $user)}}"
        method="post"
        class='d-inline'
        onSubmit="CustomDialog.submit('Deseja resetar a senha desse usuário? <Br/> <strong>Obs: Ao fazer o login a senha será igual ao email<strong>', this)">
    @csrf
    @method('PATCH')
  </form>

@endsection
