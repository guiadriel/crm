<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\CurrencyHelper;
use App\Http\Controllers\Controller;
use App\Models\Entry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EntriesController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:access entries|create entries|update entries|delete entries', ['only' => ['index', 'store']]);
        $this->middleware('permission:create entries', ['only' => ['create', 'store']]);
        $this->middleware('permission:update entries', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete entries', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.entries.new');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $amountValue = CurrencyHelper::instance()->brl2decimal($request->modal_value);

        $entry = Entry::create([
            'description' => $request->modal_description,
            'type' => $request->modal_type,
            'value' => $amountValue,
            'category_id' => $request->modal_category,
            'sub_category_id' => $request->modal_subcategory,
            'observations' => $request->modal_observations,
            'payment_date' => date('d/m/Y'),
        ]);

        if ($entry) {
            request()->session()->flash('success', "Lançamento [{$entry->description}] cadastrado com sucesso!");
        }

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'description' => ['required', 'string', 'max:255'],
        ]);
    }
}
