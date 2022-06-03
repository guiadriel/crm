@extends('layouts.app')

@section('title', 'Relatórios / Aluno')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-12">
            <h5>Relatório de alunos</h5>
            <hr>
        </div>
    </div>
    <form method="GET" action="{{ route('reports.students.show', ['student' => 0]) }}" enctype="multipart/form-data">
        @csrf
        <div class="form-group row">
            <div class="col-6">
                <label class="my-1 mr-2" for="report_type">Selecione o tipo de relatório</label>
                <select name="report_type"
                        id="report_type"
                        class='w-100'>

                    @foreach ($reports as $report_identifier => $description)
                        <option value="{{$report_identifier}}">{{$description}}</option>
                    @endforeach

                </select>
            </div>
        </div>



        <div class="form-group row">
            <div class="col-12">
                Período
                <div class="row">
                    <div class="col-3">
                        <input type="text"
                            name="initial_date"
                            id="initial_date"
                            placeholder="Dt. Inicial"
                            class="mask-date"
                            autocomplete="off"
                            value="{{ date('01/m/Y')}}"
                            required>
                    </div>
                    <div class="col-3">
                        <input type="text"
                            name="final_date"
                            id="final_date"
                            placeholder="Dt. Final"
                            class="mask-date"
                            autocomplete="off"
                            value="{{ date('t/m/Y') }}"
                            required>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-auto">

                @foreach ($statuses as $status => $description)
                    <div class="custom-control custom-checkbox d-inline mr-1">
                        <input type="checkbox"
                                name="status[]"
                                class="custom-control-input"
                                id="status-{{$status}}"
                                value="{{$status}}"
                                checked>
                        <label class="custom-control-label" for="permission-{{$status}}">{{$description}}</label>
                    </div>
                @endforeach

            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <button type="submit" class="btn btn-primary">GERAR RELATÓRIO</button>
            </div>
        </div>
    </form>
</div>

@endsection
