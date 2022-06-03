@extends('layouts.app')

@section('title', "Novo Book")

@section('content')
<div class="container">
    <div class="row mb-4 d-flex align-items-center">
      <div class="col-auto d-flex align-items-center">
        <a href="{{ url()->previous() }}" class='btn btn-primary'>VOLTAR</a>
        <span class='pl-3'>Cadastrar book</span>
      </div>
    </div>
    <div class="row">
        <div class="col-md-8">
            <form id="books_store" method="POST" action="{{ route('books.store') }}">
                @csrf

                <div class="form-group row">
                    <div class="col-12">
                        <label for="name">Book</label>
                        <input type="text"
                                name="name"
                                id="name"
                                value="{{ old('name') }}"
                                class="@error('name') is-invalid @enderror"
                                required autofocus>

                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
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

                        @error('activities')
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
@endsection

@section('body_scripts')
  <script>
      $(function () {
          $("#new-activity").on('keypress', function(e) {
            if( e.keyCode == 13){
                e.preventDefault();
                addActivity();
            }
          })
      });

    let activities = [];

    function addActivity() {
        if($("#new-activity").val() != "") {
            const foundActivity = activities.find(elm => elm.value == $("#new-activity").val());
            if( foundActivity ){
                alert('Você já cadastrou essa atividade.');
                return;
            }

            const activity = {
                id: uuidv4(),
                value: $("#new-activity").val()
            }
            activities.push(activity);
            $("#new-activity").val('');
            $("#new-activity").focus();
            $("#books_store").append(/*html*/`
                <input type="hidden" name="activities[]" id="${activity.id}" value="${activity.value}"/>
            `);
            listActivities();
        }
    }

    function removeActivity(_id) {
        activities = activities.filter(elm => elm.id !== _id);
        listActivities();
    }

    function listActivities() {
        $(".tbl-activities tbody").html("");
        activities.map(function ( elm , idx) {
            $(".tbl-activities tbody").append(/*html*/`
                <tr>
                    <td style='width: 40px; text-align:center;'>${(idx+1)}</td>
                    <td>${elm.value}</td>
                    <td class='text-right'>
                        <button type="button" class="btn btn-sm btn-outline-primary" onClick="removeActivity('${elm.id}')">REMOVER</button>
                    </td>
                </tr>
            `);
        });
    }


  </script>
@endsection
