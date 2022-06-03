<div class='entry-component'>
    <div class="row mb-4">
        <div class="col-12">
            <div class="card card-body">
                <div class="row">
                    <div class="col-10">Lançamentos</div>
                    {{-- @can('create entries') --}}
                        {{-- <div class="col-2">
                            <button class='btn btn-sm btn-primary font-weight-bold' data-toggle="modal" data-target="#modal-entries-new">NOVO LANÇAMENTO</button>
                        </div> --}}
                    {{-- @endcan --}}
                </div>
                <table id="tbl-entries-info" class="table table-borderless table-condensed">
                    <thead>
                        <th>Título</th>
                        <th class='text-right'>Valor</th>
                        <th>Categoria</th>
                        <th>SubCategoria</th>
                        <th>Contrato</th>
                        <th>Observações</th>
                        <th>Data</th>
                        <th>Dt. Pagamento</th>
                    </thead>
                    <tbody>
                    </tbody>
                    <tfoot>
                        <tr class='border-top'>
                            <td class='font-weight-bold'>Total</td>
                            <td class='text-right font-weight-bold entries-total'>R$ 0,00</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="modal-entries-new" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <form id="modal-form-new" name="modal-form-new" action="{{ route('entries.store')}}" method="POST">
                @csrf
                @method('POST')
                <div class="modal-body">
                    <div class="row form-group">
                        <div class="col-12">
                            <label for="modal_description">Descrição</label>
                            <input type="text"
                                name="modal_description"
                                id="modal_description"
                                class="form-control"
                                value=""
                                required>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-3">
                            <label for="modal_type">Tipo</label>
                            <select name="modal_type" id="modal_type" class='form-control' required>
                                <option value="income">ENTRADA</option>
                                <option value="outcome">SAIDA</option>
                            </select>
                        </div>
                        <div class="col-3">
                            <label for="modal_value">Valor (R$)</label>
                            <input type="text"
                                name="modal_value"
                                id="modal_value"
                                class="form-control mask-money text-center font-weight-bold"
                                value=""
                                required>
                        </div>
                        <div class="col-3">
                            <label for="modal_category">Categoria</label>
                            <select name="modal_category" id="modal_category" class='form-control'></select>
                        </div>
                        <div class="col-3">
                            <label for="modal_subcategory">Sub-categoria</label>
                            <select name="modal_subcategory" id="modal_subcategory" class='form-control'></select>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-12">
                            <label for="modal_observation">Observações</label>
                            <textarea name="modal_observation" id="modal_observation" class='form-control' rows="3"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">Fechar</button>
                    <button type="submit" class="btn btn-primary">SALVAR</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script async defer>
    const Entry = (function(){
        let categories;

        async function add() {
            $('#modal-entries-new').modal('close');
            get();
        }

        async function getCategories() {
            await window.axios.get('../api/categories').then(function (response){
                categories = response.data;
                $("#modal_category").html("");
                $("#modal_category").append(/*html*/`<option value="">SEM CATEGORIA</option>`);
                if( categories.length > 0 ){
                    categories.map(function(cat){
                        $("#modal_category").append(/*html*/`<option value="${cat.id}">${cat.name}</option>`);
                    } );
                }
            });
        }

        async function handleSubCategories()
        {
            const modalCategory = document.querySelector("#modal_category");
            const modalSubCategories = document.querySelector("#modal_subcategory");

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
                            $("#modal_subcategory").append(/*html*/`<option value="${subcategory.id}">${subcategory.name}</option>`);
                        });
                    });
                }
            })
        }

        async function get() {

            $(".entry-component").LoadingOverlay('show');
            const urlParams = new URLSearchParams(window.location.search);
            const filter = urlParams.get('filter');
            const initial_date = urlParams.get('initial_date');
            const final_date = urlParams.get('final_date');
            await window.axios.get('../api/entries', { params: {
                filter, initial_date, final_date
            }}).then(function (response){
                if( response.status === 200 ){
                    const entries = response.data.data;
                    let total = 0;
                    const rows = entries.map(function (elm){

                        const formattedValue = new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL'}).format(elm.value);
                        const date = moment(new Date(elm.created_at), 'MM/DD/YYYY').format('DD/MM/YYYY HH:MM:SS');
                        const paymentDate = elm.payment_date
                        const textColor = elm.type == 'income' ? 'text-success' : 'text-danger';

                        if( elm.type == 'income'){
                            total += parseFloat(elm.value);
                        }

                        if( elm.type == 'outcome'){
                            total -= parseFloat(elm.value);
                        }

                        const contractNumber = elm.contract?.number ? elm.contract.number : '';
                        return /*html*/`
                        <tr>
                            <td>${elm.description}</td>
                            <td class='text-right'><strong class='${textColor}'>${formattedValue}</strong></td>
                            <td>
                                ${ elm.category_id ? /*html*/`<span class='badge badge-secondary'>${elm.category?.name}</span>` : 'SEM CATEGORIA'}
                            </td>
                            <td>
                                ${ elm.sub_category_id ? /*html*/`<span class='badge badge-secondary'>${elm.sub_category?.name}</span>` : 'SEM CATEGORIA'}
                            </td>
                            <td>${contractNumber}</td>
                            <td>${elm.observations ?? ''}</td>
                            <td>${date}</td>
                            <td>${paymentDate}</td>
                        </tr>`;
                    });

                    $("#tbl-entries-info tbody").html(rows);

                    const totalFormatted = new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL'}).format(total);
                    $(".entries-total").text(totalFormatted);
                }
            });
            $(".entry-component").LoadingOverlay('hide');

        }

        function init() {
            getCategories();

            handleSubCategories();
        }

        return {
            add: add,
            get: get,
            init
        };
    }());


    $(function () {
        Entry.init();
        Entry.get();

        $('#modal-entries-new').on('shown.bs.modal', function () {
            $('#modal_description').trigger('focus');
        });

    });


</script>
