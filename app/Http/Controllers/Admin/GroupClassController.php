<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GroupClass;
use App\Models\Status;
use App\Models\StudentFrequency;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GroupClassController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:access class|create class|update class|delete class', ['only' => ['index', 'store']]);
        $this->middleware('permission:create class', ['only' => ['create', 'store']]);
        $this->middleware('permission:update class', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete class', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->has('filter')) {
            $groupclass = GroupClass::where('name', 'like', '%'.request('filter').'%')
                ->paginate(15)
                ->appends('filter', request('filter'))
            ;
        } else {
            $groupclass = GroupClass::paginate(15);
        }

        return view('admin.class.index')->with(['groupclass' => $groupclass]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $statuses = Status::all()->whereIn('description', [
            Status::STATUS_ATIVO,
            Status::STATUS_INATIVO,
        ]);
        $teachers = Teacher::all();

        return view('admin.class.new')->with([
            'statuses' => $statuses,
            'teachers' => $teachers,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validator($request->all())->validate();

        $classData = [
            'name' => $request->name,
            'number_vacancies' => $request->number_vacancies,
            'number_vacancies_demo' => $request->number_vacancies_demo,
            'status_id' => $request->status,
            'teacher_id' => $request->teacher,
            'time_schedule' => $request->time_schedule,
            'start_date' => $request->start_date,
            'type' => $request->type,
            'day_of_week' => join(',', $request->day_of_week),
        ];

        $student = GroupClass::create($classData);

        if ($student) {
            request()->session()->flash('success', "Turma [{$request->name}] cadastrado(a) com sucesso!");
        }

        return redirect()->route('class.edit', $student);
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(GroupClass $groupClass)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(GroupClass $class)
    {
        $statuses = Status::all()->whereIn('description', [
            Status::STATUS_ATIVO,
            Status::STATUS_INATIVO,
        ]);
        $teachers = Teacher::all();

        $class->selectedDays = explode(',', $class->day_of_week);


        return view('admin.class.edit')->with([
            'groupclass' => $class,
            'statuses' => $statuses,
            'teachers' => $teachers
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, GroupClass $class)
    {
        $this->validator($request->all())->validate();

        $class->name = $request->name;
        $class->number_vacancies = $request->number_vacancies;
        $class->number_vacancies_demo = $request->number_vacancies_demo;
        $class->status_id = $request->status;
        $class->teacher_id = $request->teacher;
        $class->time_schedule = $request->time_schedule;
        $class->start_date = $request->start_date;
        $class->type = $request->type;
        $class->day_of_week = join(',', $request->day_of_week);

        if ($class->save()) {
            request()->session()->flash('success', "Turma [{$class->name}] atualizada!");
        }

        if(count(session('links')) >= 2){
            return redirect(session('links')[1]);
        }

        return redirect()->route('class.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(GroupClass $class)
    {
        if ($class->delete()) {
            request()->session()->flash('success', "Turma [{$class->name}] removida!");
        }

        return redirect()->route('class.index');
    }

    public function detachStudent(GroupClass $class, Request $request)
    {
        $class->students()->detach($request->student);

        if(count(session('links')) >= 2){
            return redirect(session('links')[1]);
        }

        return redirect()->route('class.index');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'number_vacancies_demo' => ['required', 'max:5'],
        ]);
    }
}
