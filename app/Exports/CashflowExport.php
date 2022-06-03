<?php

namespace App\Exports;

use App\Helpers\DateFormatHelper;
use App\Models\Entry;
use DateTime;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithProperties;

class CashflowExport implements WithProperties, FromView, ShouldAutoSize
{

    public function view(): View
    {
        $request = request();
        $initialDate = date('Y-m-01');
        $finalDate = date('Y-m-t');

        if($request->has('filter')){
            $filter = $request->filter;

            switch($filter) {

                case 'period':
                    $initialDate = DateFormatHelper::convertToEN($request->initial_date);
                    $finalDate = DateFormatHelper::convertToEN($request->final_date);
                    break;
                case 'current':
                    $initialDate = date('Y-m-01');
                    $finalDate = date('Y-m-t');
                    break;
                default:
                    $formattedDate = new DateTime();
                    $intFilterDate = (int) $filter;

                    $formattedDate->modify("-{$intFilterDate} days");

                    $initialDate = $formattedDate->format('Y-m-d');
                    $finalDate = date('Y-m-d');
                    break;
            }

        }

        $entries = Entry::with(['contract', 'category', 'subCategory', 'student', 'status'])
                        ->whereBetween('payment_date', [ $initialDate, $finalDate])
                        ->orderBy('entries.payment_date')->get();

        return view('admin.cashflow.export', ['entries' => $entries]);
    }

    public function properties(): array
    {
        return [
            'creator'        => 'APP_NAME',
            'lastModifiedBy' => Auth::user()->name,
            'title'          => 'Fluxo de caixa',
            'description'    => 'Fluxo de caixa',
            'subject'        => 'Invoices',
            'keywords'       => 'invoices,export,spreadsheet',
            'category'       => 'Invoices',
            'manager'        => Auth::user()->name,
            'company'        => 'APP_NAME',
        ];
    }

}
