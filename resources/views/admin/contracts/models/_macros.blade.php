<div class="modal fade" id="modal-macros" tabindex="-1" aria-labelledby="modalMacrosLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalMacrosLabel">Macros</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Macros disponíveis
        @foreach ($macros as $group => $macrosByGroup)
            <h4>{{$group}}</h4>
            <table class="table table-sm">
                <thead>
                    <tr>
                        <th>Nome da macro</th>
                        <th>Macro</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($macrosByGroup as $macro)
                    <tr>
                        <td>{{$macro->name}}</td>
                        <td>{{$macro->macro}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @endforeach
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Fechar</button>
      </div>
    </div>
  </div>
</div>
