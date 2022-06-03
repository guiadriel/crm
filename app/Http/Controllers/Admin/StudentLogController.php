<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\StudentLog;
use DateTime;
use Illuminate\Http\Request;

class StudentLogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        $studentId = $request->student ?? 0;

        $student = Student::find($studentId);

        return view('admin.students_log.new')->with([
            'student' => $student,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $studentLog = $request->all();
        $student = StudentLog::create($studentLog);

        if ($student) {
            request()->session()->flash('success', 'Histórico adicionado com sucesso!');
        }

        if(count(session('links')) >= 2){
            return redirect(session('links')[1]);
        }

        return redirect()->route('students.index');
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(StudentLog $studentLog)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(StudentLog $studentLog)
    {
        return view('admin.students_log.edit', [
            'log' => $studentLog,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, StudentLog $studentLog)
    {
        $studentLog->who_received = $request->who_received;
        $studentLog->date_log = $request->date_log;
        $studentLog->description = $request->description;

        if ($studentLog->save()) {
            request()->session()->flash('success', 'Histórico atualizado com sucesso!');
        }

        return redirect()->route('students.show', $studentLog->student);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(StudentLog $studentLog)
    {
        $student = $studentLog->student;

        if ($studentLog->delete()) {
            request()->session()->flash('success', 'Histórico removido(a)!');
        }

        return redirect()->route('students.show', $studentLog->student);
    }
}
