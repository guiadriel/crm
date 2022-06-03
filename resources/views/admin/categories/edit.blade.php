@extends('layouts.app')

@section('title', "Editar categoria [$category->name]")

@section('content')
  <div class="container">
    <div class="row mb-4 d-flex align-items-center">
      <div class="col-auto d-flex align-items-center">
        <a href="{{ route('categories.index')}}" class='btn btn-primary mr-3'>VOLTAR</a>

        <span class='pl-3'>Editar categoria</span>
      </div>
    </div>
    <form  name="updateForm" id="updateForm" action="{{ route('categories.update', $category) }}" method="POST">
      @csrf
      {{ method_field('PUT') }}

      <div class="form-group row">
        <div class="col-12">
          <label for="name">Nome</label>
          <input type="text"
                  name="name"
                  id="name"
                  value="{{$category->name}}"
                  placeholder="Categoria"
                  class="@error('name') is-invalid @enderror"
                  required>

          @error('name')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
          @enderror
        </div>
      </div>

    </form>
    <button type="submit" class="btn btn-primary" form="updateForm">SALVAR</button>
    @include('admin.categories._delete', ['large' => true])

    <hr>

    <div class="row">
        <div class="col-12">
        <a href="{{route('sub-categories.create', ["category" => $category->id ])}}" class='btn btn-sm btn-primary mb-2'>ADICIONAR SUBCATEGORIA</a>
        <table class="table table-striped table-sm">
            <thead>
                <tr>
                <th scope="col">Subcategorias</th>
                <th scope="col">&nbsp;</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($category->subCategories as $subcategory)
                    <tr>
                        <td scope="row">{{$subcategory->name}}</td>
                        <td class="text-right">
                            @if ($category->name != 'CONTRATOS')
                                @include('admin.categories.sub-categories._delete')
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        </div>
    </div>
  </div>

@endsection
