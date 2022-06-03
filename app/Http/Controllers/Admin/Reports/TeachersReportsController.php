<?php

namespace App\Http\Controllers\Admin\Reports;

use App\Helpers\DateFormatHelper;
use App\Http\Controllers\Controller;
use App\Models\GroupClass;
use App\Models\Paragraph;
use App\Models\Teacher;
use Illuminate\Http\Request;
use PDF;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class TeachersReportsController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $teachers = Teacher::all();

        return view('admin.reports.teachers.new', [
            'teachers' => $teachers
        ]);
    }
    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $teacher = Teacher::find($request->teacher);

        $reportData = $this->calculate($teacher, $request->initial_date, $request->final_date);

        $teachersChart = $this->chart($teacher, $request->initial_date, $request->final_date);

        return view('admin.reports.teachers.report', [
            'teacher' => $teacher,
            'reportData' => $reportData,
            'chartdata' => $teachersChart
        ]);
    }

    public function chart(Teacher $teacher, $initialDate, $finalDate){

        $chartQuery = DB::table('paragraphs')
                        ->join('group_classes', 'group_classes.id', '=', 'paragraphs.group_classes_id')
                        ->join('teachers', 'teachers.id', '=', 'paragraphs.teacher_id')
                        ->select(
                            'teachers.name as teacher',
                            'teachers.id as teacher_id',
                            'teachers.color as color',
                            DB::raw('COUNT(paragraphs.id) as Aulas')
                        )
                        ->where('group_classes.type', GroupClass::TYPE_TURMA)
                        ->whereBetween('date', [
                            DateFormatHelper::convertToEN($initialDate),
                            DateFormatHelper::convertToEN($finalDate),
                        ])
                        ->groupBy('teachers.id')
                        ->get()
                        ->toArray();

        $chartQueryVip = DB::table('paragraphs')
                        ->join('group_classes', 'group_classes.id', '=', 'paragraphs.group_classes_id')
                        ->join('teachers', 'teachers.id', '=', 'paragraphs.teacher_id')
                        ->select(
                            'teachers.name as teacher',
                            'teachers.id as teacher_id',
                            'teachers.color as color',
                            DB::raw('COUNT(paragraphs.id) as Aulas')
                        )
                        ->where('group_classes.type', GroupClass::TYPE_VIP)
                        ->whereBetween('date', [
                            DateFormatHelper::convertToEN($initialDate),
                            DateFormatHelper::convertToEN($finalDate),
                        ])
                        ->groupBy('teachers.id')
                        ->get()
                        ->toArray();

        return ['normal' => $chartQuery, 'vip' => $chartQueryVip];
    }

    public function calculate(Teacher $teacher, $initialDate, $finalDate){
        $paragraphs = $teacher->paragraphs->whereBetween('date', [
            $initialDate,
            $finalDate
        ]);

        $iTurmaTotal = 0;
        $iVipTotal = 0;

        foreach($paragraphs as $paragraph) {
            if($paragraph->groupClass->type == GroupClass::TYPE_TURMA){
                $iTurmaTotal++;
            }

            if($paragraph->groupClass->type == GroupClass::TYPE_VIP){
                $iVipTotal++;
            }
        }

        $turmaAmount = $iTurmaTotal * $teacher->value_per_class;
        $vipAmount = $iVipTotal * $teacher->value_per_vip_class;

        return [
            'resume' => [
                'turma' => [
                    'count' => $iTurmaTotal,
                    'amount' => $turmaAmount,
                ],
                'vip' => [
                    'count' => $iVipTotal,
                    'amount' => $vipAmount,
                ],
                'total' => $turmaAmount + $vipAmount
            ],
            'paragraphs' => $paragraphs
        ];
    }

    public function receipt(Request $request, Teacher $teacher)
    {
        $reportData = $this->calculate($teacher, $request->initial_date, $request->final_date);

        $pdfAsHtml = view('admin.reports.teachers.receipt', [
            'teacher' => $teacher,
            'reportData' => $reportData,
            'initialDate' => $request->initial_date,
            'finalDate' => $request->final_date,
        ])->render();

        return $this->handleStream($pdfAsHtml);
    }

    public function handleStream($html) {
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadHTML($html);
        return $pdf->stream();
    }
}
