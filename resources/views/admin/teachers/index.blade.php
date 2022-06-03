@extends('layouts.app')

@section('title', 'Professores')

@section('content')
  <div class="container">
    <div class="row mb-4 d-flex align-items-center">

      @can('create teachers')
        <div class="col-2">
          <a href="{{ route('teachers.create')}}" class='btn btn-primary'>Cadastrar professor</a>
        </div>
      @endcan

      <div class="col-4 ">
        <form action="" method="get" class='d-flex align-items-center'>
          <input type="text" name="filter" id="filter" placeholder="Busque pelo nome" value="{{ request('filter')}}">

          <button type="submit" class='d-flex align-items-center btn btn-light'>
            <span class="material-icons" aria-owns="filter">search</span>
          </button>
        </form>
      </div>
      <div class="col-4">
        <span>Visualizando <strong>{{count($teachers)}} / {{$teachers->total()}}</strong> registro(s)</span>
      </div>
    </div>

    <table class="table table-striped table-borderless">
      <thead>
        <tr>
          <th scope="col">NOME</th>
          <th scope="col">EMAIL</th>
          <th scope="col">TELEFONE</th>
          <th scope="col">COR</th>
          <th scope="col">&nbsp;</th>
        </tr>
      </thead>
      <tbody>
          @foreach ($teachers as $teacher)
            <tr>
              <td>{{$teacher->name}}</td>
              <td>{{$teacher->email}}</td>
              <td>{{$teacher->phone}}</td>
              <td>
                  <span class="badge" style="background: {{$teacher->color}};">{{$teacher->color}}</span>
              </td>
              <td class='text-center'>
                @can('edit teachers')
                <a href="{{route('teachers.edit', $teacher->id)}}" class='btn btn-sm btn-primary'>EDITAR</a>
                @endcan

                @can('remove teachers')
                  @include('admin.teachers._delete')
                @endcan
              </td>
            </tr>
          @endforeach

          @if( $teachers->total() == 0 )
            <tr>
              <td colspan="5">Nenhum registro encontrado</td>
            </tr>
          @endif
      </tbody>
    </table>

    {{ $teachers->links() }}
  </div>
@endsection


