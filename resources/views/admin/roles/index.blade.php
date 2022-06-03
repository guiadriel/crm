@extends('layouts.app')

@section('title', 'Funções')
@section('content')

<div class="container">
    <div class="row mb-4 d-flex align-items-center">
        <div class="col-12">
            <div class="pull-right">
                @can('create roles')
                    <a href="{{ route('roles.create')}}" class='btn btn-primary'>Cadastrar uma nova função</a>
                @endcan
            </div>
        </div>
    </div>

        @if ($message = Session::get('success'))
            <div class="alert alert-success">
            <p>{{ $message }}</p>
            </div>
        @endif
        <table class="table table-striped table-borderless">
            <tr>
                <th>No</th>
                <th>NOME</th>
                <th width="280px">AÇÕES</th>
            </tr>
            @foreach ($roles as $key => $role)
            <tr>
                <td>{{ ++$key }}</td>
                <td>{{ $role->name }}</td>
                <td>
                    @if($role->name !== "Super Admin")
                        @can('edit roles')
                        <a class="btn btn-sm btn-primary" href="{{ route('roles.edit',$role->id) }}">Editar</a>
                        @endcan

                        @can('delete roles')
                            @include('admin.roles._delete')
                        @endcan
                    @endif
                </td>
            </tr>
            @endforeach
        </table>
        {!! $roles->render() !!}
</div>

@endsection
