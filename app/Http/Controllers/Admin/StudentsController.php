<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\DateFormatHelper;
use App\Http\Controllers\Controller;
use App\Models\Origin;
use App\Models\Responsible;
use App\Models\Status;
use App\Models\Student;
use App\Models\StudentLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;

class StudentsController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:access students|create students|update students|delete students', ['only' => ['index', 'store']]);
        $this->middleware('permission:create students', ['only' => ['create', 'store']]);
        $this->middleware('permission:update students', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete students', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $students = Student::query();
        $notShowingStatuses = Status::getIdsByConstants([
            Status::STATUS_PROSPECTO,
            Status::STATUS_REMARKETING
        ]);

        if ($request->has('student-filter') && request('student-filter') != "") {
            $students = $students->where('name', 'like', '%'.request('student-filter').'%')
                ->orWhere('email', 'like', '%'.request('student-filter').'%')
                ->orWhere('phone', 'like', '%'.request('student-filter').'%');
        }

        if( $request->has('status') && $request->status != ""){
            $students = $students->where('status_id', '=', $request->status)
                                 ->whereNotIn('status_id', $notShowingStatuses);
        }else{
            $students = $students->whereNotIn('status_id', $notShowingStatuses);
        }

        $students = $students->orderBy('name')
                ->paginate(15);

        $students->appends([
            'student-filter' => request('student-filter'),
            'status' => request('status')
        ]);

        $statuses = Status::whereNotIn('description' , [Status::STATUS_PROSPECTO, Status::STATUS_REMARKETING])->get();

        return view('admin.students.index')->with(['students' => $students, 'statuses' => $statuses]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $statuses = Status::all();
        $origins = Origin::all();
        $groupClassList = collect();

        return view('admin.students.new')->with([
            'statuses' => $statuses,
            'origins' => $origins,
        ]);
    }

    public function avatar($file)
    {
        $avatar = '';
        if ($file) {
            $destinationPath = public_path('/storage/avatars');
            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath);
            }

            $fileHashedName = $file->hashName();

            Image::make($file->path())->resize(128, 128, function ($constraint) {
                $constraint->aspectRatio();
            })->save($destinationPath.'/'.$fileHashedName);

            $avatar = asset('/storage/avatars/'.$fileHashedName);
        }

        return $avatar;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validator($request->all())->validate();

        $userData = [
            'name' => $request->name,
            'nickname' => $request->nickname,
            'email' => $request->email,
            'phone' => $request->phone,
            'phone_message' => $request->phone_message,
            'gender' => $request->gender,
            'address' => $request->address,
            'number' => $request->number,
            'zip_code' => $request->zip_code,
            'neighborhood' => $request->neighborhood,
            'city' => $request->city,
            'state' => $request->state,
            'birthday_date' => $request->birthday_date,
            'status_id' => $request->status,
            'origin_id' => $request->origin,
            'observations' => $request->observations,
            'rg' => $request->rg,
            'cpf' => $request->cpf,
            'instagram' => $request->instagram,
            'facebook' => $request->facebook,
        ];

        $file = $request->file('avatar');
        if ($file) {
            $userData['avatar'] = $this->avatar($file);
        }

        if( $request->has_responsible ) {
            $responsible = Responsible::create($this->getResponsibleData($request));

            $userData['responsible_id'] = $responsible->id;
        }

        $student = Student::create($userData);

        if ($student) {
            request()->session()->flash('success', "Aluno(a) [{$student->name}] cadastrado(a) com sucesso!");
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
    public function show(Student $student)
    {
        return view('admin.students.show')->with([
            'student' => $student,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Student $student)
    {
        $statuses = Status::all();
        $origins = Origin::all();

        return view('admin.students.edit')->with([
            'statuses' => $statuses,
            'origins' => $origins,
            'student' => $student,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Student $student)
    {
        $this->validator($request->all())->validate();

        $oldStatus = $student->status;

        $originalName = $student->getOriginal()['name'];

        $student->name = $request->name;
        $student->nickname = $request->nickname;
        $student->email = $request->email;
        $student->phone = $request->phone;
        $student->phone_message = $request->phone_message;
        $student->gender = $request->gender;
        $student->address = $request->address;
        $student->number = $request->number;
        $student->zip_code = $request->zip_code;
        $student->neighborhood = $request->neighborhood;
        $student->city = $request->city;
        $student->state = $request->city;
        $student->rg = $request->rg;
        $student->cpf = $request->cpf;
        $student->birthday_date = $request->birthday_date;


        $student->status_id = $request->status;
        $student->origin_id = $request->origin;
        $student->observations = $request->observations;

        $student->instagram = $request->instagram;
        $student->facebook = $request->facebook;

        $file = $request->file('avatar');
        if ($file) {
            $student->avatar = $this->avatar($file);
        }

        if( !$request->has_responsible ){

            if( $student->responsible_id != ""){
                $student->responsible->delete();
                $student->responsible_id = null;
            }

        }else{

            if( $student->responsible_id ){
                $student->responsible->name = $request->responsible_name;
                $student->responsible->email = $request->responsible_email;
                $student->responsible->phone = $request->responsible_phone;
                $student->responsible->gender = $request->responsible_gender;
                $student->responsible->address = $request->responsible_address;
                $student->responsible->number = $request->responsible_number;
                $student->responsible->zip_code = $request->responsible_zip_code;
                $student->responsible->neighborhood = $request->responsible_neighborhood;
                $student->responsible->birthday_date = $request->responsible_birthday_date;
                $student->responsible->city = $request->responsible_city;
                $student->responsible->state = $request->responsible_city;
                $student->responsible->rg = $request->responsible_rg;
                $student->responsible->cpf = $request->responsible_cpf;
                $student->responsible->save();
            }else {
                $responsible = Responsible::create($this->getResponsibleData($request));
                $student->responsible_id = $responsible->id;
            }



        }

        if ($student->save()) {

            // if($oldStatus->id != $request->status){
            //     $newStatus = Status::find($request->status);

            //     $log = StudentLog::firstOrNew([
            //         'type' => StudentLog::TYPE_SYSTEM,
            //         'student_id' => $student->id,
            //     ]);
            //     $log->who_received =  StudentLog::RECEIVED_SYSTEM;
            //     $log->type =  StudentLog::TYPE_SYSTEM;
            //     $log->date_log =  date('d/m/Y H:i:s');
            //     $log->student_id =  $student->id;
            //     $log->description =  "ALTERADO O STATUS DE {$oldStatus->description} para {$newStatus->description}";
            //     $log->save();
            // }

            request()->session()->flash('success', "Aluno(a) [{$originalName}] atualizado(a)!");
        }

        if(count(session('links')) >= 2){
            return redirect(session('links')[1]);
        }

        return redirect()->route('students.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Student $student)
    {
        if ($student->delete()) {
            request()->session()->flash('success', "Aluno(a) [{$student->name}] removido(a)!");
        }

        if(count(session('links')) >= 2){
            return redirect(session('links')[1]);
        }

        return redirect()->route('students.index');
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
            'birthday_date' => ['nullable', 'date_format:d/m/Y']
        ]);
    }

    public function getResponsibleData($request){
        return [
            'name' => $request->responsible_name,
            'nickname' => $request->responsible_nickname,
            'email' => $request->responsible_email,
            'phone' => $request->responsible_phone,
            'gender' => $request->responsible_gender,
            'address' => $request->responsible_address,
            'number' => $request->responsible_number,
            'zip_code' => $request->responsible_zip_code,
            'neighborhood' => $request->responsible_neighborhood,
            'city' => $request->responsible_city,
            'state' => $request->responsible_state,
            'birthday_date' => $request->responsible_birthday_date,
            'rg' => $request->responsible_rg,
            'cpf' => $request->responsible_cpf
        ];
    }



}
