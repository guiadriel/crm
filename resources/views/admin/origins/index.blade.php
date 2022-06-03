@extends('layouts.app')

@section('title', 'Origens de cadastro')

@section('content')
  <div class="container">
    <div class="row mb-4 d-flex align-items-center">
      @can('create origins')
        <div class="col-2">
          <a href="{{ route('origins.create')}}" class='btn btn-primary'>Cadastrar origem</a>
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
        <span>Visualizando <strong>{{count($origins)}} / {{$origins->total()}}</strong> registro(s)</span>
      </div>
    </div>

    <table class="table table-striped table-borderless">
      <thead>
        <tr>
          <th scope="col">ID</th>
          <th scope="col">ORIGEM</th>
          <th scope="col">&nbsp;</th>
        </tr>
      </thead>
      <tbody>
          @foreach ($origins as $origin)
            <tr>

              <th scope="row">{{$origin->id}}</th>
              <td>{{$origin->type}}</td>
              <td class='text-right'>
                @can('edit origins')
                <a href="{{route('origins.edit', $origin->id)}}" class='btn btn-sm btn-primary'>EDITAR</a>
                @endcan

                @can('delete origins')
                  @include('admin.origins._delete')
                @endcan
              </td>
            </tr>
          @endforeach

          @if( $origins->total() == 0 )
            <tr>
              <td colspan="5">Nenhum registro encontrado</td>
            </tr>
          @endif
      </tbody>
    </table>

    {{ $origins->links() }}
  </div>
@endsection


