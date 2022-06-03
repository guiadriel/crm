@extends('layouts.app')

@section('title', 'Alunos')

@section('content')
  <div class="container">
    <div class="row mb-4 d-flex align-items-center">

      @can('create students')
        <div class="col-2 mb-2">
            <a href="{{ route('students.create')}}" class='btn btn-primary'>Cadastrar aluno</a>
        </div>
      @endcan

      <div class="col-10">
        <form action="" method="get" class='d-flex align-items-center'>

            <div class="row d-flex align-items-center w-100 mb-2">
                <div class="col-5 flex-1">
                    <input type="text" name="student-filter" id="student-filter" placeholder="Busque pelo nome ou email" value="{{ request('student-filter')}}">
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
                    <a href="{{ route('students.index')}}" class="btn btn-outline-primary">LIMPAR FILTROS</a>
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
                            Status
                            <div class="row">
                                <div class="col-auto">
                                    <select name="status"
                                            id="status"
                                            class="px-2">
                                        <option value="">TODOS</option>
                                        @foreach ($statuses as $status)
                                            <option value="{{$status->id}}"
                                            @if (request('status') == $status->id)
                                                selected
                                            @endif
                                                >{{$status->description}}</option>
                                        @endforeach
                                    </select>
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
      </div>
      <div class="col-4">
        <span>Visualizando <strong>{{count($students)}} / {{$students->total()}}</strong> registro(s)</span>
      </div>
    </div>

    <table class="table table-striped table-borderless">
      <thead>
        <tr>
          <th scope="col">&nbsp;</th>
          <th scope="col">NOME</th>
          <th scope="col">EMAIL</th>
          <th scope="col">TELEFONE</th>
          <th scope="col">STATUS</th>
          <th scope="col">&nbsp;</th>
        </tr>
      </thead>
      <tbody>
          @foreach ($students as $student)
            <tr>
              <td> <img src="{{$student->avatar ?? asset('images/avatar.svg') }}" alt="" height="35" width="35" style='border-radius:50%;'> </td>
              <td>{{$student->name}}</td>
              <td>{{$student->email}}</td>
              <td>{{$student->phone}}</td>
              <td><span class="badge badge-info text-light">{{$student->status != "" ? $student->status->description : ''}}</span></td>
              <td class='text-center'>
                  <a href="{{route('students.show', $student->id)}}" class='btn btn-sm btn-primary'>VER</a>

                @can('edit students')
                  <a href="{{route('students.edit', $student->id)}}" class='btn btn-sm btn-primary'>EDITAR</a>
                @endcan


                @can('delete students')
                  @include('admin.students._delete')
                @endcan
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
@endsection


