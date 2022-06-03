@extends('layouts.app')

@section('title', 'Remarketing')

@section('content')
  <div class="container">
      <form action="" method="get">

            <div class="row mb-4 d-flex align-items-center">

                <div class="col-3">
                    <input type="text"
                           name="filter"
                           id="filter"
                           placeholder="Busque pelo nome, email ou telefone"
                           value="{{ request('filter')}}">
                </div>
                <div class="col-auto">
                    <button type="button"
                            class="btn btn-outline-primary d-flex align-items-center"
                            title="Outros filtros"
                            data-toggle="modal" data-target="#modal-filter">
                        <span class="material-icons">filter_list</span>
                    </button>

                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-primary">FILTRAR</button>
                    <a href="{{ route('prospects.index')}}" class="btn btn-outline-primary">LIMPAR FILTROS</a>
                </div>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="modal-filter" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Outros filtros</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                        </div>
                        <div class="modal-body">
                            Data de cadastro
                            <div class="row">
                                <div class="col-3">
                                    <input type="text"
                                        name="initial_date"
                                        id="initial_date"
                                        placeholder="Dt. Inicial"
                                        class="mask-date"
                                        autocomplete="off"
                                        value="{{ request('initial_date')}}">
                                </div>
                                <div class="col-3">
                                    <input type="text"
                                        name="final_date"
                                        id="final_date"
                                        placeholder="Dt. Final"
                                        class="mask-date"
                                        autocomplete="off"
                                        value="{{ request('final_date')}}">
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">FECHAR</button>
                            <button type="submit" class="btn btn-primary">FILTRAR</button>
                        </div>
                    </div>
                </div>
            </div>

        </form>

    <table class="table table-striped table-borderless table-sm">
      <thead>
        <tr>
          <th scope="col">NOME</th>
          <th scope="col">EMAIL</th>
          <th scope="col">TELEFONE</th>
          <th scope="col">DT. CADASTRO</th>
          <th scope="col">&nbsp;</th>
        </tr>
      </thead>
      <tbody>
          @foreach ($students as $student)
            <tr>
                <td>{{$student->name}}</td>
                <td>
                    <a href="mailto:{{$student->email}}">{{$student->email}}</a>
                </td>
              <td>
                  <a href="@whatsapp($student->phone)">{{$student->phone}}</a>
              </td>
              <td>{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $student->created_at)->format('d/m/Y') }}</td>
              <td class='d-flex align-items-center justify-content-end'>

                @if ($student->observations != "")
                    <span class=" d-flex justify-content-center mr-2" data-tippy-content="{{$student->observations}}">
                        <i class="material-icons text-secondary">comment_bank</i>
                    </span>
                @endif

                @if ($student->hasAnySchedule())
                    @php
                        $dtAgendamento = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s' ,$student->lastSchedule()->initial_date);
                    @endphp
                    <span class="badge badge-secondary d-flex justify-content-center mr-2"
                          title="Último agendamento em: {{$dtAgendamento}}">
                        <i class="material-icons text-white">history</i>
                    </span>
                @endif

                <div class="dropdown">
                    <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button" id="prospectActionButton-{{$student->id}}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Ações
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="prospectActionButton-{{$student->id}}">

                        <a class="dropdown-item d-flex align-items-center justify-content-between"
                            href="{{ route('prospects.edit', $student)}}">
                            <i class="material-icons text-primary mr-2">edit</i>
                           Editar observação
                        </a>

                        <a class="dropdown-item d-flex align-items-center justify-content-between"
                            href="#"
                            onClick="openModal('{{$student->id}}')"
                            >
                            <i class="material-icons text-primary mr-2">timeline</i>
                            Histórico
                        </a>

                        <div class="dropdown-divider"></div>

                        <a class="dropdown-item d-flex align-items-center justify-content-between"
                            href="{{ route('schedules.create', [ 'student_id' => $student->id])}}">
                            <i class="material-icons text-primary mr-2">event</i>
                            Agendar
                        </a>

                        <a class="dropdown-item d-flex align-items-center justify-content-between"
                            href="{{ route("contracts.create", ['student_id' => $student->id]) }}">
                            <i class="material-icons text-primary mr-2">add_circle</i>
                            Criar contrato
                        </a>

                        <div class="dropdown-divider"></div>

                        <div class="text-center">
                            @can('delete students')
                                @include('admin.students._delete')
                            @endcan
                        </div>




                    </div>
                </div>
              </td>
            </tr>
          @endforeach

          @if( $students->total() == 0 )
            <tr>
              <td colspan="6">Nenhum registro encontrado</td>
            </tr>
          @endif
      </tbody>
    </table>

    {{ $students->links() }}
  </div>

<livewire:modals.student-remarketing-timeline />

@endsection

@section('body_scripts')
    <script>
        function handleRemarketing(student_id) {
            CustomDialog.confirm('Você deseja enviar esse prospecto para o remarketing?', async function( resConfirm){
                if(resConfirm == true ){
                    $("body").LoadingOverlay('show');
                    await window.axios.post(`/api/students/${student_id}/change-status`, {
                        status: "{{ \App\Models\Status::STATUS_REMARKETING }}"
                    }).then(function (response){
                        window.location.reload();
                    });
                }
            });
        }

        function openModal(student_id){
            window.livewire.emit(`openModal`, student_id);
        }

        function binds(){
            $(".mask-date").mask('00/00/0000');
            $(".mask-date").datepicker({
                dateFormat: 'dd/mm/yy',
                dayNames: ['Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado'],
                dayNamesMin: ['D', 'S', 'T', 'Q', 'Q', 'S', 'S', 'D'],
                dayNamesShort: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb', 'Dom'],
                monthNames: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
                monthNamesShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
                nextText: 'Próximo',
                prevText: 'Anterior'
            });
        }

        let lastEvent;
        window.addEventListener('reloadMarketingModal', event => {
            binds();
            lastEvent = event.type;
            $("#model-timeline").modal("hide");
        });

        window.addEventListener('firstStudentOpenModal', evt => {
            lastEvent = null;
            $("#model-timeline").modal("show");
        });
        $(function () {
            $('#model-timeline').on('hidden.bs.modal', function (e) {

                if( lastEvent == 'reloadMarketingModal'){
                    $('#model-timeline').modal('show');
                    lastEvent = null;
                }
            });
        });
    </script>
@endsection
