@extends('layouts.app')

@section('title', 'Contratos')

@section('content')
  <div class="container">
    <div class="row mb-4 d-flex align-items-center">

      @can('create contract')
        <div class="col-2">
          <a href="{{ route('contracts-models.create')}}" class='btn btn-primary'>Novo modelo</a>
        </div>
      @endcan
      <div class="col-4">
        <span>Visualizando <strong>{{count($models)}} / {{$models->total()}}</strong> registro(s)</span>
      </div>
    </div>

    <table class="table table-striped table-borderless">
      <thead>
        <tr>
          <th scope="col">ID</th>
          <th scope="col">MODELO</th>
          <th scope="col">&nbsp;</th>
        </tr>
      </thead>
      <tbody>
          @foreach ($models as $model)
            <tr>

              <th scope="row">{{$model->id}}</th>
              <td>{{$model->title}}</td>
              <td class='text-right'>

                <a href="{{route('contracts-models.edit', $model->id)}}" class='btn btn-sm btn-primary'>EDITAR</a>
                @include('admin.contracts.models._delete')
              </td>
            </tr>
          @endforeach

          @if( $models->total() == 0 )
            <tr>
              <td colspan="7">Nenhum registro encontrado</td>
            </tr>
          @endif
      </tbody>
    </table>

    {{ $models->links() }}
  </div>
@endsection


