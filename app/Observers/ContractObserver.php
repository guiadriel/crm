<?php

namespace App\Observers;

use App\Models\Contract;
use App\Models\ContractPayment;
use App\Models\Receipt;
use App\Models\Status;
use App\Models\StudentLog;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class ContractObserver
{
    /**
     * Handle the Contract "created" event.
     *
     * @param  \App\Models\Contract  $contract
     * @return void
     */
    public function created(Contract $contract)
    {
        if( $contract->observations != "" ){

            StudentLog::create([
                'date_log' => now()->format('d/m/Y H:i:s'),
                'who_received' => auth()->user()->name,
                'description' => $contract->observations,
                'contract_id' => $contract->id,
                'type' => StudentLog::TYPE_SYSTEM,
                'student_id' => $contract->student->id
            ]);
        }
    }

    public function updating(Contract $contract)
    {
        if( $contract->getOriginal()['observations'] != $contract->observations) {
            StudentLog::create([
                'date_log' => now()->format('d/m/Y H:i:s'),
                'who_received' => auth()->user()->name,
                'description' => $contract->observations,
                'contract_id' => $contract->id,
                'type' => StudentLog::TYPE_SYSTEM,
                'student_id' => $contract->student->id
            ]);
        }
    }

    /**
     * Handle the Contract "updated" event.
     *
     * Regra de negocio:
     * - Cancelado, deve manter a parcela vigente e a próxima
     * - Quarentena, manter todos as parcelas
     *
     * @param  \App\Models\Contract  $contract
     * @return void
     */
    public function updated(Contract $contract)
    {
        $statusCancelado = Status::getDescriptionByConstant(Status::STATUS_CANCELADO);
        if($contract->status_id == $statusCancelado->id){
            $statusPendente = Status::getDescriptionByConstant(Status::STATUS_PENDENTE);
            DB::enableQueryLog();

            $payments = ContractPayment::all()->where('contract_id', $contract->id)
                           ->where('status_id', $statusPendente->id)
                           ->skip(2)
                           ->take(PHP_INT_MAX);
            $paymentsToUpdate = $payments->pluck('id')->toArray();
            ContractPayment::whereIn('id', $paymentsToUpdate)
                           ->update([ 'status_id' => $contract->status_id ]);

            Receipt::whereIn('contract_payment_id', $paymentsToUpdate)
                    ->update([ 'status_id' => $contract->status_id ]);
        }

        $statusExecutado = Status::getDescriptionByConstant(Status::STATUS_EXECUTADO);
        if($contract->status_id == $statusExecutado->id){
            $statusPendente = Status::getDescriptionByConstant(Status::STATUS_PENDENTE);
            DB::enableQueryLog();

            $payments = ContractPayment::all()->where('contract_id', $contract->id)
                           ->where('status_id', $statusPendente->id)
                           ->take(PHP_INT_MAX);
            $paymentsToUpdate = $payments->pluck('id')->toArray();
            ContractPayment::whereIn('id', $paymentsToUpdate)
                           ->update([ 'status_id' => $contract->status_id ]);

            Receipt::whereIn('contract_payment_id', $paymentsToUpdate)
                    ->update([ 'status_id' => $contract->status_id ]);
        }
    }

    /**
     * Handle the Contract "deleted" event.
     *
     * @param  \App\Models\Contract  $contract
     * @return void
     */
    public function deleting(Contract $contract)
    {
        ContractPayment::where('contract_id', $contract->id)
                       ->delete();

        $receipt = Receipt::where('contract_id', $contract->id)
                ->delete();

    }

    /**
     * Handle the Contract "deleted" event.
     *
     * @param  \App\Models\Contract  $contract
     * @return void
     */
    public function deleted(Contract $contract)
    {
        // dd('');
    }

    /**
     * Handle the Contract "restored" event.
     *
     * @param  \App\Models\Contract  $contract
     * @return void
     */
    public function restored(Contract $contract)
    {
        //
    }

    /**
     * Handle the Contract "force deleted" event.
     *
     * @param  \App\Models\Contract  $contract
     * @return void
     */
    public function forceDeleted(Contract $contract)
    {
        //
    }
}
