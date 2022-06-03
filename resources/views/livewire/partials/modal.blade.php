<div class="modal fade " wire:ignore.self id="modalStudentClass" tabindex="-1" aria-labelledby="modalStudentClassLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg \">
    <div class="modal-content">
      <div class="modal-body">

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
              <table class="table table-borderless table-striped table-condensed" id="modal_table_students">
                <thead>
                  <tr>
                    <th>Adicionar aluno</th>
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
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Fechar</button>
      </div>
    </div>
  </div>
</div>

<script type="application/javascript">
  window.livewire.on('toggleModal', () => {
    $("#modalStudentClass").modal('toggle');
  });

  function closeModal(e){
    window.location.reload();
  }

  async function handleAttachStudend(student_id, element) {
    const params = {
      groupclass: $("#groupclass_id").val(),
      student_id,
      checked: element.checked
    };
    $("#modalStudentClass").LoadingOverlay("show");
    await window.axios.post('/api/students', params).catch(function (err) {
      alert('Não foi possivel adicionar o aluno à turma. Entre em contato com o administrador do sistema.');
    } );

    $("#modalStudentClass").LoadingOverlay("hide");
  }

  $(function () {
    $("#modal_search_student_name").keyup(function(event){
      if( event.keyCode == 13 ) {
        loadStudents();
      }
    })

    $("#modalStudentClass").on('shown.bs.modal', function(){
      $("#modal_search_student_name").focus();
    }).on('hidden.bs.modal', closeModal);
  });

  async function loadStudents(){
    const params = {
      filter: $("#modal_search_student_name").val(),
      groupclass: $("#groupclass_id").val()
    };

    if(params.name == ""){
      alert('Preencha o filtro antes de continuar');
    }
    $("#modalStudentClass").LoadingOverlay("show");

    await window.axios.get('/api/students', {params })
    .then(function(response) {
      if(response.status === 200){
        const results = response.data.map(function( elm){
          const checked = elm.groupclass.map(function(e) { return e.id; }).indexOf( parseInt($("#groupclass_id").val()) ) > -1 ? 'checked' : null;
          const email = elm.email != "" ? elm.email : '';
          return /*html*/`
            <tr>
              <th scope="row" class='text-center'>
                <div class="custom-control custom-switch">
                  <input type="checkbox"
                          class="custom-control-input"
                          id="studentSwitch-${elm.id}"
                          ${checked}
                          onChange="handleAttachStudend(${elm.id}, this)"
                          >
                  <label class="custom-control-label" for="studentSwitch-${elm.id}"></label>
                </div>
              </th>
              <td>${ elm.name }</td>
              <td>${ email }</td>
              <td>${ elm.phone }</td>
            </tr>
          `;
        });
        $("#modal_table_students tbody").html(results.join(''));
      }
    });

    $("#modalStudentClass").LoadingOverlay("hide");
  }

</script>
