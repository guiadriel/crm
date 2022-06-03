@extends('layouts.app')

@section('title', "Novo contrato")
@section('content')


<div class="container">
    <div class="row mb-4 d-flex align-items-center">
      <div class="col-auto d-flex align-items-center">
        <a href="{{ url()->previous() }}" class='btn btn-primary'>VOLTAR</a>
        <span class='pl-3'>Cadastrar novo contrato</span>
      </div>
    </div>
    <div class="row">
        <div class="col-12">
            <form method="POST" action="{{ route('contracts.store') }}">
                @csrf

                <div class="form-group row">
                    <div class="col-10 input-group d-flex">
                        <label for="student">Selecione o aluno</label>
                        <input type="text"
                                name="student"
                                id="student"
                                readonly
                                @if ( request()->has('student_id'))
                                    value="{{ $student->name ?? ""}}"
                                @else
                                    value="{{ old('student') }}"
                                @endif

                                class="@error('student') is-invalid @enderror"
                                placeholder="Clique na lupa para selecionar o aluno"
                                required autofocus>

                        <input type="hidden"
                                id="student_id"
                                name="student_id"
                                required
                                @if ( request()->has('student_id'))
                                    value="{{ $student->id  ?? ""}}"
                                @else
                                    value="{{ old('student') }}"
                                @endif
                        >

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

                            @if ( isset($student) && $student->has('groupclass'))
                                @foreach ($student->groupclass as $class)
                                    <option value="{{$class->id}}"
                                        @if ($loop->first)
                                            selected
                                        @endif
                                    >{{$class->name}}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-4 input-group d-flex">
                        <label for="type">Tipo de Aluno</label>
                        <select name="type"
                                id="type"
                                class='w-100'>
                            <option value="NORMAL" selected>NORMAL</option>
                            <option value="VIP">VIP</option>
                        </select>
                    </div>
                    <div class="col-4 input-group d-flex">
                        <label for="start_date">Data de início</label>
                        <input type="text"
                                name="start_date"
                                id="start_date"
                                autocomplete="off"
                                value="{{ old('start_date') }}"
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
                                value="{{ old('school_days') }}"
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
                                value="{{ old('payment_total') }}"
                                class="@error('payment_total') is-invalid @enderror mask-money"
                                required>

                        @error('payment_total')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="col-auto d-flex align-items-center pt-4">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="payment_generate" name="payment_generate">
                            <label class="custom-control-label" for="payment_generate">Gerar parcelas automaticamente</label>
                        </div>
                    </div>
                    <div class="col-3 input-group">
                        <label for="payment_quantity">Quantidade de Parcelas</label>
                        <input type="number"
                                name="payment_quantity"
                                id="payment_quantity"
                                min="0"
                                value="{{ old('payment_quantity') ?? 0 }}"
                                class="@error('payment_quantity') is-invalid @enderror"
                                required>
                        @error('payment_quantity')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="col-3 input-group d-flex">
                        <label for="first_installment">Dt. 1ª Parcela</label>
                        <input type="text"
                                name="first_installment"
                                id="first_installment"
                                autocomplete="off"
                                value="{{ old('first_installment') }}"
                                class="@error('first_installment') is-invalid @enderror mask-date font-weight-bold"
                                pĺaceholder="__/__/____"
                                required>

                        @error('first_installment')
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
                                value="{{ old('payment_registration_value') }}"
                                class="@error('payment_registration_value') is-invalid @enderror mask-money"
                                required>

                        @error('payment_registration_value')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="col-3">
                        <label class="my-1 mr-2" for="paymentMethod">Forma de Pagamento</label>
                        <select name="paymentMethod"
                                id="paymentMethod"
                                class='w-100'>
                            @foreach ($paymentsMethod as $payment)
                                <option value="{{$payment->id}}"
                                >{{$payment->description}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-3">
                        <label class="my-1 mr-2" for="payment_due_date">Data de Vencimento (Dia) </label>
                        <select class='w-100'
                                name="payment_due_date"
                                id="payment_due_date" >
                            <option value="10">10</option>
                            <option value="20">20</option>
                        </select>

                        @error('payment_due_date')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
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



                <div class="form-group row mb-0">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">
                            {{ __('SALVAR CADASTRO') }}
                        </button>
                    </div>
                </div>
            </form>
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
    $(function () {
        $("#modal_search_student_name").keyup(function(event){
        if( event.keyCode == 13 ) {
            loadStudents();
        }
        })

        $("#modalSearchStudents").on('shown.bs.modal', function(){
            $("#modal_search_student_name").focus();
        });

        $("#payment_generate").change(function(elm) {
            if( $(this).is(":checked")){
                $("#payment_quantity").attr("min", 1);
                $("#first_installment").attr('required', true);
            }else{
                $("#payment_quantity").attr("min", 0);
                $("#first_installment").removeAttr('required');
            }
        })
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
                        <td>${ elm.email != null ? elm.email : ""}</td>
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
        })).prepend(`<option value="">Sem turma definida</option>`);
    }
</script>

@endsection
