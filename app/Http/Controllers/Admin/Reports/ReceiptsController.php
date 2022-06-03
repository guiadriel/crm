<?php

namespace App\Http\Controllers\Admin\Reports;

use App\Helpers\CurrencyHelper;
use App\Helpers\OnlyNumbersOfString;
use App\Http\Controllers\Controller;
use App\Models\ContractPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class ReceiptsController extends Controller
{
    //
    public function create()
    {
        return view('admin.reports.receipts.new');
    }

    public function show(Request $request)
    {
        $name = $request->name ?? '';
        $cpf = $request->cpf ?? '';
        $value = $request->value ?? '';
        $reason = $request->reason ?? '';



        if( $request->has('contract_payment') ) {
            $contractPayment = ContractPayment::find($request->contract_payment);
            $name = $contractPayment->contract->student->name;
            $cpf = $contractPayment->contract->student->cpf;
            $value = $contractPayment->value;
            $reason = "(pagamento de parcela)";
        }

        $pdfAsHtml = view('admin.reports.receipts.report', [
            "name" => $name,
            "cpf" => OnlyNumbersOfString::format($cpf),
            "value" => $value,
            "reason" => $reason,
            "description" => $request->has("description") ? $request->description : null
        ])->render();

        return $this->handleStream($pdfAsHtml);
    }

    public function handleStream($html) {
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadHTML($html);
        return $pdf->stream();
    }
}
