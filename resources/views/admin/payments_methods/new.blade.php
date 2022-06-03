@extends('layouts.app')

@section('title', "Novo método de pagamento")

@section('content')
<div class="container">
    <div class="row mb-4 d-flex align-items-center">
      <div class="col-auto d-flex align-items-center">
        <a href="{{ url()->previous() }}" class='btn btn-primary'>VOLTAR</a>
        <span class='pl-3'>Cadastrar novo método</span>
      </div>
    </div>
    <div class="row">
        <div class="col-12">
            <form method="POST" action="{{ route('payment-methods.store') }}">
                @csrf
                <div class="form-group row">
                    <div class="col-6">
                        <label for="description">Método</label>
                        <input type="text"
                                name="description"
                                id="description"
                                value="{{ old('description') }}"
                                class="@error('description') is-invalid @enderror"
                                required autofocus>

                        @error('description')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="col-6">
                        <label class="my-1 mr-2" for="status">Status</label>
                        <select name="status"
                                id="status"
                                class='w-100'>
                            @foreach ($statuses as $status)
                                <option value="{{$status->id}}">{{$status->description}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col-3">
                        <label for="category">Categoria</label>
                        <select name="category" id="category" class='form-control'></select>
                    </div>
                    <div class="col-3">
                        <label for="subcategory">Sub-categoria</label>
                        <select name="subcategory" id="subcategory" class='form-control'></select>
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


<script>
    async function getCategories() {
        await window.axios.get('../../api/categories').then(function (response){
            categories = response.data;
            $("#category").html("");
            $("#category").append(/*html*/`<option value="">SEM CATEGORIA</option>`);
            if( categories.length > 0 ){
                categories.map(function(cat){
                    $("#category").append(/*html*/`<option value="${cat.id}">${cat.name}</option>`);
                } );
            }
        });
    }

    async function handleSubCategories()
    {
        const modalCategory = document.querySelector("#category");
        const modalSubCategories = document.querySelector("#subcategory");

        modalCategory.addEventListener('change', function(elm) {

            if( this.value ){

                const categoryId = this.value;

                const selectedCategory = categories.filter(function(cat) {
                    if(cat.id == categoryId){
                        return cat;
                    }
                });


                while(modalSubCategories.options.length){
                    modalSubCategories.remove(0);
                }


                selectedCategory.map(function(category) {
                    category.sub_categories.map(function(subcategory){
                        $("#subcategory").append(/*html*/`<option value="${subcategory.id}">${subcategory.name}</option>`);
                    });
                });
            }
        })
    }

    $(function () {
        getCategories();
        handleSubCategories();
    });
</script>

@endsection
