@extends('layouts.app')

@section('title', 'Relatórios / Alunos')

@section('content')


<div class="container">
    <div class="row d-flex justify-content-between">
        <div class="col-auto d-flex align-items-center">
            <a href="{{ url()->previous() }}" class='btn btn-primary'>VOLTAR</a>
            <h5 class="pl-3 m-0">{{ $report_description}}</h5>
        </div>
    </div>
    <hr>

    <h5 class="font-weight-bold">Estatística geral</h5>

    <div class="row">
        <div class="col-7">
            <div class="card card-body">
                <canvas id="chart-status" width="250" height="150"></canvas>
            </div>
        </div>
        <div class="col-5">
            <div class="card card-body p-1">
                <table class="table table-sm table-striped table-borderless m-0">
                    <thead>
                        <tr>
                            <th>Status</th>
                            <th>Quantidade</th>
                            <th class="text-right">#</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($chartdata as $status)
                            <tr>
                                <td scope="row">{{$status->status}}</td>
                                <td>{{ $status->students}}</td>
                                <td class="text-right">
                                    <a href="{{ route('reports.students.detail', [
                                        'status'=> $status->status_id,
                                        'initial_date'=> request('initial_date'),
                                        'final_date'=> request('final_date'),
                                    ])}}" target="_blank" class="btn btn-sm btn-outline-primary">DETALHES</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <hr>

    <h5 class="font-weight-bold">Motivos do cancelamento no periodo de {{ request('initial_date')}} e {{ request('final_date')}}</h5>

    <div class="row">
        <div class="col-7">
            <div class="card card-body">
                <canvas id="chart-canceled" width="250" height="150"></canvas>
            </div>
        </div>
        <div class="col-5">
            <div class="card card-body p-1">
                <table class="table table-sm table-striped table-borderless m-0">
                    <thead>
                        <tr>
                            <th>Motivo</th>
                            <th>Quantidade</th>
                            <th class="text-right">#</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($chartcanceled as $status)
                            <tr>
                                <td scope="row">{{$status->reason_cancellation}}</td>
                                <td>{{ $status->students}}</td>
                                <td class="text-right">
                                    <a href="{{ route('reports.students.cancellation.detail', [
                                        'initial_date'=> request('initial_date'),
                                        'final_date'=> request('final_date'),
                                        'reason'=> $status->reason_cancellation,
                                    ])}}" target="_blank" class="btn btn-sm btn-outline-primary">DETALHES</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

@endsection

@section('body_scripts')
    <script>
        const chartdata = @json($chartdata);
        const chartcanceled = @json($chartcanceled);

        function getRandomRgb() {
            var num = Math.round(0xffffff * Math.random());
            var r = num >> 16;
            var g = num >> 8 & 255;
            var b = num & 255;
            return 'rgb(' + r + ', ' + g + ', ' + b + ')';
        }

        const labels = chartdata.map(elm => elm.status);
        const colors = chartdata.map(_ => getRandomRgb());
        const data   = chartdata.map(elm => elm.students);
		var config = {
			type: 'pie',
			data: {
				datasets: [{
					data,
					backgroundColor: colors,
					label: 'Dataset 1'
				}],
				labels
			},
			options: {
				responsive: true,
                 title: {
                    display: true,
                    text: 'Lista de Status'
                },
                legend: {
                    display: true,
                    position: 'left'
                }
			}
		};


        const labelsCanceled = chartcanceled.map(elm => elm.reason_cancellation);
        const colorsCanceled = chartcanceled.map(_ => getRandomRgb());
        const dataCanceled   = chartcanceled.map(elm => elm.students);
        var configCanceled = {
			type: 'doughnut',
			data: {
				datasets: [{
					data: dataCanceled,
					backgroundColor: colorsCanceled,
					label: 'Dataset 1'
				}],
				labels: labelsCanceled
			},
			options: {
				responsive: true,
                 title: {
                    display: true,
                    text: 'Motivos de cancelamento'
                },
                legend: {
                    display: true,
                    position: 'left'
                }
			}
		};

		window.onload = function() {
			var ctx = document.getElementById('chart-status').getContext('2d');
			window.myPie = new Chart(ctx, config);

            var ctxCanceled = document.getElementById('chart-canceled').getContext('2d');
            window.chartCanceled = new Chart(ctxCanceled, configCanceled);
		};
    </script>


@endsection

