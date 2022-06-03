@extends('layouts.app')

@section('title', "Cadastrar turma")

@section('content')

<div class="container">
    <div class="row mb-4 d-flex align-items-center">
      <div class="col-auto d-flex align-items-center">
        <a href="{{ url()->previous() }}" class='btn btn-primary'>VOLTAR</a>
        <span class='pl-3'>Cadastrar nova turma</span>
      </div>
    </div>
    <div class="row">
        <div class="col-12">
            <form method="POST" action="{{ route('class.store') }}">
                @csrf
                <div class="form-group row">
                    <div class="col-4">
                        <label class="my-1 mr-2" for="status">Status</label>
                        <select name="status"
                                id="status"
                                class='w-100'>
                            @foreach ($statuses as $status)
                                <option value="{{$status->id}}">{{$status->description}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-4">
                        <label class="my-1 mr-2" for="teacher">Professor</label>
                        <select name="teacher"
                                id="teacher"
                                class='w-100'>
                            @foreach ($teachers as $teacher)
                                <option value="{{$teacher->id}}">{{$teacher->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-4">
                        <label class="my-1 mr-2" for="type">Tipo</label>
                        <select name="type"
                                id="type"
                                class='w-100'>
                            <option value="TURMA">TURMA</option>
                            <option value="VIP">VIP</option>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-9">
                        <label for="name">Nome da turma</label>
                        <input type="text"
                                name="name"
                                id="name"
                                value="{{ old('name') }}"
                                class="@error('name') is-invalid @enderror"
                                required autofocus>

                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="col-3">
                        <label for="start_date">Data de início</label>
                        <input type="text"
                                name="start_date"
                                id="start_date"
                                value="{{ old('start_date') }}"
                                class="@error('start_date') is-invalid @enderror mask-date"
                                autocomplete="off"
                                required autofocus>

                        @error('start_date')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-6">
                        <label for="number_vacancies">Quantidade de vagas</label>
                        <input type="number"
                                name="number_vacancies"
                                id="number_vacancies"
                                value="{{ old('number_vacancies') }}"
                                class="@error('number_vacancies') is-invalid @enderror"
                                min="0"
                                required autofocus>

                        @error('number_vacancies')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="col-6">
                        <label for="number_vacancies_demo">Quantidade de vagas Aula Show</label>
                        <input type="number"
                                name="number_vacancies_demo"
                                id="number_vacancies_demo"
                                value="{{ old('number_vacancies_demo') }}"
                                class="@error('number_vacancies_demo') is-invalid @enderror"
                                min="0"
                                required autofocus>

                        @error('number_vacancies_demo')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-12">
                        <div class="custom-control custom-checkbox d-inline">
                            <input
                                type="checkbox"
                                class="custom-control-input"
                                name="day_of_week[]"
                                id="day_1"
                                value="1">
                            <label class="custom-control-label" for="day_1">Segunda-feira</label>
                        </div>
                        <div class="custom-control custom-checkbox d-inline">
                            <input
                                type="checkbox"
                                class="custom-control-input"
                                name="day_of_week[]"
                                id="day_2"
                                value="2">
                            <label class="custom-control-label" for="day_2">Terça-feira</label>
                        </div>
                        <div class="custom-control custom-checkbox d-inline">
                            <input
                                type="checkbox"
                                class="custom-control-input"
                                name="day_of_week[]"
                                id="day_3"
                                value="3">
                            <label class="custom-control-label" for="day_3">Quarta-feira</label>
                        </div>
                        <div class="custom-control custom-checkbox d-inline">
                            <input
                                type="checkbox"
                                class="custom-control-input"
                                name="day_of_week[]"
                                id="day_4"
                                value="4">
                            <label class="custom-control-label" for="day_4">Quinta-feira</label>
                        </div>
                        <div class="custom-control custom-checkbox d-inline">
                            <input
                                type="checkbox"
                                class="custom-control-input"
                                name="day_of_week[]"
                                id="day_5"
                                value="5">
                            <label class="custom-control-label" for="day_5">Sexta-feira</label>
                        </div>
                        <div class="custom-control custom-checkbox d-inline">
                            <input
                                type="checkbox"
                                class="custom-control-input"
                                name="day_of_week[]"
                                id="day_6"
                                value="6">
                            <label class="custom-control-label" for="day_6">Sábado</label>
                        </div>
                        <div class="custom-control custom-checkbox d-inline">
                            <input
                                type="checkbox"
                                class="custom-control-input"
                                name="day_of_week[]"
                                id="day_0"
                                value="0">
                            <label class="custom-control-label" for="day_0">Domingo</label>
                        </div>
                    </div>

                </div>

                <div class="form-group row">
                    <div class="col-12">
                        <label for="time_schedule">Horário (__:__)</label>
                        <input type="text"
                                name="time_schedule"
                                id="time_schedule"
                                value="{{ old('time_schedule') }}"
                                class="@error('time_schedule') is-invalid @enderror mask-time"
                                required autofocus>

                        @error('time_schedule')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="form-group row mb-0">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">
                            {{ __('SALVAR CADASTRO') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section("body_scripts")
<script>
    $(function () {
        $("#type").change(function(elm) {
            if( $(this).val() === "VIP"){
                // $("#number_vacancies").removeAttr("required");
                $("#number_vacancies").val(1);

                // $("#number_vacancies_demo").removeAttr("required");
                $("#number_vacancies_demo").val(0);
            }else{
                // $("#number_vacancies, #number_vacancies_demo").attr("required", true);
            }
        });
    });
</script>

@endsection
