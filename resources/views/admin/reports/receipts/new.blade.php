@extends('layouts.app')

@section('title', 'Relatórios / Recibos')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h5>Gerador de recibos</h5>
                <hr>
            </div>
        </div>

        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link active" id="parcelas-tab" data-toggle="tab" href="#parcelas" role="tab" aria-controls="parcelas" aria-selected="true">Parcelas</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="manual-tab" data-toggle="tab" href="#manual" role="tab" aria-controls="manual" aria-selected="false">Manual</a>
            </li>
        </ul>
        <div class="tab-content p-3" id="myTabContent">
            <div class="tab-pane fade show active" id="parcelas" role="tabpanel" aria-labelledby="parcelas-tab">
                @include('admin.reports.receipts.tabs.payments')
            </div>
            <div class="tab-pane fade" id="manual" role="tabpanel" aria-labelledby="manual-tab">
                @include('admin.reports.receipts.tabs.manual')
            </div>
        </div>
    </div>
@endsection
