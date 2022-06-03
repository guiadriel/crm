
            <form method="POST" action="{{ route('schedules.store') }}">
                @csrf

                @if($errors->any())
                    <div class="alert alert-danger" role="alert">
                        {{$errors->first()}}
                    </div>

                @endif

                <div class="form-group row">
                    <div class="col-auto">
                        <label for="initial_date" class="d-block">Data Inicial</label>
                        <input type="text"
                                name="initial_date"
                                id="initial_date"
                                value="{{ old('initial_date') }}"
                                class="@error('initial_date') is-invalid @enderror mask-datetimepicker"
                                placeholder="__/__/__  __:__:__"
                                autocomplete="off"
                                required autofocus>

                        @error('initial_date')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="col-auto">
                        <label for="final_date" class="d-block">Data final</label>
                        <input type="text"
                                name="final_date"
                                id="final_date"
                                value="{{ old('final_date') }}"
                                class="@error('final_date') is-invalid @enderror mask-datetimepicker"
                                placeholder="__/__/__  __:__:__"
                                autocomplete="off"
                                required autofocus>

                        @error('final_date')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                </div>

                <div class="row mb-3">
                    <div class="col-5">
                        <label for="name">Título</label>
                        <input type="text"
                                name="name"
                                id="name"
                                value="{{ old('name', isset($student->id) ? 'Aula Show' : "") }}"
                                class="@error('name') is-invalid @enderror"
                                required autofocus>

                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="col-5 input-group d-flex">
                        <label for="student">Selecione o aluno</label>
                        <input type="text"
                                name="student"
                                id="student"
                                readonly
                                @if ( request()->has('student_id'))
                                    value="{{ $student->name ?? ""}}"
                                @else
                                    value="{{ old('student') }}"
                                @endif

                                class="@error('student') is-invalid @enderror"
                                placeholder="Clique na lupa para selecionar o aluno"
                                autofocus>

                        <input type="hidden"
                                id="student_id"
                                name="student_id"
                                @if ( request()->has('student_id'))
                                    value="{{ $student->id  ?? ""}}"
                                @else
                                    value="{{ old('student') }}"
                                @endif
                        >

                        @error('student')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="col-2 d-flex align-items-end">
                        <button type="button" class='btn btn-primary w-100' data-toggle="modal" data-target="#modalSearchStudents">
                            <i class="material-icons align-middle">search</i>
                        </button>
                    </div>

                </div>

                <div class="form-group row">
                    <div class="col-6">
                        <label class="my-1 mr-2" for="groupclass">Turma</label>
                        <select name="groupclass"
                                id="groupclass"
                                class='w-100'>
                            <option value="">Selecione a turma</option>

                            @foreach ($groupclasses as $class)
                                <option value="{{$class->id}}">{{$class->name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-6">
                        <label class="my-1 mr-2" for="teacher">Professor</label>
                        <select name="teacher"
                                id="teacher"
                                class='w-100'>
                            <option value="">Selecione o professor</option>
                            @foreach ($teachers as $teacher)
                                <option value="{{$teacher->id}}">{{$teacher->name}}</option>
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

                <div class="form-group row mb-0">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">
                            {{ __('SALVAR AGENDAMENTO') }}
                        </button>
                    </div>
                </div>
            </form>
