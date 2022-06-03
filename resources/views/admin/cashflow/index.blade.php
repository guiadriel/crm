@extends('layouts.app')

@section('title', 'Fluxo de Caixa')
@section('head_styles')

@endsection

@section('content')
  <div class="container">
    <form method="GET" action="?" class="w-auto">
        <div class="row mb-3 d-flex justify-content-between">
            <div class="col">
                <h4 class='d-inline mr-2'><strong> Visão Geral</strong></h4>
                <select name="filter" id="filter"  class='custom-select w-25'>
                    <option value="current"  @if (request('filter') == 'current') selected @endif>MÊS VIGENTE</option>
                    <option value="30" @if (request('filter') == '30') selected @endif>30 DIAS</option>
                    <option value="15" @if (request('filter') == '15') selected @endif>15 DIAS</option>
                    <option value="10" @if (request('filter') == '10') selected @endif>10 DIAS</option>
                    <option value="5" @if (request('filter') == '5') selected @endif>5 DIAS</option>
                    <option value="1" @if (request('filter') == '1') selected @endif>1 DIA</option>
                    <option value="period">OUTRO</option>
                </select>
                <button class="btn btn-primary">FILTRAR</button>

            </div>
            <div class="col-auto text-right">
                <a href="{{ route('cashflow.export', ['initial_date' => request('initial_date'), 'final_date' => request('final_date')])}}" class='btn btn-primary btn-sm'>Exportar CSV / Excel</a>
            </div>
        </div>


        <!-- Modal -->
        <div class="modal fade" id="modal-filter" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Outros filtros</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                    </div>
                    <div class="modal-body">
                        Período de vencimento
                        <div class="row mb-1">
                            <div class="col-3">
                                <input type="text"
                                    name="initial_date"
                                    id="initial_date"
                                    placeholder="Dt. Inicial"
                                    class="mask-date"
                                    autocomplete="off"
                                    value="{{ request('initial_date')}}">
                            </div>
                            <div class="col-3">
                                <input type="text"
                                    name="final_date"
                                    id="final_date"
                                    placeholder="Dt. Final"
                                    class="mask-date"
                                    autocomplete="off"
                                    value="{{ request('final_date')}}">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">FECHAR</button>
                        <button type="submit" class="btn btn-primary">FILTRAR</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <div class="row mb-3">
      <div class="col">
        <div class="card card-body card-resume-money">
            <div>
                <span>Entradas</span>
                <span class="material-icons text-success">trending_up</span>
            </div>
            <p>@money($cards['income']) / <small>@money($cards['intended_income'])</small></p>
            <div class="progress" style="height: 5px;">
                <div class="progress-bar bg-success"
                     role="progressbar"
                     style="width: {{$cards['progress_income']}}%"
                     aria-valuenow="{{$cards['progress_income']}}"
                     aria-valuemin="0"
                     aria-valuemax="100"></div>
            </div>
        </div>
      </div>
      <div class="col">
        <div class="card card-body card-resume-money">
          <div>
            <span>Saídas</span>
            <span class="material-icons text-success">trending_down</span>
          </div>
          <p>@money($cards['outcome']) / <small>@money($cards['intended_outcome'])
          </small></p>

            <div class="progress" style="height: 5px;">
                <div class="progress-bar bg-danger"
                     role="progressbar"
                     style="width: {{$cards['progress_outcome']}}%"
                     aria-valuenow="{{$cards['progress_outcome']}}"
                     aria-valuemin="0"
                     aria-valuemax="100"></div>
            </div>
        </div>

      </div>
      {{-- <div class="col">
        <div class="card card-body card-resume-money">
          <div>
            <span>Projetado</span>
            <span class="material-icons text-secondary">gps_fixed</span>
          </div>
          <p class="m-0">@money($cards['intended'])</p>
        </div>
      </div> --}}
      <div class="col">
        <div class="card card-body card-resume-money">
          <div>
            <span>Total</span>
            <span class="material-icons text-warning">attach_money</span>
          </div>
          <p>@money($cards['total'])</p>
        </div>
      </div>
    </div>

    <div class="row mb-3">
      <div class="col-5">
        <div class="card card-body" style='min-height: 305px'>
            <canvas id="myChart" width="250" height="150"></canvas>
        </div>
      </div>

      <div class="col-7">
        <div class="card card-body"  style='min-height:280px;'>
            <div class="d-flex justify-content-between mb-2">
                <h5>Contratos pendentes do período</h5>
                <a href="{{ route('receipts.index')}}" class="btn btn-sm btn-outline-primary">Ver tudo</a>
            </div>


          <div style='height: 210px;max-height:210px; overflow-x:hidden;'>

          @php
              $totalEmAtraso = 0;
          @endphp
            @foreach ($contracts as $payment)
                @if ( $payment->student )


                <div class="card-contract">
                  <img class='rounded-circle' src="{{ isset($payment->student->avatar) && $payment->student->avatar != "" ? asset( $payment->student->avatar) : asset('images/avatar.svg') }} " alt="">
                  <div class="name">
                      <strong>{{$payment->student->name ?? ''}}</strong>
                      <p>Vence em: {{ $payment->due_date }}</p>
                  </div>
                  <div class="contact">
                      <strong>Telefone</strong>
                      <a target="_blank" class="d-block" href="@whatsapp($payment->student->phone)">{{$payment->student->phone ?? ''}}</a>
                  </div>
                  <p class='contract-value'>@money($payment->value)</p>
                  <a href="{{ route('contracts-payment.edit', $payment->id)}}" class='btn btn-sm btn-outline-dark d-flex align-items-center'>
                      <span class="material-icons">chevron_right</span>
                  </a>
                </div>
                @endif

                @php $totalEmAtraso += $payment->value @endphp
            @endforeach

            @if (count($contracts) == 0 )
                <small>Nenhum contrato pendente para o período selecionado</small>
            @endif
          </div>

          <div class="d-flex justify-content-end">Total em atraso: <h4 class="font-weight-bold ml-4 p-0 m-0">@money($totalEmAtraso)</h4></div>
        </div>
      </div>

    </div>

    <x-entries/>

  </div>
