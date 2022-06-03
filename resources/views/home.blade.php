@extends('layouts.app')

@section('title', 'CRM')

@section('content')
<div class="container">

    <div class="row">
        <div class="col-6">
            <x-dashboard.welcome-card/>
            <x-dashboard.daily-schedule />
            <x-dashboard.birthdays />
        </div>
        <div class="col-6">
            <x-dashboard.pending-bills />
            <x-dashboard.pending-receipts />
        </div>
    </div>

</div>
@endsection
