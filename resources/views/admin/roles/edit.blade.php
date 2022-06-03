@extends('layouts.app')
@section('title', "Editar função [$role->name]")
@section('content')

<div class="container">

  <div class="row mb-4 d-flex align-items-center">
    <div class="col-auto d-flex align-items-center">
      <a href="{{ url()->previous() }}" class='btn btn-primary'>VOLTAR</a>
      <span class='pl-3'>Editar aluno</span>
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


  <form action="{{route('roles.update', $role)}}" method="POST" >
    @csrf
    @method('PATCH')

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
          <div class="form-group">

          <strong>Nome da função:</strong>
          <input type="text"
                placeholder="Name"
                name="name"
                id="name"
                value="{{$role->name}}"
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
                  <div class="col-3">
                    <div class="custom-control custom-checkbox">
                      <input type="checkbox"
                            name="permission[]"
                            class="custom-control-input"
                            id="permission{{$value->id}}"
                            value="{{$value->id}}"
                            @if(in_array($value->id, $rolePermissions))
                              checked
                            @endif
                            >
                      <label class="custom-control-label" for="permission{{$value->id}}">{{$value->description}}</label>
                    </div>
                  </div>
                @endforeach
              </div>

            </div>

          </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
        <button type="submit" class="btn btn-primary">Submit</button>
      </div>
    </div>
  </form>

</div>


@endsection
