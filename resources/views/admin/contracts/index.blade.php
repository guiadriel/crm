@extends('layouts.app')

@section('title', 'Contratos')

@section('content')
  <div class="container">
    <div class="row mb-4 d-flex align-items-center">

      @can('create contract')
        <div class="col-2">
          <a href="{{ route('contracts.create')}}" class='btn btn-primary'>NOVO CONTRATO</a>
        </div>
      @endcan

      <div class="col-4 ">
        <form action="" method="get" class='d-flex align-items-center'>
          <input type="text" name="filter" id="filter" placeholder="Busque pelo numero do contrato ou o aluno" value="{{ request('filter')}}">

          <button type="submit" class='d-flex align-items-center btn btn-light'>
            <span class="material-icons" aria-owns="password">search</span>
          </button>
        </form>
      </div>
      <div class="col-4">
        <span>Visualizando <strong>{{count($contracts)}} / {{$contracts->total()}}</strong> registro(s)</span>
      </div>
    </div>

    <table class="table table-striped table-borderless">
      <thead>
        <tr>
          <th scope="col">Nº CONTRATO</th>
          <th scope="col">ALUNO</th>
          <th scope="col">STATUS DO CONTRATO</th>
          <th scope="col">VALOR</th>
          <th scope="col">DIA VENCIMENTO</th>
          <th scope="col">&nbsp;</th>
        </tr>
      </thead>
      <tbody>
          @foreach ($contracts as $contract)
            <tr>
              <th scope="row"> {{$contract->number}}</th>
              <td>{{$contract->student->name ?? ''}}</td>
              <td>{{$contract->status->description ?? ''}}</td>
              <td>@money($contract->payment_total)</td>
              <td>{{ $contract->payment_due_date }}</td>
              <td class='text-right'>

                @can('edit contract')
                  <a href="{{route('contracts.edit', $contract->id)}}" class='btn btn-sm btn-primary'>EDITAR</a>
                @endcan

                @can('delete contract')
                  @include('admin.contracts._delete')
                @endcan
              </td>
            </tr>
          @endforeach

          @if( $contracts->total() == 0 )
            <tr>
              <td colspan="7">Nenhum registro encontrado</td>
            </tr>
          @endif
      </tbody>
    </table>

    {{ $contracts->links() }}
  </div>
@endsection


