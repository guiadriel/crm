@extends('layouts.app')
@section('content')
<div class="container">

  <div class="row mb-4">
    <div class="col-12">
      <a class="btn btn-primary" href="{{ url()->previous() }}"> Voltar</a>
    </div>

  </div>

  @if (count($errors) > 0)
    <div class="alert alert-danger">
    <strong>Whoops!</strong> There were some problems with your input.<br><br>
    <ul>
    @foreach ($errors->all() as $error)
    <li>{{ $error }}</li>
    @endforeach
    </ul>
  </div>
  @endif

  <form action="{{route('roles.store')}}" method="POST">
    @csrf
    @method('POST')

    <div class="row">
      <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">

        <strong>Nome da função:</strong>
        <input type="text"
              placeholder="Name"
              name="name"
              id="name"
              class=''
              required>
        </div>
      </div>

      <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
          <strong>Permissões</strong>
          <div class="card card-body d-flex justify-content-between">
            <div class="row">
              @foreach($permission as $value)
                <div class="col-2">
                  <div class="custom-control custom-checkbox">
                    <input type="checkbox"
                          name="permission[]"
                          class="custom-control-input"
                          id="permission{{$value->id}}"
                          value="{{$value->id}}">
                    <label class="custom-control-label" for="permission{{$value->id}}">{{$value->name}}</label>
                  </div>
                </div>
              @endforeach
            </div>

          </div>

        </div>
      </div>
      <div class="col-xs-12 col-sm-12 col-md-12">
      <button type="submit" class="btn btn-primary">Salvar</button>
      </div>
    </div>
  </form>

</div>

@endsection
