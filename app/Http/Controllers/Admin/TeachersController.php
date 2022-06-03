<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\CurrencyHelper;
use App\Http\Controllers\Controller;
use App\Models\Teacher;
use App\Models\TeacherFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TeachersController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:access teachers|create teachers|update teachers|delete teachers', ['only' => ['index', 'store']]);
        $this->middleware('permission:create teachers', ['only' => ['create', 'store']]);
        $this->middleware('permission:update teachers', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete teachers', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->has('filter')) {
            $teachers = Teacher::where('name', 'like', '%'.request('filter').'%')
                ->orWhere('email', 'like', '%'.request('filter').'%')
                ->paginate(15)
                ->appends('filter', request('filter'))
            ;
        } else {
            $teachers = Teacher::paginate(15);
        }

        return view('admin.teachers.index')->with(['teachers' => $teachers]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $types = Teacher::getTypes();
        return view('admin.teachers.new', ['types' => $types]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validator($request->all())->validate();
        $valuePerClass = CurrencyHelper::instance()->brl2decimal($request->value_per_class);
        $valuePerVipClass = CurrencyHelper::instance()->brl2decimal($request->value_per_vip_class);

        $teacher = Teacher::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'value_per_class' => $valuePerClass,
            'value_per_vip_class' => $valuePerVipClass,
            'color' => $request->color,
            'type' => $request->type,
            'zip_code' => $request->zip_code,
            'address' => $request->address,
            'number' => $request->number,
            'neighborhood' => $request->neighborhood,
            'city' => $request->city,
            'state' => $request->state,
            'rg' => $request->rg,
            'cpf' => $request->cpf,
            'admission_date' => $request->admission_date,
            'resignation_date' => $request->resignation_date,
            'bank_agency' => $request->bank_agency,
            'bank_account' => $request->bank_account,
            'bank_type' => $request->bank_type,
            'bank_pix' => $request->bank_pix
        ]);

        if ($teacher) {

            $file = $request->file('teacher_file');
            if ($file ) {
                $filename = Str::snake($file->getClientOriginalName());
                $fileUrl = ($file) ? $this->upload($file) : null;

                TeacherFile::create([
                    'filename' => $filename,
                    'url' => $fileUrl,
                    'teacher_id' => $teacher->id
                ]);
            }

            request()->session()->flash('success', "Professor(a) [{$teacher->type}] cadastrado(a) com sucesso!");
        }

        return redirect()->route('teachers.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Teacher $teacher)
    {
        $types = Teacher::getTypes();
        return view('admin.teachers.edit')->with([
            'teacher' => $teacher,
            'types' => $types
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Teacher $teacher)
    {
        $this->validator($request->all())->validate();

        $originalName = $teacher->getOriginal()['name'];
        $valuePerClass = CurrencyHelper::instance()->brl2decimal($request->value_per_class);
        $valuePerVipClass = CurrencyHelper::instance()->brl2decimal($request->value_per_vip_class);

        $teacher->name = $request->name;
        $teacher->email = $request->email;
        $teacher->phone = $request->phone;
        $teacher->value_per_class = $valuePerClass;
        $teacher->value_per_vip_class = $valuePerVipClass;
        $teacher->color = $request->color;
        $teacher->type = $request->type;
        $teacher->zip_code = $request->zip_code;
        $teacher->address = $request->address;
        $teacher->number = $request->number;
        $teacher->neighborhood = $request->neighborhood;
        $teacher->city = $request->city;
        $teacher->state = $request->state;
        $teacher->rg = $request->rg;
        $teacher->cpf = $request->cpf;
        $teacher->admission_date = $request->admission_date;
        $teacher->resignation_date = $request->resignation_date;
        $teacher->bank_agency = $request->bank_agency;
        $teacher->bank_account = $request->bank_account;
        $teacher->bank_type = $request->bank_type;
        $teacher->bank_pix = $request->bank_pix;

        if ($teacher->save()) {

            $file = $request->file('teacher_file');
            if ($file ) {
                $filename = Str::snake($file->getClientOriginalName());
                $fileUrl = ($file) ? $this->upload($file) : null;

                TeacherFile::create([
                    'filename' => $filename,
                    'url' => $fileUrl,
                    'teacher_id' => $teacher->id
                ]);
            }

            request()->session()->flash('success', "Professor(a) [{$originalName}] atualizado(a)!");
        }

        return redirect()->route('teachers.edit', $teacher);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Teacher $teacher)
    {
        if ($teacher->delete()) {
            request()->session()->flash('success', "Professor(a) [{$teacher->name}] removido(a)!");
        }

        return redirect()->route('teachers.index');
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
        ]);
    }

    public function upload($file)
    {
        $file_url = '';
        if ($file) {
            $destinationPath = public_path('/storage/teachers');
            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath);
            }

            $fileHashedName = $file->hashName();

            $path = Storage::putFileAs(
                'public/teachers', request()->file('teacher_file'), $fileHashedName
            );

            return str_replace("public/", "storage/", $path);
        }

        return $file_url;
    }
}
