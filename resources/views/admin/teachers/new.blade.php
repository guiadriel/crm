@extends('layouts.app')

@section('title', "Novo professor")

@section('content')
<div class="container">
    <div class="row mb-4 d-flex align-items-center">
      <div class="col-auto d-flex align-items-center">
        <a href="{{ url()->previous() }}" class='btn btn-primary'>VOLTAR</a>
        <span class='pl-3'>Cadastrar um novo professor</span>
      </div>
    </div>
    <div class="row">
        <div class="col-12">
            <form method="POST" action="{{ route('teachers.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="form-group row">
                    <div class="col-12">
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
                </div>
                <div class="form-group row">
                    <div class="col-6">
                        <label for="email">Email</label>
                        <input type="email"
                                name="email"
                                id="email"
                                value="{{ old('email') }}"
                                class="@error('email') is-invalid @enderror"
                                required>

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="col-6">
                        <label for="phone">Telefone</label>
                        <input type="text"
                                name="phone"
                                id="phone"
                                value="{{ old('phone') }}"
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
                    <div class="col-3">
                        <label for="rg">RG</label>
                        <input type="rg"
                                name="rg"
                                id="rg"
                                value="{{ old('rg') }}"
                                class="@error('rg') is-invalid @enderror">

                        @error('rg')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="col-3">
                        <label for="cpf">CPF</label>
                        <input type="cpf"
                                name="cpf"
                                id="cpf"
                                value="{{ old('cpf') }}"
                                class="@error('cpf') is-invalid @enderror">

                        @error('cpf')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                     <div class="col-3">
                        <label for="admission_date">Dt. Admissão</label>
                        <input type="admission_date"
                                name="admission_date"
                                id="admission_date"
                                value="{{ old('admission_date') }}"
                                class="@error('admission_date') is-invalid @enderror mask-date">

                        @error('admission_date')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                     <div class="col-3">
                        <label for="resignation_date">Dt. Demissão</label>
                        <input type="resignation_date"
                                name="resignation_date"
                                id="resignation_date"
                                value="{{ old('resignation_date') }}"
                                class="@error('resignation_date') is-invalid @enderror mask-date">

                        @error('resignation_date')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>


                <div class="row mb-2">
                    <div class="col-2">
                        <label for="zip_code">Cep</label>
                        <input type="zip_code"
                                name="zip_code"
                                id="zip_code"
                                value="{{ old('zip_code') }}"
                                class="@error('zip_code') is-invalid @enderror">

                        @error('zip_code')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="col-8">
                        <label for="address">Endereço</label>
                        <input type="text"
                                name="address"
                                id="address"
                                value="{{ old('address') }}"
                                class="@error('address') is-invalid @enderror">

                        @error('address')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="col-2">
                        <label for="number">Número</label>
                        <input type="text"
                                name="number"
                                id="number"
                                value="{{ old('number') }}"
                                class="@error('number') is-invalid @enderror">

                        @error('number')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>


                <div class="row mb-2">
                    <div class="col-5">
                        <label for="neighborhood">Bairro</label>
                        <input type="text"
                                name="neighborhood"
                                id="neighborhood"
                                value="{{ old('neighborhood') }}"
                                class="@error('neighborhood') is-invalid @enderror">

                        @error('neighborhood')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="col-5">
                        <label for="city">Cidade</label>
                        <input type="text"
                                name="city"
                                id="city"
                                value="{{ old('city') }}"
                                class="@error('city') is-invalid @enderror">

                        @error('city')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="col-2">
                        <label for="state">Estado</label>
                        <input type="text"
                                name="state"
                                id="state"
                                value="{{ old('state') }}"
                                class="@error('state') is-invalid @enderror">

                        @error('state')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>


                <hr>
                <div class="form-group row">
                    <div class="col-3">
                        <label for="value_per_class">Valor/turma</label>
                        <input type="text"
                                name="value_per_class"
                                id="value_per_class"
                                value="{{ old('value_per_class') }}"
                                class="@error('value_per_class') is-invalid @enderror mask-money"
                                required>

                        @error('value_per_class')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="col-3">
                        <label for="value_per_vip_class">Valor/vip</label>
                        <input type="text"
                                name="value_per_vip_class"
                                id="value_per_vip_class"
                                value="{{ old('value_per_vip_class') }}"
                                class="@error('value_per_vip_class') is-invalid @enderror mask-money"
                                required>

                        @error('value_per_vip_class')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-3">
                        <label for="bank_agency">Agência</label>
                        <input type="bank_agency"
                                name="bank_agency"
                                id="bank_agency"
                                value="{{ old('bank_agency') }}"
                                class="@error('bank_agency') is-invalid @enderror">

                        @error('bank_agency')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="col-3">
                        <label for="bank_account">Conta</label>
                        <input type="bank_account"
                                name="bank_account"
                                id="bank_account"
                                value="{{ old('bank_account') }}"
                                class="@error('bank_account') is-invalid @enderror">

                        @error('bank_account')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="col-3">
                        <label for="bank_type">Tipo de Conta</label>
                        <input type="bank_type"
                                name="bank_type"
                                id="bank_type"
                                value="{{ old('bank_type') }}"
                                class="@error('bank_type') is-invalid @enderror">

                        @error('bank_type')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="col-3">
                        <label for="bank_pix">Chave Pix</label>
                        <input type="bank_pix"
                                name="bank_pix"
                                id="bank_pix"
                                value="{{ old('bank_pix') }}"
                                class="@error('bank_pix') is-invalid @enderror">

                        @error('bank_pix')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>


                <hr>

                <div class="form-group row">
                    <div class="col-2">
                        <label for="color">Cor de atribuição</label>
                        <input type="color"
                                name="color"
                                id="color"
                                value="{{ old('color') }}"
                                class="@error('color') is-invalid @enderror"
                                required autofocus>

                        @error('color')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="col-3">
                        <label for="type">Tipo</label>
                        <select name="type" id="type" class='form-control'>
                            @foreach ($types as $type => $description)
                                <option value="{{$type}}"
                                >{{$description}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <hr>

                <div class="form-group row mt-2" >
                    <div class="input-group mb-3 col">
                        <div>
                            <label for="teacher_file">Escolha o arquivo que deseja enviar</label>
                            <input type="file" class="bg-transparent border-0" id="teacher_file" name="teacher_file" aria-describedby="teacher_file" placeholder="escolha o arquivo">
                        </div>
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
