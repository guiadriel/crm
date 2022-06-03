<div class="row mt-3 mb-4" >
    <div class="card border-primary w-100">
        <div class="card-body">
        <div class="row">
            <div class="col-12 d-flex align-items-center justify-content-between">
            <h5 class="card-title">ALUNOS NESSA TURMA</h5>
            <button class="btn btn-sm btn-success " id="toggleStudentModal" onClick="window.livewire.emit('toggleModal')">ADICIONAR ALUNO</button>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
            <table class="table-borderless table-striped w-100 p-0 m-0">
                <thead>
                <tr>
                    <th class='p-2' scope="row">NOME</th>
                    <th>EMAIL</th>
                    <th>TELEFONE</th>
                    <th>&nbsp;</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($groupclass->students->sortBy('name') as $student)
                    <tr>
                    <td class='p-2' scope="row">{{$student->name}}</td>
                    <td scope="row">{{$student->email}}</td>
                    <td scope="row">{{$student->phone}}</td>
                    <td scope="row" class='text-right pr-2'>
                        <a href=" {{ route('students.show', $student)}}" class="btn btn-sm btn-primary">VISUALIZAR</a>
                        @include('admin.class._detach')
                    </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            </div>
        </div>
        </div>
    </div>
</div>
