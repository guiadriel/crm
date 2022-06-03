@extends('layouts.app')

@section('title', "Editar aluno [$student->name]")

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
        <a href="{{ url()->previous() }}" class='btn btn-primary mr-4'>VOLTAR</a>
        <a href="{{ route('students.show', $student->id) }}" class='btn btn-outline-primary'>VISUALIZAR</a>
        <span class='pl-3'>Editar aluno</span>
      </div>
    </div>
    <form  name="updateForm" id="updateForm" action="{{ route('students.update', $student) }}" method="POST" enctype="multipart/form-data">
      @csrf
      {{ method_field('PUT') }}

      <div class="form-group row">
        <div class="col-6">
            <label class="my-1 mr-2" for="status">Status</label>
            <select name="status"
                    id="status"
                    class='w-100'>
                @foreach ($statuses as $status)
                    <option value="{{$status->id}}"
                     @if($status->id === $student->status_id)
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
                    <option value="{{$origin->id}}"
                    @if($origin->id === $student->origin_id)
                      selected
                     @endif
                    >{{$origin->type}}</option>
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
                    value="{{ $student->name }}"
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
                    value="{{ $student->nickname }}"
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
                    value="{{ $student->phone }}"
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
                    <img src="{{$student->avatar ?? asset('images/avatar.svg') }}"/>
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
    </form>
    <button type="submit" class="btn btn-primary" form="updateForm">SALVAR</button>
    @include('admin.students._delete', ['large' => true])
  </div>

@endsection


@section('body_scripts')
    <script>
        $(function () {
            $(".image-upload input[type=file]").change(function(){ readURL(this); });
        });
    </script>


@endsection
