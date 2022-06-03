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

        <form method="POST" action="{{route('contracts-payment.store', ['contract' => $contract->id])}}">
            @csrf

            <div class="form-group row">
                <div class="col-6">
                    <label class="my-1 mr-2" for="status">Status</label>
                    <select name="status"
                            id="status"
                            class='w-100'>
                        @foreach ($statuses as $status)
                            <option value="{{$status->id}}"

                            @if ($status->description == 'PENDENTE')
                                selected
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
                            <option value="{{$method->description}}">{{$method->description}}</option>
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

                            class="@error('value') is-invalid @enderror mask-money font-weight-bold"
                            placeholder="Valor"
                            required autofocus>
                </div>
                <div class="col-3">
                    <label for="juros">Juros (R$)</label>
                    <input type="text"
                            name="juros"
                            id="juros"
                            class="@error('juros') is-invalid @enderror mask-money"
                            placeholder="Valor"
                            value="0,00"
                            required autofocus>
                </div>
                <div class="col-6">
                    <label for="due_date">Data do vencimento</label>
                    <input type="text"
                            name="due_date"
                            id="due_date"
                            autocomplete="off"
                            class="@error('due_date') is-invalid @enderror mask-date"
                            placeholder="Data de vencimento do boleto"
                            required>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-6">
                    <label for="bill_number">Linha digitável boleto</label>
                    <input type="text"
                            name="bill_number"
                            id="bill_number"
                            class="@error('bill_number') is-invalid @enderror"
                            placeholder="Número do boleto">
                </div>
                <div class="col-6">
                    <label for="bill_bank_code">Código boleto (Banco)</label>
                    <input type="text"
                            name="bill_bank_code"
                            id="bill_bank_code"
                            class="@error('bill_bank_code') is-invalid @enderror"
                            placeholder="Código do boleto">
                </div>
            </div>

            <div class="form-group row mb-2">
                <div class="col-12">
                    <label for="observations">Observações</label>
                    <textarea name="observations" id="observations" cols="30" rows="5" class="@error('name') is-invalid @enderror"></textarea>
                    @error('observations')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <hr>

            <div class="row mb-4">
                <div class="col-12 mb-4">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox"
                               class="custom-control-input"
                               name="installments"
                               id="installments" >
                        <label class="custom-control-label" for="installments">
                            Gerar sequência de parcelas
                            <small class="d-block">As datas de vencimento corresponderâo ao {{$contract->payment_due_date}}º de cada mês</small>
                        </label>

                    </div>
                </div>
                <div class="col-12 installments d-none">
                    <label for="qty_installments">Quantidade de parcelas a serem geradas</label>
                    <input type="text"
                            name="qty_installments"
                            id="qty_installments"
                            class="@error('qty_installments') is-invalid @enderror"
                            placeholder="0">
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <button class="btn btn-primary mr-4">SALVAR PAGAMENTO(S)</button>
                </div>
            </div>
        </form>
    </div>

    <script>
        $(function () {
            $("#installments").change(function() {
                $(".installments").addClass('d-none');
                $("#qty_installments").removeAttr('required');

                if( $(this).is(':checked') ) {
                    $(".installments").removeClass('d-none');
                    $("#qty_installments").attr('required', true);
                }
            });
        });
    </script>
@endsection
