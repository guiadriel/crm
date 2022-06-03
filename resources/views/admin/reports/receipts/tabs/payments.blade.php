<form method="GET" target="_blank" action="{{ route('reports.receipts.show') }}">
    @csrf

    <div class="row mb-2">
        <div class="col-12">
            <div class="ui-widget">
                <label for="contracts">Digite o código do contrato ou o nome do aluno: </label>
                <input id="contracts" required>
            </div>
        </div>
    </div>

    <div class="form-group row">
        <div class="col-6">
            <label class="my-1 mr-2" for="contract_payment">Selecione a parcela</label>
            <select name="contract_payment"
                    id="contract_payment"
                    class='w-100' required>
                <option value="">Nenhum contrato selecionado</option>
            </select>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <button type="submit" class="btn btn-primary">GERAR RECIBO</button>
        </div>
    </div>
</form>

<script>
    $( async function () {
        let resourceData;
        await window.axios.get('/api/contracts').then(function (response){
            resourceData = response.data;

            const autocompleteSource = resourceData.map(function(elm) {
                const payments = elm.payments.map(function({due_date,...rest}){
                    return {
                        raw_date: new Date(moment(due_date, 'DD/MM/YYYY')),
                        due_date,
                        ...rest
                    }
                })

                const sortedPayments = payments.sort((a, b) => b.raw_date - a.raw_date)
                return {
                    label: `[${elm.number}] ${elm.student.name}`,
                    value: `[${elm.number}] ${elm.student.name}`,
                    id: elm.id,
                    payments: sortedPayments
                };
            });

            $( "#contracts" ).autocomplete({
                minLength: 0,
                source: autocompleteSource,
                select: function( event, ui ) {
                    const options = ui.item.payments.map(function(elm){
                        const formattedValue = new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL'}).format(elm.value);
                        return /*html*/`<option value="${elm.id}">[${elm.due_date}] - ${formattedValue}</option>`;
                    });
                    $("#contract_payment").html( options.join("") );
                    return false;
                }
            });
        });


    });
</script>
