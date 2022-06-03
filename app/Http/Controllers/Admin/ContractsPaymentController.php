<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\CurrencyHelper;
use App\Helpers\DateFormatHelper;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Contract;
use App\Models\ContractPayment;
use App\Models\Entry;
use App\Models\PaymentsMethod;
use App\Models\Status;
use App\Models\SubCategory;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class ContractsPaymentController extends Controller
{
    protected $statuses;

    public function __construct(Request $request)
    {
        $this->middleware('permission:access contracts|create contracts|update contracts|delete contracts', ['only' => ['index', 'store']]);
        $this->middleware('permission:create contracts', ['only' => ['create', 'store']]);
        $this->middleware('permission:update contracts', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete contracts', ['only' => ['destroy']]);

        $this->statuses = Status::whereIn('description', [
            Status::STATUS_PENDENTE,
            Status::STATUS_ATIVO,
            Status::STATUS_CANCELADO,
            Status::STATUS_EM_ATRASO,
            Status::STATUS_EM_DIA,
            Status::STATUS_PAGO,
            Status::STATUS_INATIVO,
        ])->get();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->has('contract_id')) {
            $contract = Contract::find($request->contract_id);

            return view('admin.contracts.payments.index')->with(['contract' => $contract]);
        }

        request()->session()->flash('error', "Não foi possível encontrar o contrato selecionado. Entre em contato com o adminsitrador do sistema");
        return redirect()->back();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $contract = Contract::find($request->contract);
        if( !$contract ){
            request()->session()->flash('error', "Não foi possível encontrar o contrato selecionado. Entre em contato com o adminsitrador do sistema");
            return redirect()->back();
        }

        $methods = PaymentsMethod::getActiveMethods();

        return view('admin.contracts.payments.new', [
            'contract' => $contract,
            'methods'  => $methods,
            'statuses' => $this->statuses
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $contract = Contract::find($request->contract);
        if( !$contract ){
            request()->session()->flash('error', "Não foi possível encontrar o contrato selecionado. Entre em contato com o adminsitrador do sistema");

            return redirect()->back();
        }

        $due_date = $contract->payment_due_date;
        $student_id = $contract->student->id;
        $formattedValue = CurrencyHelper::instance()->brl2decimal($request->value);
        $formattedInterest = CurrencyHelper::instance()->brl2decimal($request->interest);

        $lastPayment = $contract->payments()->orderByDesc('sequence')->first();

        if( $request->has('installments') ){

            for ($i = 1; $i <= $request->qty_installments; ++$i) {
                $sequence = ($i + ($lastPayment->sequence ?? 0));
                $sequenceDueDate = new DateTime(DateFormatHelper::convertToEN($request->due_date));
                if( $i != 1){
                    $intDueDate = (int) $due_date;
                    $sequenceDueDate->setDate($sequenceDueDate->format('Y'), $sequenceDueDate->format('m'), $intDueDate);
                    $newMonth = $i - 1;
                    $sequenceDueDate->modify("+{$newMonth} month");
                }

                $contractPayment = [
                    'contract_id' => $contract->id,
                    'sequence' => ($sequence),
                    'due_date' => $sequenceDueDate->format('d/m/Y'),
                    'value' => $formattedValue,
                    'interest' => $formattedInterest,
                    'type' => $request->type,
                    'observations' => $request->observations,
                    'status_id' => $request->status,
                    'student_id' => $student_id,
                ];
                ContractPayment::create($contractPayment);
            }
            request()->session()->flash('success', "Sequência de parcelas do contrato [$contract->number] gerada com sucesso");

            return redirect()->route('contracts-payment.index', ['contract_id' => $contract->id]);
        }

        ContractPayment::create([
            'contract_id' => $contract->id,
            'sequence' => (($lastPayment->sequence ?? 0) + 1),
            'due_date' => $request->due_date,
            'bill_number' => $request->bill_number,
            'bill_bank_code' => $request->bill_bank_code,
            'value' => $formattedValue,
            'interest' => $formattedInterest,
            'type' => $request->type,
            'observations' => $request->observations,
            'status_id' => $request->status,
            'student_id' => $student_id,
        ]);

        request()->session()->flash('success', "Pagamento [$contract->number] gerado com sucesso");
        return redirect()->route('contracts-payment.index', ['contract_id' => $contract->id]);
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(ContractPayment $contractPayment)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(ContractPayment $contracts_payment)
    {

        $contract = $contracts_payment->contract;
        if( !$contract ){
            request()->session()->flash('error', "Não foi possível encontrar o contrato selecionado. Entre em contato com o adminsitrador do sistema");
            return redirect()->back();
        }

        $methods = PaymentsMethod::getActiveMethods();

        return view('admin.contracts.payments.edit', [
            'contract' => $contract,
            'methods'  => $methods,
            'payment'  => $contracts_payment ,
            'statuses' => $this->statuses
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ContractPayment $contracts_payment)
    {
        $contractPayment = $contracts_payment ?? ContractPayment::find($request->contracts_payment);
        $statusPago = Status::where('description', '=', Status::STATUS_PAGO)->first();

        $contractPayment->status_id = $request->status;
        if( $request->has('value') ){
            $formattedValue = CurrencyHelper::instance()->brl2decimal($request->value);
            $formattedInterest = CurrencyHelper::instance()->brl2decimal($request->interest);
            $contractPayment->value = $formattedValue;
            $contractPayment->interest = $formattedInterest;

            $contractPayment->paid_at = $request->paid_at === null ? '' : $request->paid_at;
            $contractPayment->bill_number = $request->bill_number;
            $contractPayment->bill_bank_code = $request->bill_bank_code;
            $contractPayment->bill_second_generation = $request->bill_second_generation ? 1 : 0;
            $contractPayment->due_date = $request->due_date;
            $contractPayment->type = $request->type;
            $contractPayment->observations = $request->observations;
        }



        if ($contractPayment->save()) {
            request()->session()->flash('success', "Sequencia [#{$contractPayment->sequence}] atualizada com sucesso!");
        }

        if(count(session('links')) >= 2){
            return redirect(session('links')[1]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(ContractPayment $contracts_payment)
    {
        $contract = $contracts_payment->contract;
        if ($contracts_payment->delete()) {
            request()->session()->flash('success', "Pagamento removido(a)!");
        }

        return redirect()->route('contracts-payment.index', ['contract' => $contract->id]);
    }


    public function renderPDF(Contract $contract)
    {
        if( !$contract ){
            request()->session()->flash('error', 'Contrato não encontrado, por favor tente novamente ou entre em contato com o administrador do sistema.');

            return redirect()->back();
        }

        $pdfAsHtml = view('admin.contracts.payments.pdf.render', [
            'contract' => $contract
        ])->render();

        return $this->handleStream($pdfAsHtml);
    }

    /**
     * The handle stream to generate a PDF file
     *
     * @param  mixed $html
     * @return void
     */
    public function handleStream($html) {
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadHTML($html);
        return $pdf->stream();
    }
}
