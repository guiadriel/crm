@extends('layouts.app')

@section('title', "Novo agendamento")

@section('content')
<div class="container">
    <div class="row mb-4 d-flex align-items-center">
      <div class="col-auto d-flex align-items-center">
        <a href="{{ url()->previous() }}" class='btn btn-primary'>VOLTAR</a>
        <span class='pl-3'>Novo agendamento</span>
      </div>
    </div>
    <div class="row">
        <div class="col-12">

            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link active" id="home-tab"
                        data-toggle="tab"
                        href="#home"
                        role="tab"
                        aria-controls="home"
                        aria-selected="true">Agendamento único</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link"
                        id="roles-tab"
                        data-toggle="tab"
                        href="#roles"
                        role="tab"
                        aria-controls="roles"
                        aria-selected="false">Agendamento periódico</a>
                </li>
            </ul>
            <div class="tab-content p-3 border border-top-0" id="myTabContent">
                <div class="tab-pane fade show active " id="home" role="tabpanel" aria-labelledby="home-tab">
                    @include('admin.schedules._single')
                </div>
                <div class="tab-pane fade" id="roles" role="tabpanel" aria-labelledby="roles-tab">
                    @include('admin.schedules._week')
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
            }else{
                $("#payment_quantity").attr("min", 0);
            }
        })

        function generate_series(step) {
            const dt = new Date(1970, 0, 1);
            const rc = [];

            while (dt.getDate() === 1) {
                if(dt.getHours() >= 6){
                    rc.push(dt.toLocaleTimeString('pt-BR'));
                }

                dt.setMinutes(dt.getMinutes() + step);
            }
            return rc;
        }

        $(".mask-datetimepicker").mask('00/00/0000 00:00');

        $('.mask-datetimepicker').datetimepicker({
            i18n:{
                de:{
                    months:[
                            'Januar','Februar','März','April',
                            'Mai','Juni','Juli','August',
                            'September','Oktober','November','Dezember',
                        ],
                        dayOfWeek:[
                            "So.", "Mo", "Di", "Mi",
                            "Do", "Fr", "Sa.",
                        ]
                    }
            },
            format:'d/m/Y H:i',
            allowTimes: generate_series(5)


        });

        $.datetimepicker.setLocale('pt-BR');



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
