@extends('layouts.app')

@section('title', 'Categoria')

@section('content')
  <div class="container">
    <div class="row mb-4 d-flex align-items-center">

      @can('create categories')
        <div class="col-2">
          <a href="{{ route('categories.create')}}" class='btn btn-primary'>NOVA CATEGORIA</a>
        </div>
      @endcan

      <div class="col-4 ">
        <form action="" method="get" class='d-flex align-items-center'>
          <input type="text" name="filter" id="filter" placeholder="Busque pelo tipo da origem" value="{{ request('filter')}}">

          <button type="submit" class='d-flex align-items-center btn btn-light'>
            <span class="material-icons" aria-owns="password">search</span>
          </button>
        </form>
      </div>
      <div class="col-4">
        <span>Visualizando <strong>{{count($categories)}} / {{$categories->total()}}</strong> registro(s)</span>
      </div>
    </div>

    <table class="table table-striped table-borderless">
      <thead>
        <tr>
          <th scope="col">ID</th>
          <th scope="col">CATEGORIA</th>
          <th scope="col">SUB-CATEGORIAS</th>
          <th scope="col">&nbsp;</th>
        </tr>
      </thead>
      <tbody>
          @foreach ($categories as $category)
            <tr>

              <th scope="row">{{$category->id}}</th>
              <td>{{$category->name}}</td>
              <td>
                  @foreach ($category->subCategories as $subCategory)
                    <span class="badge badge-grey badge-primary">{{$subCategory->name}}</span>
                  @endforeach

            </td>
              <td class='text-right'>
                @if ($category->name != 'CONTRATOS')
                    @can('edit categories')
                    <a href="{{route('sub-categories.create', ["category" => $category->id ])}}" class='btn btn-sm btn-primary mt-1'>ADICIONAR SUBCATEGORIA</a>
                    <a href="{{route('categories.edit', $category->id)}}" class='btn btn-sm btn-primary mt-1'>EDITAR</a>
                    @endcan

                    @can('delete categories')
                        @include('admin.categories._delete')
                    @endcan
                @endif
              </td>
            </tr>
          @endforeach

          @if( $categories->total() == 0 )
            <tr>
              <td colspan="5">Nenhum registro encontrado</td>
            </tr>
          @endif
      </tbody>
    </table>

    {{ $categories->links() }}
  </div>
@endsection


