@extends('layouts.app')

@section('title', 'Contas a receber')

@section('content')

    @method('GET')
    <div class="container">

        <form action="" method="get">

            <div class="row mb-4 d-flex align-items-center">
                <div class="col-auto">
                    <a href="{{ route('receipts.create')}}" class='btn btn-primary'>NOVO RECEBIMENTO</a>
                </div>

                <div class="col-3">
                    <input type="text"
                           name="description"
                           id="description"
                           placeholder="Busque pela descrição"
                           value="{{ request('description')}}">
                </div>
                <div class="col-auto">
                    <select name="status"
                            id="status"
                            class="px-2">
                        <option value="">TODOS</option>
                        @foreach ($statuses as $status)
                            <option value="{{$status->id}}"
                            @if (request('status') == $status->id)
                                selected
                            @endif
                                >{{$status->description}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-auto">
                    <button type="button"
                            class="btn btn-outline-primary d-flex align-items-center"
                            title="Outros filtros"
                            data-toggle="modal" data-target="#modal-filter">
                        <span class="material-icons">filter_list</span>
                    </button>

                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-primary">FILTRAR</button>
                    <a href="{{ route('receipts.index')}}" class="btn btn-outline-primary">LIMPAR FILTROS</a>
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
                            <div class="row">
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

        <div class="row">
            <div class="col-12">
                <table class="table table-striped table-borderless table-sm">
                            <thead>
                                <tr>

                                    <th scope="col">DESCRIÇÃO</th>
                                    <th scope="col">TIPO</th>
                                    <th scope="col" class="text-center">STATUS</th>
                                    <th scope="col">VALOR</th>
                                    <th scope="col">DT. VENC.</th>
                                    <th scope="col">COD. BOLETO</th>
                                    <th scope="col">CATEGORIA / SUBCATEGORIA </th>
                                    <th scope="col">&nbsp;</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($receipts as $receipt)
                                    <tr
                                    class="@if ($receipt->contractPayment && $receipt->contractPayment->bill_second_generation) text-blue @endif">
                                        <td class="align-middle">
                                            @if ($receipt->contract_id)
                                                <a target="_blank"
                                                href="{{ route('contracts.edit', $receipt->contract_id) }}"
                                                title="ALUNO: {{$receipt->contract->student->name ?? ''}}"
                                                class="btn btn-sm btn-primary">
                                                    {{$receipt->description}}
                                                    @if ( isset($receipt->contract->student->name) )
                                                        [<small >{{$receipt->contract->student->nickname ?? ''}}</small>]
                                                    @endif
                                                </a>
                                            @else
                                                {{$receipt->description}}
                                            @endif
                                        </td>
                                        <td class="align-middle">{{$receipt->type}}</td>
                                        <td class="text-center align-middle">{{$receipt->status->description}}
                                            @if ($receipt->status->description == App\Models\Status::STATUS_PAGO)
                                                <small class="d-block m-0 p-0">{{$receipt->paid_at}}</small>
                                            @endif
                                        </td>
                                        <td class="align-middle">
                                            @if ($receipt->interest > 0)
                                                <span title="Total: @money($receipt->amount) + Juros: @money($receipt->interest)" class="text-primary">
                                                    @money($receipt->amount + $receipt->interest)*
                                                </span>
                                            @else
                                                @money($receipt->amount)
                                            @endif
                                        </td>
                                        <td class="align-middle">{{$receipt->expected_date}}</td>
                                        <td class="align-middle">
                                            @if ($receipt->contractPayment)
                                            {{$receipt->contractPayment->bill_bank_code}}
                                            @endif
                                        </td>
                                        <th scope="row">
                                            @if ( isset($receipt->category))
                                                <span class="badge badge-grey badge-primary">{{$receipt->category->name}}</span>
                                            @endif
                                            @if ( isset($receipt->subCategory))
                                                <span class="badge badge-grey badge-primary">{{$receipt->subCategory->name}}</span>
                                            @endif
                                        </th>
                                        <td class="text-right align-middle">
                                            @can('edit entries')
                                                @if ($receipt->contract_payment_id)
                                                <a href="{{route('contracts-payment.edit', $receipt->contract_payment_id)}}"
                                                    class='btn btn-sm btn-primary'>EDITAR PGTO</a>
                                                @else
                                                    <a href="{{route('receipts.edit', $receipt->id)}}"
                                                    class='btn btn-sm btn-primary'>EDITAR</a>
                                                @endif
                                            @endcan

                                            @if (!$receipt->contract_id)
                                                @can('delete entries')
                                                    @include('admin.receipts._delete')
                                                @endcan
                                            @endif

                                        </td>
                                    </tr>
                                @endforeach

                                @if( $receipts->total() == 0 )
                                    <tr>
                                    <td colspan="7">Nenhum registro encontrado</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>

            </div>
        </div>



        {{ $receipts->links() }}

    </div>



@endsection
