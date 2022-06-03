@extends('layouts.app')

@section('title', 'Contas a pagar')

@section('content')
    <div class="container">
        <form action="" method="get">

            <div class="row mb-4 d-flex align-items-center">
                <div class="col-auto">
                    <a href="{{ route('bills.create')}}" class='btn btn-primary'>NOVA CONTA</a>
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
                    <a href="{{ route('bills.index')}}" class="btn btn-outline-primary">LIMPAR FILTROS</a>
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
                            <div class="form-group row">
                                <div class="col-auto">
                                    <label for="type">Tipo</label>
                                    <select name="type"
                                            id="type"
                                            class="px-2 d-block">
                                        <option value="">TODOS</option>
                                        <option value="V">V</option>
                                        <option value="F">F</option>
                                    </select>
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


        <table class="table table-striped table-borderless table-sm">
            <thead>
                <tr>
                    <th scope="col">CATEGORIA / SUBCATEGORIA </th>
                    <th scope="col">DESCRIÇÃO</th>
                    <th scope="col">TIPO</th>
                    <th scope="col">STATUS</th>
                    <th scope="col">VALOR PROJETADO</th>
                    <th scope="col">VALOR REAL</th>
                    <th scope="col">DT. VENCIMENTO</th>
                    <th scope="col">&nbsp;</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($bills as $bill)
                    <tr>
                        <th class="align-middle" scope="row">
                            @if ( isset($bill->category))
                                <span
                                    data-tippy-content="{{$bill->category->name}}"
                                    class="badge badge-grey badge-primary text-truncate"
                                    style='max-width:75px;'>{{$bill->category->name}}</span>
                            @endif
                            @if ( isset($bill->subCategory))
                                <span
                                    data-tippy-content="{{$bill->subCategory->name}}"
                                    class="badge badge-grey badge-primary text-truncate"
                                    style='max-width: 75px;'>{{$bill->subCategory->name}}</span>
                            @endif
                        </th>
                        <td class="align-middle">{{$bill->description}}
                        @if ($bill->has_installments)
                        [{{$bill->sequence}}/{!! $bill->getTotalInstallments() !!}]
                        @endif
                        </td>
                        <td class="align-middle">{{$bill->type}}</td>
                        <td class="align-middle">{{$bill->status->description}}

                        </td>
                        <td class="align-middle">@money($bill->intended_amount)</td>
                        <td class="align-middle">@money($bill->amount)</td>
                        <td class="align-middle">{{$bill->due_date}}</td>
                        <td class="align-middle d-flex align-items-center justify-content-end">
                            @if ($bill->observations != "")
                                <span class="d-flex justify-content-center mr-2 " data-tippy-content="{{$bill->observations}}">
                                    <i class="material-icons text-secondary">comment_bank</i>
                                </span>
                            @endif

                            @can('edit entries')
                                <a href="{{route('bills.edit', $bill->id)}}" class='btn btn-sm btn-primary mr-1'>EDITAR</a>
                            @endcan

                            @can('delete entries')
                                @include('admin.bills._delete')
                            @endcan
                        </td>
                    </tr>
                @endforeach

                @if( $bills->total() == 0 )
                    <tr>
                    <td colspan="7">Nenhum registro encontrado</td>
                    </tr>
                @endif
            </tbody>
        </table>

        {{ $bills->links() }}

    </div>
@endsection
