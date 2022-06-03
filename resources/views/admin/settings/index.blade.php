@extends('layouts.app')
@section('title', 'Configurações')


@section('content')
    <div class="container">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Geral</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="roles-tab" data-toggle="tab" href="#roles" role="tab" aria-controls="roles" aria-selected="false">Funções (Roles) </a>
            </li>
        </ul>
        <div class="tab-content p-3" id="myTabContent">
            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                @include('admin.settings.tabs.general')
            </div>
            <div class="tab-pane fade" id="roles" role="tabpanel" aria-labelledby="roles-tab">
                @include('admin.settings.tabs.roles')
            </div>
        </div>
    </div>
@endsection
