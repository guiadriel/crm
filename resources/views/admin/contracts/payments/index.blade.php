@extends('layouts.app')

@section('title', 'Gerenciar parcelas do contrato')

@section('content')
  <div class="container">
    <div class="row mb-4 d-flex align-items-center justify-content-between">

      @can('create contract')
        <div class="col-auto d-flex">
          <a href="{{ url()->previous() }}" class='btn btn-primary mr-4'>VOLTAR</a>

          <a href="{{ route('contracts.edit', $contract->id)}}" class='btn btn-outline-primary mr-2'>VER CONTRATO</a>

          @include('admin.contracts.payments._pdf', ['large' => true])
        </div>
      @endcan

    </div>

    <hr>

    <div class="row">
      <div class="col-12">
        <p class="m-0 p-0">Aluno</p>
        <h5 class="font-weight-bold"><span class="badge badge-white">{{$contract->student->name}}</span></h5>
      </div>
      <div class="col-auto">
        <p class="m-0 p-0">Contrato</p>
        <h5 class="font-weight-bold"><span class="badge badge-white">{{$contract->number}}</span></h5>
      </div>
      <div class="col-auto">
        <p class="m-0 p-0">Data de início</p>
        <h5 class="font-weight-bold"><span class="badge badge-white">{{$contract->start_date}}</span></h5>
      </div>
      <div class="col-auto">
        <p class="m-0 p-0">Vencimento (Dia) </p>
        <h5 class="font-weight-bold"><span class="badge badge-white">{{$contract->payment_due_date}}</span></h5>
      </div>
      <div class="col-auto">
        <p class="m-0 p-0">Valor do contrato </p>
        <h5 class="font-weight-bold"><span class="badge badge-white">@money($contract->payment_total)</span></h5>
      </div>
    </div>

    <hr>

    <div class="row">
      <div class="col-12">
        <a href="{{ route('contracts-payment.create', ['contract' => $contract])}}" class='btn btn-sm btn-primary'>ADICIONAR PAGAMENTO</a>
      </div>
      <div class="col-12">
        <table class="table table-borderless table-striped">
          <thead>
            <tr>
              <th>Sequência</th>
              <th>Tipo de pagamento</th>
              <th>Valor</th>
              <th class="text-center">Data de vencimento</th>
              <th>Status</th>
              <th>&nbsp;</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($contract->payments as $payment)
              <tr class="@if ($payment->bill_second_generation) text-blue @endif">
                <td class="align-middle font-weight-bold">{{$payment->sequence}}</td>
                <td class="align-middle">{{$payment->type}}</td>
                <td class="align-middle">
                    @if ($payment->interest > 0)
                        <span title="Total: @money($payment->value) + Juros: @money($payment->interest)" class="text-primary">
                            @money($payment->value + $payment->interest)*
                        </span>
                    @else
                        @money($payment->value)
                    @endif
                </td>
                <td class="align-middle text-center">{{$payment->due_date}}</td>
                <td class="align-middle">{{$payment->status->description}}</td>
                <td class="text-right">
                    <a class="btn btn-sm btn-primary" href="{{route('contracts-payment.edit', $payment)}}">EDITAR</a>
                    @can('delete contract')
                        @include('admin.contracts.payments._delete')
                    @endcan
                </td>
              </tr>
            @endforeach
            @if (count($contract->payments) == 0 )
              <tr>
                <td colspan="8">Nenhuma parcela disponível</td>
              </tr>
            @endif
          </tbody>
        </table>
      </div>
    </div>
  </div>
@endsection
