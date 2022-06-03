<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Origin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OriginsController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:access origins|create origins|update origins|delete origins', ['only' => ['index', 'store']]);
        $this->middleware('permission:create origins', ['only' => ['create', 'store']]);
        $this->middleware('permission:update origins', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete origins', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->has('filter')) {
            $origins = Origin::where('type', 'like', '%'.request('filter').'%')
                ->paginate(15)
                ->appends('filter', request('filter'))
            ;
        } else {
            $origins = Origin::paginate(15);
        }

        return view('admin.origins.index')->with(['origins' => $origins]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.origins.new');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validator($request->all())->validate();

        $origin = Origin::create([
            'type' => $request->type,
        ]);

        if ($origin) {
            request()->session()->flash('success', "Origem [{$origin->type}] cadastrada com sucesso!");
        }

        if(count(session('links')) >= 2){
            return redirect(session('links')[1]);
        }

        return redirect()->route('origins.index');
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Origin $origin)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Origin $origin)
    {
        return view('admin.origins.edit')->with([
            'origin' => $origin,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Origin $origin)
    {
        $this->validator($request->all())->validate();

        $originalType = $origin->getOriginal()['type'];

        $origin->type = $request->type;
        if ($origin->save()) {
            request()->session()->flash('success', "Origem [{$originalType}] atualizada!");
        }

        if(count(session('links')) >= 2){
            return redirect(session('links')[1]);
        }

        return redirect()->route('origins.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Origin $origin)
    {
        if ($origin->delete()) {
            request()->session()->flash('success', "Origem [{$origin->type}] removida!");
        }

        return redirect()->route('origins.index');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'type' => ['required', 'string', 'max:255'],
        ]);
    }
}
