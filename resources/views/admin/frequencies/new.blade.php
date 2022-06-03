@extends('layouts.app')

@section('title', "Nova lista de presença")

@section('content')
<div class="container">
    <div class="row mb-4 d-flex align-items-center">
        <div class="col-auto d-flex align-items-center">
            <a href="{{ url()->previous() }}" class='btn btn-primary'>VOLTAR</a>
            <span class='pl-3'>Cadastrar nova lista de presença</span>
        </div>
    </div>

    <div class="row">
        <div class="col-auto">
            <p class="m-1">Turma</p>
            <h5>
                <span class="d-block badge badge-white">{{$groupclass->name}}</span>
            </h5>
        </div>
        @if ( isset($groupclass->teacher))
        <div class="col-auto">
            <p class="m-1">Professor da Turma</p>
            <h5>
                <span class="d-block badge badge-white">{{$groupclass->teacher->name}}</span>
            </h5>
        </div>
        @endif
    </div>

    <hr>

    <form action="{{ route('frequency.store', ['class_id' => $groupclass->id])}}" method="POST">
        @csrf

        <div class="row">
            <div class="col-3">

                <label for="date">Data</label>
                <input type="text"
                        name="date"
                        id="date"
                        value="{{ date('d/m/Y') }}"
                        class="@error('date') is-invalid @enderror mask-date text-center p-0"
                        required autofocus>

                @error('date')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror

            </div>
        </div>

        @include('admin.frequencies._table-frequencies')

        <div class="form-group row mb-0">
            <div class="col-12">
                <button type="submit" class="btn btn-primary">
                    {{ __('SALVAR DATA') }}
                </button>
            </div>
        </div>

    </form>


</div>
@endsection
