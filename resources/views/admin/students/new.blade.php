@extends('layouts.app')

@section('title', "Novo aluno")

@section('content')
<style>
    .image-upload>input {
        display:none;
    }

    .image-upload img {
        height: 54px;
        border-radius: 50%;
    }
</style>
<div class="container">
    <div class="row mb-4 d-flex align-items-center">
      <div class="col-auto d-flex align-items-center">
        <a href="{{ url()->previous() }}" class='btn btn-primary'>VOLTAR</a>
        <span class='pl-3'>Cadastrar um novo aluno</span>
      </div>
    </div>
    <div class="row">
        <div class="col-12">
            <form method="POST" action="{{ route('students.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="form-group row">
                    <div class="col-6">
                        <label class="my-1 mr-2" for="status">Status</label>
                        <select name="status"
                                id="status"
                                class='w-100'>
                            @foreach ($statuses as $status)
                                <option value="{{$status->id}}"
                                @if ( $status->description == \App\Models\Status::STATUS_ATIVO)
                                    selected
                                @endif
                                >{{$status->description}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-6">
                        <label class="my-1 mr-2" for="origin">Origem de cadastro</label>
                        <select name="origin"
                                id="origin"
                                class='w-100'>
                            @foreach ($origins as $origin)
                                <option value="{{$origin->id}}">{{$origin->type}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-6">
                        <label for="name">Nome</label>
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
                        <label for="nickname">Apelido</label>
                        <input type="text"
                                name="nickname"
                                id="nickname"
                                value="{{ old('nickname') }}"
                                class="@error('nickname') is-invalid @enderror"
                                required autofocus>

                        @error('nickname')
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
                                value="{{ old('phone') }}"
                                class="@error('phone') is-invalid @enderror mask-phone"
                                required>

                        @error('phone')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active"
                            id="student-tab"
                            data-toggle="tab"
                            href="#student"
                            role="tab"
                            aria-controls="student"
                            aria-selected="true">Dados do aluno</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link"
                            id="responsible-tab"
                            data-toggle="tab"
                            href="#responsible"
                            role="tab"
                            aria-controls="responsible"
                            aria-selected="false">Dados do responsável</a>
                    </li>
                </ul>
                <div class="tab-content p-3 border border-top-0" id="myTabContent">
                    <div class="tab-pane fade show active" id="student" role="tabpanel" aria-labelledby="student-tab">
                        @include('admin.students.tabs.student-tab')
                    </div>
                    <div class="tab-pane fade" id="responsible" role="tabpanel" aria-labelledby="responsible-tab">
                        @include('admin.students.tabs.responsible-tab')
                    </div>
                </div>


                <div class="row mt-2" >
                    <div class="col-12">
                        <div class="image-upload">
                            <label for="avatar" style='cursor:pointer;'>
                                <img src="{{ asset('/images/avatar.svg') }}"/>
                                <small>Clique aqui ou no icone para selecionar uma imagem</small>
                            </label>
                            <input id="avatar"
                                    name="avatar"
                                    type="file"
                                    accept="image/*"
                                    />
                        </div>
                    </div>
                </div>

                <div class="form-group row mb-2">
                    <div class="col-12">
                        <label for="observations">Observações</label>
                        <textarea name="observations" id="observations" cols="30" rows="5" class="@error('name') is-invalid @enderror"></textarea>
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
                            {{ __('SALVAR CADASTRO') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


@endsection

@section('body_scripts')
    <script>
        $(function () {
            $(".image-upload input[type=file]").change(function(){ readURL(this); });
        });
    </script>
@endsection
