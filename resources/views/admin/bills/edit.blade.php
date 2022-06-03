@extends('layouts.app')

@section('title', "Cadastrar conta")

@section('content')
    <div class="container">
        <div class="row mb-4 d-flex align-items-center">
        <div class="col-auto d-flex align-items-center">
            <a href="{{ url()->previous() }}" class='btn btn-primary'>VOLTAR</a>
            <span class='pl-3'>Editar conta</span>
        </div>
        </div>
        <div class="row">
            <div class="col-12">
                <form id="bills_form" method="POST" action="{{ route('bills.update', $bill) }}">
                    @csrf
                    @method('PUT')

                    <div class="form-group row">

                        <div class="col-3">
                            <label for="category">Categoria</label>
                            <select name="category" id="category" class='form-control'>
                                @foreach ($categories as $category)
                                    <option value="{{$category->id}}"
                                        @if ($category->id === $bill->category_id)
                                            selected
                                        @endif
                                    >{{$category->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-3">
                            <label for="sub_category">Sub-categoria</label>
                            <select name="sub_category" id="sub_category" class='form-control'>
                                @foreach ($categories as $category)
                                    @if ($category->id === $bill->category_id)
                                        @foreach ($category->subCategories as $subCategory)
                                            <option value="{{$subCategory->id}}"
                                                @if ($subCategory->id === $bill->subCategory->id)
                                                    selected
                                                @endif
                                            >{{$subCategory->name}}</option>
                                        @endforeach
                                    @endif
                                @endforeach
                            </select>
                        </div>

                         <div class="col-3">
                            <label for="type">Tipo</label>
                            <select name="type" id="type" class='form-control'>
                                <option value="V" @if ($bill->type == 'V') selected @endif>V</option>
                                <option value="F" @if ($bill->type == 'F') selected @endif>F</option>
                            </select>
                            @error('type')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>


                    </div>

                    <div class="form-group row">
                        <div class="col-6">
                            <label for="description">Descrição</label>
                            <input type="text"
                                    name="description"
                                    id="description"
                                    value="{{ $bill->description }}"
                                    class="@error('description') is-invalid @enderror"
                                    required>
                            @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-3">
                            <label for="amount">Valor Real (R$)</label>
                            <input type="text"
                                    name="amount"
                                    id="amount"
                                    value="{{ $bill->amount}}"
                                    class="@error('amount') is-invalid @enderror mask-money"
                                    required>
                            @error('amount')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <div class="amount_div"></div>
                        </div>
                        <div class="col-3">
                            <label for="intended_amount">Valor Projetado(R$)</label>
                            <input type="text"
                                    name="intended_amount"
                                    id="intended_amount"
                                    value="{{ $bill->intended_amount}}"
                                    class="@error('intended_amount') is-invalid @enderror mask-money"
                                    required>
                            @error('intended_amount')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-4">

                        <div class="col-2">
                            <label for="due_date">Dt. Vencimento</label>
                            <input type="text"
                                    name="due_date"
                                    id="due_date"
                                    value="{{ $bill->due_date }}"
                                    class="@error('due_date') is-invalid @enderror mask-date p-0 text-center"
                                    required
                                    autocomplete="off">
                            @error('due_date')
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
                                    @if ($status->id == $bill->status->id)
                                        selected
                                    @endif
                                    >{{$status->description}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-2">
                            <label for="paid_at">Pago em </label>
                            <input type="text"
                                    name="paid_at"
                                    id="paid_at"
                                    value="{{ $bill->paid_at }}"
                                    class="@error('paid_at') is-invalid @enderror mask-date p-0 text-center"
                                    autocomplete="off">
                            @error('paid_at')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="col-5">
                            <label for="paid_by">Pago por</label>
                            <input type="text"
                                    name="paid_by"
                                    id="paid_by"
                                    value="{{ $bill->paid_by }}"
                                    class="@error('paid_by') is-invalid @enderror">
                            @error('paid_by')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                    </div>

                    <div class="form-group row mb-2">
                        <div class="col-12">
                            <label for="observations">Observações</label>
                            <textarea name="observations"
                                        id="observations"
                                        cols="30"
                                        rows="5"
                                        class="@error('observations') is-invalid @enderror">{{$bill->observations}}</textarea>
                            @error('observations')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </form>
                    <div class="form-group row mb-0">
                        <div class="col-12">
                            <button form="bills_form" type="submit" class="btn btn-primary">
                                {{ __('ATUALIZAR') }}
                            </button>

                            @can('delete entries')
                                @include('admin.bills._delete', ['large' => true])
                            @endcan
                        </div>
                    </div>

            </div>
        </div>
    </div>

    <script>
        const statusPago = '{{\App\Models\Status::STATUS_PAGO}}';
        const bill = @json($bill);


        $(document).ready(function () {
            let categories;

            async function getCategories() {
                await window.axios.get('/api/categories').then(function (response){
                    categories = response.data;
                    $("#category").html("");
                    // $("#category").append(/*html*/`<option value="">SEM CATEGORIA</option>`);
                    if( categories.length > 0 ){
                        categories.map(function(cat){
                            const selectedCategory = cat.id == bill.category_id ? 'selected' : '';
                            $("#category").append(/*html*/`<option value="${cat.id}" ${selectedCategory}>${cat.name}</option>`);
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
                                const selectedSubCategory = subcategory.id == bill.sub_category_id ? 'selected' : '';
                                $("#sub_category").append(/*html*/`<option value="${subcategory.id}" ${selectedSubCategory}>${subcategory.name}</option>`);
                            });
                        });
                    }
                })
            }

            getCategories();
            handleSubCategories();

            $("#status").change(function() {
                $("#paid_at, #paid_by").removeAttr("required");
                if( $("#status :selected").text() == statusPago ) {
                    $("#paid_at, #paid_by").attr("required", true);
                }
            }).change();

            $("#bills_form").submit(function(e){

                if( $("#status :selected").text() == statusPago ) {
                    const inputAmount = $('#amount').val();

                    const amount = Number(inputAmount.replace(/[^0-9-]+/g,"")) / 100;

                    if( amount <= 0){
                        e.preventDefault();
                        $('.amount_div').html(/*html*/`
                            <small class="text-primary font-weight-bold">Informe o valor real</small>
                        `);
                    }
                }
            });
        });

    </script>
@endsection
