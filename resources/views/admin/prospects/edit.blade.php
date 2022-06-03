@extends('layouts.app')

@section('title', "Editar registro")

@section('content')
<div class="container">
    <div class="row mb-4 d-flex align-items-center">
      <div class="col-auto d-flex align-items-center">
        <a href="{{ url()->previous() }}" class='btn btn-primary'>VOLTAR</a>
        <span class='pl-3'>Editar registro</span>
      </div>
    </div>
    <div class="row">
        <div class="col-12">
            <form method="POST" action="{{ route('prospects.update', $student) }}">
                @csrf
                @method('PUT')

                <div class="form-group row">
                    <div class="col-9">
                        <label for="name">Nome</label>
                        <input type="text"
                                name="name"
                                id="name"
                                value="{{ $student->name ?? '' }}"
                                class="@error('name') is-invalid @enderror"
                                required autofocus>

                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="col-3">
                        <label for="phone">Telefone</label>
                        <input type="text"
                                name="phone"
                                id="phone"
                                value="{{ $student->phone }}"
                                class="@error('phone') is-invalid @enderror"
                                onkeyup="this.value=this.value.replace(/[^\d]/,'')"
                                required>

                        @error('phone')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                </div>

                <div class="form-group row">
                    <div class="col-6">
                        <label for="email">Email</label>
                        <input type="email"
                                name="email"
                                id="email"
                                value="{{ $student->email ?? '' }}"
                                class="@error('email') is-invalid @enderror"
                                >

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="col-6">
                        <label for="who_booked">Quem agendou</label>
                        <input type="text"
                                name="who_booked"
                                id="who_booked"
                                value="{{ $student->who_booked }}"
                                class="@error('who_booked') is-invalid @enderror">

                        @error('who_booked')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row mb-2">
                    <div class="col-12">
                        <label for="observations">Observações</label>
                        <textarea name="observations"
                                  id="observations"
                                  cols="30"
                                  rows="5"
                                  class="@error('name') is-invalid @enderror">{{$student->observations}}</textarea>
                        @error('observations')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row mb-0">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">
                            {{ __('SALVAR') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
