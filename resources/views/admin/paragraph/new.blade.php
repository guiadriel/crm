@extends('layouts.app')

@section('title', "Novo paragráfo da turma")

@section('content')
    <div class="container">
        <div class="row mb-4 d-flex align-items-center">
            <div class="col-auto d-flex align-items-center">
                <a href="{{ url()->previous() }}" class='btn btn-primary'>VOLTAR</a>
                <span class='pl-3'>Cadastrar novo parágrafo</span>
            </div>
        </div>

        <div class="row">
            <div class="col-auto">
                <p class="m-1">Turma</p>
                <h5>
                    <span class="d-block badge badge-white">{{$groupclass->name}}</span>
                </h5>
            </div>
            <div class="col-auto">
                <p class="m-1">Tipo</p>
                <h5>
                    <span class="d-block badge badge-white">{{$groupclass->type}}</span>
                </h5>
            </div>
            @if ( isset($groupclass->teacher))
                <div class="col-auto">
                    <p class="m-1">Professor da Turma</p>
                    <h5>
                        <span class="d-block badge badge-white">{{$groupclass->teacher->name}}</span>
                    </h5>
                </div>
            @endif
        </div>

        <hr>

        <form action="{{ route('paragraph.store', ['class_id' => $groupclass->id])}}" method="POST">
            @csrf
            @method('POST')

            <div class="row">
                <div class="col-8">
                    <div class="form-group row">

                        <div class="col-4">
                            <label for="date">Data</label>
                            <input type="text"
                                    name="date"
                                    id="date"
                                    value="{{ date('d/m/Y') }}"
                                    class="@error('date') is-invalid @enderror mask-date"
                                    required autofocus>

                            @error('date')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="col-4">
                            <label class="my-1 mr-2" for="teacher">Professor</label>
                            <select name="teacher"
                                    id="teacher"
                                    class='w-100'>
                                @foreach ($teachers as $teacher)
                                    <option value="{{$teacher->id}}"
                                        @if (isset($groupclass->teacher) && $teacher->id === $groupclass->teacher->id)
                                            selected
                                        @endif
                                    >{{$teacher->name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-4">
                            <label class="my-1 mr-2" for="book">Book</label>
                            <select name="book"
                                    id="book"
                                    class='w-100'>
                                @foreach ($books as $book)
                                    <option value="{{$book->id}}"
                                    >{{$book->name}}</option>
                                @endforeach
                            </select>
                        </div>


                    </div>

                    <div class="form-group row">
                        <div class="col-4">
                            <label for="page">Page</label>
                            <input type="text"
                                    name="page"
                                    id="page"
                                    value="{{ old('page') }}"
                                    class="@error('page') is-invalid @enderror"
                                    required autofocus>

                            @error('page')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-4">
                            <label for="last_word">STOP</label>
                            <input type="text"
                                    name="last_word"
                                    id="last_word"
                                    value="{{ old('last_word') }}"
                                    class="@error('last_word') is-invalid @enderror"
                                    required autofocus>

                            @error('last_word')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                </div>
                <div class="col-4">
                    <label for="activity">Activity (Segure ctrl para selecionar)</label>
                    <select name="activity[]"
                            id="activity"
                            class='w-100'
                            style='height:125px;'
                            multiple="multiple">
                        @foreach ($books as $book)
                            @if ($loop->first)
                                @foreach ($book->activities as $activity)
                                    <option value="{{$activity->name}}">{{$activity->name}}</option>
                                @endforeach
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>



            <div class="form-group row mb-2">
                <div class="col-12">
                    <label for="observations">Observações</label>
                    <textarea name="observations" id="observations" cols="30" rows="5" class="@error('name') is-invalid @enderror"></textarea>
                    @error('observations')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <hr>

            <h5>Controle de presença</h5>

            @if ($groupclass->type === \App\Models\GroupClass::TYPE_VIP)
                <div class="row">
                    <div class="col-12">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="is_absent" name="is_absent">
                            <label class="custom-control-label" for="is_absent">Não compareceu</label>
                        </div>
                    </div>
                </div>
            @else

                @include('admin.frequencies._table-frequencies')

            @endif



            <div class="form-group row mb-0 mt-3">
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">
                        {{ __('SALVAR PARÁGRAFO') }}
                    </button>
                </div>
            </div>

        </form>
    </div>
@endsection


@section('body_scripts')
    <script>
        const bookInput = document.querySelector("#book");

        bookInput.addEventListener('change', async (evt) => {
            const book = evt.target.value;
            await window.axios.get(`/api/books/${book}/activities`)
                .then(function(response) {
                if(response.status === 200){
                    const results = response.data.map(function( elm){
                    return /*html*/`<option value="${elm.name}">${elm.name}</option>`;
                    });

                    $("#activity").html("").append(results.join(""));
                }
            });
        });
    </script>

@endsection
