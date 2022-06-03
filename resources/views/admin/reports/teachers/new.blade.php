@extends('layouts.app')

@section('title', 'Relatórios / Professores')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-12">
            <h5>Relatório de aulas dadas</h5>
            <hr>
        </div>
    </div>
    <form method="GET" action="{{ route('reports.teachers.show', ['teacher' => 0]) }}" enctype="multipart/form-data">
        @csrf
        <div class="form-group row">
            <div class="col-6">
                <label class="my-1 mr-2" for="teacher">Selecione o professor</label>
                <select name="teacher"
                        id="teacher"
                        class='w-100'>
                    @foreach ($teachers as $teacher)
                        <option value="{{$teacher->id}}"
                        >{{$teacher->name}}</option>
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

        <div class="row">
            <div class="col-12">
                <button type="submit" class="btn btn-primary">GERAR RELATÓRIO</button>
            </div>
        </div>


    </form>
</div>

@endsection
