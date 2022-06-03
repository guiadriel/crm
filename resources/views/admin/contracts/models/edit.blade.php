@extends('layouts.app')

@section('title', 'Modelos de contratos')

@section('content')
<div class="container">
    <div class="row mb-4 d-flex align-items-center">
      <div class="col-auto d-flex align-items-center">
        <a href="{{ url()->previous() }}" class='btn btn-primary'>VOLTAR</a>
        <span class='pl-3'>Editar modelo</span>
      </div>
    </div>

    <hr>
    <form method="POST" action="{{ route('contracts-models.update', $model) }}">
        @csrf
        @method('PUT')


        <div class="form-group row d-flex justify-content-between">
            <div class="col-10">
                <label for="title">Título</label>
                <input type="text"
                        name="title"
                        id="title"
                        value="{{ $model->title }}"
                        class="@error('title') is-invalid @enderror"
                        required autofocus>

                @error('title')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="col-auto d-flex align-items-end">
                <button type="button" class="btn btn-primary d-flex align-items-center justify-content-between" data-toggle="modal" data-target="#modal-macros">
                    Macros
                    <i class="material-icons ml-2">help_outline</i>
                </button>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-12">
                <textarea class="description" name="description" id="description">{{$model->description}}</textarea>
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

@include('admin.contracts.models._macros')

    <script src="{{ asset('node_modules/tinymce/tinymce.js') }}"></script>
    <script>
        tinymce.init({
            selector:'textarea.description',
            height: 500,
            menubar: false,
            plugins: [
                'advlist autolink lists link image charmap print preview anchor',
                'searchreplace visualblocks code fullscreen',
                'insertdatetime media table paste code help wordcount'
            ],
            toolbar: 'undo redo | formatselect | ' +
            'bold italic backcolor | alignleft aligncenter ' +
            'alignright alignjustify | bullist numlist outdent indent | ' +
            'removeformat | help preview',
            content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }'
        });
    </script>
@endsection
