@extends('layouts.app')

@section('title', "Editar origem de cadastro [$origin->type]")

@section('content')
  <div class="container">
    <div class="row mb-4 d-flex align-items-center">
      <div class="col-auto d-flex align-items-center">
        <a href="{{ route('origins.index')}}" class='btn btn-primary'>VOLTAR</a>
        <span class='pl-3'>Editar origem de cadastro</span>
      </div>
    </div>
    <form  name="updateForm" id="updateForm" action="{{ route('origins.update', $origin) }}" method="POST">
      @csrf
      {{ method_field('PUT') }}

      <div class="form-group row">
        <div class="col-12">
          <label for="type">tipo</label>
          <input type="text"
                  name="type"
                  id="type"
                  value="{{$origin->type}}"
                  placeholder="Origem"
                  class="@error('type') is-invalid @enderror"
                  required>
        </div>
      </div>
    </form>
    <button type="submit" class="btn btn-primary" form="updateForm">SALVAR</button>
    @include('admin.origins._delete', ['large' => true])
  </div>

@endsection
