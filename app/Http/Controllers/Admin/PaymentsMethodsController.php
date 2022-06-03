<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\PaymentsMethod;
use App\Models\Role;
use App\Models\Status;
use Illuminate\Http\Request;

class PaymentsMethodsController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:'.Role::SUPER_ADMIN);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->has('filter')) {
            $paymentsMethods = PaymentsMethod::where('description', 'like', '%'.request('filter').'%')
                ->paginate(15)
                ->appends('filter', request('filter'))
            ;
        } else {
            $paymentsMethods = PaymentsMethod::paginate(15);
        }

        return view('admin.payments_methods.index')->with(['paymentsMethods' => $paymentsMethods]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $statuses = Status::all()->whereIn('description', [
            Status::STATUS_ATIVO,
            Status::STATUS_INATIVO,
        ]);

        return view('admin.payments_methods.new')->with([
            'statuses' => $statuses,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $method = PaymentsMethod::create([
            'description' => $request->description,
            'status_id' => $request->status,
            'category_id' => $request->category,
            'sub_category_id' => $request->subcategory,
        ]);

        if ($method) {
            request()->session()->flash('success', "Método [{$method->description}] cadastrado com sucesso!");
        }

        if(count(session('links')) >= 2){
            return redirect(session('links')[1]);
        }

        return redirect()->route('payment-methods.index');
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(PaymentsMethod $paymentsMethod)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(PaymentsMethod $payment_method)
    {
        $statuses = Status::all()->whereIn('description', [
            Status::STATUS_ATIVO,
            Status::STATUS_INATIVO,
        ]);

        $categories = Category::all();

        return view('admin.payments_methods.edit')->with([
            'method' => $payment_method,
            'statuses' => $statuses,
            'categories' => $categories
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PaymentsMethod $payment_method)
    {
        $originalType = $payment_method->getOriginal()['description'];

        $payment_method->description = $request->description;
        $payment_method->status_id = $request->status;
        $payment_method->category_id = $request->category;
        $payment_method->sub_category_id = $request->subcategory;
        if ($payment_method->save()) {
            request()->session()->flash('success', "Metódo [{$originalType}] atualizado!");
        }

        if(count(session('links')) >= 2){
            return redirect(session('links')[1]);
        }

        return redirect()->route('payment-methods.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(PaymentsMethod $payment_method)
    {
        if ($payment_method->delete()) {
            request()->session()->flash('success', "Metodo [{$payment_method->description}] removido!");
        }

        return redirect()->route('payment-methods.index');
    }
}
