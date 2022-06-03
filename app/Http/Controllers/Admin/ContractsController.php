<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\CurrencyHelper;
use App\Helpers\DateFormatHelper;
use App\Http\Controllers\Controller;
use App\Models\Config;
use App\Models\Contract;
use App\Models\ContractPayment;
use App\Models\PaymentsMethod;
use App\Models\Status;
use App\Models\Student;
use App\Models\StudentLog;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ContractsController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:access contracts|create contracts|update contracts|delete contracts', ['only' => ['index', 'store']]);
        $this->middleware('permission:create contracts', ['only' => ['create', 'store']]);
        $this->middleware('permission:update contracts', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete contracts', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->has('filter')) {
            $contracts = Contract::with('student')
                ->where('number', 'like', '%'.request('filter').'%')
                ->orWhereHas('student', function ($query) {
                    return $query->where('name', 'like', '%'.request('filter').'%');
                })
                ->paginate(15)
                ->appends('filter', request('filter'))
            ;
        } else {
            $contracts = Contract::paginate(15);
        }

        return view('admin.contracts.index')->with(['contracts' => $contracts]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $statuses = Status::all()->whereIn('description', [
            Status::STATUS_ATIVO,
            Status::STATUS_INATIVO,
            Status::STATUS_EM_ATRASO,
            Status::STATUS_EM_DIA,
        ]);
        $paymentsMethod = PaymentsMethod::getActiveMethods();

        $student = collect();
        if ($request->has('student_id')) {
            $student = Student::with(['groupclass'])->find($request->student_id);
        }

        return view('admin.contracts.new')->with([
            'statuses' => $statuses,
            'paymentsMethod' => $paymentsMethod,
            'student' => $student,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validator($request->all())->validate();

        if (!$request->student_id) {
            request()->session()->flash('error', 'Nenhum aluno selecionado, selecione o aluno para continuar.');

            return redirect()->route('contracts.create')->withInput();
        }

        $contractSequence = Config::where('key', Config::CFG_CONTRACT_COUNT)->first();
        $contractSequence->increment('value');

        $initialParameter = $request->school_days.'X';
        if ('VIP' === $request->type) {
            $initialParameter = 'VIP';
        }

        $contractNumber = $initialParameter.str_pad($contractSequence->value, 4, 0, \STR_PAD_LEFT);

        $initialDate = $request->start_date;
        $due_date = $request->payment_due_date;

        $paymentMonthlyValue = CurrencyHelper::instance()->brl2decimal($request->payment_total);
        $registrationValue = CurrencyHelper::instance()->brl2decimal($request->payment_registration_value);


        $contract = Contract::create([
            'number' => $contractNumber,
            'type' => $request->type,
            'start_date' => $initialDate,
            'payment_due_date' => $due_date,
            'payment_total' => CurrencyHelper::instance()->brl2decimal($request->payment_total, 2),
            'school_days' => $request->school_days,
            'payment_monthly_value' => $paymentMonthlyValue,
            'payment_registration_value' => $registrationValue,
            'payments_method_id' => $request->paymentMethod,
            'payment_quantity' => $request->payment_quantity,
            'student_id' => $request->student_id,
            'group_classes_id' => $request->turma,
            'status_id' => $request->status,
            'observations' => $request->observations,
        ]);

        if ($contract) {

            $carbonInitialDate = Carbon::createFromFormat('d/m/Y', $initialDate);
            $registrationDueDate = $carbonInitialDate->addDays(5);

            $statusPendente = Status::where('description', '=', Status::STATUS_PENDENTE)->first();
            $paymentMethod = PaymentsMethod::find($request->paymentMethod);

            if( $registrationValue > 0 ) {
                ContractPayment::create([
                    'contract_id' => $contract->id,
                    'sequence' => 1,
                    'due_date' => $registrationDueDate->format('d/m/Y'),
                    'value' => $registrationValue,
                    'type' => $paymentMethod->description,
                    'status_id' => $statusPendente->id,
                    'student_id' => $request->student_id,
                    'is_registration' => 1
                ]);
            }

            if ($request->payment_generate) {

                $firstInstallment = $request->first_installment;

                for ($i = 1; $i <= $request->payment_quantity; ++$i) {
                    $sequence = ($i + 1);
                    $sequenceDueDate = new DateTime(DateFormatHelper::convertToEN($firstInstallment));
                    $intDueDate = (int) $due_date;

                    if( $i != 1){
                        $sequenceDueDate->setDate($sequenceDueDate->format('Y'), $sequenceDueDate->format('m'), $intDueDate);
                        $newMonth = $sequence - 2;
                        $sequenceDueDate->modify("+{$newMonth} month");
                    }

                    ContractPayment::create([
                        'contract_id' => $contract->id,
                        'sequence' => ($sequence),
                        'due_date' => $sequenceDueDate->format('d/m/Y'),
                        'value' => $paymentMonthlyValue,
                        'type' => $paymentMethod->description,
                        'status_id' => $statusPendente->id,
                        'student_id' => $request->student_id,
                    ]);
                }
            }

            $statusAtivo = Status::where('description', '=', Status::STATUS_ATIVO)->first();
            $student = Student::find($contract->student_id);
            $student->status_id = $statusAtivo->id;
            $student->save();

            request()->session()->flash('success', "Contrato [{$contract->number}] cadastrado com sucesso!");
        }

        if(count(session('links')) >= 2){
            return redirect(session('links')[1]);
        }

        return redirect()->route('contracts.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Contract $contract)
    {
        $statuses = Status::all()->whereIn('description', [
            Status::STATUS_ATIVO,
            Status::STATUS_INATIVO,
            Status::STATUS_EM_ATRASO,
            Status::STATUS_CANCELADO,
            Status::STATUS_EM_DIA,
            Status::STATUS_QUARENTENA,
            Status::STATUS_EXECUTADO
        ]);
        $paymentsMethod = PaymentsMethod::all();

        $reasons = collect([
            'Financeiro',
            'Trabalho',
            'Faculdade',
            'Mudança de cidade',
            'Não quer mais fazer',
            'Teacher',
            'Instituição',
            'Outro'
        ]);


        return view('admin.contracts.edit')->with([
            'contract' => $contract,
            'statuses' => $statuses,
            'paymentsMethod' => $paymentsMethod,
            'reasons' => $reasons
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Contract $contract)
    {
        $this->validator($request->all())->validate();

        $contract->start_date = $request->start_date;
        $contract->payment_due_date = $request->payment_due_date;
        $contract->payment_total = CurrencyHelper::instance()->brl2decimal($request->payment_total, 2);
        $contract->school_days = $request->school_days;
        $contract->payment_monthly_value = CurrencyHelper::instance()->brl2decimal($request->payment_monthly_value);
        $contract->payment_registration_value = CurrencyHelper::instance()->brl2decimal($request->payment_registration_value);
        $contract->payments_method_id = $request->paymentMethod;
        $contract->payment_quantity = $request->payment_quantity;
        $contract->student_id = $request->student_id;
        $contract->group_classes_id = $request->turma;
        $contract->status_id = $request->status;
        $contract->observations = $request->observations;
        if( $request->canceled_at ){
            $contract->canceled_at = $request->canceled_at;
            $contract->reason_cancellation = $request->reason_cancellation;

            $log = StudentLog::firstOrNew([
                'type' => StudentLog::TYPE_SYSTEM,
                'description' => "CONTRATO CANCELADO",
                'contract_id' => $contract->id,
            ]);
            $log->who_received =  StudentLog::RECEIVED_SYSTEM;
            $log->type =  StudentLog::TYPE_SYSTEM;
            $log->date_log =  date('d/m/Y H:i:s');
            $log->student_id =  $contract->student_id;
            $log->status_id =  $request->status;
            $log->contract_id =  $contract->id;
            $log->description =  "CONTRATO CANCELADO";
            $log->reason_cancellation =  $request->reason_cancellation;
            $log->save();
        }

        if( $request->executed_at ){
            $log = StudentLog::firstOrNew([
                'type' => StudentLog::TYPE_SYSTEM,
                'description' => "CONTRATO EXECUTADO EM {$request->executed_at}",
                'contract_id' => $contract->id,
            ]);

            $contract->executed_at = $request->executed_at;

            $log->who_received =  StudentLog::RECEIVED_SYSTEM;
            $log->type =  StudentLog::TYPE_SYSTEM;
            $log->date_log =  date('d/m/Y H:i:s');
            $log->student_id =  $contract->student_id;
            $log->status_id =  $request->status;
            $log->contract_id =  $contract->id;
            $log->description =  "CONTRATO EXECUTADO EM {$request->executed_at}";
            $log->save();
        }

        if ($contract->save()) {
            request()->session()->flash('success', "Contrato [{$contract->number}] atualizado!");
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
    public function destroy(Contract $contract)
    {
        if ($contract->delete()) {
            request()->session()->flash('success', "Contrato [{$contract->number}] removido!");
        }

        return redirect()->route('contracts.index');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'type' => ['required', 'string', 'max:255'],
        ]);
    }
}
