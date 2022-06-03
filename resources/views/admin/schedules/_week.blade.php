<form method="POST" action="{{ route('periodic-schedules.store') }}">
    @csrf

    <div class="form-group row">
        <div class="col-auto">
            <label for="period_initial_date" class="d-block">Data Inicial</label>
            <input type="text"
                    name="period_initial_date"
                    id="period_initial_date"
                    value="{{ old('period_initial_date') }}"
                    class="@error('period_initial_date') is-invalid @enderror mask-date"
                    placeholder="__/__/__"
                    autocomplete="off"
                    required autofocus>

            @error('period_initial_date')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="col-auto">
            <label for="period_final_date" class="d-block">Data final</label>
            <input type="text"
                    name="period_final_date"
                    id="period_final_date"
                    value="{{ old('period_final_date') }}"
                    class="@error('period_final_date') is-invalid @enderror mask-date"
                    placeholder="__/__/__  __:__:__"
                    autocomplete="off"
                    required autofocus>

            @error('period_final_date')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="col-auto">
            <label class="my-1 mr-2" for="period_teacher">Professor</label>
            <select name="period_teacher"
                    id="period_teacher"
                    class='w-100'
                    required>
                <option value="">Selecione o professor</option>
                @foreach ($teachers as $teacher)
                    <option value="{{$teacher->id}}">{{$teacher->name}}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="row">
        <div class="col-12 form-group">
            <strong>Turmas</strong>
            <div class="card card-body">
                <div class="row">
                    <div class="col-2">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox"
                                name="select-all"
                                class="custom-control-input"
                                id="select-all"
                                checked>
                            <label class="custom-control-label" for="select-all">Selecionar todos</label>
                        </div>
                    </div>
                </div>
                <hr>

                <div class="row">
                @foreach($groupclasses as $class)
                    <div class="col-2">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox"
                                name="chk-class[]"
                                class="custom-control-input chk-class"
                                id="chk-class{{$class->id}}"
                                value="{{$class->id}}"
                                checked>
                            <label class="custom-control-label" for="chk-class{{$class->id}}">{{$class->name}}</label>
                        </div>
                    </div>
                @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="form-group row mb-0">
        <div class="col-12">
            <button type="submit" class="btn btn-primary">
                {{ __('SALVAR AGENDAMENTO PERIÓDICO') }}
            </button>
        </div>
    </div>
</form>


<script>
    $(function () {
        $("#select-all").change(function() {
            if( $(this).is(':checked') ){
                $(".chk-class").attr('checked', true);
            }else{
                $(".chk-class").removeAttr('checked');
            }
        })
    });
</script>
