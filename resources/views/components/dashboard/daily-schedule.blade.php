<div {{ $attributes->merge(['class' => 'card mb-2'])  }} >
    <div class="card-body">
        <div class="d-flex justify-content-between mb-2">
            <div>
                <h5 class="mb-3">Agenda de hoje</h5>
            </div>
            <div>
                <a href="{{ route('schedules.index')}}" class="btn btn-sm btn-primary">Ver tudo</a>
            </div>
        </div>
        <ul class="list-group">
            @foreach ($schedules as $schedule)
                <li class="list-group-item p-1">
                    <div class="d-flex w-100 align-items-center align-items-lg-stretch">
                        <span class="badge badge-light d-flex align-items-center px-4">
                            {{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$schedule->initial_date)->format('H:i') }}
                        </span>
                        <div class="ml-2">
                            <h5 class="m-0">{{ $schedule->name}}
                            @if ($schedule->groupClass)
                                [{{$schedule->groupClass->name}}]
                            @endif
                            </h5>
                            @if ($schedule->teacher)
                                <small>Professor: <strong>{{ $schedule->teacher->name ?? ''}}</strong></small>
                            @endif
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
</div>
