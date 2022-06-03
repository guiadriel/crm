@extends('layouts.app')

@section('title', 'Books')

@section('content')
  <div class="container">
    <div class="row mb-4 d-flex align-items-center">

      @can('create books')
        <div class="col-2">
          <a href="{{ route('books.create')}}" class='btn btn-primary'>Cadastrar books</a>
        </div>
      @endcan

      <div class="col-4">
        <form action="" method="get" class='d-flex align-items-center'>
          <input type="text" name="filter" id="filter" placeholder="Busque pelo nome" value="{{ request('filter')}}">

          <button type="submit" class='d-flex align-items-center btn btn-light'>
            <span class="material-icons" aria-owns="filter">search</span>
          </button>
        </form>
      </div>
      <div class="col-4">
        <span>Visualizando <strong>{{count($books)}} / {{$books->total()}}</strong> registro(s)</span>
      </div>
    </div>

    <table class="table table-striped table-borderless">
      <thead>
        <tr>
          <th scope="col">ID</th>
          <th scope="col">LIVRO</th>
          <th scope="col">ATIVIDADES</th>
          <th scope="col">&nbsp;</th>
        </tr>
      </thead>
      <tbody>
          @foreach ($books as $book)
            <tr>

              <th scope="row">{{$book->id}}</th>
              <td>{{$book->name}}</td>
              <td>
                @if (count($book->activities) > 0 )
                    @foreach ($book->activities as $activity)
                        <span class="badge badge-pill badge-primary">{{$activity->name}}</span>
                    @endforeach
                @endif
              </td>
              <td class='text-right'>
                @can('edit books')
                  <a href="{{route('books.edit', $book->id)}}" class='btn btn-sm btn-primary'>EDITAR</a>
                @endcan

                @can('delete books')
                  @include('admin.books._delete')
                @endcan
              </td>
            </tr>
          @endforeach

          @if( $books->total() == 0 )
            <tr>
              <td colspan="5">Nenhum registro encontrado</td>
            </tr>
          @endif
      </tbody>
    </table>

    {{ $books->links() }}
  </div>
@endsection
