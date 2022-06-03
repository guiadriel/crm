@extends('layouts.app')

@section('title', 'Relatórios / Alunos / Detalhes de cancelamento')

@section('content')


<div class="container">
    <div class="row d-flex justify-content-between">
        <div class="col-auto d-flex align-items-center">
            <h5 class="pl-3 m-0">Detalhes de cancelamentos </h5>
        </div>
    </div>
    <hr>

    <div class="row d-flex justify-content-center">
        <div class="col-12">
            <table class="table table-borderless table-sm table-hover">
                <thead>
                    <tr>
                        <th class="">&nbsp;</th>
                        <th class="">Nome do aluno</th>
                        <th class="">Email</th>
                        <th class="">Número do contrato</th>
                        <th class="text-center">Telefone</th>
                        <th class="text-center">Dt. de cadastro</th>
                        <th class="text-center">Ultima atualização</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($students as $student)
                        <tr>
                            <td class="align-middle"> <img src="{{$student->avatar ?? asset('images/avatar.svg') }}" alt="" height="35" width="35" style='border-radius:50%;'> </td>
                            <td class="align-middle">{{$student->name}}</td>
                            <td class="align-middle">{{$student->email}}</td>
                            <td class="align-middle">
                                @if ($student->hasActiveContract())
                                    <a href="{{ route('contracts.edit', $student->lastContractActive()->id)}}">
                                        {{$student->lastContractActive()->number ?? ''}}
                                    </a>
                                @endif
                                </td>
                            <td class="align-middle text-center">{{$student->phone}}</td>
                            <td class="align-middle text-center">{{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$student->created_at)->format('d/m/Y H:i')}}</td>
                            <td class="align-middle text-center">{{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$student->updated_at)->format('d/m/Y H:i')}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection


