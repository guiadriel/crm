@extends('layouts.app')

@section('title', "Editar book [$book->name]")

@section('content')
  <div class="container">
    <div class="row mb-4 d-flex align-items-center">
      <div class="col-auto d-flex align-items-center">
        <a href="{{ url()->previous() }}" class='btn btn-primary'>VOLTAR</a>
        <span class='pl-3'>Editar book</span>
      </div>
    </div>
    <form  name="updateForm" id="updateForm" action="{{ route('books.update', $book) }}" method="POST">
      @csrf
      {{ method_field('PUT') }}

      <div class="form-group row">
        <div class="col-12">
          <label for="name">Nome</label>
          <input type="text"
                  name="name"
                  id="name"
                  value="{{$book->name}}"
                  placeholder="Book"
                  class="@error('name') is-invalid @enderror"
                  required>
        </div>
      </div>

      <div class="row mb-4">
        <div class="col-12">
          <div class="card card-body">
              <label for="new-activity">Nova atividade</label>
              <input type="text"
                      name="new-activity"
                      id="new-activity"
                      class=" form-control mb-1">
              <button type="button"b class='btn btn-primary btn-sm' onClick="addActivity()">Adicionar atividade</button>
              <div class="row">
                  <div class="col-12">
                      <small>As atividades aparecerão aqui</small>
                      <table class='tbl-activities table table-condensed table-borderless table-striped mb-0'>
                          <tbody></tbody>
                      </table>
                  </div>
              </div>
          </div>
        </div>
      </div>

      @foreach ($book->activities as $activity)
          <input type="hidden" name="activities[]" id="activity-id-{{ $activity->id }}" value="{{$activity->name}}"/>
      @endforeach
    </form>
    <button type="submit" class="btn btn-primary" form="updateForm">SALVAR</button>
    @include('admin.books._delete', ['large' => true])
  </div>

@endsection


@section('body_scripts')
  <script>
      $(function () {
          $("#new-activity").on('keypress', function(e) {
            if( e.keyCode == 13){
                e.preventDefault();
                addActivity();
            }
          });

          listActivities();
      });

    let activities = @json($book->activities);

    function addActivity() {
        if($("#new-activity").val() != "") {
            const foundActivity = activities.find(elm => elm.name == $("#new-activity").val());
            if( foundActivity ){
                alert('Você já cadastrou essa atividade.');
                return;
            }

            const activity = {
                id: uuidv4(),
                name: $("#new-activity").val()
            }
            activities.push(activity);
            $("#new-activity").val('');
            $("#new-activity").focus();
            $("#updateForm").append(/*html*/`
                <input type="hidden" name="activities[]" id="${activity.id}" value="${activity.name}"/>
            `);
            listActivities();
        }
    }

    function removeActivity(_id) {
        activities = activities.filter(elm => elm.id != _id);
        $(`#activity-id-${_id}`).remove();
        listActivities();
    }

    function listActivities() {
        $(".tbl-activities tbody").html("");
        activities.map(function ( elm , idx) {
            $(".tbl-activities tbody").append(/*html*/`
                <tr>
                    <td style='width: 40px; text-align:center;'>${(idx+1)}</td>
                    <td>${elm.name}</td>
                    <td class='text-right'>
                        <button type="button" class="btn btn-sm btn-outline-primary" onClick="removeActivity('${elm.id}')">REMOVER</button>
                    </td>
                </tr>
            `);
        });
    }


  </script>
@endsection
