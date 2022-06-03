<?php

namespace App\Services;

use App\Models\ContractPayment;
use App\Models\Receipt;
use App\Models\Status;
use App\User;
use Illuminate\Support\Facades\DB;

class ContractAnalyserService
{
    /**
     * Analyse the date of contracts and update statuses
     *
     * @return void
     */
    public function handle()
    {
        $statusPendente = Status::getDescriptionByConstant(Status::STATUS_PENDENTE);
        $statusEmAtraso = Status::getDescriptionByConstant(Status::STATUS_EM_ATRASO);

        $updatedContractsPayments = DB::table('contract_payments')
            ->select( 'id' )
            ->where('due_date','<', now()->format('Y-m-d'))
            ->where('status_id', $statusPendente->id)
            ->get()
            ->pluck('id')
            ->toArray();

        ContractPayment::whereIn('id', $updatedContractsPayments)
            ->update([
                'status_id' => $statusEmAtraso->id
            ]);

        Receipt::whereIn('contract_payment_id', $updatedContractsPayments)
            ->update([
                'status_id' => $statusEmAtraso->id
            ]);
    }
}
