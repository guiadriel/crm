@extends('layouts.app')

@section('title', "Novo prospecto")

@section('content')
<div class="container">
    <div class="row mb-4 d-flex align-items-center">
      <div class="col-auto d-flex align-items-center">
        <a href="{{ url()->previous() }}" class='btn btn-primary'>VOLTAR</a>
        <span class='pl-3'>Cadastrar um novo prospecto</span>
      </div>
    </div>
    <div class="row">
        <div class="col-12">
            <form method="POST" action="{{ route('prospects.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="form-group row">
                    <div class="col-9">
                        <label for="name">Nome</label>
                        <input type="text"
                                name="name"
                                id="name"
                                value="{{ old('name') }}"
                                class="@error('name') is-invalid @enderror"
                                required autofocus>

                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="col-3">
                        <label for="phone">Telefone</label>
                        <input type="text"
                                name="phone"
                                id="phone"
                                value="{{ old('phone') }}"
                                class="@error('phone') is-invalid @enderror"
                                onkeyup="this.value=this.value.replace(/[^\d]/,'')"
                                required>

                        @error('phone')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>




                </div>

                <div class="form-group row">
                    <div class="col-12">
                        <label for="email">Email</label>
                        <input type="email"
                                name="email"
                                id="email"
                                value="{{ old('email') }}"
                                class="@error('email') is-invalid @enderror"
                                >

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row mb-0">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">
                            {{ __('SALVAR PROSPECTO') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
