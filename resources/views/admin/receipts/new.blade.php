@extends('layouts.app')

@section('title', "Cadastrar conta a receber")

@section('content')
    <div class="container">
        <div class="row mb-4 d-flex align-items-center">
        <div class="col-auto d-flex align-items-center">
            <a href="{{ url()->previous() }}" class='btn btn-primary'>VOLTAR</a>
            <span class='pl-3'>Cadastrar conta a receber</span>
        </div>
        </div>
        <div class="row">
            <div class="col-12">
                <form id="bills_store" method="POST" action="{{ route('receipts.store') }}">
                    @csrf

                    <div class="form-group row">

                        <div class="col-3">
                            <label for="category">Categoria</label>
                            <select name="category" id="category" class='form-control'>
                                @foreach ($categories as $category)
                                    <option value="{{$category->id}}">{{$category->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-3">
                            <label for="sub_category">Sub-categoria</label>
                            <select name="sub_category" id="sub_category" class='form-control'>
                                @foreach ($categories as $category)
                                    @if ($loop->first)
                                        @foreach ($category->subCategories as $subCategory)
                                            <option value="{{$subCategory->id}}">{{$subCategory->name}}</option>
                                        @endforeach
                                    @endif
                                @endforeach
                            </select>
                        </div>

                        <div class="col-3">
                            <label for="type">Tipo</label>
                            <select name="type" id="type" class='form-control'>
                                <option value="V">V</option>
                                <option value="F">F</option>
                            </select>
                            @error('type')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="col-3">
                            <label for="status">Status</label>
                            <select name="status" id="status" class='form-control'>
                                @foreach ($statuses as $status)
                                    <option value="{{$status->id}}"
                                    @if ($status->description == App\Models\Status::STATUS_EM_DIA)
                                        selected
                                    @endif
                                    >{{$status->description}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-12">
                            <label for="description">Descrição</label>
                            <input type="text"
                                    name="description"
                                    id="description"
                                    value="{{ old('description') }}"
                                    class="@error('description') is-invalid @enderror"
                                    required>
                            @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-4">
                            <label for="amount">Valor (R$)</label>
                            <input type="text"
                                    name="amount"
                                    id="amount"
                                    value="{{ old('amount') }}"
                                    class="@error('amount') is-invalid @enderror mask-money"
                                    required>
                            @error('amount')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-2">
                            <label for="due_date">Dt. Esperada</label>
                            <input type="text"
                                    name="due_date"
                                    id="due_date"
                                    value="{{ old('due_date') }}"
                                    class="@error('due_date') is-invalid @enderror mask-date p-0 text-center"
                                    required
                                    autocomplete="off">
                            @error('due_date')
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

    <script>


        $(document).ready(function () {
            let categories;

            async function getCategories() {
                await window.axios.get('../../api/categories').then(function (response){
                    categories = response.data;
                    $("#category").html("");
                    // $("#category").append(/*html*/`<option value="">SEM CATEGORIA</option>`);
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
                const modalSubCategories = document.querySelector("#sub_category");

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
                                $("#sub_category").append(/*html*/`<option value="${subcategory.id}">${subcategory.name}</option>`);
                            });
                        });
                    }
                })
            }

            getCategories();
            handleSubCategories();
        });

    </script>
@endsection
