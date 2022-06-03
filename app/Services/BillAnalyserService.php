<?php

namespace App\Services;

use App\Models\Bill;
use App\Models\Status;
use Illuminate\Support\Facades\DB;

class BillAnalyserService
{
    /**
     * Analyse the date of contracts and update statuses
     *
     * @return void
     */
    public function handle()
    {
        $statusPendente = Status::getDescriptionByConstant(Status::STATUS_PENDENTE);
        $statusEmDia = Status::getDescriptionByConstant(Status::STATUS_EM_DIA);
        $statusEmAtraso = Status::getDescriptionByConstant(Status::STATUS_EM_ATRASO);

        $updatedContractsPayments = DB::table('bills')
            ->select( 'id' )
            ->where('due_date','<', now()->format('Y-m-d'))
            ->whereIn('status_id', [$statusPendente->id, $statusEmDia->id])
            ->get()
            ->pluck('id')
            ->toArray();

        Bill::whereIn('id', $updatedContractsPayments)
            ->update([
                'status_id' => $statusEmAtraso->id
            ]);
    }
}
