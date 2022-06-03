<div class="row mt-2">
    <div class="col-12">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Aluno</th>
                    <th>Esteve presente?</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($groupclass->students->sortBy('name') as $student)


                    @php
                        $studentFrequency = isset($frequencies) ? $frequencies->first(function($value, $key) use ($student){
                            return $value->student_id == $student->id;
                        }) : null;
                    @endphp
                    <tr>
                        <td scope="row">{{$student->name}}</td>
                        <td>
                            <div class="custom-control custom-switch">
                                <input type="checkbox"
                                       class="custom-control-input"
                                       id="chk-{{$student->id}}"
                                       name="is_attend[]"
                                       value="{{$student->id}}"
                                       @if (isset($studentFrequency) && $studentFrequency->is_attend == 1)
                                        checked
                                       @endif
                                       >
                                <label class="custom-control-label" for="chk-{{$student->id}}">Presente</label>
                            </div>
                        </td>
                    </tr>
                @endforeach

            </tbody>
        </table>
    </div>
</div>
