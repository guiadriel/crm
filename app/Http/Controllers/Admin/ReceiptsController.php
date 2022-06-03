<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\CurrencyHelper;
use App\Helpers\DateFormatHelper;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Receipt;
use App\Models\Status;
use App\Models\Student;
use Illuminate\Http\Request;

class ReceiptsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $receipts = Receipt::query()->with(['contract','status', 'contractPayment']);

        if( $request->has('status') && $request->status != ""){
            $receipts = $receipts->where('status_id', $request->status );

        }else{
            $receipts = $receipts->whereNotIn('status_id', Status::getIdsByConstants([Status::STATUS_PAGO, Status::STATUS_CANCELADO, Status::STATUS_EXECUTADO]));
        }

        if( $request->has('description') && $request->description != ""){
            $receipts = $receipts->where('description', 'like', '%'.$request->description.'%')
                                 ->orWhereHas('contractPayment', function($query) use($request){
                                    $query->where('bill_bank_code', 'like', '%'.$request->description.'%');
                                })
                                 ->orWhereHas('contract', function($query) use($request){
                                        $query->whereHas('student', function($query) use($request){
                                            $query->where('name', 'like', "%". $request->description. "%")
                                                  ->orWhere('nickname', 'like', "%". $request->description. "%");
                                        });
                                    });

        }

        if( $request->has('initial_date') &&
            $request->has('final_date') &&
            $request->initial_date != "" &&
            $request->initial_date != ""){
            $receipts = $receipts->whereBetween('expected_date', [
                DateFormatHelper::convertToEN($request->initial_date),
                DateFormatHelper::convertToEN($request->final_date)
            ]);
        }

        $statusEmAtraso = Status::getDescriptionByConstant(Status::STATUS_EM_ATRASO)->id;

        $receipts = $receipts->orderByRaw("FIELD(status_id, '{$statusEmAtraso}') DESC")->orderBy('expected_date')->paginate(15);

        $receipts->appends([
            'description' => request('description'),
            'status_id' => request('status'),
            'initial_date' => request('initial_date'),
            'final_date' => request('final_date'),
        ]);

        $statuses = Status::whereIn('description', [
            Status::STATUS_PENDENTE,
            Status::STATUS_EM_DIA,
            Status::STATUS_EM_ATRASO,
            Status::STATUS_PAGO,
            Status::STATUS_CANCELADO,
        ])->get();

        return view('admin.receipts.index', [
            'receipts' => $receipts,
            'statuses' => $statuses
        ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        $statuses   = Status::all();

        return view('admin.receipts.new', [
            'categories' => $categories,
            'statuses' => $statuses
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
        $amountValue = CurrencyHelper::instance()->brl2decimal($request->amount);

        $receipts = Receipt::create([
            'category_id' => $request->category,
            'sub_category_id' => $request->sub_category,
            'type' => $request->type,
            'status_id' => $request->status,
            'expected_date' => $request->due_date,
            'amount' => $amountValue,
            'description' => $request->description
        ]);

        if( $receipts ){

            if( $receipts->status->id === Status::getStatusPago()->id){

                $receipts->paid = 1;
                $receipts->paid_at = date('d/m/Y');
                $receipts->paid_by = auth()->user()->name;
                $receipts->save();

            }

            request()->session()->flash('success', "Conta [{$receipts->description}] cadastrada com sucesso!");
        }

        if(count(session('links')) >= 2){
            return redirect(session('links')[1]);
        }

        return redirect()->route('receipts.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Receipt  $receipt
     * @return \Illuminate\Http\Response
     */
    public function show(Receipt $receipt)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Receipt  $receipt
     * @return \Illuminate\Http\Response
     */
    public function edit(Receipt $receipt)
    {
        $categories = Category::all();
        $statuses   = Status::all();
        return view('admin.receipts.edit', [
            'receipt' => $receipt,
            'categories' => $categories,
            'statuses' => $statuses
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Receipt  $receipt
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Receipt $receipt)
    {
        $amountValue = CurrencyHelper::instance()->brl2decimal($request->amount);
        $receipt->category_id = $request->category;
        $receipt->sub_category_id = $request->sub_category;
        $receipt->type = $request->type;
        $receipt->status_id = $request->status;
        $receipt->expected_date = $request->expected_date;
        $receipt->amount = $amountValue;
        $receipt->description = $request->description;
        $receipt->paid_at = $request->paid_at;
        $receipt->paid_by = $request->paid_by;

        if( $receipt->save() ) {

            // $this->generateEntry($receipt);

            request()->session()->flash('success', "Conta [{$receipt->description}] atualizada com sucesso!");
        }

        if(count(session('links')) >= 2){
            return redirect(session('links')[1]);
        }

        return redirect()->route('receipts.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Receipt  $receipt
     * @return \Illuminate\Http\Response
     */
    public function destroy(Receipt $receipt)
    {
        //
        $description = $receipt->description;
        // $receipt_id = $receipt->id;
        if ($receipt->delete()) {

            // Entry::where('bill_id', $receipt_id)->delete();

            request()->session()->flash('success', "Conta a receber [{$description}] removida!");
        }

        return redirect()->route('receipts.index');
    }
}
