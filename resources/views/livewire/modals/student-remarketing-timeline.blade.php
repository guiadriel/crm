<div>

    <!-- Modal -->
    <div class="modal fade" id="model-timeline" tabindex="-1" role="dialog" aria-labelledby="model-timeline" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content ">
                <div class="modal-body">
                    <div class="row d-flex justify-content-between mb-2">
                        <div class="col-auto">
                            <h5>Histórico de remarketing [{{ $student->name ?? 'err' }}]</h5>
                        </div>
                    </div>

                    @livewire('modals.student-remarketing-timeline-form')

                    <table class="table table-sm table-striped">
                        <thead>
                            <tr>
                                <th>Data</th>
                                <th>Quem entrou em contato</th>
                                <th>Tipo de contato</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($records as $history)
                                <tr>
                                    <td scope="row">{{ $history->contact_date }}</td>
                                    <td>{{ $history->who_contacted}} </td>
                                    <td>{{ $history->type}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-primary">FECHAR</button>
                </div>
            </div>
        </div>
    </div>



</div>
