@extends('layouts.app')

@section('title', 'Modelos de contratos')

@section('content')
<div class="container">
    <div class="row mb-4 d-flex align-items-center">
      <div class="col-auto d-flex align-items-center">
        <a href="{{ url()->previous() }}" class='btn btn-primary'>VOLTAR</a>
        <span class='pl-3'>Gerar contrato</span>
      </div>
    </div>

    <hr>

    <div class="row">
      <div class="col-12">
        <p class="m-0 p-0">Aluno</p>
        <h5 class="font-weight-bold"><span class="badge badge-white">{{$contract->student->name}}</span></h5>
      </div>
      <div class="col-auto">
        <p class="m-0 p-0">Contrato</p>
        <h5 class="font-weight-bold"><span class="badge badge-white">{{$contract->number}}</span></h5>
      </div>
      <div class="col-auto">
        <p class="m-0 p-0">Data de início</p>
        <h5 class="font-weight-bold"><span class="badge badge-white">{{$contract->start_date}}</span></h5>
      </div>
      <div class="col-auto">
        <p class="m-0 p-0">Vencimento (Dia) </p>
        <h5 class="font-weight-bold"><span class="badge badge-white">{{$contract->payment_due_date}}</span></h5>
      </div>
      <div class="col-auto">
        <p class="m-0 p-0">Valor do contrato </p>
        <h5 class="font-weight-bold"><span class="badge badge-white">@money($contract->payment_total)</span></h5>
      </div>
    </div>


    <hr>
    <form method="POST" action="{{ route('contracts.renderpdf', $contract) }}">
        @csrf
        @method('POST')

        <div class="row mb-3">
            <div class="col-12">
                <textarea class="description" name="description" id="description">{{$contractfile->content_html ?? ''}}</textarea>
            </div>
        </div>
        <div class="form-group row mb-0">
            <div class="col-12">
                <input type="submit" name="action" formtarget="_blank" class="btn w-auto btn-outline-primary mr-2" value="PREVIEW">
                <input type="submit" name="action" class="btn w-auto btn-primary" value="SALVAR E GERAR PDF">
            </div>
        </div>
    </form>

</div>
    <script src="{{ asset('node_modules/tinymce/tinymce.js') }}"></script>
    <script>
        const models = @json($models);
        const contract = @json($contract);
        const responsible = @json($responsible);

        function templateGenerator(contract) {
            var objectGenerator = {};

            for( studentAttribute in contract.student ){
                var formattedAttribute = contract.student[studentAttribute] !== null
                    ? contract.student[studentAttribute]
                    : '____________________';

                objectGenerator[`student.${studentAttribute}`] = formattedAttribute;
            }

            if(responsible){
                for( responsibleAttribute in responsible ){
                    var formattedAttribute = contract.student[responsibleAttribute] !== null
                        ? contract.student[responsibleAttribute]
                        : '____________________';

                    objectGenerator[`responsible.${responsibleAttribute}`] = formattedAttribute;
                }
            }


            for( contractAttribute in contract ){
                var formattedAttribute = contract[contractAttribute] !== null
                    ? contract[contractAttribute]
                    : '____________________';
                objectGenerator[`contract.${contractAttribute}`] = formattedAttribute;
            }

            return objectGenerator;
        }

        const templateValues = templateGenerator(contract);

        tinymce.init({
            selector:'textarea.description',
            height: 500,
            menubar: 'custom',
            menu: {
                custom: { title: 'Modelos', items: 'models' }
            },
            setup: function(editor){
                var toggleState = false;

                const items = models.map( function( model ) {
                    return {
                        type: 'menuitem',
                        text: `Modelo: ${model.title}`,
                        onAction: function () {
                            editor.execCommand('mceInsertTemplate', false, `${model.description}`);
                        }
                    }
                });

                editor.ui.registry.addMenuButton('models', {
                    text: 'Modelos',
                    fetch: function (callback) {
                        callback(items);
                    }
                });

            },
            template_replace_values: templateValues,
            templates: [
                {
                    title: "VIP",
                    description: "Modelo VIP",
                    content: `<p>Nome: {$student['name']}</p>`
                }
            ],
            plugins: [
                'advlist autolink lists link image charmap print preview anchor',
                'searchreplace visualblocks code fullscreen',
                'insertdatetime media table paste code help wordcount',
                'template'
            ],
            toolbar: 'models | undo redo | formatselect | ' +
            'bold italic backcolor | alignleft aligncenter ' +
            'alignright alignjustify | bullist numlist outdent indent | ' +
            'removeformat | help preview ',
            content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }'
        });
    </script>
@endsection
