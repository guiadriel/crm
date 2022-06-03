<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContractModel;
use App\Models\Macro;
use Illuminate\Http\Request;

class ContractsModelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $models = ContractModel::paginate(15);
        return view('admin.contracts.models.index', ['models' => $models]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $macros = Macro::all()->groupBy('group');
        return view('admin.contracts.models.new', ['macros' => $macros]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $contract = ContractModel::create($request->all());
        if($contract) {
            request()->session()->flash('success', "Modelo de contrato [{$request->title}] criado com sucesso!");
        }

        if(count(session('links')) >= 2){
            return redirect(session('links')[1]);
        }

        return redirect()->route('contracts-models.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(ContractModel $contracts_model)
    {
        $macros = Macro::all()->groupBy('group');
        return view('admin.contracts.models.edit', [
            'model' => $contracts_model,
            'macros' => $macros
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ContractModel $contracts_model)
    {

        $contracts_model->title = $request->title;
        $contracts_model->description = $request->description;

        if ($contracts_model->save()) {
            request()->session()->flash('success', "Modelo de contrato [{$contracts_model->title}] atualizado!");
        }

        if(count(session('links')) >= 2){
            return redirect(session('links')[1]);
        }

        return redirect()->route('contracts-models.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(ContractModel $contracts_model)
    {
        $title = $contracts_model->title;
        if ($contracts_model->delete()) {
            request()->session()->flash('success', "Modelo [{$title}] removido(a)!");
        }

        return redirect()->route('contracts-models.index');
    }
}
