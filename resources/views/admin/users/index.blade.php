@extends('layouts.app')

@section('title', 'Usuários')

@section('content')
  <div class="container">
    <div class="row mb-4 d-flex align-items-center">

      @can('create users')
        <div class="col-2">
          <a href="{{ route('users.registerForm')}}" class='btn btn-primary'>Cadastrar usuário</a>
        </div>
      @endcan

      <div class="col-4 ">
        <form action="" method="get" class='d-flex align-items-center'>
          <input type="text" name="filter" id="filter" placeholder="Busque pelo nome ou email" value="{{ request('filter')}}">

          <button type="submit" class='d-flex align-items-center btn btn-light'>
            <span class="material-icons" aria-owns="password">search</span>
          </button>
        </form>
      </div>
      <div class="col-4">
        <span>Visualizando <strong>{{count($users)}} / {{$users->total()}}</strong> registro(s)</span>
      </div>
    </div>

    <table class="table table-striped table-borderless">
      <thead>
        <tr>
          <th scope="col">ID</th>
          <th scope="col">NOME</th>
          <th scope="col">EMAIL</th>
          <th scope="col">FUNÇÃO</th>
          <th scope="col">&nbsp;</th>
        </tr>
      </thead>
      <tbody>
          @foreach ($users as $user)
            <tr>

              <th scope="row">{{$user->id}}</th>
              <td>{{$user->name}}</td>
              <td>{{$user->email}}</td>
              <td>
                @foreach ( $user->roles()->get()->pluck('name')->toArray() as $item)
                  <span class="badge badge-secondary">{{$item}}</span>
                  @if($loop->index % 2 === 0 && $loop->index !== 0)
                  <br/>
                  @endif
                @endforeach
              </td>
              <td class='text-center'>
                @can('update users')
                <a href="{{route('users.edit', $user->id)}}" class='btn btn-sm btn-primary'>EDITAR</a>
                @endcan

                @can('delete users')
                  @include('admin.users._delete')
                @endcan
              </td>
            </tr>
          @endforeach

          @if( $users->total() == 0 )
            <tr>
              <td colspan="5">Nenhum registro encontrado</td>
            </tr>
          @endif
      </tbody>
    </table>

    {{ $users->links() }}
  </div>
@endsection


