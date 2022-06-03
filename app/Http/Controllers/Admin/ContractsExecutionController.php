<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contract;
use App\Models\Status;
use DateTime;
use Illuminate\Http\Request;

class ContractsExecutionController extends Controller
{
    public function execute(Contract $contract)
    {
        $statusExecuted = Status::where('description', Status::STATUS_EXECUTADO)->first();

        $contract->status_id = $statusExecuted->id;
        $contract->executed_at = (new DateTime())->format('d/m/Y');

        if( $contract->save() ) {
            request()->session()->flash('success', "Contrato [{$contract->number}] execute com sucesso!");
        }

        if(count(session('links')) >= 2){
            return redirect(session('links')[1]);
        }

        return redirect()->back();
    }
}
