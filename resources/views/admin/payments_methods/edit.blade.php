@extends('layouts.app')

@section('title', "Editar método [$method->description]")

@section('content')
  <div class="container">
    <div class="row mb-4 d-flex align-items-center">
      <div class="col-auto d-flex align-items-center">
        <a href="{{ route('payment-methods.index')}}" class='btn btn-primary'>VOLTAR</a>
        <span class='pl-3'>Editar método de pagamento</span>
      </div>
    </div>
    <form  name="updateForm" id="updateForm" action="{{ route('payment-methods.update', $method) }}" method="POST">
      @csrf
      {{ method_field('PUT') }}

      <div class="form-group row">
        <div class="col-6">
          <label for="description">Método</label>
          <input type="text"
                  name="description"
                  id="description"
                  value="{{$method->description}}"
                  placeholder="Descrição do método"
                  class="@error('description') is-invalid @enderror"
                  required>
        </div>
        <div class="col-6">
            <label class="my-1 mr-2" for="status">Status</label>
            <select name="status"
                    id="status"
                    class='w-100'>
                @foreach ($statuses as $status)
                    <option value="{{$status->id}}"
                    @if($status->id === $method->status_id)
                      selected
                     @endif
                    >{{$status->description}}</option>
                @endforeach
            </select>
        </div>
      </div>

        <div class="row form-group">
            <div class="col-3">
                <label for="category">Categoria</label>
                <select name="category" id="category" class='form-control'>
                    @foreach ($categories as $category)
                        <option value="{{$category->id}}"
                        @if ($method->category_id === $category->id)
                            selected
                        @endif
                        >{{$category->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-3">
                <label for="subcategory">Sub-categoria</label>
                <select name="subcategory" id="subcategory" class='form-control'>
                    @if ($method->category_id)
                        @foreach ($method->category->subCategories as $subCategory)
                            <option value="{{$subCategory->id}}"
                                @if ($method->sub_category_id === $subCategory->id)
                                    selected
                                @endif
                            >{{$subCategory->name}}</option>
                        @endforeach
                    @endif
                </select>
            </div>
        </div>
    </form>
    <button type="submit" class="btn btn-primary" form="updateForm">SALVAR</button>
    @include('admin.payments_methods._delete', ['large' => true])
  </div>


<script>
    // let categories = @json($categories);
    let selectedCategory = @json($method->category_id);

    async function getCategories() {
        await window.axios.get('/api/categories').then(function (response){
            categories = response.data;
            $("#category").html("");
            $("#category").append(/*html*/`<option value="">SEM CATEGORIA</option>`);
            if( categories.length > 0 ){
                categories.map(function(cat){
                    const selected = cat.id == selectedCategory ? 'selected' : '';
                    $("#category").append(/*html*/`<option value="${cat.id}" ${selected}>${cat.name}</option>`);
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
