<?php

namespace App\Observers;

use App\Models\Entry;
use App\Models\Receipt;
use App\Models\Status;

class ReceiptObserver
{
    /**
     * Handle the Receipt "created" event.
     *
     * @param  \App\Models\Receipt  $receipt
     * @return void
     */
    public function created(Receipt $receipt)
    {
        if( $receipt->status_id === Status::getStatusPago()->id ){

            $entry = Entry::where('receipt_id', $receipt->id)->first();

            if(!$entry){
                Entry::create( $this->getEntryData($receipt) );
            }else {
                $entry->update( $this->getEntryData($receipt) );
            }
        }
    }

    /**
     * Handle the Receipt "updated" event.
     *
     * @param  \App\Models\Receipt  $receipt
     * @return void
     */
    public function updated(Receipt $receipt)
    {
        if( $receipt->status_id === Status::getStatusPago()->id ){

            $entry = Entry::where('receipt_id', $receipt->id)->first();

            if(!$entry){
                Entry::create( $this->getEntryData($receipt) );
            }else {
                $entry->update( $this->getEntryData($receipt) );
            }
        }
    }

    /**
     * get Data of entries
     *
     * @param  mixed $receipt
     * @return array
     */
    public function getEntryData(Receipt $receipt)
    {
        return [
            'status_id' => $receipt->status_id,
            'category_id' => $receipt->category_id,
            'sub_category_id' => $receipt->sub_category_id,
            'contract_id' => $receipt->contract_id,
            'contract_payment_id' => $receipt->contract_payment_id,
            'value' => $receipt->amount,
            'interest' => $receipt->interest,
            'description' => $receipt->description,
            'payment_date' => $receipt->paid_at,
            'type' => Entry::TYPE_INCOME
        ];
    }

    /**
     * Handle the Receipt "deleted" event.
     *
     * @param  \App\Models\Receipt  $receipt
     * @return void
     */
    public function deleted(Receipt $receipt)
    {
        //
    }

    /**
     * Handle the Receipt "restored" event.
     *
     * @param  \App\Models\Receipt  $receipt
     * @return void
     */
    public function restored(Receipt $receipt)
    {
        //
    }

    /**
     * Handle the Receipt "force deleted" event.
     *
     * @param  \App\Models\Receipt  $receipt
     * @return void
     */
    public function forceDeleted(Receipt $receipt)
    {
        //
    }
}
