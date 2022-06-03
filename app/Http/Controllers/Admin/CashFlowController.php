<?php

namespace App\Http\Controllers\Admin;

use App\Exports\CashflowExport;
use App\Helpers\DateFormatHelper;
use App\Http\Controllers\Controller;
use App\Models\Bill;
use App\Models\ContractPayment;
use App\Models\Entry;
use App\Models\Receipt;
use App\Models\Status;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class CashFlowController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:access cashflow|create cashflow|update cashflow|delete cashflow', ['only' => ['index', 'store']]);
        $this->middleware('permission:create cashflow', ['only' => ['create', 'store']]);
        $this->middleware('permission:update cashflow', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete cashflow', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
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


        $contracts = ContractPayment::where('due_date', '<', date('Y-m-d') )
            ->where('status_id' ,'!=', Status::getStatusPago()->id )
            ->get();

        // $totalExpectedContracts = 0;
        // foreach ($contracts as $payment) {
        //     $totalExpectedContracts += $payment->value;
        // }

        $contracts = ContractPayment::whereBetween('due_date', [$initialDate, $finalDate])
            ->whereNull('paid_at')
            ->get();

        $totalIncome = 0;
        $totalOutcome = 0;

        $entries = Entry::whereBetween('payment_date', [$initialDate, $finalDate])->get();
        foreach ($entries as $entry) {
            if (Entry::TYPE_INCOME === $entry->type) {
                $totalIncome += $entry->value;
            }

            if (Entry::TYPE_OUTCOME === $entry->type) {
                $totalOutcome += $entry->value;
            }
        }


        $bills = Bill::query();
        $bills = $bills->whereBetween('due_date', [$initialDate, $finalDate])->get();

        $totalIntendedOutcome = 0;
        foreach($bills as $bill){
            $totalIntendedOutcome += $bill->intended_amount;
        }


        $receipts = Receipt::query();
        $receipts = $receipts->whereBetween('expected_date', [$initialDate, $finalDate])->get();

        $totalIntendedIncome = 0;
        foreach($receipts as $receipts){
            $totalIntendedIncome += $receipts->amount;
        }

        /* Chart */
        $entriesByCategory = DB::table('entries')
            ->select('categories.name as category',
                     'sub_categories.name as subcategory',
                     DB::raw('SUM(value) as total_entries', 'entries.type'),
                     'entries.type',
                     'entries.payment_date'
                    )
            ->leftJoin('categories', 'categories.id', '=', 'entries.category_id')
            ->leftJoin('sub_categories', 'sub_categories.id', '=', 'entries.sub_category_id')
            ->groupBy('sub_categories.name', 'entries.type', 'entries.payment_date')
            ->orderBy('entries.payment_date')
            ->whereNull('entries.deleted_at')
            ->whereBetween('payment_date', [$initialDate, $finalDate])
            ->get()
            ->toArray()
        ;

        foreach($entriesByCategory as &$entry){
            $entry->payment_date = DateFormatHelper::convertToBR($entry->payment_date);
        }
        $handleDates = function ($entry) {
            return $entry->payment_date;
        };
        $mappedCategories = array_map($handleDates, $entriesByCategory);
        /* End Chart */

        $totalGeneral = $totalIncome - $totalOutcome;

        $progressIncome = $totalIntendedIncome > 0 ? ($totalIncome / $totalIntendedIncome) * 100 : 0;
        $progressOutcome = $totalIntendedOutcome > 0 ? ($totalOutcome / $totalIntendedOutcome) * 100 : 0;

        return view('admin.cashflow.index')->with([
            'contracts' => $contracts,
            'cards' => [
                'intended_income' => $totalIntendedIncome,
                'intended_outcome' => $totalIntendedOutcome,
                'progress_income' => $progressIncome,
                'progress_outcome' => $progressOutcome,
                'income' => $totalIncome,
                'outcome' => $totalOutcome,
                'total' => $totalGeneral,
            ],
            'chart' => [
                'query' => $entriesByCategory,
                'categories' => $mappedCategories,
            ],
        ]);
    }

    public function download(Request $request)
    {
        return Excel::download(new CashflowExport, 'cashflow.xlsx');
    }
}
