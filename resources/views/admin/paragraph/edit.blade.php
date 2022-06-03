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
                    <span class="d-block badge badge-white">{{$paragraph->groupclass->name}}</span>
                </h5>
            </div>
            <div class="col-auto">
                <p class="m-1">Professor da Turma</p>
                <h5>
                    <span class="d-block badge badge-white">{{isset($paragraph->groupclass->teacher) && $paragraph->groupclass->teacher->name}}</span>
                </h5>
            </div>
        </div>

        <hr>

        <form action="{{ route('paragraph.update', $paragraph)}}" method="POST">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-8">
                    <div class="form-group row">

                        <div class="col-4">
                            <label for="date">Data</label>
                            <input type="text"
                                    name="date"
                                    id="date"
                                    value="{{ $paragraph->date }}"
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
                                        @if (isset($paragraph->teacher_id) && $teacher->id === $paragraph->teacher_id)
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
                                        @if (isset($paragraph->book) && $book->id === $paragraph->book->id)
                                            selected
                                        @endif
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
                                    value="{{ $paragraph->page }}"
                                    class="@error('page') is-invalid @enderror"
                                    required autofocus>

                            @error('page')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-4">
                            <label for="last_word">Stop</label>
                            <input type="text"
                                    name="last_word"
                                    id="last_word"
                                    value="{{ $paragraph->last_word }}"
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
                    <label for="activity">Activity (Segure Ctrl para selecionar)</label>
                    <select name="activity[]"
                            id="activity"
                            class='w-100'
                            style="height: 126px;"
                            multiple="multiple">
                        @php
                            $selected_activities = explode("|", $paragraph->activity);
                        @endphp
                        @foreach ($books as $book)
                            @if (isset($paragraph->book) && $book->id === $paragraph->book->id)

                                @foreach ($book->activities as $activity)
                                    <option value="{{$activity->name}}"
                                        @if (isset($paragraph->activity) && in_array($activity->name, $selected_activities) )
                                            selected
                                        @endif
                                    >{{$activity->name}}</option>
                                @endforeach
                            @endif
                        @endforeach
                    </select>
                </div>

            </div>




            <div class="form-group row mb-2">
                <div class="col-12">
                    <label for="observations">Observações</label>
                    <textarea name="observations" id="observations" cols="30" rows="5" class="@error('name') is-invalid @enderror">{{$paragraph->observation}}</textarea>
                    @error('observations')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

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


            <div class="form-group row mb-0">
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
