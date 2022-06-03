@extends('layouts.app')

@section('title', "Novo usuário")

@section('content')
<div class="container">
    <div class="row mb-4 d-flex align-items-center">
      <div class="col-auto d-flex align-items-center">
        <a href="{{ url()->previous() }}" class='btn btn-primary'>VOLTAR</a>
        <span class='pl-3'>Cadastrar usuário</span>
      </div>
    </div>
    <div class="row">
        <div class="col-md-8">
            <form method="POST" action="{{ route('users.register') }}">
                @csrf


                <div class="form-group row">
                    <div class="col-12">
                        <label for="name">Nome</label>
                        <input type="text"
                                name="name"
                                id="name"
                                value="{{ old('name') }}"
                                placeholder="Nome"
                                class="@error('name') is-invalid @enderror"
                                required autocomplete="name" autofocus>

                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-12">
                        <label for="email" >{{ __('Email') }}</label>
                        <input id="email"
                               type="email"
                               class="@error('email') is-invalid @enderror"
                               name="email"
                               value="{{ old('email') }}"
                               required
                               autocomplete="email">
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-6">
                        <label for="password" >{{ __('Senha') }}</label>
                        <input id="password" type="password" class="@error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">


                    <div class="col-md-6">
                        <label for="password-confirm" >{{ __('Confirmação de senha') }}</label>
                        <input id="password-confirm" type="password" name="password_confirmation" required autocomplete="new-password">
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
                            >
                            <label class="custom-control-label" for="customCheck{{$role->id}}">{{$role->name}}</label>
                            </div>
                        @endforeach
                        </div>
                    </div>

                    </div>
                </div>

                <div class="form-group row mb-0">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">
                            {{ __('SALVAR CADASTRO') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
