@extends('layouts.app')

@section('title', 'Subcategoria')

@section('content')
    <div class="container">
        <div class="row mb-4 d-flex align-items-center">
            <div class="col-auto d-flex align-items-center">
                <a href="{{ route('categories.index')}}" class='btn btn-primary'>VOLTAR</a>
                <span class='pl-3'>Cadastrar nova categoria</span>
            </div>
        </div>

        <hr>

        <div class="row">
            <div class="col-12">
                Categoria
                <strong class="d-block">{{$category->name}}</strong>
            </div>
        </div>

        <hr>

        <form method="POST" action="{{ route('sub-categories.store', ['category_id' => $category->id]) }}">
            @csrf

            <div class="form-group row">
                <div class="col-12">
                    <label for="name">Nome da sub-categoria</label>
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
@endsection
