<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TeacherFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TeacherFilesController extends Controller
{

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $file = TeacherFile::find($id);

        return response()->download(public_path( $file->url ), $file->filename);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $file = TeacherFile::find($id);


        if( Storage::delete( str_replace("storage/", "public/", $file->url) ) ) {
            if ($file->delete() ) {
                request()->session()->flash('success', "Arquivo removido(a)!");
            }
        }

        return redirect()->route('teachers.edit', $file->teacher);
    }
}
