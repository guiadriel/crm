<?php

namespace App\Observers;

use App\Models\Bill;
use App\Models\Entry;
use App\Models\Status;

class BillObserver
{
    /**
     * Handle the Bill "created" event.
     *
     * @param  \App\Models\Bill  $bill
     * @return void
     */
    public function created(Bill $bill)
    {
        if( $bill->status_id == Status::getStatusPago()->id ){

            $entry = Entry::where('bill_id', $bill->id)->first();

            if(!$entry){
                Entry::create( $this->getEntryData($bill) );
            }else {
                $entry->update( $this->getEntryData($bill) );
            }
        }
    }

    /**
     * Handle the Bill "updated" event.
     *
     * @param  \App\Models\Bill  $bill
     * @return void
     */
    public function updated(Bill $bill)
    {
        //
        if( $bill->status_id == Status::getStatusPago()->id ){


            $entry = Entry::where('bill_id', $bill->id)->first();

            if(!$entry){
                Entry::create( $this->getEntryData($bill) );
            }else {
                $entry->update( $this->getEntryData($bill) );
            }
        }
    }

    /**
     * Handle the Bill "deleted" event.
     *
     * @param  \App\Models\Bill  $bill
     * @return void
     */
    public function deleted(Bill $bill)
    {
        //
    }

    /**
     * Handle the Bill "restored" event.
     *
     * @param  \App\Models\Bill  $bill
     * @return void
     */
    public function restored(Bill $bill)
    {
        //
    }

    /**
     * Handle the Bill "force deleted" event.
     *
     * @param  \App\Models\Bill  $bill
     * @return void
     */
    public function forceDeleted(Bill $bill)
    {
        //
    }

    /**
     * get Data of entries
     *
     * @param  mixed $receipt
     * @return array
     */
    public function getEntryData(Bill $bill)
    {

        $description = $bill->has_installments
                     ? $bill->description . "({$bill->sequence})"
                     : $bill->description;
        return [
            'status_id' => $bill->status_id,
            'category_id' => $bill->category_id,
            'sub_category_id' => $bill->sub_category_id,
            'contract_id' => $bill->contract_id,
            'contract_payment_id' => $bill->contract_payment_id,
            'value' => $bill->amount,
            'interest' => $bill->interest,
            'description' => $description,
            'type' => Entry::TYPE_OUTCOME,
            'bill_id' => $bill->id,
            'payment_method' => $bill->type,
            'payment_date' => $bill->paid_at,
        ];
    }
}
