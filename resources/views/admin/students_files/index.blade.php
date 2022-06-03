@extends('layouts.app')

@section('title', 'Alunos')

@section('content')
  <div class="container">
    <div class="row mb-4 d-flex align-items-center">

      @can('upload files')
        <div class="col-2">
            <a href="{{ route('students.create')}}" class='btn btn-primary'>Cadastrar aluno</a>
        </div>
      @endcan
    </div>
  </div>


@endsection
