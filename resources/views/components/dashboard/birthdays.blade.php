<div {{ $attributes->merge(['class' => 'card mb-2'])  }} >
    <div class="card-body">
        <div class="d-flex justify-content-between mb-2">
            <div>
                <h5 class="mb-3">Aniversariantes da semana</h5>
            </div>
        </div>
        <div style='max-height:345px; overflow-x:hidden;'>
            {{-- @foreach ($saturdayStudents as $student)
                <div class="card-contract justify-content-start">
                    <img class='rounded-circle' src="{{ isset($student->avatar) && $student->avatar != "" ? asset( $student->avatar ) : asset('images/avatar.svg') }}" alt="">
                    <div class="name ml-2">
                        <strong>{{$student->name}} {{$student->avatar}}</strong>
                        <p>
                            @if ( $currentDayOfWeek == 1)
                                Fez aniversário <strong>sábado!</strong>
                            @endif
                            @if ( $currentDayOfWeek == 5)
                                Fará aniversário <strong>sábado!</strong>
                            @endif
                            <a target="_blank" href="@whatsapp($student->phone)">Dê os parabéns</a>
                        </p>
                    </div>
                </div>
            @endforeach

            @foreach ($sundayStudents as $student)
                <div class="card-contract justify-content-start">
                    <img class='rounded-circle' src="{{ isset($student->avatar) && $student->avatar != "" ? asset( $student->avatar ) : asset('images/avatar.svg') }}" alt="">
                    <div class="name ml-2">
                        <strong>{{$student->name}}</strong>
                        <p>
                            @if ( $currentDayOfWeek == 1)
                                Fez aniversário <strong>domingo!</strong>
                            @endif
                            @if ( $currentDayOfWeek == 5)
                                Fará aniversário <strong>domingo!</strong>
                            @endif
                            <a target="_blank" href="@whatsapp($student->phone)">Dê os parabéns</a>
                        </p>
                    </div>
                </div>
            @endforeach --}}

            @foreach ($students as $student)
                <div class="card-contract justify-content-start">
                    <img class='rounded-circle' src="{{ isset($student->avatar) && $student->avatar != "" ? asset( $student->avatar ) : asset('images/avatar.svg') }}" alt="">
                    <div class="name ml-2">
                        <strong>{{$student->name}}</strong>
                        <p>Faz aniversário essa semana [Dia {{\Carbon\Carbon::createFromFormat('d/m/Y', $student->birthday_date)->format('d')}}] <a target="_blank" href="@whatsapp($student->phone)">Dê os parabéns</a></p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
