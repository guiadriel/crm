@extends('layouts.app')

@section('title', "Editar histórico")

@section('content')
<div class="container">
  <div class="row mb-4 d-flex align-items-center">
    <div class="col-auto d-flex align-items-center">
      <a href="{{ url()->previous() }}" class='btn btn-primary'>VOLTAR</a>
      <span class='pl-3'>Editar histórico</span>
    </div>
  </div>

  <form method="POST" action="{{ route('student-logs.update', $log) }}">
    @csrf
    @method('PUT')

    <div class="form-group row">
      <div class="col-12">
        <label for="student_name">Aluno</label>
        <input type="text"
               id="student_name"
               name="student_name"
               value="{{$log->student->name}}"
               class="bg-light"
               readonly />
        <input type="hidden" name="student_id" id="student_id" value="{{$log->student->id}}">
      </div>
    </div>
    <div class="form-group row">
        <div class="col-3">
            <label for="date_log">Data</label>
            <input type="text"
                    name="date_log"
                    id="date_log"
                    value="{{ $log->date_log }}"
                    class="mask-datetime @error('date_log') is-invalid @enderror"
                    required>

            @error('date_log')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="col-9">
            <label for="who_received">Quem atendeu?</label>
            <input type="text"
                    name="who_received"
                    id="who_received"
                    value="{{ $log->who_received }}"
                    class="@error('who_received') is-invalid @enderror"
                    autocomplete="off"
                    required autofocus>

            @error('who_received')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>

    <div class="row mb-3">
      <div class="col-12">
        <label for="Descrição">Descrição</label>
        <textarea name="description" id="description" cols="30" rows="5" required>{{$log->description}}</textarea>
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
@endsection
