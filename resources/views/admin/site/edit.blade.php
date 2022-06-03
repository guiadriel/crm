@extends('layouts.app')

@section('title', "Editar configurações de contato do site")

@section('content')
  <div class="container">
    <form  name="update_form" 
           id="update_form" 
           action="{{ route('admin.siteconfig.update', $siteconfig) }}" 
           method="POST"
           onSubmit="CustomDialog.submit('Deseja salvar esses dados?', this)">
      @csrf
      {{ method_field('PUT') }}

      <div class="form-group row">
        <div class="col-8">
          <label for="address">Endereço</label>
          <input type="text"
                  name="address"
                  id="address"
                  value="{{$siteconfig->address}}"
                  placeholder="Endereço"
                  class="@error('address') is-invalid @enderror"
                  required>
        </div>
        <div class="col-4">
          <label for="number">Número</label>
          <input type="text"
                  name="number"
                  id="number"
                  value="{{$siteconfig->number}}"
                  placeholder="Número"
                  class="@error('number') is-invalid @enderror"
                  required>
        </div>
      </div>

      <div class="form-group row">
        <div class="col-5">
          <label for="district">Bairro</label>
          <input id="district"
                   type="text"
                   class="@error('district') is-invalid @enderror" 
                   name="district"
                   value="{{$siteconfig->district}}"
                   placeholder="Bairro"
                   autofocus>
        </div>
        <div class="col-5">
          <label for="city">Cidade</label>
          <input id="city"
                   type="text"
                   class="@error('city') is-invalid @enderror" 
                   name="city"
                   value="{{$siteconfig->city}}"
                   placeholder="Cidade"
                   autofocus>
        </div>
        <div class="col-2">
          <label for="state">Estado</label>
          <input id="state"
                   type="text"
                   class="@error('state') is-invalid @enderror" 
                   name="state"
                   value="{{$siteconfig->state}}"
                   placeholder="Estado"
                   autofocus>
        </div>
      </div>

      <div class="form-group row ">
        <div class="col-6">
          <label for="email">Email</label>
          <input id="email"
                   type="text"
                   class="@error('email') is-invalid @enderror" 
                   name="email"
                   value="{{$siteconfig->email}}"
                   placeholder="Email"
                   autofocus>
        </div>
        <div class="col-4">
          <label for="phone">Telefone</label>
          <input id="phone"
                   type="text"
                   class="@error('phone') is-invalid @enderror" 
                   name="phone"
                   value="{{$siteconfig->phone}}"
                   placeholder="Telefone"
                   autofocus>
        </div>
      </div>

    </form>
    <button type="submit" class="btn btn-primary" form="update_form">SALVAR</button>
  </div>


@endsection
