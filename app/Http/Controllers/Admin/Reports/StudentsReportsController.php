<?php

namespace App\Http\Controllers\Admin\Reports;

use App\Http\Controllers\Controller;
use App\Models\Status;
use App\Models\Student;
use App\Models\StudentLog;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use stdClass;

class StudentsReportsController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.reports.students.new', [
            'reports' => $this->getReportList(),
            'statuses' => $this->getStatusList()
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $initialDate = Carbon::createFromFormat('d/m/Y', $request->initial_date);
        $finalDate = Carbon::createFromFormat('d/m/Y', $request->final_date);
        $statusCanceled = Status::getDescriptionByConstant(Status::STATUS_CANCELADO);

        $statuses = collect($request->status);

        if( in_array('ATIVOS', $request->status) ){

            $activeStatusesList = Status::getIdsByConstants([
                STATUS::STATUS_EM_DIA,
                STATUS::STATUS_ATIVO,
                STATUS::STATUS_EM_ATRASO,
                STATUS::STATUS_PAGO,
                STATUS::STATUS_PENDENTE,
                ]);

            $activeStatusesQuery = DB::table('students')
            ->join('statuses', 'students.status_id', '=', 'statuses.id')
            ->select(
                DB::raw("'ATIVOS' as status"),
                DB::raw("'ATIVOS' as status_id"),
                DB::raw('COUNT(students.id) as students')
            )
            ->whereIn('statuses.id', $activeStatusesList)
            ->groupBy('status');
        }

         if( in_array('NOVOS', $request->status) ){


            DB::enableQueryLog();
            $newStudentsQuery = DB::table('students')
            ->join('contracts', 'contracts.student_id', '=', 'students.id')
            ->select(
                DB::raw("'NOVOS' as status"),
                DB::raw("'NOVOS' as status_id"),
                DB::raw('COUNT(students.id) as students')
            )
            ->whereBetween('contracts.start_date', [$initialDate->format('Y-m-d'), $finalDate->format('Y-m-d')]);
        }

        $filteredBasicStatuses = $statuses->filter(function($value){
            return \in_array($value, ['PROSPECTO', 'REMARKETING', 'CANCELADO', 'QUARENTENA']);
        });

        $statuses = Status::whereIn('description',$filteredBasicStatuses->toArray())->get()->pluck('id')->toArray();

        $basicStatusesQuery = DB::table('students')
            ->join('statuses', 'students.status_id', '=', 'statuses.id')
            ->select(
                'statuses.description as status',
                'statuses.id as status_id',
                DB::raw('COUNT(students.id) as students')
            )
            ->whereIn('statuses.id', $statuses)
            ->groupBy('status_id')
            ->union($activeStatusesQuery)
            ->union($newStudentsQuery)
            ->get();

        $chartcanceled = DB::table('students')
            ->join('student_logs', 'students.id', '=', 'student_logs.student_id')
            ->select(
                'student_logs.reason_cancellation',
                DB::raw('COUNT(students.id) as students')
            )
            ->where('student_logs.status_id', $statusCanceled->id)
            ->whereBetween('date_log', [$initialDate->format('Y-m-d 00:00:00'), $finalDate->format('Y-m-d 23:59:59')])
            ->groupBy('student_logs.reason_cancellation')
            ->get();

        $reportDescription = $this->getReportList()->get($request->report_type);
        return view('admin.reports.students.report_cancellation', [
            'report_description' => $reportDescription,
            'chartdata' => $basicStatusesQuery,
            'chartcanceled' => $chartcanceled
        ]);
    }

    /**
     * detail
     *
     * @param  mixed $request
     * @return \Illuminate\Http\Response
     */
    public function detail(Request $request)
    {
        if( $request->status != "NOVOS" && $request->status != "ATIVOS") {
            $status = Status::find($request->status);
            $students = Student::where('status_id', $status->id)
                        ->get();
        }


        if( $request->status == 'ATIVOS'){
            $initialDate = Carbon::createFromFormat('d/m/Y', $request->initial_date);
            $finalDate = Carbon::createFromFormat('d/m/Y', $request->final_date);
            $activeStatusesList = Status::getIdsByConstants([
                STATUS::STATUS_EM_DIA,
                STATUS::STATUS_ATIVO,
                STATUS::STATUS_EM_ATRASO,
                STATUS::STATUS_PAGO,
                STATUS::STATUS_PENDENTE,
                ]);
            $status = collect();
            $status->description = 'ATIVOS';
            $students = Student::whereIn('status_id', $activeStatusesList)->get();
        }

        if( $request->status == 'NOVOS'){
            $initialDate = Carbon::createFromFormat('d/m/Y', $request->initial_date);
            $finalDate = Carbon::createFromFormat('d/m/Y', $request->final_date);
            $status = collect();
            $status->description = 'NOVOS';
            $students = Student::whereHas('contracts', function($query) use( $initialDate, $finalDate) {
                return $query->whereBetween('contracts.start_date', [
                                    $initialDate->format('Y-m-d'),
                                    $finalDate->format('Y-m-d')
                                ]);
            })->get();
        }



        return view('admin.reports.students.report_detail', [
            'students' => $students,
            'status' => $status
        ]);
    }

    /**
     * detail
     *
     * @param  mixed $request
     * @return \Illuminate\Http\Response
     */
    public function cancellationDetail(Request $request)
    {
        $initialDate = Carbon::createFromFormat('d/m/Y', $request->initial_date);
        $finalDate = Carbon::createFromFormat('d/m/Y', $request->final_date);
        $reason = $request->reason;

        $students = Student::with(['contracts'])->whereHas('logs', function(Builder $query) use ($reason, $initialDate, $finalDate){
            $query->where('reason_cancellation', $reason)
                ->whereBetween('date_log', [$initialDate->format('Y-m-d 00:00:00'), $finalDate->format('Y-m-d 23:59:59')]);
        })->get();

        return view('admin.reports.students.report_cancellation_detail', [
            'students' => $students
        ]);
    }


    public function getReportList()
    {
       $reportList = collect([
           'STATUS_REPORT' => "Relatório de Status dos alunos"
       ]);

       return $reportList;
    }

    public function getStatusList()
    {
        $statuses = collect([
            'PROSPECTO' => 'Prospecto',
            'REMARKETING' => 'Remarketing',
            'ATIVOS' => 'Ativos',
            'NOVOS' => 'Novos',
            'CANCELADO' => 'Cancelados',
            'QUARENTENA' => 'Quarentena'
        ]);
        return $statuses;
    }
}
