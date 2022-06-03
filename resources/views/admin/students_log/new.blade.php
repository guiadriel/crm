@extends('layouts.app')

@section('title', "Histórico")

@section('content')
<div class="container">
  <div class="row mb-4 d-flex align-items-center">
    <div class="col-auto d-flex align-items-center">
      <a href="{{ url()->previous() }}" class='btn btn-primary'>VOLTAR</a>
      <a href="{{ route('students.index') }}" class='btn btn-primary ml-2'>CADASTRO DE ALUNOS</a>
      <span class='pl-3'>Cadastrar um novo histórico</span>
    </div>
  </div>

  <form method="POST" action="{{ route('student-logs.store') }}">
    @csrf

    <div class="form-group row">
      <div class="col-12">
        <label for="student_name">Aluno</label>
        <input type="text"
               id="student_name"
               name="student_name"
               value="{{$student->name}}"
               class="bg-light"
               readonly />
        <input type="hidden" name="student_id" id="student_id" value="{{$student->id}}">
      </div>
    </div>
    <div class="form-group row">
        <div class="col-3">
            <label for="date_log">Data</label>
            <input type="text"
                    name="date_log"
                    id="date_log"
                    value="{{ date('d/m/Y H:i:s') }}"
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
                    value="{{ old('who_received', auth()->user()->name ) }}"
                    class="@error('who_received') is-invalid @enderror"
                    autocomplete="off"
                    required >

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
        <textarea name="description" id="description" cols="30" rows="5" required autofocus></textarea>
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
