@extends('layouts.app')

@section('title', "ALUNO(A) - $student->name")

@section('content')
  <div class="container">
    <div class="row mb-4 d-flex align-items-center">
      <div class="col-auto d-flex align-items-center">
        <a href="{{ route('students.index') }}" class='btn btn-white mr-2'>VOLTAR</a>
        <a href="{{ route('students.edit', $student->id) }}" class='btn btn-primary'>EDITAR INFORMAÇÕES</a>
      </div>
    </div>
  </div>


    <div class="container">
      <div class="row mb-4">
        <div class="col-2">
          <img src="{{$student->avatar ?? asset('images/avatar.svg') }}" alt="" class='img-thumbnail mx-auto w-100'>
        </div>
        <div class="col-10">
          <h2 class='text-capitalize'>{{$student->name}}</h2>
          <p>
            @if($student->email != "" )
              <h5 class='d-inline'><span class='badge badge-white p-2'>{{$student->email}}</span></h5>
            @endif

            @if($student->phone != "" )
              <h5 class='d-inline'><span class='badge badge-white p-2'>{{$student->phone}}</span></h5>
            @endif

            @if($student->phone_message != "" )
              <h5 class='d-inline'><span class='badge badge-white p-2'>{{$student->phone_message}}</span></h5>
            @endif

            @if($student->instagram != "" )
                <h5 class='d-inline'>
                    <span class='badge badge-white p-2'>
                        <a target="_blank" href="https://instagram.com/{{$student->instagram}}">
                            <img src="{{ asset('images/brandico_instagram_black.svg')}}" height="16px" alt="Instagram">
                            {{$student->instagram}}
                        </a>
                    </span>
                </h5>
            @endif

            @if($student->facebook != "" )
                <h5 class='d-inline'>
                    <span class='badge badge-white p-2'>
                        <a target="_blank" href="https://facebook.com/{{$student->facebook}}">
                            <img src="{{ asset('images/brandico_facebook_black.svg')}}" height="16px" alt="Facebook">
                            {{$student->facebook}}
                        </a>
                    </span>
                </h5>
            @endif

            @if($student->facebook != "" )
              <h5 class='d-inline'><span class='badge badge-white p-2'>{{$student->phone_message}}</span></h5>
            @endif
          </p>
          <div class="row mb-2">
            <div class="col-auto">
              <p class='mb-1'>Endereço</p>
              <h5 class='d-inline'>
                <span class="badge badge-white p-2 text-left">
                  {{$student->address}}@if ($student->number), {{$student->number}}@endif
                  @if ($student->neighborhood) <br/>{{$student->neighborhood}} @endif
                  @if ($student->city) <br/>{{$student->city}} @endif
                  @if ($student->state) - {{$student->state}} @endif
                &nbsp;</span>
              </h5>
            </div>
            <div class="col-auto text-center">
              <p class='mb-1'>Dt. Nascimento</p>
              <h5 class='d-inline'>
              <span class="badge badge-white p-2">{{$student->birthday_date}}&nbsp;</span>
              </h5>
            </div>
            <div class="col-auto text-center">
              <p class='mb-1'>Origem de cadastro</p>
              <h5 class='d-inline'>
              <span class="badge badge-white p-2">{{$student->origin->type ?? ''}}</span>
              </h5>
            </div>
            <div class="col-auto text-right">
              <p class='mb-1'>Situação atual</p>
              <h5 class='d-inline'>
              <span class="badge badge-white p-2">{{$student->status->description ?? ''}}</span>
              </h5>
            </div>

            @if( $student->groupclass->first() )
                <div class="col-auto text-center">
                    <p class='mb-1'>Turma</p>
                    <h5 class='d-inline'>
                    <span class="badge badge-white p-2">{{ $student->groupclass->first()->name ?? ''}}</span>
                    </h5>
                </div>
            @endif
          </div>

          @if ( $student->responsible_id)

          <hr>

            <div class="row">
                <div class="col-auto">
                    <p class="mb-1">Nome do responsável</p>
                    <h5 class='d-inline'>
                        <span class="badge badge-white p-2 text-left">
                            {{ $student->responsible->name}}
                        </span>
                    </h5>
                </div>
                <div class="col-auto">
                    <p class='mb-1'>Endereço do responsável</p>
                    <h5 class='d-inline'>
                    <span class="badge badge-white p-2 text-left">
                        {{$student->responsible->address}}@if ($student->responsible->number), {{$student->responsible->number}}@endif
                        @if ($student->responsible->neighborhood) <br/>{{$student->responsible->neighborhood}} @endif
                        @if ($student->responsible->city) <br/>{{$student->responsible->city}} @endif
                        @if ($student->responsible->state) - {{$student->responsible->state}} @endif
                    &nbsp;</span>
                    </h5>
                </div>
            </div>

          @endif

          <div class="row">
            <div class="col-12">
              <p class="mb-1">Observações</p>
                <p class="bg-white rounded font-weight-bold p-2">
                  @if ($student->observations != "")
                    {{ $student->observations}}
                  @else
                    &nbsp;
                  @endif
                </p>
            </div>
          </div>
        </div>
      </div>


      <ul class="nav nav-tabs" id="myTab" role="tablist">
          <li class="nav-item" role="presentation">
              <a class="nav-link active"
                  id="home-tab"
                  data-toggle="tab"
                  href="#home"
                  role="tab"
                  aria-controls="home"
                  aria-selected="true">Histórico</a>
          </li>
          <li class="nav-item" role="presentation">
              <a class="nav-link"
                 id="contract-tab"
                 data-toggle="tab"
                 href="#contract"
                 role="tab"
                 aria-controls="contract"
                 aria-selected="false">Contrato</a>
          </li>
          <li class="nav-item" role="presentation">
              <a class="nav-link"
                 id="files-tab"
                 data-toggle="tab"
                 href="#files"
                 role="tab"
                 aria-controls="files"
                 aria-selected="false">Arquivos</a>
          </li>
      </ul>
      <div class="tab-content p-3 " id="myTabContent">
          <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">

              <div class="row">
                <div class="col-12">
                  <a href="{{ route('student-logs.create', ['student' => $student->id]) }}" class='btn btn-primary'>NOVO ASSUNTO</a>
                </div>
              </div>

              <div class="row">
                <div class="col-12">
                  <table class="table table-striped table-borderless table-sm">
                    <thead class="thead-inverse">
                      <tr>
                        <th class="">Data</th>
                        <th class=''>Quem atendeu</th>
                        <th class="">Assunto</th>
                        <th class="">&nbsp;</th>
                      </tr>
                    </thead>
                    <tbody>

                      @foreach ($student->logs->sortByDesc('date_log') as $log)
                        <tr>
                          <td class="align-middle" scope="row"> {{ $log->date_log }}</td>
                          <td class="align-middle">{{$log->who_received}}</td>
                          <td class="align-middle">{{$log->description}}</td>
                          <td class='text-right'>
                            {{-- @if ($log->type != \App\Models\StudentLog::TYPE_SYSTEM)

                                @can('edit history')
                                    <a href="{{route('student-logs.edit', $log->id)}}" class='btn btn-sm btn-primary'>EDITAR</a>
                                @endcan

                                @can('delete history')
                                    @include('admin.students_log._delete')
                                @endcan
                            @endif --}}

                          </td>
                        </tr>
                      @endforeach

                      @if( $student->logs->count() == 0 )
                        <tr>
                          <td colspan="4">Nenhum histórico disponível.</td>
                        </tr>
                      @endif

                    </tbody>
                  </table>
                </div>
              </div>


          </div>
          <div class="tab-pane fade py-2" id="contract" role="tabpanel" aria-labelledby="contract-tab">

            @if($student->lastContract() !== null && $student->lastContract()->status->description == \App\Models\Status::STATUS_CANCELADO)
                <div class="alert alert-danger" role="alert">
                    Contrato cancelado em {{$student->lastContract()->canceled_at}}.
                    <p class="m-0 p-0">Motivo: <strong>{{$student->lastContract()->reason_cancellation }}</strong></p>
                </div>
            @endif

            @if ( $student->hasActiveContract() )

              <div class="row mb-2">
                <div class="col-auto">
                  <p class="m-0 p-0">Código do contrato</p>
                  <h5 class='d-inline'><span class="badge badge-white p-2">{{$student->lastContractActive()->number}}</span></h5>
                </div>
                <div class="col-auto">
                  <p class="m-0 p-0">Início do contrato</p>
                  <h5 class='d-inline'><span class="badge badge-white p-2">{{$student->lastContractActive()->start_date}}</span></h5>
                </div>
                <div class="col-auto">
                  <p class="m-0 p-0">Tipo de contrato</p>
                  <h5 class='d-inline'><span class="badge badge-white p-2">{{$student->lastContractActive()->type}}</span></h5>
                </div>
                <div class="col-auto">
                  <p class="m-0 p-0">Meio de pagamento</p>
                  <h5 class='d-inline'><span class="badge badge-white p-2">{{$student->lastContractActive()->paymentMethod->description ?? ''}}</span></h5>
                </div>
                <div class="col-auto">
                  <p class="m-0 p-0">Total de aulas por semana</p>
                  <h5 class='d-inline'><span class="badge badge-white p-2">{{$student->lastContractActive()->school_days}}</span></h5>
                </div>

                <div class="col align-self-start text-right">
                  <a class="btn btn-sm btn-primary" href="{{ route('contracts.edit', $student->lastContractActive()->id)}}">EDITAR CONTRATO</a>
                </div>

              </div>
              <div class="row mb-2">
                <div class="col-12">
                  <p class="m-0 p-0">Observações</p>
                  <h5 class='d-inline'>&nbsp;<span class="badge badge-white p-2">{{$student->lastContractActive()->observations}}</span></h5>
                </div>
              </div>

              <hr>

              <div class="row">
                <div class="col-12">

                  <div class="row">
                    <div class="col-12 d-flex align-items-center justify-content-between">
                      <h5>Histórico de parcelas</h5>
                      <div class="d-flex">
                        <a href="{{ route("contracts-payment.index", ['contract_id' => $student->lastContractActive()->id ])}}" class="btn btn-sm btn-link">Gerenciamento de parcelas</a>
                        @include('admin.contracts.payments._pdf', ['contract' => $student->lastContractActive()->id])
                      </div>

                    </div>
                  </div>

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
                        @foreach ($student->lastContractActive()->payments as $payment)
                            <tr class="@if ($payment->bill_second_generation) text-blue @endif">
                                <th scope="row" class='text-center'>#{{$payment->sequence}}</th>
                                <td >
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
                                <td>{{ $payment->due_date }}</td>
                                <td>
                                    {{ $payment->bill_number }}
                                    @if ($payment->bill_bank_code)
                                        (Código: {{$payment->bill_bank_code}})
                                    @endif
                                </td>
                                <td class='text-right p-2'>
                                    <a class=" btn btn-sm btn-primary" href="{{route('contracts-payment.edit', ['contracts_payment' => $payment->id])}}">EDITAR</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                  </table>
                </div>
              </div>

            @else
                @if( isset($student->lastContract()->executed_at) )
                    <div class="alert alert-info" role="alert">
                        Contrato [{{$student->lastContract()->number}}] executado em {{$student->lastContract()->executed_at}}.
                    </div>
                @endif
                <a href="{{ route("contracts.create", ['student_id' => $student->id]) }}" class="btn btn-primary">CRIAR CONTRATO</a>
            @endif
          </div>

          <div class="tab-pane fade" id="files" role="tabpanel" aria-labelledby="files-tab">
            <ul class="list-unstyled">
              <li class="media">
                <div class="media-body">
                  <h5 class="mt-0 mb-1">Arquivo</h5>
                  Nenhum arquivo disponível
                </div>
              </li>
            </ul>
            <a href="{{ route("contracts.create") }}" class="btn btn-primary disabled">Adicionar arquivos</a>
          </div>
      </div>

    </div>
@endsection
