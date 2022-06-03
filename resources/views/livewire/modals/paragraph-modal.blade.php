<div>
    <div class="row mt-3 mb-4" >
        <div class="card border-primary w-100">
            <div class="card-body">
            <div class="row">
                <div class="col-4 d-flex align-items-center">
                    <h5 class="card-title">Controle de parágrafos</h5>
                </div>
                <div class="col d-flex align-items-center justify-content-end">
                    @can('generate paragraph')
                        <a target="_blank" href="{{route('paragraph.index', ['class_id' => $groupclass->id ])}}" class='btn btn-sm btn-dark' title="GERAR CONTROLE EM PDF">GERAR CONTROLE EM PDF</a>
                        <a href="{{route('paragraph.create', ['class_id' => $groupclass->id ])}}" class='btn btn-sm btn-success ml-2' title="ADICIONAR PARÁGRAFO">ADICIONAR PARÁGRAFO</a>
                    @endcan
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                <table class="table-borderless table-striped w-100 p-0 m-0">
                    <thead>
                    <tr>
                        <th class='p-2' scope="row">DATE</th>
                        <th>BOOK</th>
                        <th>PAGE</th>
                        <th>STOP</th>
                        <th>ACTIVITY</th>
                        <th>OBSERVATION</th>
                        <th>TEACHER</th>
                        <th>&nbsp;</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($groupclass->paragraphs->sortByDesc(function($item){ return \Carbon\Carbon::createFromFormat('d/m/Y', $item->date)->format('Y-m-d');}) as $paragraph)
                        <tr>
                        <td class='p-2' scope="row">{{$paragraph->date}}</td>
                        <td scope="row">{{$paragraph->book->name ?? ''}}</td>
                        <td scope="row">{{$paragraph->page}}</td>
                        <td scope="row">{{$paragraph->last_word}}</td>
                        <td scope="row">{{$paragraph->activity}}</td>
                        <td scope="row">{{$paragraph->observation}}</td>
                        <td scope="row">{{$paragraph->teacher->name ?? ''}}</td>
                        <td scope="row" class='text-right pr-2'>
                            <a href=" {{ route('paragraph.edit', $paragraph)}}" class="btn btn-sm btn-primary">EDITAR</a>

                            @can('remove paragraph')
                                @include('admin.paragraph._delete')
                            @endcan
                        </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                </div>
            </div>
            </div>
        </div>
    </div>
</div>
