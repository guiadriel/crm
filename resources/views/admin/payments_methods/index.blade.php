@extends('layouts.app')

@section('title', 'Métodos de pagamento')

@section('content')
  <div class="container">
    <div class="row mb-4 d-flex align-items-center">
      @can('create origins')
        <div class="col-2">
          <a href="{{ route('payment-methods.create')}}" class='btn btn-primary'>Cadastrar método</a>
        </div>
      @endcan

      <div class="col-4 ">
        <form action="" method="get" class='d-flex align-items-center'>
          <input type="text" name="filter" id="filter" placeholder="Busque pelo método" value="{{ request('filter')}}">

          <button type="submit" class='d-flex align-items-center btn btn-light'>
            <span class="material-icons" aria-owns="password">search</span>
          </button>
        </form>
      </div>
      <div class="col-4">
        <span>Visualizando <strong>{{count($paymentsMethods)}} / {{$paymentsMethods->total()}}</strong> registro(s)</span>
      </div>
    </div>

    <table class="table table-striped table-borderless">
      <thead>
        <tr>
          <th scope="col">ID</th>
          <th scope="col">MÉTODO DE PAGAMENTO</th>
          <th scope="col">STATUS</th>
          <th scope="col">CATEGORIA / SUBCATEGORIA</th>
          <th scope="col">&nbsp;</th>
        </tr>
      </thead>
      <tbody>
          @foreach ($paymentsMethods as $method)
            <tr>
              <th scope="row">{{$method->id}}</th>
              <td>{{$method->description}}</td>
              <td>{{$method->status->description}}</td>
              <td>
                  @if ($method->category)
                      {{$method->category->name}} / {{$method->subCategory->name}}
                  @endif
                  </td>
              <td class='text-right'>
                <a href="{{route('payment-methods.edit', $method->id)}}" class='btn btn-sm btn-primary'>EDITAR</a>
                  @include('admin.payments_methods._delete')
              </td>
            </tr>
          @endforeach

          @if( $paymentsMethods->total() == 0 )
            <tr>
              <td colspan="5">Nenhum registro encontrado</td>
            </tr>
          @endif
      </tbody>
    </table>

    {{ $paymentsMethods->links() }}
  </div>
@endsection


