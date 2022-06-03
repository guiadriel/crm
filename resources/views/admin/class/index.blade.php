@extends('layouts.app')

@section('title', 'Turma')

@section('content')
  <div class="container">
    <div class="row mb-4 d-flex align-items-center">

      @can('create class')
        <div class="col-2">
          <a href="{{ route('class.create')}}" class='btn btn-primary'>Cadastrar turma</a>
        </div>
      @endcan

      <div class="col-4 ">
        <form action="" method="get" class='d-flex align-items-center'>
          <input type="text" name="filter" id="filter" placeholder="Busque pelo nome da turma ou aluno" value="{{ request('filter')}}">

          <button type="submit" class='d-flex align-items-center btn btn-light'>
            <span class="material-icons" aria-owns="password">search</span>
          </button>
        </form>
      </div>
      <div class="col-4">
        <span>Visualizando <strong>{{count($groupclass)}} / {{$groupclass->total()}}</strong> registro(s)</span>
      </div>
    </div>

    <table class="table table-striped table-borderless">
      <thead>
        <tr>
          <th scope="col">ID</th>
          <th scope="col">TIPO</th>
          <th scope="col">NOME DA TURMA</th>
          <th scope="col">DIA</th>
          <th scope="col">HORÁRIO</th>
          <th scope="col">Nº PESSOAS</th>
          <th scope="col">PROFESSOR</th>
          <th scope="col">&nbsp;</th>
          <th scope="col">&nbsp;</th>
        </tr>
      <tbody>
      </thead>
          @foreach ($groupclass as $class)
            <tr>
              <th scope="row">{{$class->id}}</th>
              <td>{{$class->type}}</td>
              <td>{{$class->name}}</td>
              <td>{!! App\Helpers\NumberToDayOfWeek::convert($class->day_of_week) !!}</td>
              <td>{{$class->time_schedule}}</td>
              <td>{{count($class->students)}} / {{$class->number_vacancies}}</td>
              <td>
                {{ !empty($class->teacher->name) ? $class->teacher->name:'' }}
              </td>
              <td>

                @can('generate paragraph')
                  <a href="{{route('paragraph.index', ['class_id' => $class->id ])}}" class='btn btn-sm btn-dark' title="Gerar controle de parágrafo"><i class="material-icons" style='font-size:16px'>picture_as_pdf</i></a>
                @endcan

              </td>
              <td class='text-center'>
                @can('edit class')
                  <a href="{{route('class.edit', $class->id)}}" class='btn btn-sm btn-primary mr-2'>EDITAR</a>
                @endcan

                @can('delete class')
                  @include('admin.class._delete')
                @endcan
              </td>
            </tr>
          @endforeach

          @if( $groupclass->total() == 0 )
            <tr>
              <td colspan="8">Nenhum registro encontrado</td>
            </tr>
          @endif
      </tbody>
    </table>

    {{ $groupclass->links() }}
  </div>
@endsection


