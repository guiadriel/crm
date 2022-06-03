<div>
    <div class="row mt-3 mb-4" >
        <div class="card border-primary w-100">
            <div class="card-body">
            <div class="row">
                <div class="col-4 d-flex align-items-center">
                    <h5 class="card-title">Controle de frequência</h5>
                </div>
                <div class="col d-flex align-items-center justify-content-end">
                    @can('edit class')
                        <a href="{{route('frequency.create', ['class_id' => $groupclass->id ])}}" class='btn btn-sm btn-success ml-2' title="ADICIONAR AULA">ADICIONAR AULA</a>
                    @endcan
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                <table class="table-borderless table-striped w-100 p-0 m-0">
                    <thead>
                    <tr>
                        <th class='p-2' scope="row">DATA</th>
                        <th>ALUNOS PRESENTES</th>
                        <th>&nbsp;</th>
                    </tr>
                    </thead>
                    <tbody>
                    @php
                        $formattedDates = [];
                        foreach($dates as $date => $values) {
                            $new_date = \App\Helpers\DateFormatHelper::convertToEN($date);
                            $formattedDates[$new_date] = $values;
                        }
                        krsort($formattedDates);
                    @endphp
                    @foreach ($formattedDates as $date => $students)
                        <tr>
                        <td class='p-2' scope="row">{{ \App\Helpers\DateFormatHelper::convertToBR($date) }}</td>
                        <td scope="row">
                            @foreach ($students as $student)

                                @if ($student->is_attend)
                                    <span class="badge badge-primary">
                                        {{$student->student->name ?? ''}}
                                    </span>
                                @endif
                            @endforeach
                        </td>
                        <td scope="row" class='text-right pr-2'>

                            {{-- @can('remove paragraph')
                                @include('admin.paragraph._delete')
                            @endcan --}}
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
