@extends('layouts.app')

@section('title', 'Agendamento')

@section('content')
    <div class="container">
        <livewire:schedules.calendar />
    </div>
@endsection
