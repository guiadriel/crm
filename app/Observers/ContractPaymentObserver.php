<?php

namespace App\Observers;

use App\Models\ContractPayment;
use App\Models\PaymentsMethod;
use App\Models\Receipt;
use App\Models\Status;

class ContractPaymentObserver
{
    /**
     * Handle the ContractPayment "created" event.
     *
     * @param  \App\Models\ContractPayment  $contractPayment
     * @return void
     */
    public function created(ContractPayment $contractPayment)
    {
        $paymentMethod = PaymentsMethod::where('description', $contractPayment->type)->first();

        $categoryId = $paymentMethod->category->id ?? 0;
        $subCategoryId = $paymentMethod->subCategory->id ?? 0;

        $isMatricula = '';

        if($contractPayment->is_registration){
            $isMatricula = '[MATRICULA] ';
            $subCategoryMatricula = $paymentMethod->category->subCategories()->where('name', 'MATRÍCULA')->first();
            $subCategoryId = $subCategoryMatricula->id ?? $subCategoryId;
        }

        Receipt::create([
            'category_id' => $categoryId,
            'sub_category_id' => $subCategoryId,
            'type' => $contractPayment->type,
            'description' => $isMatricula . 'CONTRATO '. $contractPayment->contract->number,
            'expected_date' => $contractPayment->due_date,
            'interest' => $contractPayment->interest,
            'amount' => $contractPayment->value,
            'status_id' => $contractPayment->status_id,
            'contract_id' => $contractPayment->contract->id,
            'contract_payment_id' => $contractPayment->id
        ]);
    }

    /**
     * Handle the ContractPayment "updated" event.
     *
     * @param  \App\Models\ContractPayment  $contractPayment
     * @return void
     */
    public function updated(ContractPayment $contractPayment)
    {
        $paymentMethod = PaymentsMethod::where('description', $contractPayment->type)->first();

        $receipt = Receipt::where('contract_payment_id', $contractPayment->id)->first();
        $receipt->status_id = $contractPayment->status->id;
        $receipt->amount = $contractPayment->value;
        $receipt->interest = $contractPayment->interest;
        $receipt->expected_date = $contractPayment->due_date;
        $receipt->type = $contractPayment->type;
        $receipt->category_id = $paymentMethod->category->id ?? 0;
        $receipt->sub_category_id = $paymentMethod->subCategory->id ?? 0;
        $receipt->paid_at = $contractPayment->paid_at;
        $receipt->save();


        if( $contractPayment->status->id == Status::getStatusPago()->id){

        }
    }

    /**
     * Handle the ContractPayment "deleted" event.
     *
     * @param  \App\Models\ContractPayment  $contractPayment
     * @return void
     */
    public function deleted(ContractPayment $contractPayment)
    {
        //
    }

    /**
     * Handle the ContractPayment "deleting" event.
     *
     * @param  \App\Models\ContractPayment  $contractPayment
     * @return void
     */
    public function deleting(ContractPayment $contractPayment)
    {
        Receipt::where('contract_payment_id', $contractPayment->id)->delete();
    }

    /**
     * Handle the ContractPayment "restored" event.
     *
     * @param  \App\Models\ContractPayment  $contractPayment
     * @return void
     */
    public function restored(ContractPayment $contractPayment)
    {
        //
    }

    /**
     * Handle the ContractPayment "force deleted" event.
     *
     * @param  \App\Models\ContractPayment  $contractPayment
     * @return void
     */
    public function forceDeleted(ContractPayment $contractPayment)
    {
        //
    }
}
