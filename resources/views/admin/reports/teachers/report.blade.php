@extends('layouts.app')

@section('title', 'Reports / Teachers')

@section('content')


<div class="container">
    <div class="row d-flex justify-content-between">
        <div class="col-auto d-flex align-items-center">
            <a href="{{ url()->previous() }}" class='btn btn-primary'>VOLTAR</a>
            <h5 class="pl-3 m-0">Relatório: <strong>{{ $teacher->name }}</strong></h5>
        </div>
        <div class="col-auto">
            <form action="{{ route('reports.teachers.receipt', $teacher)}}"
                  method="POST"
                  target="_blank"
                  onSubmit="CustomDialog.submit('Você deseja gerar o recibo?', this)">
                @csrf
                @method('POST')

                <input type="hidden" name="initial_date" value="{{ request('initial_date') }}">
                <input type="hidden" name="final_date" value="{{ request('final_date') }}">
                <button class="btn btn-primary d-flex align-items-center" data-tippy-content="Gerar PDF ">
                    <i class="material-icons mr-2">picture_as_pdf</i>
                    Gerar Recibo
                </button>
            </form>

        </div>
    </div>
    <hr>

    <div class="row">
        <div class="col-6">
            <table class="table table-bordered table-sm table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th class="text-center">Tipo</th>
                        <th class="text-center">Quantidade de aulas dadas</th>
                        <th class="text-center">Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="font-weight-bold text-center">VIP</td>
                        <td class="font-weight-bold text-center">{{ $reportData['resume']['vip']['count'] }}</td>
                        <td class="font-weight-bold text-right">@money($reportData['resume']['vip']['amount'])</td>
                    </tr>
                    <tr>
                        <td class="font-weight-bold text-center">TURMA</td>
                        <td class="font-weight-bold text-center">{{ $reportData['resume']['turma']['count'] }}</td>
                        <td class="font-weight-bold text-right">@money($reportData['resume']['turma']['amount'])</td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td></td>
                        <td class="text-center"><h4 class="m-0 font-weight-bold"> {!! $reportData['resume']['turma']['count'] + $reportData['resume']['vip']['count'] !!}</h4></td>
                        <td class="text-right py-2 m-0"><h4 class="m-0 d-inline font-weight-bold">@money($reportData['resume']['total'])</h4></td>
                    </tr>
                </tfoot>
            </table>
        </div>
        <div class="col-3">
            <canvas id="chart-turma" height="200"></canvas>

        </div>
        <div class="col-3">
            <canvas id="chart-vip" height="200"></canvas>
        </div>
    </div>

    <hr>

    <div class="row">
        <div class="col-12">
            <h5>Lista de aulas informadas no sistema</h5>
            <table class="table table-striped table-sm">
                <thead>
                    <tr>
                        <th>Data</th>
                        <th>Turma</th>
                        <th>Livro</th>
                        <th>Atividade</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($reportData['paragraphs'] as $paragraph)
                        <tr>
                            <td scope="row"> {{ $paragraph->date }} </td>
                            <td>{{ $paragraph->groupClass->name ?? '' }}</td>
                            <td>{{ $paragraph->book->name ?? '' }}</td>
                            <td>{{ $paragraph->activity}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection


@section('body_scripts')
    <script>
        const chartdata = @json($chartdata);
        const teacher = @json($teacher);
        function getRandomRgb() {
            var num = Math.round(0xffffff * Math.random());
            var r = num >> 16;
            var g = num >> 8 & 255;
            var b = num & 255;
            return 'rgb(' + r + ', ' + g + ', ' + b + ', 0.05)';
        }

        function hexToRgb(hex) {
        var result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
            return result ? {
                r: parseInt(result[1], 16),
                g: parseInt(result[2], 16),
                b: parseInt(result[3], 16)
            } : null;
        }

        const labels = chartdata.vip.map(elm => elm.teacher);
        const colors = chartdata.vip.map(function (elm) {
            if( elm.teacher_id == teacher.id){ return elm.color; }
            const teacherRgbColor = hexToRgb(elm.color);
            return 'rgb(' + teacherRgbColor.r + ', ' + teacherRgbColor.g + ', ' + teacherRgbColor.b + ', 0.1)';;
        });
        const borders = chartdata.vip.map(function (elm) {
            const teacherRgbColor = hexToRgb(elm.color);
            let opacity = '0.2';
            if( elm.teacher_id == teacher.id){ return 'rgb(0,0,0)'; }
            return 'rgb(' + teacherRgbColor.r + ', ' + teacherRgbColor.g + ', ' + teacherRgbColor.b + ', ' + opacity +')';
        });
        const data   = chartdata.vip.map(elm => elm.Aulas);
		var config = {
			type: 'doughnut',
			data: {
				datasets: [{
					data,
					backgroundColor: colors,
                    borderColor: borders,
					label: 'Normal'
				}],
				labels
			},
			options: {
				responsive: true,
                 title: {
                    display: true,
                    text: 'Vip'
                },
                legend: {
                    display: false,
                    position: 'left'
                }
			}
		};

        const normalLabels = chartdata.normal.map(elm => elm.teacher);
        const normalColors = chartdata.normal.map(function (elm) {
            if( elm.teacher_id == teacher.id){ return elm.color; }
            const teacherRgbColor = hexToRgb(elm.color);
            return 'rgb(' + teacherRgbColor.r + ', ' + teacherRgbColor.g + ', ' + teacherRgbColor.b + ', 0.1)';;
        });
        const normalBorders = chartdata.normal.map(function (elm) {
            const teacherRgbColor = hexToRgb(elm.color);
            let opacity = '0.2';
            if( elm.teacher_id == teacher.id){ return 'rgb(0,0,0)'; }
            return 'rgb(' + teacherRgbColor.r + ', ' + teacherRgbColor.g + ', ' + teacherRgbColor.b + ', ' + opacity +')';
        });
        const normalData   = chartdata.normal.map(elm => elm.Aulas);
        var configTurma = {
			type: 'doughnut',
			data: {
				datasets: [{
					data: normalData,
					backgroundColor: normalColors,
                    borderColor: normalBorders,
					label: 'Normal'
				}],
				labels: normalLabels
			},
			options: {
				responsive: true,
                 title: {
                    display: true,
                    text: 'Turma'
                },
                legend: {
                    display: false,
                    position: 'left'
                }
			}
		};

		window.onload = function() {
			var ctx = document.getElementById('chart-vip').getContext('2d');
			window.myPie = new Chart(ctx, config);

            var ctx2 = document.getElementById('chart-turma').getContext('2d');
			window.myPie2 = new Chart(ctx2, configTurma);

		};
    </script>


@endsection