@endsection

@section('body_scripts')
    <script >
        var ctx = document.getElementById('myChart');


        $(function () {
            const jsonCategories = @json($chart['categories']);
            const arrDates = jsonCategories.filter(function(item, pos) { return jsonCategories.indexOf(item) == pos;});
            const query = @json($chart['query']);

            const generateDataset = query.map( function(res) {
                const chartStack = res.type;
                delete res.type;

                const chartColors = {
                    backgroundColor: chartStack == 'income' ? 'rgba(38,125,25, 0.1)' : 'rgba(167, 17, 25, 0.1)',
                    borderColor: chartStack == 'income' ? 'rgba(38,125,25, 1)' : 'rgba(167,17,25, 1)',
                    borderWidth: 1
                }

                const dataAttributes = Array(arrDates.length).fill(0);

                const idxDate = arrDates.findIndex(function( elm ) {
                    return elm == res.payment_date;
                })
                dataAttributes[idxDate] = res.total_entries;


                const returnValue = {
                    label: `${res.category} ${res.subcategory ? '- '+res.subcategory : ''}`,
                    stack: chartStack,
                    data: dataAttributes
                };

                const chart = Object.assign( returnValue, chartColors);
                return chart;
            });


           var myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: arrDates,
                    datasets: generateDataset
                },
                options: {
                    height: 150,
                    tooltips: {
                        mode: 'index',
                        intersect: false
                    },
                    legend: {
                        display: false
                    },
                    title: {
                        display: true,
                        text: 'Gráfico de entradas e saídas por data'
                    },
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true,
                                callback: function(value, index, values) {
                                    return value.toLocaleString("pt-BR",{style:"currency", currency:"BRL"});
                                }
                            },
                            stacked: true
                        }],
                        xAxes: [{
                            stacked: true
                        }]
                    }
                }
            });

            $("#filter").change(function(){
                if($(this).val() == 'period'){
                    $("#modal-filter").modal("show");
                }
            });
        });

    </script>
@endsection
