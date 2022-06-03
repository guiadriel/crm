@extends('layouts.app')

@section('title', "Cadastrar conta")

@section('content')
    <div class="container">
        <div class="row mb-4 d-flex align-items-center">
        <div class="col-auto d-flex align-items-center">
            <a href="{{ url()->previous() }}" class='btn btn-primary'>VOLTAR</a>
            <span class='pl-3'>Cadastrar conta</span>
        </div>
        </div>
        <div class="row">
            <div class="col-12">
                <form id="bills_store" method="POST" action="{{ route('bills.store') }}">
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
                                            <option value="{{$subCategory->id}}"
                                            >{{$subCategory->name}}</option>
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
                        <div class="col-10">
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
                        <div class="col-2">
                            <label for="due_date">Dt. 1º Vencimento</label>
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

                    <div class="row mb-4">
                        <div class="col-3">
                            <label for="intended_amount">Valor Projetado (R$)</label>
                            <input type="text"
                                    name="intended_amount"
                                    id="intended_amount"
                                    value="{{ old('intended_amount') }}"
                                    class="@error('intended_amount') is-invalid @enderror mask-money"
                                    autocomplete="off"
                                    required>
                            @error('intended_amount')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-3">
                            <label for="amount">Valor Real(R$)</label>
                            <input type="text"
                                    name="amount"
                                    id="amount"
                                    autocomplete="off"
                                    value="{{ old('amount') }}"
                                    class="@error('amount') is-invalid @enderror mask-money">
                            @error('amount')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="col-2">
                            <label for="paid_at">Pago em </label>
                            <input type="text"
                                    name="paid_at"
                                    id="paid_at"
                                    value="{{ old('paid_at') }}"
                                    class="@error('paid_at') is-invalid @enderror mask-date p-0 text-center"
                                    autocomplete="off">
                            @error('paid_at')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="col-4">
                            <label for="paid_by">Pago por</label>
                            <input type="text"
                                    name="paid_by"
                                    id="paid_by"
                                    value="{{ old('paid_by') }}"
                                    class="@error('paid_by') is-invalid @enderror">
                            @error('paid_by')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                    </div>

                    <hr>

                    <div class="row mb-4">
                        <div class="col-auto d-flex align-items-center pt-4">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="has_installments" name="has_installments">
                                <label class="custom-control-label" for="has_installments">Gerar parcelas</label>
                            </div>
                        </div>
                        <div class="col-3 input-group">
                            <label for="quantity">Quantidade de Parcelas</label>
                            <input type="number"
                                    name="quantity"
                                    id="quantity"
                                    min="0"
                                    value="{{ old('quantity') ?? 0 }}"
                                    class="@error('quantity') is-invalid @enderror"
                                    required>
                            @error('quantity')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="col-6 offset-1 input-group">
                            <label for="total_month">Repetir por quantos meses?</label>
                            <input type="number"
                                    name="total_month"
                                    id="total_month"
                                    min="0"
                                    value="0">
                        </div>
                    </div>

                    <div class="form-group row mb-2">
                        <div class="col-12">
                            <label for="observations">Observações</label>
                            <textarea name="observations"
                                        id="observations"
                                        cols="30"
                                        rows="5"
                                        class="@error('observations') is-invalid @enderror"></textarea>
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

    <script>
        const statusPago = '{{\App\Models\Status::STATUS_PAGO}}';


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

            const statusInput = document.querySelector('#status');

            statusInput.addEventListener('change', function( elm){
            })

            $("#has_installments").change(function(elm){
                if( $(this).is(':checked') ){
                    $("#total_month").css('visibility', 'hidden');
                    $("#quantity").css('visibility', 'visible');
                }else{
                    $("#total_month").css('visibility', 'visible');
                    $("#quantity").css('visibility', 'hidden');

                }
            }).change();

            $("#status").change(function() {
                $("#paid_at, #paid_by").removeAttr("required");
                if( $("#status :selected").text() == statusPago ) {
                    $("#paid_at, #paid_by").attr("required", true);
                }
            });
        });

    </script>
@endsection
