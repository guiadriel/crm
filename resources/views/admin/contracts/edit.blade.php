@extends('layouts.app')

@section('title', "Editar contrato [$contract->number]")

@section('head_scripts')
    <style>
        .clickable:hover {
            cursor:pointer;
            background: #245FAD !important;
            color: #FFF;
        }

        table td {
            padding: 10px 5px;
        }

    </style>
@endsection
@section('content')
  <div class="container">
    <div class="row mb-4 d-flex align-items-center justify-content-between">
      <div class="col-auto d-flex align-items-center ">
        <a href="{{ url()->previous() }}" class='btn btn-primary mr-4'>VOLTAR</a>

        <span class='pl-3'>Editar contrato</span>


      </div>
      <div class="col-auto">
        <a href="{{ route('students.show', $contract->student->id) }}" class='btn btn-outline-primary'>VER ALUNO</a>
        <a href="{{ route('contracts.generate', $contract->id) }}" class='btn btn-dark ml-2'>GERAR PDF</a>
      </div>
    </div>

    <hr>

    <form  name="updateForm" id="updateForm" action="{{ route('contracts.update', $contract) }}" method="POST">
      @csrf
      {{ method_field('PUT') }}

        <div class="form-group row">
            <div class="col-10 input-group d-flex">
                <label for="student">Selecione o aluno</label>
                <input type="text"
                        name="student"
                        id="student"
                        readonly
                        value="{{ $contract->student->name }}"
                        class="@error('student') is-invalid @enderror"
                        placeholder="Clique na lupa para selecionar o aluno"
                        required autofocus>
                <input type="hidden"
                    id="student_id"
                    name="student_id"
                    value="{{ $contract->student->id }}">

                @error('student')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="col-2 d-flex align-items-end">

                <button type="button" class='btn btn-primary w-100' data-toggle="modal" data-target="#modalSearchStudents">
                    <i class="material-icons align-middle">search</i>
                </button>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-6">
                <label class="my-1 mr-2" for="status">Status</label>
                <select name="status"
                        id="status"
                        class='w-100'>
                    @foreach ($statuses as $status)
                        <option value="{{$status->id}}"
                        @if ($contract->status_id === $status->id)
                            selected
                        @endif
                        >{{$status->description}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-6">
                <label class="my-1 mr-2" for="turma">Turma</label>
                <select name="turma"
                        id="turma"
                        class='w-100'>
                    <option value="">Sem turma definida</option>
                    @foreach ($contract->student->groupclass as $class)
                        <option value="{{ $class->id }}" selected>{{ $class->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-4 input-group d-flex">
                <label for="type">Tipo de Aluno</label>
                <select name="type"
                        id="type"
                        class='w-100'>
                    <option value="NORMAL" @if ($contract->type == 'NORMAL') selected @endif>NORMAL</option>
                    <option value="VIP" @if ($contract->type == 'VIP') selected @endif>VIP</option>
                </select>
            </div>
            <div class="col-4 input-group d-flex">
                <label for="start_date">Data de início</label>
                <input type="text"
                        name="start_date"
                        id="start_date"
                        value="{{ $contract->start_date }}"
                        class="@error('start_date') is-invalid @enderror mask-date font-weight-bold"
                        pĺaceholder="__/__/____"
                        required>

                @error('start_date')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="col-4 input-group">
                <label class="my-1 mr-2" for="school_days">Aulas por semana (Qtde)</label>
                <input type="number"
                        name="school_days"
                        id="school_days"
                        min="0"
                        value="{{ $contract->school_days }}"
                        class="@error('school_days') is-invalid @enderror"
                        required>

                @error('school_days')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

        </div>
        <div class="row form-group">
            <div class="col-3">
                <label class="my-1 mr-2" for="payment_total">Valor do contrato</label>
                <input type="text"
                        name="payment_total"
                        id="payment_total"
                        value="{{ $contract->payment_total }}"
                        class="@error('payment_total') is-invalid @enderror mask-money"
                        required>

                @error('payment_total')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="col-3 input-group d-flex">
                <label for="payment_quantity">Quantidade de Parcelas</label>
                <input type="number"
                        name="payment_quantity"
                        id="payment_quantity"
                        min="0"
                        value="{{ $contract->payment_quantity ?? 1 }}"
                        class="@error('payment_quantity') is-invalid @enderror"
                        required>
                @error('payment_quantity')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
        <div class="form-group row">

            <div class="col-3">
                <label class="my-1 mr-2" for="payment_registration_value">Valor Matrícula</label>
                <input type="text"
                        name="payment_registration_value"
                        id="payment_registration_value"
                        value="{{ $contract->payment_registration_value }}"
                        class="@error('payment_registration_value') is-invalid @enderror mask-money"
                        required>

                @error('payment_registration_value')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="col-3">
                <label class="my-1 mr-2" for="paymentMethod">Meio de Pagamento</label>
                <select name="paymentMethod"
                        id="paymentMethod"
                        class='w-100'>
                    @foreach ($paymentsMethod as $payment)
                        <option value="{{$payment->id}}"
                                @if ($payment->id === $contract->payments_method_id)
                                    selected
                                @endif
                        >{{$payment->description}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-3">
                <label class="my-1 mr-2" for="payment_due_date">Data de Vencimento (Dia) </label>
                <select class='w-100'
                        name="payment_due_date"
                        id="payment_due_date"
                        required>
                    <option value="10" @if ($contract->payment_due_date == '10') selected @endif>10</option>
                    <option value="20" @if ($contract->payment_due_date == '20') selected @endif>20</option>

                </select>

                @error('payment_due_date')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>


        </div>

        <div class="canceled_input d-none">
            <hr>
                <div class="row">

                    <div class="col-3 ">
                        <label class="my-1 mr-2" for="canceled_at">Data de cancelamento </label>
                        <input type="text"
                                name="canceled_at"
                                id="canceled_at"
                                value="{{ $contract->canceled_at }}"
                                class="@error('canceled_at') is-invalid @enderror mask-date font-weight-bold"
                                pĺaceholder="__/__/____">

                        @error('canceled_at')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="col-9">
                        <label class="my-1 mr-2" for="reason_cancellation">Motivo do cancelamento</label>

                        <select class='w-100'
                                name="reason_cancellation"
                                id="reason_cancellation"
                                required>
                            @foreach ($reasons as $reason)
                                <option value="{{$reason}}" @if ($contract->reason_cancellation == $reason) selected @endif>{{$reason}}</option>
                            @endforeach
                        </select>

                        {{-- <input type="text"
                                name="reason_cancellation"
                                id="reason_cancellation"
                                value="{{ $contract->reason_cancellation }}"
                                class="@error('reason_cancellation') is-invalid @enderror font-weight-bold text-primary"
                                pĺaceholder=""> --}}

                        @error('reason_cancellation')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
            <hr>
        </div>

        <div class="executed_input d-none">
            <hr>
                <div class="row">

                    <div class="col-3 ">
                        <label class="my-1 mr-2" for="executed_at">Data de Execução </label>
                        <input type="text"
                                name="executed_at"
                                id="executed_at"
                                value="{{ $contract->executed_at }}"
                                class="@error('executed_at') is-invalid @enderror mask-date font-weight-bold"
                                pĺaceholder="__/__/____">

                        @error('executed_at')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                </div>
            <hr>
        </div>


        <div class="form-group row mb-2">
            <div class="col-12">
                <label for="observations">Observações</label>
                <textarea name="observations" id="observations" cols="30" rows="5" class="@error('name') is-invalid @enderror">{{$contract->observations}}</textarea>
                @error('observations')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

    </form>

    {{-- <form
        id="executeContractForm"
        name="executeContractForm"
        method="POST"
        onSubmit="CustomDialog.submit('Deseja executar esse contrato?', this)"
        action="{{ route('contracts.execute', $contract) }}">
        @csrf
        @method("PATCH")
    </form> --}}

    <div class="row justify-content-between">
        <div class="col-auto">
            <button type="submit" class="btn btn-primary" form="updateForm">SALVAR</button>
            @include('admin.contracts._delete', ['large' => true])

        </div>
        {{-- <div class="col-auto">
            @if( $contract->executed_at )
                Contrato executado em {{$contract->executed_at}}
            @else
                <button type="submit" class="btn btn-dark text-white" form="executeContractForm">EXECUTAR CONTRATO</button>
            @endif
        </div> --}}
    </div>

    <div class="row mt-3 mb-4" >
        <div class="col-12">
<div class="card border-primary w-100" style='background: #fffdfd'>
        <div class="card-body">
          <div class="row mb-2">
            <div class="col-12 d-flex align-items-center justify-content-between">
              <h5 class="card-title">Histórico de parcelas</h5>
              <div class="controls d-flex">
                @include('admin.contracts.payments._pdf')

                <a href="{{route("contracts-payment.index", ["contract_id" => $contract->id])}}" class="btn btn-sm btn-primary">GERENCIAR PARCELAS</a>

              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-12">
              <table class="table-borderless table-striped w-100 p-0 m-0">
                <thead>
                  <tr>
                    <th class='p-2 text-center' scope="row">#</th>
                    <th>VALOR</th>
                    <th>TIPO</th>
                    <th>STATUS</th>
                    <th>DATA</th>
                    <th>BOLETO</th>
                    <th class='text-center'>&nbsp;</th>
                  </tr>
                </thead>
                <tbody>
                    @foreach ($contract->payments as $payment)
                        <tr class="@if ($payment->bill_second_generation) text-blue @endif">
                            <th scope="row" class='text-center '>#{{$payment->sequence}}</th>
                            <td>
                                @if ($payment->interest > 0)
                                    <span title="Total: @money($payment->value) + Juros: @money($payment->interest)" class="text-primary">
                                        @money($payment->value + $payment->interest)*
                                    </span>
                                @else
                                    @money($payment->value)
                                @endif
                            </td>
                            <td>{{$payment->type}}</td>
                            <td>{{$payment->status->description}}</td>
                            <td>{{$payment->due_date}}</td>
                            <td>
                                {{ $payment->bill_number }}
                                @if ($payment->bill_bank_code)
                                    (Código: {{$payment->bill_bank_code}})
                                @endif
                            </td>
                            <td class='text-right'>
                                <a class=" btn btn-sm btn-primary" href="{{route('contracts-payment.edit', ['contracts_payment' => $payment->id])}}">EDITAR</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
        </div>

    </div>


  </div>


<!-- Modal -->
<div class="modal fade" id="modalSearchStudents" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row d-flex align-items-end mb-2">
                        <div class="col-10">
                            <label for="modal_search_student_name">Nome ou email do aluno</label>
                            <input type="text"
                                    name="modal_search_student_name"
                                    id="modal_search_student_name"
                                    class="form-control"
                                    placeholder="Digite o nome aqui..."
                                    value="">
                        </div>
                        <div class="col-2">
                        <input type="button"
                                class='btn btn-primary'
                                value="Pesquisar"
                                onClick="loadStudents()" >
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <small>Clique no registro para selecionar</small>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                        <table class="table table-borderless table-striped table-condensed" id="modal_table_students">
                            <thead>
                            <tr>
                                <th>Aluno</th>
                                <th>Email</th>
                                <th>Telefone</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td colspan="4">Os resultados aparecerão aqui.</td>
                            </tr>
                            </tbody>
                        </table>
                        </div>
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>

<script>
    const statusCancelado = "{{\App\Models\Status::STATUS_CANCELADO}}";
    const statusExecutado = "{{\App\Models\Status::STATUS_EXECUTADO}}";
    $(function () {
        $("#modal_search_student_name").keyup(function(event){
        if( event.keyCode == 13 ) {
            loadStudents();
        }
        })

        $("#modalSearchStudents").on('shown.bs.modal', function(){
            $("#modal_search_student_name").focus();
        });

        $("#status").change(function() {
            $(".canceled_input, .executed_input").addClass('d-none');
            $("#canceled_at, #reason_cancellation").removeAttr('required');

            if($("#status :selected").text() == statusCancelado ){
                $(".canceled_input").removeClass('d-none');
                $("#canceled_at, #reason_cancellation").attr('required', true);
            }

            if($("#status :selected").text() == statusExecutado ){
                $(".executed_input").removeClass('d-none');
                $("#executed_at").attr('required', true);
            }
        }).change();
    });

    async function loadStudents(){
        const params = {
            filter: $("#modal_search_student_name").val()
        };

        if(params.name == ""){
            alert('Preencha o filtro antes de continuar');
        }
        $("#modalSearchStudents").LoadingOverlay("show");

        await window.axios.get('/api/students', {params })
            .then(function(response) {
            if(response.status === 200){
                const results = response.data.map(function( elm){
                return /*html*/`
                    <tr class='clickable' onClick='handlerChooseStudent(${JSON.stringify(elm)})'>
                        <td>${ elm.name }</td>
                        <td>${ elm.email }</td>
                        <td>${ elm.phone }</td>
                    </tr>
                `;
                });
                $("#modal_table_students tbody").html(results.join(''));
            }
        });

        $("#modalSearchStudents").LoadingOverlay("hide");
    }

    async function handlerChooseStudent( student ) {
        $('#student').val(student.name);
        $("#student_id").val(student.id);
        $("#modalSearchStudents").modal('hide');
        $("#turma").html(student.groupclass.map(function( turma) {
            return `<option value="${turma.id}">${turma.name}</option>`;
        }));
    }
</script>

@endsection
