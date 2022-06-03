<?php

namespace App\Http\Controllers\Admin;

use App\Traits\FrequencyTrait;
use App\Http\Controllers\Controller;
use App\Models\GroupClass;
use App\Models\StudentFrequency;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\TryCatch;

class FrequencyController extends Controller
{
    use FrequencyTrait;

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if( !$request->has('class_id')){
            request()->session()->flash('error', "Nenhuma classe selecionada, não é possível continuar!");
            return redirect()->back();
        }

        $groupClass = GroupClass::find($request->class_id);

        return view('admin.frequencies.new', [
            'groupclass' => $groupClass
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if( !$request->has('class_id')){
            request()->session()->flash('error', "Nenhuma classe selecionada, não é possível continuar!");
            return redirect()->back();
        }

        $groupClass = GroupClass::find($request->class_id);

        $this->insertFrequencies($request);

        request()->session()->flash('success', "Parágrafo cadastrado com sucesso!");


        return redirect()->route('class.edit', $groupClass->id);
    }
}
