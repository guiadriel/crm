@extends('layouts.app')

@section('title', 'Prospectos')

@section('content')
  <div class="container">
      <form action="" method="get">

            <div class="row mb-4 d-flex align-items-center">
                {{-- @can('create students') --}}
                    <div class="col-2">
                        <a href="{{ route('prospects.create')}}" class='btn btn-primary'>NOVO PROSPECTO</a>
                    </div>
                {{-- @endcan --}}

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
          <th scope="col">QUEM AGENDOU</th>
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
              <td>{{ $student->who_booked }}</td>
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
                    <small class="d-flex justify-content-center mr-2"
                          data-tippy-content="??ltimo agendamento em: {{$dtAgendamento->format('d/m/Y H:i')}}">
                        <i class="material-icons text-secondary">event</i>
                    </small>
                @endif

                <div class="dropdown">
                    <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button" id="prospectActionButton-{{$student->id}}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        A????es
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="prospectActionButton-{{$student->id}}">
                        <a class="dropdown-item d-flex align-items-center justify-content-between"
                            href="{{ route('prospects.edit', $student)}}">
                            <i class="material-icons text-primary mr-2">edit</i>
                           Editar observa????o
                        </a>

                        <a class="dropdown-item d-flex align-items-center justify-content-between"
                            href="{{ route('schedules.create', [ 'student_id' => $student->id])}}">
                            <i class="material-icons text-primary mr-2">event</i>
                            Agendar
                        </a>


                        <button class="dropdown-item d-flex align-items-center justify-content-between btn-remarketing" onClick="handleRemarketing('{{$student->id}}')">
                            <i class="material-icons text-primary mr-2">model_training</i>
                            Remarketing</a>
                        </button>

                        <a class="dropdown-item d-flex align-items-center justify-content-between"
                            href="{{ route("contracts.create", ['student_id' => $student->id]) }}">
                            <i class="material-icons text-primary mr-2">add_circle</i>
                            Criar contrato
                        </a>

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

    <script>
        function handleRemarketing(student_id) {
            CustomDialog.confirm('Voc?? deseja enviar esse prospecto para o remarketing?', async function( resConfirm){
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


    </script>


@endsection

