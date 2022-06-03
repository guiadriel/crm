<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StudentFile;
use Illuminate\Http\Request;

class StudentFilesController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:upload files', ['only' => ['store']]);
        $this->middleware('permission:delete files', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.students_files.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(StudentFile $studentFile)
    {
    }
}
