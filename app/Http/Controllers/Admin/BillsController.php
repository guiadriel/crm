<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\CurrencyHelper;
use App\Helpers\DateFormatHelper;
use App\Http\Controllers\Controller;
use App\Models\Bill;
use App\Models\Category;
use App\Models\Entry;
use App\Models\Status;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BillsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $bills = Bill::query();

        if( $request->has('description') && $request->description != ""){
            $bills = $bills->where('description', 'like', '%'.$request->description.'%');
        }

        if( $request->has('status') && $request->status != ""){
            $bills = $bills->where('status_id', $request->status );
        }

        if( $request->has('type') && $request->type != ""){
            $bills = $bills->where('type', $request->type );
        }

        if( $request->has('initial_date') &&
            $request->has('final_date') &&
            $request->initial_date != "" &&
            $request->initial_date != ""){
            $bills = $bills->whereBetween('due_date', [
                DateFormatHelper::convertToEN($request->initial_date),
                DateFormatHelper::convertToEN($request->final_date)
            ]);
        }
        $status = Status::getStatusPago()->id;

        $bills = $bills
                    ->orderByRaw("FIELD(status_id, '{$status}')")
                    ->orderBy('due_date')
                    ->paginate(15);

        $bills->appends([
            'description' => request('description'),
            'status_id' => request('status'),
            'initial_date' => request('initial_date'),
            'final_date' => request('final_date'),
        ]);

        $statuses = Status::whereIn('description', [
            // Status::STATUS_PENDENTE,
            Status::STATUS_EM_DIA,
            Status::STATUS_EM_ATRASO,
            Status::STATUS_PAGO,
            Status::STATUS_CANCELADO,
        ])->get();

        return view('admin.bills.index', [
            'bills' => $bills,
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

        return view('admin.bills.new', [
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
        $intendedAmountValue = CurrencyHelper::instance()->brl2decimal($request->intended_amount);
        $due_date = $request->due_date;

        // $formattedDueDate = Carbon::createFromFormat('d/m/Y', $due_date);


        $quantity = 1;

        if( $request->has_installments ){
            $quantity = $request->quantity;
        }

        $statusPagoId = Status::getStatusPago()->id;

        $intendedAmountValue = $intendedAmountValue / $quantity;

        if( $request->has('total_month') && ! $request->has_installments ){
            $quantity = (int) $request->total_month + 1;
        }

        $referer_id = 0;
        for($i = 1; $i <= $quantity; $i++ ){
            $sequence = $i - 1;
            $formattedDueDate = Carbon::createFromFormat('d/m/Y', $due_date);
            $formattedDueDate->addMonths($sequence);

            $bill = [
                'category_id' => $request->category,
                'sub_category_id' => $request->sub_category,
                'type' => $request->type,
                'status_id' => $request->status,
                'due_date' => $formattedDueDate->format('d/m/Y'),
                'amount' => $amountValue,
                'intended_amount' => $intendedAmountValue,
                'description' => $request->description,
                'has_installments' => $request->has_installments ? 1 : 0,
                'sequence' => $i,
                'referer_id' => $referer_id,
                'observations' => $request->observations,
            ];

            if( $request->status === $statusPagoId){
                $bill['paid'] = 1;
            }

            $bill['paid_at'] = $request->paid_at;
            $bill['paid_by'] = $request->paid_by;

            $bill = Bill::create($bill);

            if( $i == 1 ){
                $bill->referer_id = $referer_id = $bill->id;
                $bill->save();
            }
        }

        request()->session()->flash('success', "Conta [{$request->description}] cadastrada com sucesso!");

        if(count(session('links')) >= 2){
            return redirect(session('links')[1]);
        }

        return redirect()->route('bills.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Bill  $bill
     * @return \Illuminate\Http\Response
     */
    public function edit(Bill $bill)
    {
        $categories = Category::all();
        $statuses   = Status::all();
        return view('admin.bills.edit', [
            'bill' => $bill,
            'categories' => $categories,
            'statuses' => $statuses
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Bill  $bill
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Bill $bill)
    {
        $amountValue = CurrencyHelper::instance()->brl2decimal($request->amount);
        $intendedAmountValue = CurrencyHelper::instance()->brl2decimal($request->intended_amount);

        $bill->category_id = $request->category;
        $bill->sub_category_id = $request->sub_category;
        $bill->type = $request->type;
        $bill->status_id = $request->status;
        $bill->due_date = $request->due_date;
        $bill->amount = $amountValue;
        $bill->intended_amount = $intendedAmountValue;
        $bill->description = $request->description;
        $bill->paid_at = $request->paid_at;
        $bill->paid_by = $request->paid_by;
        $bill->observations = $request->observations;

        if( $bill->save() ) {
            request()->session()->flash('success', "Conta [{$bill->description}] atualizada com sucesso!");
        }

        if(count(session('links')) >= 2){
            return redirect(session('links')[1]);
        }

        return redirect()->route('bills.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Bill  $bill
     * @return \Illuminate\Http\Response
     */
    public function destroy(Bill $bill)
    {
        $description = $bill->description;
        $bill_id = $bill->id;
        if ($bill->delete()) {
            // Entry::where('bill_id', $bill_id)->delete();
            request()->session()->flash('success', "Conta [{$description}] removida!");
        }

        return redirect()->route('bills.index');
    }
}
