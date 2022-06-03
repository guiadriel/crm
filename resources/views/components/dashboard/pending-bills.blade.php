<div {{ $attributes->merge(['class' => 'card mb-2'])  }} >
  <div class="card-body">

      <div class="d-flex justify-content-between mb-2">
          <div>
              <h5 class="mb-3">Próximas contas a pagar</h5>
          </div>
          <div>
              <a href="{{ route('bills.index')}}" class="btn btn-sm btn-primary">Ver tudo</a>
          </div>
      </div>


    <div style='max-height:210px; overflow-x:hidden;'>

        @foreach ($bills as $bill)
            <div class="card-contract">
                <div>
                    <strong>{{$bill->description}}</strong>
                    <p>Vence em: {{ $bill->due_date}}</p>
                </div>


                <div class="d-flex align-items-center">
                    <p class="mr-2">@money($bill->intended_amount)</p>
                    <a href="{{ route('bills.edit', $bill)}}" class="btn btn-outline-primary">EDITAR</a>
                </div>
            </div>

        @endforeach

    </div>
  </div>
</div>
