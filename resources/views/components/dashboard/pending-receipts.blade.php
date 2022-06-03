<div {{ $attributes->merge(['class' => 'card mb-2'])  }} >
  <div class="card-body">
        <div class="d-flex justify-content-between mb-2">
          <div>
              <h5 class="mb-3">Contas a receber</h5>
          </div>
          <div>
              <a href="{{ route('bills.index')}}" class="btn btn-sm btn-primary">Ver tudo</a>
          </div>
      </div>

        <div style='max-height:210px; overflow-x:hidden;'>

            @foreach ($receipts as $receipt)
                @if (isset($receipt->contract->student))

                    <div class="card-contract">
                        <img class='rounded-circle' src="{{ isset($receipt->contract->student->avatar) && $receipt->contract->student->avatar != "" ? asset( $receipt->contract->student->avatar) : asset('images/avatar.svg') }} " alt="">
                        <div class="name">
                            <strong>{{$receipt->contract->student->name}}</strong>
                            <p>Vence em: {{ $receipt->expected_date }}</p>
                        </div>
                        <div class="contact">
                            <strong>Telefone</strong>
                            <a target="_blank" class="d-block" href="@whatsapp($receipt->contract->student->phone)">{{$receipt->contract->student->phone}}</a>
                        </div>
                        <p class='contract-value'>@money($receipt->amount)</p>
                        <a href="{{ route('contracts-payment.edit', $receipt->contract_id)}}" class='btn btn-sm btn-outline-dark d-flex align-items-center'>
                            <span class="material-icons">chevron_right</span>
                        </a>
                    </div>

                @else
                    <div class="card-contract">
                        {{$receipt->description}}

                        <a href="{{ route('receipts.edit', $receipt)}}" class="btn btn-outline-primary">VER</a>
                    </div>
                @endif


            @endforeach

        </div>

  </div>
</div>
