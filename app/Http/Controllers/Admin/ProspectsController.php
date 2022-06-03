<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\DateFormatHelper;
use App\Http\Controllers\Controller;
use App\Models\Status;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProspectsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $students = Student::query();

        $statusProspected = Status::getDescriptionByConstant(Status::STATUS_PROSPECTO);
        $students = $students->where('status_id', $statusProspected->id);

        if ($request->has('filter')) {
            $students = $students->where(function( $query) {
                return $query->where('name', 'like', '%'.request('filter').'%')
                ->orWhere('email', 'like', '%'.request('filter').'%')
                ->orWhere('phone', 'like', '%'.request('filter').'%');
            });
        }

        if( $request->has('initial_date') &&
            $request->has('final_date') &&
            $request->initial_date != "" &&
            $request->initial_date != ""){
            $students = $students->whereBetween('created_at', [
                DateFormatHelper::convertToEN($request->initial_date) . " 00:00:00",
                DateFormatHelper::convertToEN($request->final_date) . " 23:59:59"
            ]);
        }

        $students = $students->orderBy('created_at')
                            ->paginate(15);

        return view('admin.prospects.index', [
            'students' => $students
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        //
        return view('admin.prospects.new');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validator($request->all())->validate();
        $prospectStatus = Status::getDescriptionByConstant(Status::STATUS_PROSPECTO);

        $student = Student::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'observations' => $request->observations,
            'who_booked' => $request->who_booked,
            'status_id' => $prospectStatus->id,
        ]);

        if ($student) {
            request()->session()->flash('success', "Prospecto(a) [{$student->name}] cadastrado(a) com sucesso!");
        }

        if(count(session('links')) >= 2){
            return redirect(session('links')[1]);
        }

        return redirect()->route('prospects.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Student $prospect)
    {
        $statuses = Status::all();

        return view('admin.prospects.edit')->with([
            'student' => $prospect,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Student $prospect)
    {
        $this->validator($request->all())->validate();
        $prospect->name = $request->name;
        $prospect->email = $request->email;
        $prospect->phone = $request->phone;
        $prospect->observations = $request->observations;
        $prospect->who_booked = $request->who_booked;

        if ($prospect->save()) {
            request()->session()->flash('success', "Prospecto(a) [{$prospect->name}] alterado(a) com sucesso!");
        }

        if(count(session('links')) >= 2){
            return redirect(session('links')[1]);
        }

        return redirect()->route('prospects.index');
    }


    /**
     * Get a validator for an incoming registration request.
     *
     * @return \Illuminate\Support\Facades\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
        ]);
    }

}
