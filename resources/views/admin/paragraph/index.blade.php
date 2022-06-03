@extends('layouts.app')

@section('title', "Controle de parágrafos")

@section('content')
  <div class="container">
    <div class="row mb-4 d-flex align-items-center">
      <div class="col-auto d-flex align-items-center">
        <a href="{{ url()->previous() }}" class='btn btn-primary mr-2'>VOLTAR</a>
        <span>Gerar controle de paragrafos</span>
      </div>
    </div>
    <form action="{{ route('paragraph.show', ['paragraph'=> 1])}}" method="GET" target="_blank">
      @csrf
      <div class="row mb-4">
        <div class="col-6">
            <label class="my-1 mr-2" for="groupclass">Classe</label>
            <select name="groupclass"
                    id="groupclass"
                    class='w-100'>
                @foreach ($groupclass as $class)
                    <option value="{{$class->id}}">{{$class->name}}</option>
                @endforeach
            </select>
        </div>
        <div class="col-6">
            <label class="my-1 mr-2" for="book">Book</label>
            <select name="book"
                    id="book"
                    class='w-100'>
                @foreach ($books as $book)
                    <option value="{{$book->id}}">{{$book->name}}</option>
                @endforeach
            </select>
        </div>
      </div>
      <div class="row mb-4">
        <div class="col-3">
            <label class="my-1 mr-2" for="qty">Qtde Linhas</label>
            <input type="text"
                    name="qty"
                    id="qty"
                   value="24"
                   required>
        </div>
      </div>

      <div class="form-group row mb-0">
          <div class="col-12">
              <button type="submit" class="btn btn-primary">
                  {{ __('GERAR CONTROLE') }}
              </button>
          </div>
      </div>

    </form>
  </div>
@endsection
