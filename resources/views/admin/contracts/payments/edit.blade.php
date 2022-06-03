@extends('layouts.app')

@section('title', 'Gerenciar parcelas do contrato')

@section('content')
    <div class="container">
        <div class="row mb-4 d-flex align-items-center justify-content-between">

            @can('create contract')
                <div class="col-auto d-flex">
                <a href="{{ url()->previous() }}" class='btn btn-primary mr-4'>VOLTAR</a>
                <a href="{{ route('contracts.edit', $contract->id)}}" class='btn btn-outline-primary'>VER CONTRATO</a>
                </div>
            @endcan
        </div>

        <hr>

        <div class="row">
            <div class="col-12">
                <p class="m-0 p-0">Aluno</p>
                <h5 class="font-weight-bold"><span class="badge badge-white">{{$contract->student->name ?? ''}}</span></h5>
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

        <form method="POST" action="{{route('contracts-payment.update', ['contracts_payment' => $payment->id])}}">
            @csrf
            @method('PUT')

            <div class="form-group row">
                <div class="col-6">
                    <label class="my-1 mr-2" for="status">Status</label>
                    <select name="status"
                            id="status"
                            class='w-100'>
                        @foreach ($statuses as $status)
                            <option value="{{$status->id}}"

                            @if ($status->id == $payment->status->id)
                                selected
                            @endif

                            @if ( request()->has('confirm') && request('confirm') == true)
                                @if ($status->id == \App\Models\Status::getStatusPago()->id)
                                    selected
                                @endif
                            @endif

                            >{{$status->description}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-6">
                    <label class="my-1 mr-2" for="type">Tipo de pagamento</label>
                    <select name="type"
                            id="type"
                            class='w-100'>
                        @foreach ($methods as $method)
                            <option value="{{$method->description}}"

                                @if ($method->description == $payment->type)
                                    selected
                                @endif

                            >{{$method->description}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="row mb-2">
                <div class="col-3">
                    <label for="value">Valor (R$)</label>
                    <input type="text"
                            name="value"
                            id="value"
                            value="{{$payment->value}}"
                            class="@error('value') is-invalid @enderror mask-money font-weight-bold"
                            placeholder="Valor"
                            required

                            @if (!request()->has('confirm'))
                                autofocus
                            @endif
                            >
                </div>
                <div class="col-3">
                    <label for="interest">Juros (R$)</label>
                    <input type="text"
                            name="interest"
                            id="interest"
                            value="{{$payment->interest ?? '0,00'}}"
                            class="@error('interest') is-invalid @enderror mask-money"
                            placeholder="Juros">
                </div>
                <div class="col-6">
                    <label for="paid_at">Pago em</label>
                    <input type="text"
                            name="paid_at"
                            id="paid_at"
                            autocomplete="off"
                            value="{{$payment->paid_at}}"
                            class="@error('paid_at') is-invalid @enderror mask-date"
                            placeholder="00/00/0000"
                            @if (request()->has('confirm'))
                                autofocus
                            @endif
                            >
                </div>

            </div>

            <div class="row mb-2">

                {{-- <div class="col-3">
                    <label for="bill_number">Linha digitável Boleto</label>
                    <input type="text"
                            name="bill_number"
                            id="bill_number"
                            value="{{$payment->bill_number}}"
                            class="@error('bill_number') is-invalid @enderror"
                            placeholder="Linha digitável do boleto">
                </div> --}}

                <div class="col-3">
                    <label for="bill_bank_code">Código boleto (Banco)</label>
                    <input type="text"
                            name="bill_bank_code"
                            id="bill_bank_code"
                            value="{{$payment->bill_bank_code}}"
                            class="@error('bill_bank_code') is-invalid @enderror"
                            placeholder="Código do boleto">
                </div>

                <div class="col-3">
                    <label for="due_date">Data do vencimento</label>
                    <input type="text"
                            name="due_date"
                            id="due_date"
                            autocomplete="off"
                            value="{{$payment->due_date}}"

                            class="@error('due_date') is-invalid @enderror mask-date"
                            placeholder="Data de vencimento do boleto"
                            required>
                </div>

            </div>

            <div class="row my-2">
                <div class="col-6">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox"
                               class="custom-control-input"
                               id="bill_second_generation"
                               name="bill_second_generation"
                               @if ($payment->bill_second_generation)
                                    checked
                               @endif
                               >
                        <label class="custom-control-label" for="bill_second_generation">Gerado novamente</label>
                    </div>
                </div>
            </div>

            <div class="form-group row mb-2">
                <div class="col-12">
                    <label for="observations">Observações</label>
                    <textarea name="observations" id="observations" cols="30" rows="5" class="@error('name') is-invalid @enderror">{{$payment->observations}}</textarea>
                    @error('observations')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <hr>

            <div class="row">
                <div class="col-12">
                    <button class="btn btn-primary mr-4">ATUALIZAR</button>
                </div>
            </div>
        </form>
    </div>
@endsection
