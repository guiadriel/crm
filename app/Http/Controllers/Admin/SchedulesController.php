<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GroupClass;
use App\Models\Schedule;
use App\Models\Student;
use App\Models\Teacher;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Str;

class SchedulesController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:access schedule|create schedule|update schedule|delete schedule', ['only' => ['index', 'store']]);
        $this->middleware('permission:create schedule', ['only' => ['create', 'store']]);
        $this->middleware('permission:update schedule', ['only' => ['edit', 'update']]);
        // $this->middleware('permission:delete schedule', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $events = [];
        return view('admin/schedules/index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $student = collect();
        if ($request->has('student_id')) {
            $student = Student::with(['groupclass'])->find($request->student_id);
        }
        $groupclasses = GroupClass::all();
        $teachers = Teacher::all();
        return view('admin/schedules/new', [
            'groupclasses' => $groupclasses,
            'teachers' => $teachers,
            'student' => $student
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $initialDate = Carbon::createFromFormat('d/m/Y H:i', $request->initial_date)->format('Y-m-d H:i:00');
        $finalDate   = Carbon::createFromFormat('d/m/Y H:i', $request->final_date)->format('Y-m-d H:i:00');
        if($initialDate > $finalDate){
            return redirect()->back()->withErrors([
                'message' => 'A data inicial não pode ser maior que a final'
            ]);
        }

        $existingSchedules = Schedule::where('initial_date', $initialDate)
                                    ->where('final_date', $finalDate)
                                    ->get();

        foreach($existingSchedules as $schedule ){
            if( $schedule->group_classes_id == $request->groupclass){
                return redirect()->back()->withInput()->withErrors([
                    'message' => 'Já existe um agendamento com essa turma nesse horário'
                ]);
            }

            if( $schedule->teacher_id == $request->teacher){
                return redirect()->back()->withInput()->withErrors([
                    'message' => 'Já existe um agendamento com esse professor nesse horário'
                ]);
            }
        }

        $teacher = $request->teacher;

        if( !$request->teacher && $request->groupclass){

            $groupClass = GroupClass::find($request->groupclass);
            $teacher = $groupClass->teacher_id;
        }

        $schedule = Schedule::create([
           'group_classes_id'=> $request->groupclass,
           'name' => $request->name,
           'student_id' => $request->student_id ?? '',
           'initial_date' => $initialDate,
           'final_date' => $finalDate,
           'teacher_id' => $teacher,
           'observation' => $request->observations
        ]);

        if ($schedule) {
            request()->session()->flash('success', "Agendamento cadastrado com sucesso!");
        }


        if(count(session('links')) >= 1){
            return redirect(session('links')[1]);
        }


        return redirect()->route('schedules.index');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Schedule $id)
    {
        if( $id->delete() )
        {
            return ['message' => 'Removido com sucesso'];
        }

        return ['error' => 'Erro ao remover o agendamento.'];
    }

     public function calendar(Request $request)
    {
        $schedules = Schedule::orderByDesc('initial_date')->get();
        $events = [];

        $calendars = [
            [
                "id" => "aulaShow",
                "name" => "Aula Show",
                "description" => "Aula show",
                "color" => "#FFF",
                "bgColor"=> "#00F",
                "borderColor"=> "#00F",
                "dragBgColor"=> "#00F",
            ]
        ];

        $teachers = Teacher::all();
        foreach($teachers as $teacher ){
            $calendars[] = [
                "id" => 'teacher-cal-'.$teacher->id,
                "name" => Str::words($teacher->name, 2),
                "description" => "teste",
                "color" => "#FFF",
                "bgColor" => $teacher->color,
                "borderColor" => $teacher->color,
                "dragBgColor" => $teacher->color,
            ];
        }

        foreach($schedules as $schedule){
            $event = [];

            $time = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $schedule->initial_date)->format('H:i');
            $event['id'] = $schedule->id;

            if($schedule->teacher || $schedule->groupClass ){

                if( isset($schedule->teacher) && $schedule->teacher instanceof Teacher ){
                    $calendarId = 'teacher-cal-' . $schedule->teacher->id;
                }

            }
            if( $schedule->student ){
                $calendarId = 'aulaShow';
            }

            if( isset($calendarId) )
            {
                $event['calendarId'] = $calendarId;
                $event['title'] = "[{$time}] - $schedule->name";
                $event['category'] = 'time';
                $event['isAllDay'] = true;
                $event['dueDateClass'] = '';
                $event['start'] = $schedule->initial_date;
                $event['end'] = $schedule->final_date;
                $event['body'] = "<b>{$schedule->observation}<b/>";
                $events[] = $event;
            }

        }

        return [
            'calendars' => $calendars,
            'events' => $events
        ];
    }

    public function print(Request $request)
    {
        return view('admin.schedules.print');
    }
}
