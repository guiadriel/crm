@extends('layouts.app')

@section('title', "Nova origem de cadastro")

@section('content')
<div class="container">
    <div class="row mb-4 d-flex align-items-center">
      <div class="col-auto d-flex align-items-center">
        <a href="{{ url()->previous() }}" class='btn btn-primary'>VOLTAR</a>
        <span class='pl-3'>Cadastrar nova origem</span>
      </div>
    </div>
    <div class="row">
        <div class="col-md-8">
            <form method="POST" action="{{ route('origins.store') }}">
                @csrf


                <div class="form-group row">
                    <div class="col-12">
                        <label for="type">Origem de cadastro</label>
                        <input type="text"
                                name="type"
                                id="type"
                                value="{{ old('type') }}"
                                class="@error('type') is-invalid @enderror"
                                required autofocus>

                        @error('type')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
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
